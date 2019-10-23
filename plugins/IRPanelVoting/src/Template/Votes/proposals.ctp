<br/><br/><br/>
<div class="col-lg-10 col-lg-offset-1">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Proposals List</h3>
        </div>
        <div class="box-body">
            <div class="users index col-lg-12 col-md-12 columns">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('name', 'Name') ?></th>
                        <th>Description</th>
                        <th><?= $this->Paginator->sort('yay', 'Yay') ?></th>
                        <th><?= $this->Paginator->sort('nay', 'Nay') ?></th>
                        <th><?= $this->Paginator->sort('abstain', 'Abstain') ?></th>
                        <th><?= $this->Paginator->sort('registered_nickname', 'Created By') ?></th>
                        <th><?= $this->Paginator->sort('created', 'Created On') ?></th>
                        <th class="actions">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach (${$tableAlias} as $user) : ?>
                        <tr>
                            <td><?= h($user->username) ?></td>
                            <td><?= h($user->email) ?></td>
                            <td><?= h($user->first_name) ?></td>
                            <td><?= h($user->last_name) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__d('CakeDC/Users', '[ View ]'), ['controller' => 'Users', 'action' => 'profile', $user->id]) ?>
                                <?= $this->Html->link(__d('CakeDC/Users', '[ Change password ]'), ['controller' => 'Users', 'action' => 'changePassword', $user->id]) ?>
                                <?= $this->Html->link(__d('CakeDC/Users', '[ Edit ]'), ['controller' => 'Users', 'action' => 'edit', $user->id]) ?>
                                <?= $this->Form->postLink(__d('CakeDC/Users', '[ Delete ]'), ['action' => 'delete', $user->id], ['confirm' => __d('CakeDC/Users', 'Are you sure you want to delete # {0}?', $user->id)]) ?>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>
        <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin pull-right">
                <li><a href="#">&laquo;</a></li>
                <?= $this->Paginator->prev('< ' . __d('CakeDC/Users', 'previous')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__d('CakeDC/Users', 'next') . ' >') ?>
            </ul>
            <p><?= $this->Paginator->counter() ?></p>
        </div>
    </div>
</div>
