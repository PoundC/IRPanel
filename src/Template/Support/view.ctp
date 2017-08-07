<div class="row jlr-dashbox">
    <div class="col-md-7 col-md-offset-1">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 style="margin-top: 0px !important"><?= $message->subject ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-primary" style="border-top-color: white !important;">
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <div class="mailbox-read-info">

                        <h5>From: <?= $messageFromUser->username ?>
                            <span class="mailbox-read-time pull-right"><?= $message->created ?></span></h5>
                    </div>

                    <!-- /.mailbox-controls -->
                    <div class="mailbox-read-message">
                        <p><?= $this->Markdown->transform($message->message) ?></p>
                    </div>
                    <!-- /.mailbox-read-message -->
                </div>
                <!--
                <div class="box-footer">
                    <ul class="mailbox-attachments clearfix">
                        <li>
                            <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>

                            <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> Sep2014-report.pdf</a>
                                <span class="mailbox-attachment-size">
                              1,245 KB
                              <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                            </span>
                            </div>
                        </li>
                        <li>
                            <span class="mailbox-attachment-icon"><i class="fa fa-file-word-o"></i></span>

                            <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> App Description.docx</a>
                                <span class="mailbox-attachment-size">
                              1,245 KB
                              <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                            </span>
                            </div>
                        </li>
                        <li>
                            <span class="mailbox-attachment-icon has-img"><img src="../../dist/img/photo1.png" alt="Attachment"></span>

                            <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> photo1.png</a>
                                <span class="mailbox-attachment-size">
                              2.67 MB
                              <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                            </span>
                            </div>
                        </li>
                        <li>
                            <span class="mailbox-attachment-icon has-img"><img src="../../dist/img/photo2.png" alt="Attachment"></span>

                            <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> photo2.png</a>
                                <span class="mailbox-attachment-size">
                              1.9 MB
                              <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                            </span>
                            </div>
                        </li>
                    </ul>
                </div>
                -->
            </div>
            <!-- /. box -->
        </div>

        <?php foreach($replies as $reply) { ?>

        <div id="reply-<?php echo $reply->id; ?>" class="col-md-12">
            <div class="box box-primary" style="border-top-color: white !important;">
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <div class="mailbox-read-info">
                        <h5>From: <?= $reply->user->username ?>
                            <span class="mailbox-read-time pull-right"><?= $reply->created ?></span></h5>
                    </div>

                    <!-- /.mailbox-controls -->
                    <div class="mailbox-read-message">
                        <p><?= $this->Markdown->transform($reply->message) ?></p>
                    </div>
                    <!-- /.mailbox-read-message -->
                </div>
                <!--
                <div class="box-footer">
                    <ul class="mailbox-attachments clearfix">
                        <li>
                            <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>

                            <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> Sep2014-report.pdf</a>
                                <span class="mailbox-attachment-size">
                              1,245 KB
                              <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                            </span>
                            </div>
                        </li>
                        <li>
                            <span class="mailbox-attachment-icon"><i class="fa fa-file-word-o"></i></span>

                            <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> App Description.docx</a>
                                <span class="mailbox-attachment-size">
                              1,245 KB
                              <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                            </span>
                            </div>
                        </li>
                        <li>
                            <span class="mailbox-attachment-icon has-img"><img src="../../dist/img/photo1.png" alt="Attachment"></span>

                            <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> photo1.png</a>
                                <span class="mailbox-attachment-size">
                              2.67 MB
                              <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                            </span>
                            </div>
                        </li>
                        <li>
                            <span class="mailbox-attachment-icon has-img"><img src="../../dist/img/photo2.png" alt="Attachment"></span>

                            <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> photo2.png</a>
                                <span class="mailbox-attachment-size">
                              1.9 MB
                              <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                            </span>
                            </div>
                        </li>
                    </ul>
                </div>
                -->
            </div>
            <!-- /. box -->
        </div>

        <?php } ?>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs" id="jlr-tabs">

                                <li class="active"><a href="#reply" data-toggle="tab" aria-expanded="false">Reply</a></li>
                                <li><a href="#preview" data-toggle="tab" aria-expanded="false" id="preview-markdown">Preview Markdown</a></li>

                            </ul>
                            <div class="tab-content" id="jlr-tabs-content">
                                <div class="tab-pane active" id="reply">

                                    <div class="box-body no-padding">

                                        <?= $this->Form->create($supportEntity, ['url' => '/support/reply/' . $message->id, 'context' => ['validator' => ['Messages'
                                        => 'reply']]]) ?>

                                        <div class="row">
                                            &nbsp;
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-10 col-lg-offset-1">
                                                <div class="form-group">
                                                    <?= $this->Form->control('message', ['label' => false, 'type' => 'textarea', 'placeholder'
                                                    => 'Enter message here...', 'class' => 'form-control', 'id' => 'message']); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-4 col-xs-offset-4">
                                                <?= $this->Form->button('Reply To Ticket', ['class' => 'btn
                                                btn-primary btn-block btn-flat']) ?>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <div class="row">
                                            &nbsp;
                                        </div>
                                        <?= $this->Form->end() ?>
                                    </div>

                                </div>
                                <div class="tab-pane active" id="preview">

                                </div>
                                <div style="display:none" id="hiddenpreview">
                                    <?= $this->element('Help/markdown', ['markdownthis' => '']); ?>
                                </div>
                            </div>

                            <script>
                                $('#preview-markdown').click(function() {

                                    $('#message-preview').val($('#message').val());

                                    $.ajax
                                    ({
                                        url: '/markdown',
                                        data: $('#prevmdform').serialize(),
                                        type: 'post',
                                        success: function(result)
                                        {
                                            $('#preview').html(result);
                                        }
                                    });
                                });
                            </script>


                        </div>

                    </div>
                </div>
            </div>
            <?php if($isAdmin == true) { ?>
            <div class="row">
                <div class="col-md-12">
                    <!-- About Me Box -->
                    <div class="box box-primary" style="border-top-color: white !important;">
                        <div class="box-body">
                            <div class="col-md-4 pull-right">
                                <button type="button" class="btn btn-default" style="width:100%"><i class="fa fa-close"></i> Close
                                    Ticket
                                </button>
                            </div>
                            <div class="col-md-4 pull-right">
                                <button type="button" class="btn btn-default" style="width:100%">
                                    <i class="fa fa-space-shuttle"></i>
                                    <span>Auto-Answer</span>
                                </button>
                            </div>
                            <div class="col-md-4 pull-right">
                                <button type="button" class="btn btn-default" style="width:100%">
                                    <i class="fa fa-fighter-jet"></i>
                                    <span>Convert FAQ</span>
                                </button>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="<?php echo empty($messageFromUser->avatar) ? '/cake_d_c/users/img/avatar_placeholder.png' : $messageFromUser->avatar ?>" alt="User profile picture">

                <h3 class="profile-username text-center"><?= $messageFromUser->first_name . ' ' . $messageFromUser->last_name ?></h3>

                <p class="text-muted text-center"><?= $messageFromUser->username ?></p>

            </div>
            <!-- /.box-body -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->postLink('<i class="fa fa-close"></i> Close Ticket', ['action' => 'close', $message->id], ['escape' => false, 'style' => 'width: 100%', 'class' => 'btn btn-default']) ?>
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>