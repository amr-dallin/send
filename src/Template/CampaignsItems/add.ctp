<?php
$title = __('Add Subscribers');

$this->assign('title', $title);

$this->start('ribbon');
$breadcrumbs = [
    [
        'url' => ['controller' => 'Customers', 'action' => 'index'],
        'title' => __('Customers')
    ],
    [
        'url' => ['controller' => 'Customers', 'action' => 'view', $campaign->customer_id],
        'title' => h($campaign->customer->fullname)
    ],
    [
        'url' => ['controller' => 'Campaigns', 'action' => 'view', $campaign->id],
        'title' => h($campaign->title)
    ],
    ['title' => $title]
];
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

<?php $this->start('script-code'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#all-regions').change(function() {
            $('#form-regions input[type=checkbox]').prop('checked', this.checked);
        });

        $('.region-checkbox').change(function() {
            var checkbox = $(this).find('input[type=checkbox]');
            var region_id = checkbox.attr('data-region-id');

            if (!checkbox.prop('checked')) {
                $('#all-regions').prop('checked', checkbox.prop('checked'));
            }

            $('#region' + region_id + ' input[type=checkbox]').prop('checked', checkbox.prop('checked'));
        });

        $('.city-checkbox').change(function() {
            var checkbox = $(this).find('input[type=checkbox]');
            var region_id = checkbox.attr('data-region-id');
        });

        $("form#form-regions").submit(function(e) {
            e.preventDefault();

            var targetUrl = $(this).attr('rel');

            $.ajax({
                type: 'post',
                url: targetUrl,
                data: $(this).serialize(),
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                    $('#section-container').html('<div class="margin-top-10 margin-bottom-10 text-center"><i class="fa fa-3x fa-spin fa-spinner" aria-hidden="true"></i></div>');
                },
                success: function(response) {
                    //return console.log(response);

                    if (response.content) {
                        $('#section-container').html(response.content);
                    }
                },
                error: function(e) {
                    var responseText = $.parseJSON(e.responseText);
                    alert("An error occurred: " + responseText.message);
                }
            });
        });

        $("#section-container").on('change', ".category-checkbox", function() {
            var count_select_items = [];

            $("#section-container input[type=checkbox]").each(function(indx) {
                if ($(this).prop('checked')) {
                    var item_ids = JSON.parse($(this).attr('data-item-ids'));
                    count_select_items = $.merge(count_select_items, item_ids);
                }
            });

            count_select_items = (new Set(count_select_items)).size;

            $("#section-container").find('#count-select-items').html(count_select_items);

            var checkbox = $(this).find('input[type=checkbox]');
            var count_items = Object.keys(JSON.parse(checkbox.attr('data-item-ids'))).length;

            if (checkbox.prop('checked')) {
				$.smallBox({
					title : "+ " + count_items,
					content : "Всего выбрано: " + count_select_items + " items...",
					color : "#659265",
					iconSmall : "fa fa-thumbs-up bounce animated",
					timeout : 2000
				});
            } else {
				$.smallBox({
					title : "- " + count_items,
					content : "Всего выбрано: " + count_select_items + " items...",
					color : "#C46A69",
					iconSmall : "fa fa-thumbs-down bounce animated",
					timeout : 2000
				});
            }
        });
    });
</script>
<?php $this->end(); ?>


<div class="row">
    <div class="col-xs-12 col-md-8">
        <h1 class="page-title txt-color-blueDark">
            <!-- PAGE HEADER -->
            <?php echo $title; ?>
        </h1>
    </div>
</div>

<section id="widget-grid">
    <?php
    echo $this->Form->create(null, [
        'autocomplete' => 'off',
        'templates' => 'SmartAdmin.app_form',
        'id' => 'form-regions',
        'rel' => $this->Url->build([
            'controller' => 'Sections',
            'action' => 'regionSectionList',
            '?' => ['campaign_id' => h($campaign->id)]
        ])
    ]);
    ?>
    <div class="row">
        <article class="col-md-12">
            <div class="jarviswidget" data-widget-sortable="false" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" id="wid-id-0">
                <header>
                    <h2><?php echo __('Regional filtering'); ?></h2>
                </header>

                <div>
                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->
                    </div>
                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                echo $this->Form->control('', [
                                    'id' => 'all-regions',
                                    'label' => [
                                        'class' => 'text-uppercase text-danger',
                                        'text' => __('All Regions')
                                    ],
                                    'type' => 'checkbox',
                                    'hiddenField' => false
                                ]);
                                ?>
                                <hr/>
                            </div>
                        </div>
                        <?php foreach($regions as $region): ?>
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                echo $this->Form->control('Regions.id[]', [
                                    'id' => 'region' . h($region->id),
                                    'data-region-id' => h($region->id),
                                    'label' => [
                                        'class' => 'text-uppercase text-info region-checkbox',
                                        'text' => h($region->title)
                                    ],
                                    'type' => 'checkbox',
                                    'hiddenField' => false
                                ]);
                                ?>

                                <?php if (!empty($region->cities)): ?>
                                <div id="region<?php echo h($region->id); ?>">
                                    <?php
                                    foreach($region->cities as $city) {
                                        echo $this->Form->control('Cities.id[]', [
                                            'id' => 'city' . h($city->id),
                                            'data-region-id' => h($region->id),
                                            'label' => [
                                                'class' => 'city-checkbox',
                                                'text' => h($city->title)
                                            ],
                                            'type' => 'checkbox',
                                            'hiddenField' => false,
                                            'value' => h($city->id),
                                            'templates' => [
                                                'inputContainer' => '<span style="margin-right: 8px;">{{content}}</span>'
                                            ]
                                        ]);
                                    }
                                    ?>
                                </div>
                                <hr/>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <div class="row margin-top-5 text-center">
                            <?php
                            echo $this->Form->button(
                                $this->Html->tag('i', '', ['class' => 'fa fa-search']) . ' ' . __('Find'),
                                [
                                    'escape' => false,
                                    'class' => 'btn btn-primary',
                                    'id' => 'find-button'
                                ]
                            );
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </div>
    <?php echo $this->Form->end(); ?>

    <!-- row -->
    <div class="row" id="section-container"></div>
    <!-- end row -->
</section>
