<?php
$title = ($customer->fullname);

$this->assign('title', $title);

$this->start('ribbon');
$breadcrumbs = [
    [
        'url' => ['action' => 'index'],
        'title' => __('Customers')
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
        var table = $('#dt_basic').DataTable({
            "dom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'hidden-xs col-sm-6'l>r>"+
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
            columnDefs: [
                {orderable: false, targets: 0},
                {orderable: false, targets: -1}
            ],
            order: [1, 'asc']
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
            __('Create Campaign'),
            ['controller' => 'campaigns', 'action' => 'add', '?' => ['customer_id' => $customer->id]],
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
                <header>
                    <h2><?php echo __('Campaigns'); ?></h2>
                </header>
                <!-- widget div-->
                <div>

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->
                    </div>
                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body no-padding">
                        <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th style="width: 5%;"></th>
                                    <th class="all"><?php echo __('Title'); ?></th>
                                    <th><?php echo __('New'); ?></th>
                                    <th><?php echo __('Sended'); ?></th>
                                    <th class="desktop"><?php echo __('Date Created'); ?></th>
                                    <th style="width: 5%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($customer->campaigns as $campaign): ?>
                                <tr>
                                    <td class="text-center">
                                        <?php
                                        echo $this->Html->link(
                                            $this->Html->tag('i', '', ['class' => 'fa fa-pencil']),
                                            ['controller' => 'Campaigns', 'action' => 'edit', $campaign->id],
                                            ['escape' => false]
                                        );
                                        ?>
                                    </td>
                                    <td><?php echo h($campaign->title); ?></td>
                                    <td><?php echo $this->Send->countSubscribers($campaign->items, 'new'); ?></td>
                                    <td><?php echo $this->Send->countSubscribers($campaign->items, 'sended'); ?></td>
                                    <td><?php echo $campaign->date_created; ?></td>
                                    <td class="text-center">
                                        <?php
                                        echo $this->Html->link(
                                            $this->Html->tag('i', '', ['class' => 'fa fa-eye']),
                                            ['controller' => 'Campaigns', 'action' => 'view', $campaign->id],
                                            ['escape' => false]
                                        );
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
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