<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;

/**
 * Domains Model
 *
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\HasMany $Items
 *
 * @method \App\Model\Entity\Domain get($primaryKey, $options = [])
 * @method \App\Model\Entity\Domain newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Domain[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Domain|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Domain saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Domain patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Domain[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Domain findOrCreate($search, callable $callback = null, $options = [])
 */
class DomainsTable extends Table
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

        $this->setTable('domains');
        $this->setDisplayField('domain');
        $this->setPrimaryKey('id');

        $this->hasMany('Items', [
            'foreignKey' => 'domain_id'
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
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('domain')
            ->maxLength('domain', 255)
            ->requirePresence('domain', 'create')
            ->notEmptyString('domain');

        return $validator;
    }

    public function findSmtpCheck(Query $query, array $options)
    {
        return $query->where([
            'Domains.smtp_validate' => true
        ]);
    }

    public function findSmtpFailedCheck(Query $query, array $options)
    {
        return $query->where([
            'Domains.smtp_validate' => false
        ]);
    }
}
