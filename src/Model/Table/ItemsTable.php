<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Sunra\PhpSimple\HtmlDomParser;
use Cake\Utility\Text;
use Cake\Database\Expression\QueryExpression;

/**
 * Items Model
 *
 * @property \App\Model\Table\CountriesTable|\Cake\ORM\Association\BelongsTo $Countries
 * @property \App\Model\Table\RegionsTable|\Cake\ORM\Association\BelongsTo $Regions
 * @property \App\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 * @property \App\Model\Table\ItemTelephonesTable|\Cake\ORM\Association\HasMany $ItemTelephones
 * @property \App\Model\Table\CategoriesTable|\Cake\ORM\Association\BelongsToMany $Categories
 *
 * @method \App\Model\Entity\Item get($primaryKey, $options = [])
 * @method \App\Model\Entity\Item newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Item[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Item|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Item saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Item patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Item[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Item findOrCreate($search, callable $callback = null, $options = [])
 */
class ItemsTable extends Table
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

        $this->setTable('items');
        $this->setDisplayField('email');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'date_created' => 'new'
                ]
            ]
        ]);

        $this->belongsTo('Countries', [
            'foreignKey' => 'country_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Regions', [
            'foreignKey' => 'region_id'
        ]);
        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id'
        ]);
        $this->belongsTo('Domains', [
            'foreignKey' => 'domain_id'
        ]);
        $this->hasMany('ItemTelephones', [
            'foreignKey' => 'item_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->belongsToMany('Categories', [
            'foreignKey' => 'item_id',
            'targetForeignKey' => 'category_id',
            'joinTable' => 'categories_items'
        ]);
        $this->belongsToMany('Campaigns', [
            'foreignKey' => 'item_id',
            'targetForeignKey' => 'campaign_id',
            'joinTable' => 'campaigns_items'
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
            ->scalar('legal_name')
            ->maxLength('legal_name', 255)
            ->requirePresence('legal_name', 'create')
            ->allowEmptyString('legal_name', false);

        $validator
            ->scalar('brand_name')
            ->maxLength('brand_name', 255)
            ->allowEmptyString('brand_name');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('website')
            ->maxLength('website', 255)
            ->allowEmptyString('website');

        $validator
            ->scalar('fax')
            ->maxLength('fax', 255)
            ->allowEmptyString('fax');

        $validator
            ->scalar('landmarks')
            ->maxLength('landmarks', 255)
            ->allowEmptyString('landmarks');

        $validator
            ->scalar('postal_code')
            ->maxLength('postal_code', 255)
            ->allowEmptyString('postal_code');

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->allowEmptyString('address');

        $validator
            ->scalar('latitude')
            ->maxLength('latitude', 255)
            ->allowEmptyString('latitude');

        $validator
            ->scalar('longitude')
            ->maxLength('longitude', 255)
            ->allowEmptyString('longitude');

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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['country_id'], 'Countries'));
        $rules->add($rules->existsIn(['region_id'], 'Regions'));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));

        return $rules;
    }

    public function saveWithCategory($item_list)
    {
        $items = [];
        foreach ($item_list as $key => $item) {
            if ($key == 0) {
                continue;
            }
            $result = $this->parseWithCategory($item);
            if ($result) {
                $items[] = $result;
            }
        }


        if (!empty($items)) {
            $items = $this->newEntities($items, [
                'associated' => ['ItemTelephones', 'Categories']
            ]);

            foreach ($items as $item) {
                $this->save($item);
            }
        }

        return true;
    }

    private function parseWithCategory($item)
    {
        $organizationHeader = $item->find('h4.organizationHeader', 0);
        $a_tag = $organizationHeader->find('a', 0);
        $brand_name = $a_tag->plaintext;

        $a_href = explode('/', $a_tag->href);
        $slug = end($a_href);

        $organizationInfo = $item->find('div.organizationInfo', 0);


        //////////// FISRT BLOCK ////////////

        $first = 0;
        $second = 1;
        if (null !== $organizationInfo->find('div.row', 0)->children(2)) {
            $first = 1;
            $second = 2;
        }

        $firstBlock = $organizationInfo->find('div.row', 0)->children($first);

        if (null == $firstBlock) {
            echo $brand_name;
            exit;
        }

        // Email
        $email = null;
        $meta_email = $firstBlock->find('meta[itemprop=email]', 0);
        if (null !== $meta_email) {
            $email = $meta_email->getAttribute('content');
        }

        /*  Find item */
        $item_find = $this->find()
            ->where([
                'Items.brand_name' => $brand_name,
                'Items.slug' => $slug,
                'Items.email' => $email
            ])
            ->first();

        if (!empty($item_find)) {
            return false;
        }
        /*  Find item */


        // Phone List
        $phone_list = $firstBlock->find('p', 0)->find('a');
        $phones = [];
        foreach($phone_list as $phone) {
            $phones[]['phone'] = $phone->plaintext;
        }

        // Website
        $website = null;
        $a_website = $firstBlock->find('a[itemprop=url]', 0);
        if (null !== $a_website) {
            $website = $a_website->plaintext;
        }
        //////////// FISRT BLOCK ////////////


        //////////// SECOND BLOCK ////////////
        $secondBlock = $organizationInfo->find('div.row', 0)->children($second);

        // Legal Name
        $legal_name = mb_substr($secondBlock->find('p', 0)->plaintext, 22);

        // Address //
        $address_text = $secondBlock->find('p[itemprop=address]', 0)->plaintext;
        $address = trim(preg_replace('/\s{2,}/', ' ', mb_substr(trim($address_text), 6)));

        // Country
        $addressCountry = $secondBlock->find('span[itemprop=addressCountry]', 0)->plaintext;
        $country_title = preg_replace('/\,?/', '', trim($addressCountry));

        $country_id = null;
        $country = $this->Countries->findByTitle($country_title)->first();
        if (null == $country) {
            $country = $this->Countries->newEntity(['title' => $country_title]);
            $result = $this->Countries->save($country);

            $country_id = $result->id;
        } else {
            $country_id = $country->id;
        }

        /// Region and City
        $region_title = null;
        $secondRegion = $secondBlock->find('span[itemprop=addressRegion]', 1);
        if (null == $secondRegion) {
            $city_title = $secondBlock->find('span[itemprop=addressRegion]', 0)->find('a', 0)->plaintext;
        } else {
            $region_title = $secondBlock->find('span[itemprop=addressRegion]', 0)->find('a', 0)->plaintext;
            $city_title = $secondBlock->find('span[itemprop=addressRegion]', 1)->find('a', 0)->plaintext;
        }

        // Region
        $region_id = null;
        if (null !== $region_title) {
            $region = $this->Regions
                ->find()
                ->where([
                    'Regions.country_id' => $country_id,
                    'Regions.title' => $region_title
                ])
                ->first();

            if (empty($region)) {
                $region = $this->Regions->newEntity([
                    'country_id' => $country->id,
                    'title' => $region_title
                ]);
                $result = $this->Regions->save($region);

                $region_id = $result->id;
            } else {
                $region_id = $region->id;
            }
        }

        // City
        $city = $this->Cities
            ->find()
            ->where([
                'Cities.country_id' => $country_id,
                'Cities.title' => $city_title
            ])
            ->first();

        if (empty($city)) {
            $city = $this->Cities->newEntity([
                'region_id' => $region_id,
                'country_id' => $country->id,
                'title' => $city_title
            ]);
            $result = $this->Cities->save($city);

            $city_id = $result->id;
        } else {
            $city_id = $city->id;
        }

        // Postal Code
        $postal_code = null;
        $postalCode = $secondBlock->find('span[itemprop=postalCode]', 0);
        if (null !== $postalCode) {
            $postal_code = preg_replace('/\,?/', '', trim($postalCode->plaintext));
        }

        // Address //

        //////////// SECOND BLOCK ////////////


        // Category Item List
        $organizationBottom = $item->find('div.organizationBottom', 0);

        $category_item_list = $organizationBottom->find('div.organizationRubricsContainer', 0)->children();

        $categories = [];
        foreach($category_item_list as $category_item) {
            $category_title = $category_item->find('a', 0)->plaintext;

            $a_href = explode('/', $category_item->find('a', 0)->href);
            $category_slug = end($a_href);

            $category = $this->Categories
                ->find()
                ->where([
                    'Categories.slug' => $category_slug,
                    'Categories.title' => $category_title
                ])
                ->first();

            if (!empty($category)) {
                $categories['_ids'][] = $category->id;
            }
        }

        return [
            'country_id' => $country_id,
            'region_id' => $region_id,
            'city_id' => $city_id,
            'slug' => $slug,
            'legal_name' => $legal_name,
            'brand_name' => $brand_name,
            'item_telephones' => $phones,
            'email' => $email,
            'website' => $website,
            'postal_code' => $postal_code,
            'address' => $address,
            'categories' => $categories
        ];
    }

    public function findResult(Query $query, array $options)
    {
        $result = $query
            ->innerJoinWith('Categories', function(Query $q) use ($options) {
                if (!empty($options['category_ids'])) {
                    return $q
                        ->where(['Categories.id IN' => $options['category_ids']]);
                }

                return false;
            })
            ->where(['Items.city_id IN' => $options['city_ids']])
            ->find('live')
            ->distinct('Items.id');

        if (!empty($options['item_ids'])) {
            $result = $result->where(['Items.id NOT IN' => $options['item_ids']]);
        }

        return $result;
    }

    public function findCampaignItems(Query $query, array $options)
    {
        return $query->Campaigns
            ->find('list', [
                'valueField' => 'items_id'
            ])
            ->where([
                'Campaigns.campaign_id' => $options['campaign_id']
            ]);
    }

    public function findLive(Query $query, array $options)
    {
        return $query
            ->find('withEmail')
            ->find('domainSmtpCheck')
            ->where(['Items.is_live' => true]);
    }

    public function findDie(Query $query, array $options)
    {
        return $query
            ->find('withEmail')
            ->find('domainSmtpCheck')
            ->where(['Items.is_live' => false]);
    }

    public function findIncorrect(Query $query, array $options)
    {
        return $query
            ->find('withEmail')
            ->where(function (QueryExpression $exp) {
                return $exp->or_([
                    'is_live' => false,
                    'rfc_validate' => false,
                    'spoof_validate' => false,
                    'dns_validate' => false
                ]);
        });
    }

    public function findWithEmail(Query $query, array $options)
    {
        return $query->where([
            'Items.email IS NOT' => null
        ]);
    }

    public function findDomainSmtpCheck(Query $query, array $options)
    {
        return $query
            ->innerJoinWith('Domains', function ($q) {
                return $q->where(['Domains.smtp_validate' => true]);
            });
    }

    public function findDomainSmtpFailedCheck(Query $query, array $options)
    {
        return $query
            ->innerJoinWith('Domains', function ($q) {
                return $q->where(['Domains.smtp_validate' => false]);
            });
    }

    public function findDistributionByRegions(Query $query, array $options)
    {
        return $query
            ->select([
                'region' => 'Regions.title',
                'quantity' => $query->func()->count('Items.id')
            ])
            ->innerJoinWith('Cities.Regions')
            ->group(['region'])
            ->order(['quantity' => 'DESC']);
    }

    public function findRfcFailedCheck(Query $query, array $options)
    {
        return $query
            ->where(['Items.rfc_validate' => false])
            ->find('withEmail')
        ;
    }

    public function findSpoofFailedCheck(Query $query, array $options)
    {
        return $query
            ->where(['spoof_validate' => false])
            ->find('withEmail')
        ;
    }

    public function findDnsFailedCheck(Query $query, array $options)
    {
        return $query
            ->where(['dns_validate' => false])
            ->find('withEmail')
        ;
    }
}
