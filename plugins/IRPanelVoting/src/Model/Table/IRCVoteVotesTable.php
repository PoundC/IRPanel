<?php
namespace IRPanelVoting\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IRCVoteVotes Model
 *
 * @property \IRPanelVoting\Model\Table\IRCVoteProposalsTable|\Cake\ORM\Association\BelongsTo $IRCVoteProposals
 * @property \IRPanelVoting\Model\Table\IRCUserRegistrationsTable|\Cake\ORM\Association\BelongsTo $IRCUserRegistrations
 *
 * @method \IRPanelVoting\Model\Entity\IRCVoteVote get($primaryKey, $options = [])
 * @method \IRPanelVoting\Model\Entity\IRCVoteVote newEntity($data = null, array $options = [])
 * @method \IRPanelVoting\Model\Entity\IRCVoteVote[] newEntities(array $data, array $options = [])
 * @method \IRPanelVoting\Model\Entity\IRCVoteVote|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \IRPanelVoting\Model\Entity\IRCVoteVote saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \IRPanelVoting\Model\Entity\IRCVoteVote patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \IRPanelVoting\Model\Entity\IRCVoteVote[] patchEntities($entities, array $data, array $options = [])
 * @method \IRPanelVoting\Model\Entity\IRCVoteVote findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class IRCVoteVotesTable extends Table
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

        $this->setTable('i_r_c_vote_votes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('IRCVoteProposals', [
            'foreignKey' => 'i_r_c_vote_proposal_id',
            'joinType' => 'INNER',
            'className' => 'IRPanelVoting.IRCVoteProposals'
        ]);
        $this->belongsTo('IRCUserRegistrations', [
            'foreignKey' => 'i_r_c_user_registration_id',
            'joinType' => 'INNER',
            'className' => 'IRPanelVoting.IRCUserRegistrations'
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
            ->scalar('vote')
            ->requirePresence('vote', 'create')
            ->allowEmptyString('vote', false);

        $validator
            ->scalar('message')
            ->requirePresence('message', 'create')
            ->allowEmptyString('message', true);

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
        $rules->add($rules->existsIn(['i_r_c_vote_proposal_id'], 'IRCVoteProposals'));
        $rules->add($rules->existsIn(['i_r_c_user_registration_id'], 'IRCUserRegistrations'));

        return $rules;
    }
}
