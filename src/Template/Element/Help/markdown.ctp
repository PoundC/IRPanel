<!-- begin form -->
<?= $this->Form->create(null, ['id' => 'prevmdform', 'url' => '/markdown']) ?>
<?= $this->Form->control('message_preview', ['label' => false, 'type' => 'textarea', 'style' => 'display:none;']); ?>
<?= $this->Form->end() ?>
<!-- end form -->

<div id="previewForm2">
<?php echo $this->Markdown->transform($markdownthis); ?>
</div>