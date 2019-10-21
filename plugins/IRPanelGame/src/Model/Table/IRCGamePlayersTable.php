<?php
namespace IRPanelGame\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IRCGamePlayers Model
 *
 * @property \IRPanelGame\Model\Table\IRCUserRegistrationsTable|\Cake\ORM\Association\BelongsTo $IRCUserRegistrations
 * @property \IRPanelGame\Model\Table\IRCGameBetsTable|\Cake\ORM\Association\HasMany $IRCGameBets
 * @property \IRPanelGame\Model\Table\IRCGameFeatureTextsTable|\Cake\ORM\Association\HasMany $IRCGameFeatureTexts
 * @property \IRPanelGame\Model\Table\IRCGameLogsTable|\Cake\ORM\Association\HasMany $IRCGameLogs
 * @property \IRPanelGame\Model\Table\IRCGameLottoWinsTable|\Cake\ORM\Association\HasMany $IRCGameLottoWins
 * @property \IRPanelGame\Model\Table\IRCGamePlayerFeaturesTable|\Cake\ORM\Association\HasMany $IRCGamePlayerFeatures
 *
 * @method \IRPanelGame\Model\Entity\IRCGamePlayer get($primaryKey, $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGamePlayer newEntity($data = null, array $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGamePlayer[] newEntities(array $data, array $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGamePlayer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGamePlayer saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGamePlayer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGamePlayer[] patchEntities($entities, array $data, array $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGamePlayer findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class IRCGamePlayersTable extends Table
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

        $this->setTable('i_r_c_game_players');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('IRCUserRegistrations', [
            'foreignKey' => 'i_r_c_user_registration_id',
            'joinType' => 'INNER',
            'className' => 'IRPanelGame.IRCUserRegistrations'
        ]);
        $this->hasMany('IRCGameBets', [
            'foreignKey' => 'i_r_c_game_player_id',
            'className' => 'IRPanelGame.IRCGameBets'
        ]);
        $this->hasMany('IRCGameFeatureTexts', [
            'foreignKey' => 'i_r_c_game_player_id',
            'className' => 'IRPanelGame.IRCGameFeatureTexts'
        ]);
        $this->hasMany('IRCGameLogs', [
            'foreignKey' => 'i_r_c_game_player_id',
            'className' => 'IRPanelGame.IRCGameLogs'
        ]);
        $this->hasMany('IRCGameLottoWins', [
            'foreignKey' => 'i_r_c_game_player_id',
            'className' => 'IRPanelGame.IRCGameLottoWins'
        ]);
        $this->hasMany('IRCGamePlayerFeatures', [
            'foreignKey' => 'i_r_c_game_player_id',
            'className' => 'IRPanelGame.IRCGamePlayerFeatures'
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
            ->integer('cash')
            ->requirePresence('cash', 'create')
            ->allowEmptyString('cash', false);

        $validator
            ->integer('points')
            ->requirePresence('points', 'create')
            ->allowEmptyString('points', false);

        $validator
            ->integer('score')
            ->requirePresence('score', 'create')
            ->allowEmptyString('score', false);

        $validator
            ->integer('power')
            ->requirePresence('power', 'create')
            ->allowEmptyString('power', false);

        $validator
            ->scalar('war_cry')
            ->requirePresence('war_cry', 'create')
            ->allowEmptyString('war_cry', false);

        $validator
            ->scalar('o_noise')
            ->requirePresence('o_noise', 'create')
            ->allowEmptyString('o_noise', false);

        $validator
            ->scalar('hack_words')
            ->requirePresence('hack_words', 'create')
            ->allowEmptyString('hack_words', false);

        $validator
            ->scalar('steal_slogan')
            ->requirePresence('steal_slogan', 'create')
            ->allowEmptyString('steal_slogan', false);

        $validator
            ->scalar('smack_words')
            ->requirePresence('smack_words', 'create')
            ->allowEmptyString('smack_words', false);

        $validator
            ->scalar('greeting')
            ->requirePresence('greeting', 'create')
            ->allowEmptyString('greeting', false);

        $validator
            ->integer('lotto_one')
            ->requirePresence('lotto_one', 'create')
            ->allowEmptyString('lotto_one', false);

        $validator
            ->integer('lotto_two')
            ->requirePresence('lotto_two', 'create')
            ->allowEmptyString('lotto_two', false);

        $validator
            ->integer('lotto_three')
            ->requirePresence('lotto_three', 'create')
            ->allowEmptyString('lotto_three', false);

        $validator
            ->integer('lotto_four')
            ->requirePresence('lotto_four', 'create')
            ->allowEmptyString('lotto_four', false);

        $validator
            ->integer('lotto_five')
            ->requirePresence('lotto_five', 'create')
            ->allowEmptyString('lotto_five', false);

        $validator
            ->integer('lotto_six')
            ->requirePresence('lotto_six', 'create')
            ->allowEmptyString('lotto_six', false);

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
