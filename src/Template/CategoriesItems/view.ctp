<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CategoriesItem $categoriesItem
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Categories Item'), ['action' => 'edit', $categoriesItem->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Categories Item'), ['action' => 'delete', $categoriesItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $categoriesItem->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Categories Items'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Categories Item'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="categoriesItems view large-9 medium-8 columns content">
    <h3><?= h($categoriesItem->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Category') ?></th>
            <td><?= $categoriesItem->has('category') ? $this->Html->link($categoriesItem->category->title, ['controller' => 'Categories', 'action' => 'view', $categoriesItem->category->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item') ?></th>
            <td><?= $categoriesItem->has('item') ? $this->Html->link($categoriesItem->item->id, ['controller' => 'Items', 'action' => 'view', $categoriesItem->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($categoriesItem->id) ?></td>
        </tr>
    </table>
</div>
