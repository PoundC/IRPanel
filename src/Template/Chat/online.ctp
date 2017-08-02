<?php
/*
<div class="row">

<div class="col-md-8 col-md-offset-2">

    <div class="box box-info">

        <div class="box-header with-border">

            <h3 class="box-title">Enter your chat display name</h3>
        </div>

        <form class="form-horizontal">

            <div class="box-body">

                <div class="form-group">

                    <div class="col-sm-7">

                        <input type="email" class="form-control" id="inputEmail3" placeholder="Display Name">
                    </div>

                    <div class="col-sm-3">

                        <div class="checkbox pull-right">

                            <label>

                                <input type="checkbox"> Remember me
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-info pull-right">Sign in</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
*/
?>
<div class="row jlr-dashbox">
    <div class="col-lg-4 col-lg-offset-1">
        <!-- DIRECT CHAT PRIMARY -->
        <div class="box box-primary direct-chat direct-chat-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Live Chat</h3>

                <!--<div class="box-tools pull-right">
                    <span data-toggle="tooltip" title="" class="badge bg-light-blue" data-original-title="3 New Messages">3</span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="" data-widget="chat-pane-toggle" data-original-title="Contacts">
                        <i class="fa fa-comments"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>-->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages" id="direct-chat-messages">

                    <?php $lastMessageId = 0; ?>

                    <?php foreach($chatsResults as $chatResult) { ?>

                    <?php $lastMessageId = $chatResult->id; ?>

                    <?php if($chatResult['user']->id == $currentUser->id) { ?>

                    <!-- Message. Default to the right -->
                    <div class="direct-chat-msg">
                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name pull-left"><?= $chatResult['user']->first_name ?></span>
                            <span class="direct-chat-timestamp pull-right"><?= $chatResult->created ?></span>
                        </div>
                        <?php echo $this->Html->image(
                        empty($currentUser->avatar) ? $avatarPlaceholder : $currentUser->avatar,
                        ['class' => 'direct-chat-img']
                        ); ?>
                        <!--<img class="direct-chat-img" src="../dist/img/user1-128x128.jpg" alt="Message User Image"><!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                            <?= $chatResult->message ?>
                        </div>
                        <!-- /.direct-chat-text -->
                    </div>
                    <?php } else { ?>

                    <!-- Message. Default to the left -->
                    <div class="direct-chat-msg">
                        <div class="direct-chat-msg right">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-right"><?= $chatResult['user']->first_name ?></span>
                                <span class="direct-chat-timestamp pull-left"><?= $chatResult->created ?></span>
                            </div>
                            <!-- /.direct-chat-info -->
                            <?php echo $this->Html->image(
                            empty($currentUser->avatar) ? $avatarPlaceholder : $currentUser->avatar,
                            ['class' => 'direct-chat-img']
                            ); ?>
                            <!-- <img class="direct-chat-img" src="../dist/img/user3-128x128.jpg" alt="Message User Image"><!-- /.direct-chat-img -->
                            <div class="direct-chat-text">
                                <?= $chatResult->message ?>
                            </div>
                            <!-- /.direct-chat-text -->
                        </div>
                    </div>

                    <?php } ?>
                    <?php } // End Foreach ?>
                </div>
                <!--/.direct-chat-messages-->

                <!-- Contacts are loaded here -->
                <div class="direct-chat-contacts">
                    <ul class="contacts-list">
                        <li>
                            <a href="#">
                                <img class="contacts-list-img" src="../dist/img/user1-128x128.jpg" alt="User Image">

                                <div class="contacts-list-info">
                            <span class="contacts-list-name">
                              Count Dracula
                              <small class="contacts-list-date pull-right">2/28/2015</small>
                            </span>
                                    <span class="contacts-list-msg">How have you been? I was...</span>
                                </div>
                                <!-- /.contacts-list-info -->
                            </a>
                        </li>
                        <!-- End Contact Item -->
                    </ul>
                    <!-- /.contatcts-list -->
                </div>
                <!-- /.direct-chat-pane -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer" id="box-footer">

                <?= $this->element('Chat/chatsend') ?>
            </div>
            <div class="box-hidden-footer" id="box-hidden-footer">

                <?php if(isset($message_id) == false) { $message_id = '0'; } ?>

                <?= $this->element('Chat/receive', array('message_id' => $message_id)) ?>

            </div>
            <!-- /.box-footer-->
        </div>
        <!--/.direct-chat -->
    </div>
    <div class="col-md-6">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" id="jlr-tabs">

                <li class="active"><a href="#timeline" data-toggle="tab" aria-expanded="false">Help Tutorial</a></li>

            </ul>
            <div class="tab-content" id="jlr-tabs-content">
                <div class="tab-pane active" id="timeline">

                    <h3>This is where you will find live up-to-date real time FAQ help, wait for the tab to become active.</h3>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        var tt = window.setInterval(function () {

            $.ajax({
                type: "POST",
                url: "/receive/<?php echo $roomId; ?>",
                dataType: 'text',
                data: $('#receive').serialize(),
                async: false,

                success: function (data) {

                    $('#box-hidden-footer').html(data);

                    return false;
                },
                error: function (data) {

                    clearInterval(tt);
                    return false;
                }
            });

        }, 3000);
    });
</script>