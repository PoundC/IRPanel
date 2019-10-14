<section class="content-header">
  <h1>
    Message
    <small>Compose</small>
  </h1>
  <ol class="breadcrumb">
    <li>
    <?= $this->Html->link('<i class="fa fa-inbox"></i> '.__('Back'), ['action' => 'index'], ['escape' => false]) ?>
    </li>
  </ol>
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
    <!-- left column -->
    <div class="col-md-9">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Compose New Message</h3>
        </div>
        <!-- /.box-header -->
        <?= $this->Form->create(null, ['url' => '/message-new']); ?>
        <div class="box-body">
          <div class="form-group">
            <?= $this->Form->control('to', ['id' => 'to', 'label' => false, 'type' => 'text', 'name' => 'to',
            'placeholder' => 'Enter Recipient Name Here...', 'value' => '', 'class' => 'form-control']); ?>
          </div>
          <div class="form-group">
            <?= $this->Form->control('subject', ['id' => 'subject', 'label' => false, 'type' => 'text', 'name' => 'subject',
            'placeholder' => 'Enter subject here...', 'value' => '', 'class' => 'form-control']); ?>
          </div>
          <div class="form-group">
              <textarea id="compose-textarea" class="form-control" name="message" style="height: 300px"></textarea>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <div class="pull-right">
            <?= $this->Form->button('<i class="fa fa-envelope-o"></i> Send', ['escape' => false,
            'class' => 'btn btn-primary']) ?>
          </div>
          <?= $this->Html->link('Discard', ['action' => 'index'], ['class'=>'btn btn-default']) ?>
        </div>
        <!-- /.box-footer -->
        <?= $this->Form->hidden('to-hidden', ['id' => 'to-hidden']); ?>
        <?= $this->Form->unlockField('to-hidden'); ?>
        <?= $this->Form->unlockField('to'); ?>
        <?= $this->Form->unlockField('subject'); ?>
        <?= $this->Form->unlockField('message'); ?>
        <?= $this->Form->end() ?>
      </div>
      <!-- /. box -->
    </div>
  </div>
</section>
<script type="text/javascript">
    $(function() {
        $('#to').autocomplete({
            source: '/autocomplete',
            minLength: 1,
            select: function(event, ui) {
                $('#to-hidden').val(ui.item.id);
            }
        });
    })
</script>
