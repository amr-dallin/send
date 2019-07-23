<?php
$title = __('Create Campaign');

$this->assign('title', $title);

$this->start('ribbon');
$breadcrumbs = [
    [
        'url' => ['controller' => 'customers', 'action' => 'index'],
        'title' => __('Customers')
    ],
    [
        'url' => ['controller' => 'customers', 'action' => 'view', h($customer->id)],
        'title' => h($customer->fullname)
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
                        <?php
                        echo $this->Form->create($campaign, [
                            'autocomplete' => 'off',
                            'templates' => 'SmartAdmin.app_form'
                        ]);
                        ?>
                        <fieldset>
                            <?php
                            echo $this->Form->control('customer_id', [
                                'type' => 'hidden',
                                'value' => h($customer->id)
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