<?php

use App\Utility\Dates;

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
                            <?= $this->Form->button('<i class="far fa-square"></i>', ['escape' => false, 'class' => 'btn btn-default btn-sm checkbox-toggle', 'name' => 'submit', 'value' => 'checkAll']) ?>
                            <div class="btn-group">
                                <?= $this->Form->button('<i class="far fa-trash-alt"></i>', ['escape' => false, 'class' => 'btn btn-default btn-sm', 'name' => 'submit', 'value' => 'deleteChecked']) ?>
                            </div>
                            <!-- /.pull-right -->
                        </div>
                        <table class="table table-hover table-striped table-bordered">
                            <thead><th></th><th></th><th>Notification</th><th></th></thead>
                            <tbody>
                            <?php foreach ($notifications as $notification): ?>
                            <tr>
                                <td><input type="checkbox" name="checkie[]" value="<?= $notification['id'] ?>" <?php if($checkAll == true) { ?>checked<?php } ?>></td>
                                <?php switch($notification['type']) {
                                            case 'newuser':
                                                $icon = 'user';
                                                $color = 'text-green';
                                                break;
                                            case 'users':
                                                $icon = 'users';
                                                $color = 'text-aqua';
                                                break;
                                            case 'alert':
                                                $icon = 'warning';
                                                $color = 'text-yellow';
                                                break;
                                            case 'sale':
                                                $icon = 'shopping-cart';
                                                $color = 'text-green';
                                                break;
                                            } ?>
                                <td nowrap="true" class="mailbox-name"><center><i class="fa fa-<?php echo $icon; ?> <?= $color ?>"></i></center></td>
                                <td class="mailbox-subject" style="width:70%"><?= $notification['message'] ?></td>
                                <td class="mailbox-date" style="white-space: nowrap;"><?= Dates::getLapsedTime($notification['created']) ?> ago</td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?= $this->Form->unlockField('checkie') ?>
                        <?= $this->Form->end() ?>
                    </div>
                    <!-- /.mail-box-messages -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer no-padding">
                    <div class="mailbox-controls">
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
                    </div>
                </div>
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
    </div>
</section>
<!-- /.content -->
