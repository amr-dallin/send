<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ItemTelephone[]|\Cake\Collection\CollectionInterface $itemTelephones
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Item Telephone'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="itemTelephones index large-9 medium-8 columns content">
    <h3><?= __('Item Telephones') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('phone') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($itemTelephones as $itemTelephone): ?>
            <tr>
                <td><?= $this->Number->format($itemTelephone->id) ?></td>
                <td><?= $itemTelephone->has('item') ? $this->Html->link($itemTelephone->item->id, ['controller' => 'Items', 'action' => 'view', $itemTelephone->item->id]) : '' ?></td>
                <td><?= h($itemTelephone->phone) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $itemTelephone->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $itemTelephone->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $itemTelephone->id], ['confirm' => __('Are you sure you want to delete # {0}?', $itemTelephone->id)]) ?>
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
