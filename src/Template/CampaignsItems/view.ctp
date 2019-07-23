<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CampaignsItem $campaignsItem
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Campaigns Item'), ['action' => 'edit', $campaignsItem->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Campaigns Item'), ['action' => 'delete', $campaignsItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $campaignsItem->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Campaigns Items'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Campaigns Item'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Campaigns'), ['controller' => 'Campaigns', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Campaign'), ['controller' => 'Campaigns', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="campaignsItems view large-9 medium-8 columns content">
    <h3><?= h($campaignsItem->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Campaign') ?></th>
            <td><?= $campaignsItem->has('campaign') ? $this->Html->link($campaignsItem->campaign->title, ['controller' => 'Campaigns', 'action' => 'view', $campaignsItem->campaign->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item') ?></th>
            <td><?= $campaignsItem->has('item') ? $this->Html->link($campaignsItem->item->id, ['controller' => 'Items', 'action' => 'view', $campaignsItem->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($campaignsItem->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Created') ?></th>
            <td><?= h($campaignsItem->date_created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Sended') ?></th>
            <td><?= h($campaignsItem->date_sended) ?></td>
        </tr>
    </table>
</div>
