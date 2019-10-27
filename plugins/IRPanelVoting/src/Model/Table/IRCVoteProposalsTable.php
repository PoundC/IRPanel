<?php
namespace IRPanelVoting\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IRCVoteProposals Model
 *
 * @property \IRPanelVoting\Model\Table\IRCUserRegistrationsTable|\Cake\ORM\Association\BelongsTo $IRCUserRegistrations
 * @property \IRPanelVoting\Model\Table\IRCVoteVotesTable|\Cake\ORM\Association\HasMany $IRCVoteVotes
 *
 * @method \IRPanelVoting\Model\Entity\IRCVoteProposal get($primaryKey, $options = [])
 * @method \IRPanelVoting\Model\Entity\IRCVoteProposal newEntity($data = null, array $options = [])
 * @method \IRPanelVoting\Model\Entity\IRCVoteProposal[] newEntities(array $data, array $options = [])
 * @method \IRPanelVoting\Model\Entity\IRCVoteProposal|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \IRPanelVoting\Model\Entity\IRCVoteProposal saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \IRPanelVoting\Model\Entity\IRCVoteProposal patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \IRPanelVoting\Model\Entity\IRCVoteProposal[] patchEntities($entities, array $data, array $options = [])
 * @method \IRPanelVoting\Model\Entity\IRCVoteProposal findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class IRCVoteProposalsTable extends Table
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

        $this->setTable('i_r_c_vote_proposals');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('IRCUserRegistrations', [
            'foreignKey' => 'i_r_c_user_registration_id',
            'joinType' => 'INNER',
            'className' => 'IRPanelVoting.IRCUserRegistrations'
        ]);
        $this->hasMany('IRCVoteVotes', [
            'foreignKey' => 'i_r_c_vote_proposal_id',
            'className' => 'IRPanelVoting.IRCVoteVotes'
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
            ->scalar('name')
            ->maxLength('name', 128)
            ->allowEmptyString('name', false);

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->allowEmptyString('description', false);

        $validator
            ->integer('yay')
            ->requirePresence('yay', 'create')
            ->allowEmptyString('yay', false);

        $validator
            ->integer('nay')
            ->requirePresence('nay', 'create')
            ->allowEmptyString('nay', false);

        $validator
            ->integer('abstain')
            ->requirePresence('abstain', 'create')
            ->allowEmptyString('abstain', false);

        $validator
            ->integer('completed')
            ->allowEmptyString('completed', false);

        $validator
            ->integer('vetting')
            ->allowEmptyString('vetting', false);

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
        $rules->add($rules->existsIn(['i_r_c_user_registration_id'], 'IRCUserRegistrations'));

        return $rules;
    }
}
