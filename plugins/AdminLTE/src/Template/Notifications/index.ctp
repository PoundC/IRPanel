<?php

use AdminLTE\Utility\Dates;

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Notifications
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Recent Notifications</h3>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <div class="table-responsive mailbox-messages">
                        <?= $this->Form->create(null, ['url' => '/notifications']); ?>
                        <div class="mailbox-controls">

                        </div>
                        <table class="table table-hover table-striped table-bordered">
                            <thead><th></th><th>Notification</th><th></th></thead>
                            <tbody>
                            <?php foreach ($notifications as $notification): ?>
                            <tr>
                                <td nowrap="true" class="mailbox-name label-<?= $notification['color'] ?>"><center><i class="<?php echo $notification['type']; ?>"></i></center></td>
                                <td class="mailbox-subject" style="width:70%"><a href="<?= $notification['link'] ?>"><?= $notification['message'] ?></a></td>
                                <td class="mailbox-date" style="white-space: nowrap;"><?= Dates::getLapsedTime($notification['created']) ?> ago</td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?= $this->Form->end() ?>
                    </div>
                    <!-- /.mail-box-messages -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer no-padding">
                    <div class="mailbox-controls">
                        <center>
                            <div class="paginator">
                                <ul class="pagination">
                                    <?= $this->Paginator->first('<< ' . __('first')) ?>
                                    <?= $this->Paginator->prev('< ' . __('previous')) ?>
                                    <?= $this->Paginator->numbers() ?>
                                    <?= $this->Paginator->next(__('next') . ' >') ?>
                                    <?= $this->Paginator->last(__('last') . ' >>') ?>
                                </ul>
                                <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
                            </div>
                        </center>
                    </div>
                </div>
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
    </div>
</section>
<!-- /.content -->
