<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CampaignsItems Model
 *
 * @property \App\Model\Table\CampaignsTable|\Cake\ORM\Association\BelongsTo $Campaigns
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\BelongsTo $Items
 *
 * @method \App\Model\Entity\CampaignsItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\CampaignsItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CampaignsItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CampaignsItem|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CampaignsItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CampaignsItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CampaignsItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CampaignsItem findOrCreate($search, callable $callback = null, $options = [])
 */
class CampaignsItemsTable extends Table
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

        $this->setTable('campaigns_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'date_created' => 'new'
                ]
            ]
        ]);

        $this->belongsTo('Campaigns', [
            'foreignKey' => 'campaign_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
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
        $rules->add($rules->existsIn(['campaign_id'], 'Campaigns'));
        $rules->add($rules->existsIn(['item_id'], 'Items'));

        return $rules;
    }

    public function addSubscribers(Array $options)
    {
        $items = $this->Items
            ->find('result', [
                'category_ids' => $options['category_ids'],
                'city_ids' => $options['city_ids'],
                'item_ids' => $options['campaign']['items']
            ])
            ->select(['Items.id'])
            ->toArray();

        $campaignsItems = [];
        foreach($items as $item) {
            $campaignsItems[] = [
                'campaign_id' => $options['campaign']['id'],
                'item_id' => $item->id
            ];
        }

        $campaignsItems = $this->newEntities($campaignsItems);
        foreach($campaignsItems as $campaignsItem) {
            $this->save($campaignsItem);
        }

        return true;
    }
}
