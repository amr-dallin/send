<?php
$title = __('Add Customer');

$this->assign('title', $title);

$this->start('ribbon');
$breadcrumbs[0]['title'] = $title;
echo $this->element('ribbon', ['breadcrumbs' => $breadcrumbs]);
$this->end();

$this->start('navigation');
$menu['customers'][0] = true;
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
                        echo $this->Form->create($customer, [
                            'autocomplete' => 'off',
                            'templates' => 'SmartAdmin.app_form'
                        ]);
                        ?>
                        <fieldset>
                            <?php
                            echo $this->Form->control('fullname', [
                                'placeholder' => __('Full Name'),
                                'class' => 'form-control input-lg'
                            ]) . '<hr/>';
                            echo $this->Form->control('email', [
                                'placeholder' => __('Email')
                            ]);
                            echo $this->Form->control('phone', [
                                'placeholder' => __('Telephone')
                            ]) . '<hr/>';
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