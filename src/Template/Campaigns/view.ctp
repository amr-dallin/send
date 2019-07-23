<?php
$title = ($campaign->title);

$this->assign('title', $title);

$this->start('ribbon');
$breadcrumbs = [
    [
        'url' => ['controller' => 'customers', 'action' => 'index'],
        'title' => __('Customers')
    ],
    [
        'url' => ['controller' => 'customers', 'action' => 'view', $campaign->customer_id],
        'title' => h($campaign->customer->fullname)
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

<?php $this->start('script-code'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('.datatables').DataTable({
            "dom": "<'dt-toolbar'<'col-xs-12 hidden-xs col-sm-6'f><'col-xs-12 col-sm-6 text-right'B>r>"+
                "t"+
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
			},
            responsive: {
                details: {
                    type: 'column', target: 'tr'
                }
            },
            order: [0, 'asc'],
            buttons: [
                {
                    extend: 'csvHtml5',
                    exportOptions: {
                        columns: [':visible' ]
                    }
                },
                'colvis'
            ]
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
    <div class="col-xs-12 col-md-4 text-align-right" style="margin: 10px 0 20px;">
        <?php
        echo $this->Html->link(
            __('Add Subscribers'),
            ['controller' => 'campaigns_items', 'action' => 'add', '?' => ['campaign_id' => $campaign->id]],
            ['class' => 'btn btn-success']
        )
        ?>
    </div>
</div>

<section id="widget-grid">

    <!-- row -->
    <div class="row">
        <!-- NEW WIDGET START -->
        <article class="col-md-12">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-1">
                <header></header>
                <!-- widget div-->
                <div>

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->
                    </div>
                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body no-padding">
                        <?php $subscribers = $this->Send->subscribers($campaign->items); ?>
                        <ul id="myTab1" class="nav nav-tabs bordered">
                            <li class="active">
                                <a href="#s1" data-toggle="tab" aria-expanded="true"><?php echo __('New Subscribers'); ?></a>
                            </li>
                            <li class="">
                                <a href="#s2" data-toggle="tab" aria-expanded="false"><?php echo __('Sended'); ?></a>
                            </li>
                        </ul>

                        <div id="myTabContent1" class="tab-content">
                            <div class="tab-pane fade active in" id="s1">
                                <table class="table table-striped table-bordered table-hover datatables" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="all" style="width: 30%;"><?php echo __('Legal Name'); ?></th>
                                            <th class="all" style="width: 8%;"><?php echo __('Email'); ?></th>
                                            <th class="min-phone"><?php echo __('Telephone(s)'); ?></th>
                                            <th class="min-phone" style="width: 8%;"><?php echo __('Website'); ?></th>
                                            <th class="min-phone"><?php echo __('Address'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($subscribers['new'])): ?>
                                        <?php foreach($subscribers['new'] as $key => $item): ?>
                                        <tr>
                                            <td><?php echo $item->legal_name; ?></td>
                                            <td><?php echo h($item->email); ?></td>
                                            <td></td>
                                            <td><?php echo h($item->website); ?></td>
                                            <td><?php echo h($item->address); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="s2">
                                <table class="table table-striped table-bordered table-hover datatables" width="100%">
                                    <thead>
                                        <tr>
                                            <th data-class="expand" style="width: 30%;"><?php echo __('Brand Name'); ?></th>
                                            <th style="width: 8%;"><?php echo __('Email'); ?></th>
                                            <th data-hide="phone,tablet"><?php echo __('Telephone(s)'); ?></th>
                                            <th data-hide="phone,tablet" style="width: 8%;"><?php echo __('Website'); ?></th>
                                            <th data-hide="phone,tablet"><?php echo __('Address'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($subscribers['sended'])): ?>
                                        <?php foreach($subscribers['sended'] as $item): ?>
                                        <tr>
                                            <td><?php echo $item->brand_name; ?></td>
                                            <td><?php echo h($item->email); ?></td>
                                            <td></td>
                                            <td><?php echo h($item->website); ?></td>
                                            <td><?php echo h($item->address); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end widget content -->
                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->
        </article>
        <!-- WIDGET END -->
    </div>
    <!-- end row -->
</section>