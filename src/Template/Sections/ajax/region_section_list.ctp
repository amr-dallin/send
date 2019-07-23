<?php if (!empty($sections)): ?>
<div class="col-md-12">
    <div class="alert alert-info fade in font-lg">
        <?php echo __('In the selected region <strong>{0}</strong> companies', $this->Send->countItemsInSections($sections)); ?>
    </div>
</div>

<?php
echo $this->Form->create(null, [
    'autocomplete' => 'off',
    'templates' => 'SmartAdmin.app_form',
    'url' => [
        'controller' => 'CampaignsItems',
        'action' => 'add',
        '?' => [
            'campaign_id' => h($campaign->id)
        ]
    ]
]);

foreach($cities as $city) {
    echo $this->Form->control('Cities.id[]', [
        'type' => 'hidden',
        'value' => h($city),
    ]);
}
?>

<!-- NEW WIDGET START -->
<article class="col-xs-12 col-sm-12 col-md-6">
    <?php foreach($sections as $key => $section): ?>

<?php if ($key == ceil(count($sections) / 2) - 1): ?>
</article>
<article class="col-xs-12 col-sm-12 col-md-6">
<?php endif; ?>

    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-<?php echo h($section->id); ?>">
        <header>
            <h2><?php echo h($section->title); ?></h2>
        </header>
        <!-- widget div-->
        <div>
            <!-- widget edit box -->
            <div class="jarviswidget-editbox">
                <!-- This area used as dropdown edit box -->
            </div>
            <!-- end widget edit box -->

            <!-- widget content -->
            <div class="widget-body">
                <ul class="list-unstyled">
                    <?php
                    foreach($section->categories as $category) {
                        if (empty($category->items)) {
                            continue;
                        }
                        echo '<li>';
                        echo $this->Form->control('Categories.id[]', [
                            'id' => 'category' . h($category->id),
                            'label' => [
                                'class' => 'category-checkbox',
                                'text' => h($category->title)
                            ],
                            'type' => 'checkbox',
                            'hiddenField' => false,
                            'value' => h($category->id),
                            'data-item-ids' => $this->Send->itemIds($category->items)
                        ]);
                        echo '</li>';
                    }
                    ?>
                </ul>
            </div>
            <!-- end widget content -->
        </div>
        <!-- end widget div -->
    </div>
    <!-- end widget -->
    <?php endforeach; ?>
</article>
<!-- WIDGET END -->
<div class="col-md-12">
    <?php
    echo $this->Form->button(__('Add Subscribers'), [
        'type' => 'submit',
        'class' => 'btn btn-primary btn-lg'
    ]);
    ?>
    <span class="text-primary font-md margin-top-5" style="margin-left: 10px;"><?php echo __('Total selected'); ?> <strong id="count-select-items">0</strong></span>
</div>
<?php echo $this->Form->end(); ?>

<?php else: ?>
<div class="col-md-12">
    <div class="alert alert-warning fade in">
        <?php echo __('There are no companies in selected regions ...'); ?>
    </div>
</div>
<?php endif; ?>