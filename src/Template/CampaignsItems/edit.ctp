<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CampaignsItem $campaignsItem
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $campaignsItem->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $campaignsItem->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Campaigns Items'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Campaigns'), ['controller' => 'Campaigns', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Campaign'), ['controller' => 'Campaigns', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="campaignsItems form large-9 medium-8 columns content">
    <?= $this->Form->create($campaignsItem) ?>
    <fieldset>
        <legend><?= __('Edit Campaigns Item') ?></legend>
        <?php
            echo $this->Form->control('campaign_id', ['options' => $campaigns]);
            echo $this->Form->control('item_id', ['options' => $items]);
            echo $this->Form->control('date_created');
            echo $this->Form->control('date_sended', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
