<div class="row jlr-dashbox">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $boxTitle ?></h3>
            </div>
            <div class="box-body">
                <div class="users index col-lg-12 col-md-12 columns">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('created', 'Created') ?></th>
                            <th><?= $this->Paginator->sort('success', 'Success') ?></th>
                            <th class="actions"><?= 'Actions' ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach (${$tableAlias} as $crontabLog) : ?>
                        <tr>
                            <td><?= $crontabLog->created ?></td>
                            <?php $green = true; ?>

                            <?php if($crontabLog->success == '-1') { $green = false; break; } ?>

                            <?php if($green == true) { ?>
                            <td style="background-color: green; color: white;">
                                GREEN
                                <?php } else { ?>
                            <td style="background-color: red; color: white;">
                                RED
                                <?php } ?>
                            </td>
                            <td class="actions">
                                <?= $this->Html->link('[ View ]', ['controller' => 'Crontab', 'action' => 'viewlog', $crontabLog->id]) ?>
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