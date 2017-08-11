<div class="row jlr-dashbox">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Crontabs List</h3>
            </div>
            <div class="box-body">
                <div class="users index col-lg-12 col-md-12 columns">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('schedule', 'Schedule') ?></th>
                            <th><?= $this->Paginator->sort('name', 'Name') ?></th>
                            <th><?= $this->Paginator->sort('command', 'Command') ?></th>
                            <th><?= $this->Paginator->sort('locked', 'Locked') ?></th>
                            <th><?= $this->Paginator->sort('timeout', 'Timeout') ?></th>
                            <th><?= 'Status' ?></th>
                            <th class="actions"><?= 'Actions' ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach (${$tableAlias} as $crontab) : ?>
                        <tr>
                            <td><?= h($crontab->schedule) ?></td>
                            <td><?= h($crontab->name) ?></td>
                            <td><?= h($crontab->command) ?></td>
                            <td><?= h($crontab->locked) ?></td>
                            <td><?= h($crontab->timeout) ?></td>
                            <?php $green = true; ?>
                            <?php foreach($crontab->logs as $log) { ?>

                            <?php if($log->success == '-1') { $green = false; break; } ?>

                            <?php } ?>
                            <?php if($green == true) { ?>
                            <td style="background-color: green; color: white;">
                                GREEN
                                <?php } else { ?>
                            <td style="background-color: red; color: white;">
                                RED
                            <?php } ?>
                            </td>
                            <td class="actions">
                                <?= $this->Html->link('[ View ]', ['controller' => 'Crontab', 'action' => 'log', $crontab->id]) ?>
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
</div>