<?php

use AdminLTE\Utility\Dates;

?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Messages
  </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-3">
      <a href="/message-new" class="btn btn-primary btn-block margin-bottom">Compose</a>
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Folders</h3>
        </div>
        <div class="box-body no-padding">
          <ul class="nav nav-pills nav-stacked">
            <li class="<?= $userActive ?>">
              <a href="/messages?inbox=user">
                <i class="fa fa-inbox"></i>
                User Inbox
                <span class="label label-<?php
                if($userCount > 0) {
                  echo 'success';
                } else {
                  echo 'primary';
                } ?> pull-right">
                  <?= $userCount ?>
                </span>
              </a>
            </li>
              <li class="<?= $sentActive ?>">
                  <a href="/messages?inbox=sent">
                      <i class="fa fa-envelope-o"></i>
                      Sent box
                  </a>
              </li>
              <li class="<?= $deletedActive ?>">
                  <a href="/messages?inbox=deleted">
                      <i class="fa fa-trash-o"></i>
                      Deleted Box
                  </a>
              </li>
          </ul>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="col-md-9">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><?= $inboxTitle ?></h3>
          <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <div class="table-responsive mailbox-messages">
            <?= $this->Form->create(null, ['url' => $url]); ?>
              <?php if($deletedActive == '') { ?>
                <div class="mailbox-controls">
                    <?php if($checkAll == true) { ?>
                        <?= $this->Form->button('<i class="fa fa-check-square-o"></i>', ['escape' => false, 'class' => 'btn btn-default btn-sm checkbox-toggle', 'name' => 'submit', 'value' => 'checkNone']) ?>
                    <?php } else { ?>
                        <?= $this->Form->button('<i class="fa fa-square-o"></i>', ['escape' => false, 'class' => 'btn btn-default btn-sm checkbox-toggle', 'name' => 'submit', 'value' => 'checkAll']) ?>
                    <?php } ?>
                  <div class="btn-group">
                    <?= $this->Form->button('<i class="fa fa-trash-o"></i>', ['escape' => false, 'class' => 'btn btn-default btn-sm', 'name' => 'submit', 'value' => 'deleteChecked']) ?>
                  </div>
                  <!-- /.pull-right -->
                </div>
              <?php } else { ?>
              <div class="mailbox-controls">&nbsp;</div>
              <?php } ?>
            <table class="table table-hover table-striped table-bordered">
                <thead><th></th><th>Sender</th><th></th><th>Subject</th><th></th><th></th></thead>
              <tbody>
              <?php foreach ($messages as $message): ?>
              <tr>
                  <?php if($deletedActive == '') { ?><td><input type="checkbox" name="checkie[]" value="<?= $message->id ?>" <?php if($checkAll == true) { ?>checked<?php } ?>></td><?php } else { ?><td>&nbsp;</td><?php } ?>
                <?php if($user_id == $message->user_id) { ?>
                  <td nowrap="true" class="mailbox-name"><?= h($message->user->first_name . ' ' . $message->user->last_name) ?></td>
                  <td><span class="label label-primary pull-right">READ</span></td>
                <?php } else { ?>
                  <td nowrap="true" class="mailbox-name"><?= $message->has('user') ? $this->Html->link($message->user->first_name . ' ' . $message->user->last_name, ['controller' => 'Users', 'action' => 'view', $message->user->id], ['target' => '_blank', 'style' => 'color: black;']) : 'Unknown Error' ?></td>
                  <?php if($message->recipient_read == 0) { ?>
                    <td><span class="label label-success pull-right">UNREAD</span></td>
                  <?php } else { ?>
                    <td><span class="label label-primary pull-right">READ</span></td>
                  <?php } ?>
                <?php } ?>
                <td class="mailbox-subject" style="width:100%"><?= $this->Html->link($message->subject, ['action' => 'view', $message->id], ['target' => '_blank']) ?></td>
                <td class="mailbox-date" style="white-space: nowrap;"><?= Dates::getLapsedTime($message->created) ?> ago</td>
                <td class="actions" style="white-space:nowrap">
                  <?= $this->Html->link(__('View'), ['action' => 'view', $message->id], ['class'=>'btn btn-info btn-xs', 'target' => '_blank']) ?>
                </td>
              </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
            <?= $this->Form->unlockField('checkie') ?>
            <?= $this->Form->end() ?>
            <!-- /.table -->
              <?php if(count($messages) > 0) { ?>
              <span><center><p>Click subject to open message.</p></center></span>
              <?php } else { ?>
              <span><center><p>You do not have any messages at this time.</p></center></span>
              <?php } ?>
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
