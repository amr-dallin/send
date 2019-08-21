<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Http\Client;
use Sunra\PhpSimple\HtmlDomParser;
use Cake\Utility\Text;

/**
 * Sections Model
 *
 * @property \App\Model\Table\CategoriesTable|\Cake\ORM\Association\HasMany $Categories
 *
 * @method \App\Model\Entity\Section get($primaryKey, $options = [])
 * @method \App\Model\Entity\Section newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Section[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Section|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Section saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Section patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Section[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Section findOrCreate($search, callable $callback = null, $options = [])
 */
class SectionsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('sections');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->hasMany('Categories', [
            'foreignKey' => 'section_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->requirePresence('slug', 'create')
            ->allowEmptyString('slug', false);

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->allowEmptyString('title', false);

        return $validator;
    }

    private function domParser($url)
    {
        $client = new Client();
        $response = $client->get($url);

        $dom = '';
        switch($response->getStatusCode()) {
            case 200:
                $dom = HtmlDomParser::str_get_html($response->getStringBody());
                break;
        }

        return $dom;
    }

    public function parse()
    {
        $dom = $this->domParser(YP);

        if (empty($dom)) {
            return false;
        }

        $page_categories = $dom->find('.categories', 0);
        if (null == $page_categories) {
            return false;
        }

        $section_list = $page_categories
            ->find('div.col-md-4');

        $sections = [];
        foreach ($section_list as $key => $section) {
            if ($key == 0) {
                continue;
            }

            $a_tag = $section
                ->find('h4.media-heading', 0)
                ->find('a', 0);

            $a_href = explode('/', $a_tag->href);

            $sections[] = [
                'slug' => end($a_href),
                'title' => $a_tag->plaintext
            ];
        }

        if (!empty($sections)) {
            $sections = $this->newEntities($sections);

            foreach ($sections as $section) {
                $this->save($section);
            }
        }

        return true;
    }

    public function analysed()
    {
        $section = $this
            ->find()
            ->where(['Sections.date_analysed IS' => null])
            ->first();

        if (empty($section)) {
            return false;
        }

        $dom = $this->domParser(SECTION . $section->slug);

        if (empty($dom)) {
            return false;
        }

        $rubricsCategories = $dom->find('.rubricsCategories', 0);
        if (null == $rubricsCategories) {
            return false;
        }

        $category_list = $rubricsCategories->find('li');

        $categories = [];
        foreach ($category_list as $category) {
            $a_tag = $category->find('a', 0);

            $a_href = explode('/', $a_tag->href);

            $categories[] = [
                'section_id' => $section->id,
                'slug' => end($a_href),
                'title' => $a_tag->plaintext
            ];
        }

        if (!empty($categories)) {
            $categories = $this->Categories->newEntities($categories);

            foreach ($categories as $category) {
                $this->Categories->save($category);
            }
        }

        $section->date_analysed = date('Y-m-d H:i:s');
        $this->save($section);

        return true;
    }

    public function findResult(\Cake\ORM\Query $query, array $options)
    {
        return $query
            ->innerJoinWith('Categories.Items', function (\Cake\ORM\Query $q) use ($options) {
                if (isset($options['city_ids']) && !empty($options['city_ids'])) {
                    $q = $q->where(['Items.city_id IN' => $options['city_ids']]);
                }

                if (isset($options['item_ids']) && !empty($options['item_ids'])) {
                    $q = $q->where(['Items.id NOT IN' => $options['item_ids']]);
                }

                return $q->find('live');
            })
            ->group('Sections.id')
            ->select(['Sections.id', 'Sections.title'])
            ->contain('Categories.Items', function (\Cake\ORM\Query $q) use ($options) {
                if (isset($options['city_ids']) && !empty($options['city_ids'])) {
                    $q = $q->where(['Items.city_id IN' => $options['city_ids']]);
                }

                if (isset($options['item_ids']) && !empty($options['item_ids'])) {
                    $q = $q->where(['Items.id NOT IN' => $options['item_ids']]);
                }

                return $q
                    ->select(['Items.id'])
                    ->find('live');
            });
    }
}
