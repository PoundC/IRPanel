<?= $this->Form->create($chatsEntity, ['id' => 'receive', 'url' => '/receive/' . $roomId, 'context' => ['validator' => ['Chats' => 'receive']]]) ?>
<?= $this->Form->control('message_id', ['id' => 'recmsg', 'label' => false, 'type' => 'text', 'style' => 'display:none;', 'value' => $message_id, 'class' => 'form-control']); ?>
<?= $this->Form->control('helptab_id', ['id' => 'recfaq', 'label' => false, 'type' => 'text', 'style' => 'display:none;', 'value' => $helptab_id, 'class' => 'form-control']); ?>
<?= $this->Form->end() ?>

<div style="display:none;" id="receive">
    <script>
        $(document).ready(function() {

        <?php $scroll = false; ?>

        <?php if($lastChats != '') { ?>

            <?php foreach($lastChats as $lastChat) { ?>

                <?php if($lastChat->user_id == $currentUser->id) { ?>

                    <?php $scroll = true; ?>
                        $('#direct-chat-messages').append('<div class="direct-chat-msg"><div class="direct-chat-info clearfix"><span class="direct-chat-name pull-right"><?= $currentUser->first_name ?></span><span class="direct-chat-timestamp pull-left"><?= $currentUser->created ?></span></div><?php echo $this->Html->image(empty($currentUser->avatar) ? $avatarPlaceholder : $currentUser->avatar, ['class' => 'direct-chat-img']); ?><div class="direct-chat-text"><?php echo $lastChat->message; ?></div></div>');

                <?php } else { ?>

                    <?php $scroll = true; ?>
                        $('#direct-chat-messages').append('<div class="direct-chat-msg"><div class="direct-chat-msg right"><div class="direct-chat-info clearfix"><span class="direct-chat-name pull-right"><?= $lastChat->user->first_name ?></span><span class="direct-chat-timestamp pull-left"><?= $currentUser->created ?></span></div><?php echo $this->Html->image(empty($currentUser->avatar) ? $avatarPlaceholder : $currentUser->avatar, ['class' => 'direct-chat-img']); ?><div class="direct-chat-text"><?php echo $lastChat->message; ?></div></div></div>');

                <?php } ?>

            <?php } ?>

        <?php } ?>


            <?php if($scroll == true) { ?>
            $('#direct-chat-messages').animate({
                scrollTop: $('#direct-chat-messages').get(0).scrollHeight
            }, 2000);
            <?php } ?>


            <?php if(isset($helpTabsEntity)) { ?>

                <?php foreach($helpTabsEntity as $helpTab) { ?>

                    $('#timelinetab').removeClass('active');
                    $('#timeline').removeClass('active');
                    $('#jlr-tabs').append('<li class="active"><a href="#<?php echo str_replace(' ', '', $helpTab->answer->subject) ?>" data-toggle="tab" aria-expanded="false"><?= $helpTab->answer->subject ?></a></li>');
                    $('#jlr-tabs-content').append(`<div class="tab-pane active" id="<?= str_replace(' ', '', $helpTab->answer->subject) ?>"><?= $this->Markdown->transform($helpTab->answer->answer) ?></div>`);



                <?php } ?>

            <?php } ?>

        });
    </script>
</div>




