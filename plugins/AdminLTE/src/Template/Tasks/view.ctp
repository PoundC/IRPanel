<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $adminLTETask
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Admin L T E Task'), ['action' => 'edit', $adminLTETask->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Admin L T E Task'), ['action' => 'delete', $adminLTETask->id], ['confirm' => __('Are you sure you want to delete # {0}?', $adminLTETask->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Admin L T E Tasks'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Admin L T E Task'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="adminLTETasks view large-9 medium-8 columns content">
    <h3><?= h($adminLTETask->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= h($adminLTETask->user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($adminLTETask->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Link') ?></th>
            <td><?= h($adminLTETask->link) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Icon') ?></th>
            <td><?= h($adminLTETask->icon) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($adminLTETask->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Seen') ?></th>
            <td><?= $this->Number->format($adminLTETask->seen) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Completed') ?></th>
            <td><?= $this->Number->format($adminLTETask->completed) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($adminLTETask->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($adminLTETask->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Message') ?></h4>
        <?= $this->Text->autoParagraph(h($adminLTETask->message)); ?>
    </div>
</div>
