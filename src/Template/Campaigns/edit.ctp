<?php
$title = __('Edit Campaign');

$this->assign('title', $title);

$this->start('ribbon');
$breadcrumbs = [
    [
        'url' => ['controller' => 'Customers', 'action' => 'index'],
        'title' => __('Customers')
    ],
    [
        'url' => ['controller' => 'Customers', 'action' => 'view', h($campaign->customer->id)],
        'title' => h($campaign->customer->fullname)
    ],
    [
        'url' => ['controller' => 'Campaigns', 'action' => 'view', h($campaign->id)],
        'title' => h($campaign->title)
    ],
    ['title' => $title]
];
echo $this->element('ribbon', ['breadcrumbs' => $breadcrumbs]);
$this->end();

$this->start('navigation');
$menu['customers'][1] = true;
echo $this->element('navigation', ['menu' => $menu]);
$this->end();
?>

<div class="row">
    <div class="col-md-12">
        <h1 class="page-title txt-color-blueDark">
            <?php echo $title; ?>
        </h1>
    </div>
</div>

<section id="widget-grid">
    <div class="row">
        <article class="col-md-6">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-1">
                <header></header>

                <!-- widget div-->
                <div>
                    <!-- widget content -->
                    <div class="widget-body">
                        <div class="widget-body-toolbar">
                            <div class="row">
                                <div class="col-sm-12 text-align-right">
                                    <?php
                                    echo $this->Form->postLink(
                                        $this->Html->tag('i', '', ['class' => 'fa fa-trash']) . ' ' .
                                        __('Delete'),
                                        ['action' => 'delete', h($campaign->id)],
                                        [
                                            'confirm' => __('Are you sure you want to delete # {0}?', h($campaign->id)),
                                            'class' => 'btn btn-danger',
                                            'escape' => false
                                        ]
                                    )
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        echo $this->Form->create($campaign, [
                            'autocomplete' => 'off',
                            'templates' => 'SmartAdmin.app_form'
                        ]);
                        ?>
                        <fieldset>
                            <?php
                            echo $this->Form->control('id', [
                                'type' => 'hidden',
                                'value' => h($campaign->id)
                            ]);
                            echo $this->Form->control('title', [
                                'placeholder' => __('Title')
                            ]);
                            echo $this->Form->control('body', [
                                'placeholder' => __('Body'),
                                'rows' => 5
                            ]);
                            ?>
                        </fieldset>

                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php echo $this->Form->submit(); ?>
                                </div>
                            </div>
                        </div>

                        <?php echo $this->Form->end(); ?>
                    </div>
                    <!-- end widget content -->

                </div>
                <!-- end widget div -->

            </div>
            <!-- end widget -->

        </article>
    </div>
</section>