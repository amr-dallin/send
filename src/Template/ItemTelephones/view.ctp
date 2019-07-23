<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ItemTelephone $itemTelephone
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Item Telephone'), ['action' => 'edit', $itemTelephone->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Item Telephone'), ['action' => 'delete', $itemTelephone->id], ['confirm' => __('Are you sure you want to delete # {0}?', $itemTelephone->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Item Telephones'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Telephone'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="itemTelephones view large-9 medium-8 columns content">
    <h3><?= h($itemTelephone->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Item') ?></th>
            <td><?= $itemTelephone->has('item') ? $this->Html->link($itemTelephone->item->id, ['controller' => 'Items', 'action' => 'view', $itemTelephone->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Phone') ?></th>
            <td><?= h($itemTelephone->phone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($itemTelephone->id) ?></td>
        </tr>
    </table>
</div>
