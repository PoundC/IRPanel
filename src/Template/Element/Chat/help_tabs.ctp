<?= $this->Form->create($chatsEntity, ['id' => 'receive', 'url' => '/receive/' . $roomId, 'context' => ['validator' => ['Chats' => 'receive']]]) ?>
<?= $this->Form->control('message_id', ['id' => 'recmsg', 'label' => false, 'type' => 'text', 'style' => 'display:none;', 'value' => $message_id, 'class' => 'form-control']); ?>
<?= $this->Form->end() ?>

<div style="display:none;" id="receive">
    <script>
        $(document).ready(function() {

            <?php if($lastChats != '') { ?>

            <?php foreach($lastChats as $lastChat) { ?>

                <?php if($lastChat->user_id == $currentUser->id) { ?>

                        $('#direct-chat-messages').append('<div class="direct-chat-msg"><div class="direct-chat-info clearfix"><span class="direct-chat-name pull-right"><?= $currentUser->first_name ?></span><span class="direct-chat-timestamp pull-left"><?= $currentUser->created ?></span></div><?php echo $this->Html->image(empty($currentUser->avatar) ? $avatarPlaceholder : $currentUser->avatar, ['class' => 'direct-chat-img']); ?><div class="direct-chat-text"><?php echo $lastChat->message; ?></div></div>');

                    <?php } else { ?>

                        $('#direct-chat-messages').append('<div class="direct-chat-msg"><div class="direct-chat-msg right"><div class="direct-chat-info clearfix"><span class="direct-chat-name pull-right"><?= $lastChat->user->first_name ?></span><span class="direct-chat-timestamp pull-left"><?= $currentUser->created ?></span></div><?php echo $this->Html->image(empty($currentUser->avatar) ? $avatarPlaceholder : $currentUser->avatar, ['class' => 'direct-chat-img']); ?><div class="direct-chat-text"><?php echo $lastChat->message; ?></div></div></div>');

                    <?php } ?>

                <?php } ?>

            <?php } ?>
        });
    </script>
</div>




