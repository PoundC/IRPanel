<?php
namespace IRPanelGame\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IRCGamePlayerFeatures Model
 *
 * @property \IRPanelGame\Model\Table\IRCGamePlayersTable|\Cake\ORM\Association\BelongsTo $IRCGamePlayers
 * @property \IRPanelGame\Model\Table\IRCGameFeaturesTable|\Cake\ORM\Association\BelongsTo $IRCGameFeatures
 *
 * @method \IRPanelGame\Model\Entity\IRCGamePlayerFeature get($primaryKey, $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGamePlayerFeature newEntity($data = null, array $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGamePlayerFeature[] newEntities(array $data, array $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGamePlayerFeature|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGamePlayerFeature saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGamePlayerFeature patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGamePlayerFeature[] patchEntities($entities, array $data, array $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGamePlayerFeature findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class IRCGamePlayerFeaturesTable extends Table
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

        $this->setTable('i_r_c_game_player_features');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('IRCGamePlayers', [
            'foreignKey' => 'i_r_c_game_player_id',
            'joinType' => 'INNER',
            'className' => 'IRPanelGame.IRCGamePlayers'
        ]);
        $this->belongsTo('IRCGameFeatures', [
            'foreignKey' => 'i_r_c_game_feature_id',
            'joinType' => 'INNER',
            'className' => 'IRPanelGame.IRCGameFeatures'
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
            ->integer('power_power')
            ->requirePresence('power_power', 'create')
            ->allowEmptyString('power_power', false);

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
        $rules->add($rules->existsIn(['i_r_c_game_feature_id'], 'IRCGameFeatures'));

        return $rules;
    }
}
