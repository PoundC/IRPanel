<?php
namespace IRPanelGame\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IRCGameFeatures Model
 *
 * @property \IRPanelGame\Model\Table\IRCGameFeatureTextsTable|\Cake\ORM\Association\HasMany $IRCGameFeatureTexts
 * @property \IRPanelGame\Model\Table\IRCGamePlayerFeaturesTable|\Cake\ORM\Association\HasMany $IRCGamePlayerFeatures
 *
 * @method \IRPanelGame\Model\Entity\IRCGameFeature get($primaryKey, $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGameFeature newEntity($data = null, array $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGameFeature[] newEntities(array $data, array $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGameFeature|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGameFeature saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGameFeature patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGameFeature[] patchEntities($entities, array $data, array $options = [])
 * @method \IRPanelGame\Model\Entity\IRCGameFeature findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class IRCGameFeaturesTable extends Table
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

        $this->setTable('i_r_c_game_features');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('IRCGameFeatureTexts', [
            'foreignKey' => 'i_r_c_game_feature_id',
            'className' => 'IRPanelGame.IRCGameFeatureTexts'
        ]);
        $this->hasMany('IRCGamePlayerFeatures', [
            'foreignKey' => 'i_r_c_game_feature_id',
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
            ->scalar('feature_use')
            ->requirePresence('feature_use', 'create')
            ->allowEmptyString('feature_use', false);

        $validator
            ->scalar('feature_help')
            ->requirePresence('feature_help', 'create')
            ->allowEmptyString('feature_help', false);

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
            ->integer('power_multiplier_min')
            ->requirePresence('power_multiplier_min', 'create')
            ->allowEmptyString('power_multiplier_min', false);

        $validator
            ->integer('power_multiplier_max')
            ->requirePresence('power_multiplier_max', 'create')
            ->allowEmptyString('power_multiplier_max', false);

        $validator
            ->integer('power_multiplier_weight')
            ->requirePresence('power_multiplier_weight', 'create')
            ->allowEmptyString('power_multiplier_weight', false);

        $validator
            ->integer('daily_use_limit')
            ->requirePresence('daily_use_limit', 'create')
            ->allowEmptyString('daily_use_limit', false);

        $validator
            ->integer('buy_cost_weight')
            ->requirePresence('buy_cost_weight', 'create')
            ->allowEmptyString('buy_cost_weight', false);

        $validator
            ->integer('order_index')
            ->requirePresence('order_index', 'create')
            ->allowEmptyString('order_index', false);

        return $validator;
    }
}
