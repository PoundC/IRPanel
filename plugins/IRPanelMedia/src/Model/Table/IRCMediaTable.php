<?php
namespace IRPanelMedia\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IRCMedia Model
 *
 * @property \IRPanelMedia\Model\Table\IRCUsersTable|\Cake\ORM\Association\BelongsTo $IRCUsers
 * @property \IRPanelMedia\Model\Table\IRCMediaGalleriesTable|\Cake\ORM\Association\HasMany $IRCMediaGalleries
 *
 * @method \IRPanelMedia\Model\Entity\IRCMedia get($primaryKey, $options = [])
 * @method \IRPanelMedia\Model\Entity\IRCMedia newEntity($data = null, array $options = [])
 * @method \IRPanelMedia\Model\Entity\IRCMedia[] newEntities(array $data, array $options = [])
 * @method \IRPanelMedia\Model\Entity\IRCMedia|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \IRPanelMedia\Model\Entity\IRCMedia saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \IRPanelMedia\Model\Entity\IRCMedia patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \IRPanelMedia\Model\Entity\IRCMedia[] patchEntities($entities, array $data, array $options = [])
 * @method \IRPanelMedia\Model\Entity\IRCMedia findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class IRCMediaTable extends Table
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

        $this->setTable('i_r_c_media');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('IRCUsers', [
            'foreignKey' => 'i_r_c_users_id',
            'joinType' => 'INNER',
            'className' => 'IRPanelMedia.IRCUsers'
        ]);
        $this->belongsTo('IRCChannels', [
            'foreignKey' => 'i_r_c_channel_id',
            'joinType' => 'INNER',
            'className' => 'IRPanelMedia.IRCChannels'
        ]);
        $this->hasMany('IRCMediaGalleries', [
            'foreignKey' => 'i_r_c_media_id',
            'className' => 'IRPanelMedia.IRCMediaGalleries'
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

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->allowEmptyString('description', false);

        $validator
            ->scalar('title')
            ->requirePresence('title', 'create')
            ->allowEmptyString('title', false);

        $validator
            ->scalar('media_type')
            ->maxLength('media_type', 32)
            ->requirePresence('media_type', 'create')
            ->allowEmptyString('media_type', false);

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
