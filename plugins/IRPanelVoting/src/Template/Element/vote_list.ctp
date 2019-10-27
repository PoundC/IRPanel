<br/>
<div class="col-lg-12">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= $name ?> List</h3>
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
                    <?php foreach ($i_r_c_vote_proposals as $vote) : ?>
                        <tr>
                            <td><?= h($vote->name) ?></td>
                            <td><?= h($vote->description) ?></td>
                            <td><?= h($vote->yay) ?></td>
                            <td><?= h($vote->nay) ?></td>
                            <td><?= h($vote->abstain) ?></td>
                            <td><?= h($vote->i_r_c_user_registration->registered_nickname) ?></td>
                            <td><?= h($vote->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__d('CakeDC/Users', '[View]'), ['plugin' => 'IRPanelVoting', 'controller' => 'Votes', 'action' => 'view', $vote->id]) ?>
                                <!--<?= $this->Html->link(__d('CakeDC/Users', '[Edit]'), ['plugin' => 'IRPanelVoting', 'controller' => 'Votes', 'action' => 'edit', $vote->id]) ?>
                                <?= $this->Form->postLink(__d('CakeDC/Users', '[Delete]'), ['plugin' => 'IRPanelVoting', 'controller' => 'Votes', 'action' => 'delete', $vote->id], ['confirm' => __d('CakeDC/Users', 'Are you sure you want to delete # {0}?', $vote->id)]) ?> -->
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
