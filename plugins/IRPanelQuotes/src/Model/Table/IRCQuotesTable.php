<?php
namespace IRPanelQuotes\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IRCQuotes Model
 *
 * @property \IRPanelQuotes\Model\Table\IRCUsersTable|\Cake\ORM\Association\BelongsTo $IRCUsers
 *
 * @method \IRPanelQuotes\Model\Entity\IRCQuote get($primaryKey, $options = [])
 * @method \IRPanelQuotes\Model\Entity\IRCQuote newEntity($data = null, array $options = [])
 * @method \IRPanelQuotes\Model\Entity\IRCQuote[] newEntities(array $data, array $options = [])
 * @method \IRPanelQuotes\Model\Entity\IRCQuote|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \IRPanelQuotes\Model\Entity\IRCQuote saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \IRPanelQuotes\Model\Entity\IRCQuote patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \IRPanelQuotes\Model\Entity\IRCQuote[] patchEntities($entities, array $data, array $options = [])
 * @method \IRPanelQuotes\Model\Entity\IRCQuote findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class IRCQuotesTable extends Table
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

        $this->setTable('i_r_c_quotes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('IRCUsers', [
            'foreignKey' => 'i_r_c_user_id',
            'joinType' => 'INNER',
            'className' => 'IRPanelQuotes.IRCUsers'
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
            ->scalar('quote')
            ->requirePresence('quote', 'create')
            ->allowEmptyString('quote', false);

        $validator
            ->scalar('topic')
            ->requirePresence('topic', 'create')
            ->allowEmptyString('topic', false);

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
        $rules->add($rules->existsIn(['i_r_c_user_id'], 'IRCUsers'));

        return $rules;
    }
}
