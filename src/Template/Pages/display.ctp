<?php
$title = __('Dashboard');

$this->assign('title', $title);

$this->start('ribbon');
echo $this->element('ribbon');
$this->end();

$this->start('navigation');
$menu['dashboard'] = true;
echo $this->element('navigation', ['menu' => $menu]);
$this->end();

echo $this->Html->script([
    'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js',
    'https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels'
], ['block' => true]);

//echo $this->Send->distributionItemsWithEmailByRegions($distributionItemsWithEmailByRegions);
//exit;
?>

<?php $this->start('script-code'); ?>
<script>
$(document).ready(function() {
    Chart.plugins.unregister(ChartDataLabels);
    new Chart($('#countItemsPie'), {
        type: 'pie',
        data: {
            labels: ['Без электронных адресов', 'С электронными адресами'],
            datasets: [{
                    data: [<?php echo $countItems - $countItemsWithEmail; ?>, <?php echo $countItemsWithEmail; ?>],
                    backgroundColor: ['#00a7db', '#001e37']
                }]
        },
        plugins: [ChartDataLabels],
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: true,
                onClick: (e) => e.stopPropagation()
            },
            tooltips: {
                /*callbacks: {
                    label: function(tooltipItem, data) {
                        let sum = 0;
                        let dataArr = data.datasets[tooltipItem.datasetIndex].data;
                        let value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]
                        dataArr.map(data => {
                            sum += data;
                        });
                        let percentage = (value * 100 / sum).toFixed(2) + "%";

                        return data.labels[tooltipItem.index] + ': ' + percentage;
                    }
                }*/
            },
            plugins: {
                datalabels: {
                    formatter: (value, ctx) => {
                        let sum = 0;
                        let dataArr = ctx.chart.data.datasets[0].data;
                        dataArr.map(data => {
                            sum += data;
                        });
                        let percentage = (value*100 / sum).toFixed(2) + "%";
                        return [value, '', percentage];
                    },
                    font: {
                        weight: 'bold'
                    },
                    textAlign: 'center',
                    clip: true,
                    color: '#fff',
                }
            }
        }
    });


    new Chart($('#distributionItemsWithEmailByRegionsBar'), {
        type: 'horizontalBar',
        data: <?php echo $this->Send->distributionItemsWithEmailByRegions($distributionItemsWithEmailByRegions); ?>,
        plugins: [ChartDataLabels],
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false,
                onClick: (e) => e.stopPropagation()
            },
            plugins: {
                datalabels: {
                    font: {
                        weight: 'bold'
                    },
                    textAlign: 'center',
                    clip: true,
                    color: '#fff',
                }
            }
        }
    });

    new Chart($('#topDomain'), {
        type: 'horizontalBar',
        data: {
            labels: ['mail.ru', 'gmail.com', 'yandex.ru', 'bk.ru', 'inbox.ru', 'list.ru', 'rambler.ru', 'umail.uz', 'yahoo.com', 'nfs.uz', 'Другие'],
            datasets: [
                {
                    label: 'Не живые',
                    data: [0, 107, 3, 0, 0, 0, 20, 41, 0, 0, 289],
                    backgroundColor: '#001e37'
                },
                {
                    label: 'Живые',
                    data: [3756, 730, 295, 237, 194, 143, 108, 54, 69, 52, 2055],
                    backgroundColor: '#00a7db'
                }
            ]
        },
        plugins: [ChartDataLabels],
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
				xAxes: [{
                    stacked: true,
				}],
                yAxes: [{
                    stacked: true
                }]
			},
            plugins: {
                datalabels: {
                    font: {
                        weight: 'bold'
                    },
                    textAlign: 'center',
                    clip: true,
                    color: '#fff',
                }
            }
        }
    });


    new Chart($('#result'), {
        type: 'doughnut',
        data: {
            labels: ['Активные', 'Не живые'],
            datasets: [{
                    data: [<?php echo $countLiveEmails; ?>, <?php echo $countIncorrectEmails; ?>],
                    backgroundColor: ['#00a7db', '#001e37']
                }]
        },
        plugins: [ChartDataLabels],
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: true,
                onClick: (e) => e.stopPropagation()
            },
            tooltips: {
                /*callbacks: {
                    label: function(tooltipItem, data) {
                        let sum = 0;
                        let dataArr = data.datasets[tooltipItem.datasetIndex].data;
                        let value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]
                        dataArr.map(data => {
                            sum += data;
                        });
                        let percentage = (value * 100 / sum).toFixed(2) + "%";

                        return data.labels[tooltipItem.index] + ': ' + percentage;
                    }
                }*/
            },
            plugins: {
                datalabels: {
                    formatter: (value, ctx) => {
                        let sum = 0;
                        let dataArr = ctx.chart.data.datasets[0].data;
                        dataArr.map(data => {
                            sum += data;
                        });
                        let percentage = (value * 100 / sum).toFixed(2) + "%";
                        return percentage;
                    },
                    font: {
                        weight: 'bold'
                    },
                    textAlign: 'center',
                    clip: true,
                    color: '#fff',
                }
            }
        }
    });

});
</script>
<?php $this->end(); ?>

<section id="widget-grid">
    <!-- row -->
    <div class="row">
        <div class="col-md-12">
            <h2>Первый этап. До провеки адресов</h2>
        </div>
        <div class="col-md-6">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-1">
                <header>
                    <h3>Общее количество компаний: <?php echo $countItems; ?></h3>
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
                        <div class="chart-container" style="position: relative; height:50vh;">
                            <canvas id="countItemsPie"></canvas>
                        </div>
                    </div>
                    <!-- end widget content -->
                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->
        </div>
        <div class="col-md-6">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-2">
                <header>
                    <h3>Региональная распределённость</h3>
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
                        <div class="chart-container" style="position: relative; height:50vh;">
                            <canvas id="distributionItemsWithEmailByRegionsBar"></canvas>
                        </div>
                    </div>
                    <!-- end widget content -->
                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->
        </div>
        <div class="col-md-12">
            <h2>Второй этап. Проверка</h2>
        </div>
        <div class="col-md-12">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-2">
                <header>
                    <h3>Проверка RFC, Spoof, DNS и Domains SMTP</h3>
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
                        <h4>RFC Check</h4>
                        <div class="panel-group smart-accordion-default mb-5" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
									<h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" class="collapsed">
                                            <i class="fa fa-lg fa-angle-down pull-right"></i>
                                            <i class="fa fa-lg fa-angle-up pull-right"></i> Не прошли проверку электронные адреса в количестве: <?php echo $countRfcFailedCheckItems; ?>
                                        </a>
                                    </h4>
								</div>
								<div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
									<div class="panel-body">
                                    <?php echo $this->Text->toList($rfcFailedCheckItems); ?>
									</div>
								</div>
							</div>
						</div>

                        <br/>
                        <h4>Spoof Check</h4>
                        <div class="panel-group smart-accordion-default mt-2" id="accordion2">
                            <div class="panel panel-default">
                                <div class="panel-heading">
									<h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion2" href="#collapseOne2" aria-expanded="false" class="collapsed">
                                            <i class="fa fa-lg fa-angle-down pull-right"></i>
                                            <i class="fa fa-lg fa-angle-up pull-right"></i> Не прошли проверку электронные адреса в количестве: <?php echo $countSpoofFailedCheckItems; ?>
                                        </a>
                                    </h4>
								</div>
								<div id="collapseOne2" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
									<div class="panel-body">
                                        <?php echo $this->Text->toList($spoofFailedCheckItems); ?>
									</div>
								</div>
							</div>
						</div>

                        <br/>
                        <h4>DNS Check</h4>
                        <div class="panel-group smart-accordion-default mt-2" id="accordion3">
                            <div class="panel panel-default">
                                <div class="panel-heading">
									<h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion3" href="#collapseOne3" aria-expanded="false" class="collapsed">
                                            <i class="fa fa-lg fa-angle-down pull-right"></i>
                                            <i class="fa fa-lg fa-angle-up pull-right"></i> Не прошли проверку электронные адреса в количестве: <?php echo $countDnsFailedCheckItems; ?>
                                        </a>
                                    </h4>
								</div>
								<div id="collapseOne3" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
									<div class="panel-body">
                                        <?php echo $this->Text->toList($dnsFailedCheckItems); ?>
									</div>
								</div>
							</div>
						</div>

                        <br/>
                        <h4>Domain SMTP Check</h4>
                        <div class="panel-group smart-accordion-default mt-2" id="accordion4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
									<h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion4" href="#collapseOne4" aria-expanded="false" class="collapsed">
                                            <i class="fa fa-lg fa-angle-down pull-right"></i>
                                            <i class="fa fa-lg fa-angle-up pull-right"></i> Не прошли проверку домены в количестве: <?php echo $countSmtpFailedCheckDomains; ?>, включающие в себя <?php echo $countDomainSmtpFailedCheckItems; ?> электронных адресов
                                        </a>
                                    </h4>
								</div>
								<div id="collapseOne4" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
									<div class="panel-body">
                                        <?php echo $this->Text->toList($smtpFailedCheckDomains); ?>
									</div>
								</div>
							</div>
						</div>

                        <br/>
                        <h4>Email SMTP Check</h4>
                        <div class="panel-group smart-accordion-default mt-2" id="accordion5">
                            <div class="panel panel-default">
                                <div class="panel-heading">
									<h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion5" href="#collapseOne5" aria-expanded="false" class="collapsed">
                                            <i class="fa fa-lg fa-angle-down pull-right"></i>
                                            <i class="fa fa-lg fa-angle-up pull-right"></i> Не прошли проверку электронные адреса в количестве: <?php echo $countDieEmails; ?>
                                        </a>
                                    </h4>
								</div>
								<div id="collapseOne5" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
									<div class="panel-body">
                                        <?php echo $this->Text->toList($dieEmails); ?>
									</div>
								</div>
							</div>
						</div>
                    </div>
                    <!-- end widget content -->
                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->
        </div>

        <div class="col-md-12">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-2">
                <header>
                    <h3>Доля активных электронных адресов у популярных доменов</h3>
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
                        <div class="chart-container" style="position: relative; height:60vh;">
                            <canvas id="topDomain"></canvas>
                        </div>
                    </div>
                    <!-- end widget content -->
                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->
        </div>


        <div class="col-md-12">
            <h2>Итоговый результат</h2>
        </div>

        <div class="col-md-12">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-2">
                <header>
                    <h3>Доля не существующих адресов</h3>
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
                        <div class="chart-container" style="position: relative; height:60vh;">
                            <canvas id="result"></canvas>
                        </div>
                    </div>
                    <!-- end widget content -->
                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->
        </div>
    </div>
</section>