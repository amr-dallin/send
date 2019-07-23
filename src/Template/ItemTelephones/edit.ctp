<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ItemTelephone $itemTelephone
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $itemTelephone->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $itemTelephone->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Item Telephones'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="itemTelephones form large-9 medium-8 columns content">
    <?= $this->Form->create($itemTelephone) ?>
    <fieldset>
        <legend><?= __('Edit Item Telephone') ?></legend>
        <?php
            echo $this->Form->control('item_id', ['options' => $items]);
            echo $this->Form->control('phone');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
