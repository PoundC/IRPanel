<?php
namespace IRPanelLinks\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IRCLinks Model
 *
 * @property \IRPanelLinks\Model\Table\IRCUsersTable|\Cake\ORM\Association\BelongsTo $IRCUsers
 *
 * @method \IRPanelLinks\Model\Entity\IRCLink get($primaryKey, $options = [])
 * @method \IRPanelLinks\Model\Entity\IRCLink newEntity($data = null, array $options = [])
 * @method \IRPanelLinks\Model\Entity\IRCLink[] newEntities(array $data, array $options = [])
 * @method \IRPanelLinks\Model\Entity\IRCLink|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \IRPanelLinks\Model\Entity\IRCLink saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \IRPanelLinks\Model\Entity\IRCLink patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \IRPanelLinks\Model\Entity\IRCLink[] patchEntities($entities, array $data, array $options = [])
 * @method \IRPanelLinks\Model\Entity\IRCLink findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class IRCLinksTable extends Table
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

        $this->setTable('i_r_c_links');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('IRCUsers', [
            'foreignKey' => 'i_r_c_users_id',
            'joinType' => 'INNER',
            'className' => 'IRPanelLinks.IRCUsers'
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
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('link')
            ->maxLength('link', 3000)
            ->allowEmptyString('link', false);

        $validator
            ->scalar('searchable')
            ->requirePresence('searchable', 'create')
            ->allowEmptyString('searchable', false);

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
        $rules->add($rules->existsIn(['i_r_c_users_id'], 'IRCUsers'));

        return $rules;
    }
}
