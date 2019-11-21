<?php
namespace IRPanelMedia\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IRCMediaGalleries Model
 *
 * @property \IRPanelMedia\Model\Table\IRCMediaTable|\Cake\ORM\Association\BelongsTo $IRCMedia
 *
 * @method \IRPanelMedia\Model\Entity\IRCMediaGallery get($primaryKey, $options = [])
 * @method \IRPanelMedia\Model\Entity\IRCMediaGallery newEntity($data = null, array $options = [])
 * @method \IRPanelMedia\Model\Entity\IRCMediaGallery[] newEntities(array $data, array $options = [])
 * @method \IRPanelMedia\Model\Entity\IRCMediaGallery|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \IRPanelMedia\Model\Entity\IRCMediaGallery saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \IRPanelMedia\Model\Entity\IRCMediaGallery patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \IRPanelMedia\Model\Entity\IRCMediaGallery[] patchEntities($entities, array $data, array $options = [])
 * @method \IRPanelMedia\Model\Entity\IRCMediaGallery findOrCreate($search, callable $callback = null, $options = [])
 */
class IRCMediaGalleriesTable extends Table
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

        $this->setTable('i_r_c_media_galleries');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('IRCMedia', [
            'foreignKey' => 'i_r_c_media_id',
            'joinType' => 'INNER',
            'className' => 'IRPanelMedia.IRCMedia'
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
            ->scalar('media_url')
            ->maxLength('media_url', 3000)
            ->allowEmptyString('media_url', false);

        $validator
            ->scalar('media_type')
            ->maxLength('media_type', 16)
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
        $rules->add($rules->existsIn(['i_r_c_media_id'], 'IRCMedia'));

        return $rules;
    }
}
