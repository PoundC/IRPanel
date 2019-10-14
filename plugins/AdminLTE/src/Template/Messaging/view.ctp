<section class="content-header">
    <h1>
        <?php echo __('Message'); ?>
    </h1>
    <ol class="breadcrumb">
        <li>
            <?= $this->Html->link('<i class="fa fa-dashboard"></i> ' . __('Back'), ['action' => 'index'], ['escape' =>
            false])?>
        </li>
    </ol>
</section>
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
            </div>
        </div>
        <div class="col-md-9">

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3><?= h($message->subject) ?>
                                <span class="mailbox-read-time pull-right"><?= $message->created ?></span>
                            </h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                            <div class="mailbox-read-info">
                                <h5>From: <?= h($message->user->first_name . ' ' . $message->user->last_name)
                                    ?></h5>
                                <h5>To: <?= h($message->recipients->first_name . ' ' .
                                    $message->recipients->last_name) ?></h5>
                            </div>
                            <!-- /.mailbox-controls -->
                            <div class="mailbox-read-message">
                                <p><?= h($message->message) ?></p>
                            </div>
                            <!-- /.mailbox-read-message -->
                        </div>
                        <div class="box-footer">
                            <?= $this->Form->create(null, ['url' => '/message-delete/' . $message->id]); ?>
                            <?= $this->Form->button('<i class="fa fa-trash-o"></i> Delete', ['escape' => false,
                            'class' => 'btn btn-primary pull-right']) ?>
                            <?= $this->Form->end() ?>
                        </div>
                    </div>
                    <!-- /. box -->
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h4>Reply</h4>
                        </div>
                        <?= $this->Form->create(null, ['url' => '/message-reply/' . $message->id]); ?>
                        <div class="box-body">
                            <textarea style="width:100%" rows="10" name="reply_field" required></textarea>
                        </div>
                        <div class="box-footer">
                            <div class="pull-right">
                                <?= $this->Form->button('<i class="fa fa-envelope-o"></i> Send', ['escape' => false,
                                'class' => 'btn btn-primary']) ?>
                            </div>
                        </div>
                        <?= $this->Form->unlockField('reply_field'); ?>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
