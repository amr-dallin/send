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
 * Categories Model
 *
 * @property \App\Model\Table\SectionsTable|\Cake\ORM\Association\BelongsTo $Sections
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\BelongsToMany $Items
 *
 * @method \App\Model\Entity\Category get($primaryKey, $options = [])
 * @method \App\Model\Entity\Category newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Category[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Category|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Category saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Category patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Category[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Category findOrCreate($search, callable $callback = null, $options = [])
 */
class CategoriesTable extends Table
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

        $this->setTable('categories');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('Sections', [
            'foreignKey' => 'section_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('Items', [
            'foreignKey' => 'category_id',
            'targetForeignKey' => 'item_id',
            'joinTable' => 'categories_items'
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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['section_id'], 'Sections'));

        return $rules;
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

    public function analysed()
    {
        $category = $this
            ->find()
            ->where(['Categories.date_analysed IS' => null])
            ->first();

        if (empty($category)) {
            return false;
        }

        $dom = $this->domParser(CATEGORY . $category->slug . '?pagesize=10000');

        if (empty($dom)) {
            return false;
        }

        $organizations = $dom->find('.organizations', 0);
        if (null == $organizations) {
            return false;
        }

        $item_list = $organizations->find('div.organizationBlock');

        if ($this->Items->saveWithCategory($item_list)) {
            $category->date_analysed = date('Y-m-d H:i:s');
            $this->save($category);

            return true;
        }

        return false;
    }
}
