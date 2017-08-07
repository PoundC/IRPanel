<?= $this->Form->create(null, ['id' => 'prevmdform', 'url' => '/markdown']) ?>
<?= $this->Form->control('message_preview', ['label' => false, 'type' => 'textarea', 'style' => 'display:none;']); ?>
<?= $this->Form->end() ?>

<?php echo $this->Markdown->transform($markdownthis); ?>