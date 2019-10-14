<?= $this->Form->create($chatsEntity, ['id' => 'chatsend', 'url' => '/chatsend/' . $roomId, 'context' =>
['validator' => ['Chats' => 'send']]]) ?>
<div class="input-group">
    <?= $this->Form->control('message', ['id' => 'sendmsg', 'label' => false, 'type' => 'text', 'name' => 'message',
    'placeholder' => 'Enter message here...', 'value' => '', 'class' => 'form-control']); ?>
    <span class="input-group-btn">
                        <?= $this->Form->button(__d('CakeDC/Users', 'Send'), ['type' => 'submit', 'class' => 'btn btn-primary btn-block btn-flat', 'style' => 'margin-top:-4px;']) ?>
                      </span>
</div>
<?= $this->Form->end() ?>
<?php if(isset($message_id) == false) { $message_id = '0'; } ?>
<?= $this->Form->control('message_id', ['id' => 'recmsg2', 'label' => false, 'type' => 'hidden', 'name' => 'message_id', 'value' => $message_id, 'class' => 'form-control']); ?>
<script>
    $(document).ready(function () {

        $('#recmsg').val('<?php echo $message_id; ?>');

        $('#direct-chat-messages').animate({
            scrollTop: $('#direct-chat-messages').get(0).scrollHeight
        }, 2000);

        $('#chatsend').on('submit', function () {

            var sendmsg = $('#sendmsg').val();

            $.ajax({
                type: "POST",
                url: "/chatsend/<?php echo $roomId; ?>",
                dataType: 'text',
                data: $('#chatsend').serialize(),
                async: false,
                success: function (data) {
                    $('#box-footer').html(data);
                    $('#direct-chat-messages').append('<div class="direct-chat-msg"><div class="direct-chat-info clearfix"><span class="direct-chat-name pull-left"><?= $currentUser->first_name ?></span><span class="direct-chat-timestamp pull-right"><?= $currentUser->created ?></span></div><?php echo $this->Html->image(empty($currentUser->avatar) ? $avatarPlaceholder : $currentUser->avatar, ['class' => 'direct-chat-img']); ?><div class="direct-chat-text">' + sendmsg + '</div></div>');
                    $('#direct-chat-messages').animate({
                        scrollTop: $('#direct-chat-messages').get(0).scrollHeight
                    }, 2000);
                    $('#sendmsg').focus();
                    return false;
                },
                error: function (data) {

                    return false;
                }
            });

            return false;
        });
    });
</script>