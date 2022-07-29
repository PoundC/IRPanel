<?php
namespace IRPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Comments Model
 *
 * @property \IRPanel\Model\Table\IRCUsersTable|\Cake\ORM\Association\BelongsTo $IRCUsers
 * @property \IRPanel\Model\Table\TableRowsTable|\Cake\ORM\Association\BelongsTo $TableRows
 * @property \IRPanel\Model\Table\CommentsTable|\Cake\ORM\Association\BelongsTo $Comments
 * @property \IRPanel\Model\Table\CommentsTable|\Cake\ORM\Association\HasMany $Comments2
 *
 * @method \IRPanel\Model\Entity\Comment get($primaryKey, $options = [])
 * @method \IRPanel\Model\Entity\Comment newEntity($data = null, array $options = [])
 * @method \IRPanel\Model\Entity\Comment[] newEntities(array $data, array $options = [])
 * @method \IRPanel\Model\Entity\Comment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \IRPanel\Model\Entity\Comment saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \IRPanel\Model\Entity\Comment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \IRPanel\Model\Entity\Comment[] patchEntities($entities, array $data, array $options = [])
 * @method \IRPanel\Model\Entity\Comment findOrCreate($search, callable $callback = null, $options = [])
 */
class CommentsTable extends Table
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

        $this->setTable('comments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('IRCUsers', [
            'foreignKey' => 'i_r_c_users_id',
            'joinType' => 'INNER',
            'className' => 'IRPanel.IRCUsers'
        ]);
        $this->belongsTo('ParentComments', [
            'foreignKey' => 'comment_id',
            'joinType' => 'INNER',
            'className' => 'IRPanel.Comments'
        ])->setConditions(['comment_id' => '0']);

        $this->hasMany('ChildComments', [
            'foreignKey' => 'comment_id',
            'className' => 'IRPanel.Comments'
        ])->setConditions(['comment_id >' => '0']);
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
            ->scalar('comment')
            ->requirePresence('comment', 'create')
            ->allowEmptyString('comment', false);

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
        $rules->add($rules->existsIn(['comment_id'], 'Comments'));

        return $rules;
    }
}
