<div class="row jlr-dashbox">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Open Chats List</h3>
            </div>
            <div class="box-body">
                <div class="users index col-lg-12 col-md-12 columns">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('users.id', 'User ID') ?></th>
                            <th><?= $this->Paginator->sort('active', 'Last Active') ?></th>
                            <th><?= $this->Paginator->sort('user_id', 'Assigned To') ?></th>
                            <th class="actions"><?= 'Actions' ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach (${$tableAlias} as $openchat) : ?>
                        <tr>
                            <td><?= h($openchat->room->name) ?></td>
                            <td><?= h($openchat->active) ?></td>
                            <?php if(isset($openchat->user->username)) { ?>
                                <td><?= h($openchat->user->username) ?></td>
                            <?php } else { echo '<td>Not Assigned Yet</td>'; } ?>
                            <td class="actions">
                                <?php if(isset($openchat->user->username) == false) { ?>

                                    <?= $this->Html->link('[ Open & Assign ]', '/chat/' . $openchat->room->name . '?assign=true') ?>

                                <?php } else { ?>

                                    <?= $this->Html->link('[ View Open Chat ]', '/chat/' . $openchat->room->name) ?>

                                <?php } ?>

                                <?= $this->Form->postLink('[ Close Chat ]', ['url' => '/closechat/' . $openchat->room->name], ['confirm' => 'Are you sure you want to close this chat?']) ?>
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
                    <?= $this->Paginator->prev('< ' . 'previous') ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next('next' . ' >') ?>
                </ul>
                <p><?= $this->Paginator->counter() ?></p>
            </div>
        </div>
    </div>
</div>