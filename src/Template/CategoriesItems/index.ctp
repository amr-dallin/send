<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CategoriesItem[]|\Cake\Collection\CollectionInterface $categoriesItems
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Categories Item'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="categoriesItems index large-9 medium-8 columns content">
    <h3><?= __('Categories Items') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('category_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categoriesItems as $categoriesItem): ?>
            <tr>
                <td><?= $this->Number->format($categoriesItem->id) ?></td>
                <td><?= $categoriesItem->has('category') ? $this->Html->link($categoriesItem->category->title, ['controller' => 'Categories', 'action' => 'view', $categoriesItem->category->id]) : '' ?></td>
                <td><?= $categoriesItem->has('item') ? $this->Html->link($categoriesItem->item->id, ['controller' => 'Items', 'action' => 'view', $categoriesItem->item->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $categoriesItem->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $categoriesItem->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $categoriesItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $categoriesItem->id)]) ?>
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
