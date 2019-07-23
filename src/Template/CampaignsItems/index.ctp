<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CampaignsItem[]|\Cake\Collection\CollectionInterface $campaignsItems
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Campaigns Item'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Campaigns'), ['controller' => 'Campaigns', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Campaign'), ['controller' => 'Campaigns', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="campaignsItems index large-9 medium-8 columns content">
    <h3><?= __('Campaigns Items') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campaign_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date_created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date_sended') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($campaignsItems as $campaignsItem): ?>
            <tr>
                <td><?= $this->Number->format($campaignsItem->id) ?></td>
                <td><?= $campaignsItem->has('campaign') ? $this->Html->link($campaignsItem->campaign->title, ['controller' => 'Campaigns', 'action' => 'view', $campaignsItem->campaign->id]) : '' ?></td>
                <td><?= $campaignsItem->has('item') ? $this->Html->link($campaignsItem->item->id, ['controller' => 'Items', 'action' => 'view', $campaignsItem->item->id]) : '' ?></td>
                <td><?= h($campaignsItem->date_created) ?></td>
                <td><?= h($campaignsItem->date_sended) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $campaignsItem->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $campaignsItem->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $campaignsItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $campaignsItem->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
