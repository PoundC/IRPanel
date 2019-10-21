<?php
namespace IRPanelGame\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IRCGameLogs Model
 *
 * @property \IRPanelGame\Model\Table\IRCGamePlayersTable|\Cake\ORM\Association\BelongsTo $IRCGamePlayers
 * @property \IRPanelGame\Model\Table\IRCFeatureTextsTable|\Cake\ORM\Association\BelongsTo $IRCFeatureTexts
 * @property \IRPanelGame\Model\Table\IRCGameBetsTable|\Cake\ORM\Association\HasMany $IRCGameBets
 *
 * @method \IRPanelGame\Model\Entity\IRCGameLog get($primaryKey, $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGameLog newEntity($data = null, array $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGameLog[] newEntities(array $data, array $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGameLog|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGameLog saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGameLog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGameLog[] patchEntities($entities, array $data, array $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGameLog findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class IRCGameLogsTable extends Table
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

        $this->setTable('i_r_c_game_logs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('IRCGamePlayers', [
            'foreignKey' => 'i_r_c_game_player_id',
            'joinType' => 'INNER',
            'className' => 'IRPanelGame.IRCGamePlayers'
        ]);
        $this->belongsTo('IRCFeatureTexts', [
            'foreignKey' => 'i_r_c_feature_text_id',
            'joinType' => 'INNER',
            'className' => 'IRPanelGame.IRCFeatureTexts'
        ]);
        $this->hasMany('IRCGameBets', [
            'foreignKey' => 'i_r_c_game_log_id',
            'className' => 'IRPanelGame.IRCGameBets'
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
            ->scalar('feature_type')
            ->maxLength('feature_type', 64)
            ->requirePresence('feature_type', 'create')
            ->allowEmptyString('feature_type', false);

        $validator
            ->scalar('feature_name')
            ->maxLength('feature_name', 64)
            ->requirePresence('feature_name', 'create')
            ->allowEmptyString('feature_name', false);

        $validator
            ->integer('power_cash')
            ->requirePresence('power_cash', 'create')
            ->allowEmptyString('power_cash', false);

        $validator
            ->integer('power_points')
            ->requirePresence('power_points', 'create')
            ->allowEmptyString('power_points', false);

        $validator
            ->integer('power_score')
            ->requirePresence('power_score', 'create')
            ->allowEmptyString('power_score', false);

        $validator
            ->integer('power_power')
            ->requirePresence('power_power', 'create')
            ->allowEmptyString('power_power', false);

        $validator
            ->integer('power_multiplier')
            ->requirePresence('power_multiplier', 'create')
            ->allowEmptyString('power_multiplier', false);

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
        $rules->add($rules->existsIn(['i_r_c_game_player_id'], 'IRCGamePlayers'));
        $rules->add($rules->existsIn(['i_r_c_feature_text_id'], 'IRCFeatureTexts'));

        return $rules;
    }
}
