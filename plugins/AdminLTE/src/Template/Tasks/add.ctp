<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $adminLTETask
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Admin L T E Tasks'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="adminLTETasks form large-9 medium-8 columns content">
    <?= $this->Form->create($adminLTETask) ?>
    <fieldset>
        <legend><?= __('Add Admin L T E Task') ?></legend>
        <?php
            echo $this->Form->control('user_id');
            echo $this->Form->control('title');
            echo $this->Form->control('message');
            echo $this->Form->control('link');
            echo $this->Form->control('icon');
            echo $this->Form->control('seen');
            echo $this->Form->control('completed');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
