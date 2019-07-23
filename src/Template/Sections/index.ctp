<?php
$title = __('Services');

$this->assign('title', $title);

$this->start('ribbon');
$breadcrumbs[0]['title'] = $title;
echo $this->element('ribbon', ['breadcrumbs' => $breadcrumbs]);
$this->end();

$this->start('navigation');
$menu['services'][1] = true;
echo $this->element('navigation', ['menu' => $menu]);
$this->end();

$this->start('script');
echo $this->Html->script([

]);
$this->end();
?>

<section id="widget-grid">
    <?php
    echo $this->Form->create(null, [
        'autocomplete' => 'off',
        'url' => ['controller' => 'Items', 'action' => 'index'],
        'templates' => 'SmartAdmin.app_form'
    ]);
    ?>
    <!-- row -->
    <div class="row">
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
                    <h2>
                        <?php
                        echo $this->Form->control('id[]', [
                            'id' => 'section' . h($section->id),
                            'label' => h($section->title),
                            'type' => 'checkbox',
                            'hiddenField' => false,
                            'value' => h($section->id)
                        ]);
                        ?>
                    </h2>
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
                                echo '<li>';
                                echo $this->Form->control('Categories.id[]', [
                                    'id' => 'category' . h($category->id),
                                    'label' => h($category->title),
                                    'type' => 'checkbox',
                                    'hiddenField' => false,
                                    'value' => h($category->id)
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
    </div>
    <!-- end row -->
    <?php echo $this->Form->submit(); ?>
    <?php echo $this->Form->end(); ?>
</section>
