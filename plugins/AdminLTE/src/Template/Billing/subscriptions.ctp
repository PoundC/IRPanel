<div class="row jlr-dashbox">
    <div class="col-md-10 col-md-offset-1">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Subscriptions</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

                <div class="row">
                    <div class="col-sm-12">
                        <table id="example1" class="table table-bordered table-striped dataTable" role="grid"
                               aria-describedby="example1_info">
                            <thead>
                            <tr>
                                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('subscription_id') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($usersSubscriptions as $usersSubscription): ?>
                            <tr>
                                <td><?= $this->Number->format($usersSubscription->id) ?></td>
                                <td><?= $usersSubscription->has('user') ? $this->Html->link($usersSubscription->user->username, ['controller' => 'Users', 'action' => 'profile', $usersSubscription->user->id]) : '' ?></td>
                                <td><?= h($usersSubscription->subscription_id) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('View'), ['action' => 'view', $usersSubscription->id]) ?>
                                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $usersSubscription->id]) ?>
                                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $usersSubscription->id], ['confirm' => __('Are you sure you want to delete # {0}?', $usersSubscription->id)]) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box-footer">
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
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
<!-- /.col -->
</div>

