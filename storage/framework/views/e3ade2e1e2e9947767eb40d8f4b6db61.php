<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Dashboard')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>
        (function() {

            var optionsCost = {
                chart: {
                    height: 180,
                    type: 'area',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: 'Total Cost',
                    data: <?php echo json_encode(array_values($home_data['totalCostByMonth'])); ?>

                }, ],
                xaxis: {
                    categories: <?php echo json_encode(array_keys($home_data['totalCostByMonth'])); ?>,
                },
                colors: ['#fff'],
                fill: {
                    type: 'solid',
                },
                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                },
                // markers: {
                //     size: 4,
                //     colors: ['#3ec9d6', '#FF3A6E',],
                //     opacity: 0.9,
                //     strokeWidth: 2,
                //     hover: {
                //         size: 7,
                //     }
                // }
            };
            var chartCost = new ApexCharts(document.querySelector("#chart_cost"), optionsCost);
            chartCost.render();

            var optionsHargaKains = {
                chart: {
                    height: 380,
                    type: 'bar',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: 'Total ',
                    data: <?php echo json_encode(array_values($home_data['harga_kains'])); ?>

                }, ],
                xaxis: {
                    categories: <?php echo json_encode(array_keys($home_data['harga_kains'])); ?>,
                },
                colors: ['#fff'],
                fill: {
                    type: 'solid',
                },
                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                },
                // markers: {
                //     size: 4,
                //     colors: ['#3ec9d6', '#FF3A6E',],
                //     opacity: 0.9,
                //     strokeWidth: 2,
                //     hover: {
                //         size: 7,
                //     }
                // }
            };
            var chartHargaKains = new ApexCharts(document.querySelector("#chart_harga_kains"), optionsHargaKains);
            chartHargaKains.render();

            var optionsHargaTintas = {
                chart: {
                    height: 380,
                    type: 'bar',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: 'Total ',
                    data: <?php echo json_encode(array_values($home_data['harga_tintas'])); ?>

                }, ],
                xaxis: {
                    categories: <?php echo json_encode(array_keys($home_data['harga_tintas'])); ?>,
                },
                colors: ['#fff'],
                fill: {
                    type: 'solid',
                },
                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                },
                // markers: {
                //     size: 4,
                //     colors: ['#3ec9d6', '#FF3A6E',],
                //     opacity: 0.9,
                //     strokeWidth: 2,
                //     hover: {
                //         size: 7,
                //     }
                // }
            };
            var chartHargaTintas = new ApexCharts(document.querySelector("#chart_harga_tintas"), optionsHargaTintas);
            chartHargaTintas.render();

            var optionsHargaKertass = {
                chart: {
                    height: 380,
                    type: 'bar',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: 'Total ',
                    data: <?php echo json_encode(array_values($home_data['harga_kertass'])); ?>

                }, ],
                xaxis: {
                    categories: <?php echo json_encode(array_keys($home_data['harga_kertass'])); ?>,
                },
                colors: ['#fff'],
                fill: {
                    type: 'solid',
                },
                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                },
                // markers: {
                //     size: 4,
                //     colors: ['#3ec9d6', '#FF3A6E',],
                //     opacity: 0.9,
                //     strokeWidth: 2,
                //     hover: {
                //         size: 7,
                //     }
                // }
            };
            var chartHargaKertass = new ApexCharts(document.querySelector("#chart_harga_kertass"), optionsHargaKertass);
            chartHargaKertass.render();

            var optionsBudget = {
                chart: {
                    height: 180,
                    type: 'area',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: 'Total Budget',
                    data: <?php echo json_encode(array_values($home_data['totalBudgetByMonth'])); ?>

                }, ],
                xaxis: {
                    categories: <?php echo json_encode(array_keys($home_data['totalBudgetByMonth'])); ?>,
                },
                colors: ['#fff'],
                fill: {
                    type: 'solid',
                },
                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                },
                // markers: {
                //     size: 4,
                //     colors: ['#3ec9d6', '#FF3A6E',],
                //     opacity: 0.9,
                //     strokeWidth: 2,
                //     hover: {
                //         size: 7,
                //     }
                // }
            };
            var chartBudget = new ApexCharts(document.querySelector("#chart_budget"), optionsBudget);
            chartBudget.render();

            var optionsEfisiensi = {
                chart: {
                    height: 180,
                    type: 'area',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: 'Total Efisiensi',
                    data: <?php echo json_encode(array_values($home_data['totalEfisiensiByMonth'])); ?>

                }, ],
                xaxis: {
                    categories: <?php echo json_encode(array_keys($home_data['totalEfisiensiByMonth'])); ?>,
                },
                colors: ['#fff'],
                fill: {
                    type: 'solid',
                },
                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                },
                // markers: {
                //     size: 4,
                //     colors: ['#3ec9d6', '#FF3A6E',],
                //     opacity: 0.9,
                //     strokeWidth: 2,
                //     hover: {
                //         size: 7,
                //     }
                // }
            };
            var chartEfisiensi = new ApexCharts(document.querySelector("#chart_efisiensi"), optionsEfisiensi);
            chartEfisiensi.render();

            var optionsKains = {
                chart: {
                    height: 180,
                    type: 'area',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: 'Total ',
                    data: <?php echo json_encode(array_values($home_data['kainsByMonth'])); ?>

                }, ],
                xaxis: {
                    categories: <?php echo json_encode(array_keys($home_data['kainsByMonth'])); ?>,
                },
                colors: ['#fff'],
                fill: {
                    type: 'solid',
                },
                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                },
                // markers: {
                //     size: 4,
                //     colors: ['#3ec9d6', '#FF3A6E',],
                //     opacity: 0.9,
                //     strokeWidth: 2,
                //     hover: {
                //         size: 7,
                //     }
                // }
            };
            var chartKains = new ApexCharts(document.querySelector("#chart_kains"), optionsKains);
            chartKains.render();

            var optionsTintas = {
                chart: {
                    height: 180,
                    type: 'area',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: 'Total ',
                    data: <?php echo json_encode(array_values($home_data['tintasByMonth'])); ?>

                }, ],
                xaxis: {
                    categories: <?php echo json_encode(array_keys($home_data['tintasByMonth'])); ?>,
                },
                colors: ['#fff'],
                fill: {
                    type: 'solid',
                },
                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                },
                // markers: {
                //     size: 4,
                //     colors: ['#3ec9d6', '#FF3A6E',],
                //     opacity: 0.9,
                //     strokeWidth: 2,
                //     hover: {
                //         size: 7,
                //     }
                // }
            };
            var chartTintas = new ApexCharts(document.querySelector("#chart_tintas"), optionsTintas);
            chartTintas.render();

            var optionsKertass = {
                chart: {
                    height: 180,
                    type: 'area',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: 'Total ',
                    data: <?php echo json_encode(array_values($home_data['kertassByMonth'])); ?>

                }, ],
                xaxis: {
                    categories: <?php echo json_encode(array_keys($home_data['kertassByMonth'])); ?>,
                },
                colors: ['#fff'],
                fill: {
                    type: 'solid',
                },
                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                },
                // markers: {
                //     size: 4,
                //     colors: ['#3ec9d6', '#FF3A6E',],
                //     opacity: 0.9,
                //     strokeWidth: 2,
                //     hover: {
                //         size: 7,
                //     }
                // }
            };
            var chartKertass = new ApexCharts(document.querySelector("#chart_kertass"), optionsKertass);
            chartKertass.render();

            <?php $__currentLoopData = $home_data['pertintasByMonth']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tinta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                var optionsTintas<?php echo e(str_replace(' ', '', $key)); ?> = {
                    chart: {
                        height: 180,
                        type: 'area',
                        toolbar: {
                            show: false,
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: 2,
                        curve: 'smooth'
                    },
                    series: [{
                        name: 'Total ',
                        data: <?php echo json_encode(array_values($home_data['pertintasByMonth'][$key])); ?>

                    }, ],
                    xaxis: {
                        categories: <?php echo json_encode(array_keys($home_data['pertintasByMonth'][$key])); ?>,
                    },
                    colors: ['#fff'],
                    fill: {
                        type: 'solid',
                    },
                    grid: {
                        strokeDashArray: 4,
                    },
                    legend: {
                        show: true,
                        position: 'top',
                        horizontalAlign: 'right',
                    },
                    // markers: {
                    //     size: 4,
                    //     colors: ['#3ec9d6', '#FF3A6E',],
                    //     opacity: 0.9,
                    //     strokeWidth: 2,
                    //     hover: {
                    //         size: 7,
                    //     }
                    // }
                };
                var chartTintas<?php echo e(str_replace(' ', '', $key)); ?> = new ApexCharts(document.querySelector(
                        "#chart_penggunaan_tintas<?php echo e(str_replace(' ', '', $key)); ?>"),
                    optionsTintas<?php echo e(str_replace(' ', '', $key)); ?>);
                chartTintas<?php echo e(str_replace(' ', '', $key)); ?>.render();
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php $__currentLoopData = $home_data['perkertassByMonth']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $kertas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                var optionsKertass<?php echo e(str_replace(' ', '', $key)); ?> = {
                    chart: {
                        height: 180,
                        type: 'area',
                        toolbar: {
                            show: false,
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: 2,
                        curve: 'smooth'
                    },
                    series: [{
                        name: 'Total ',
                        data: <?php echo json_encode(array_values($home_data['perkertassByMonth'][$key])); ?>

                    }, ],
                    xaxis: {
                        categories: <?php echo json_encode(array_keys($home_data['perkertassByMonth'][$key])); ?>,
                    },
                    colors: ['#fff'],
                    fill: {
                        type: 'solid',
                    },
                    grid: {
                        strokeDashArray: 4,
                    },
                    legend: {
                        show: true,
                        position: 'top',
                        horizontalAlign: 'right',
                    },
                    // markers: {
                    //     size: 4,
                    //     colors: ['#3ec9d6', '#FF3A6E',],
                    //     opacity: 0.9,
                    //     strokeWidth: 2,
                    //     hover: {
                    //         size: 7,
                    //     }
                    // }
                };
                var chartKertass<?php echo e(str_replace(' ', '', $key)); ?> = new ApexCharts(document.querySelector(
                        "#chart_penggunaan_kertass<?php echo e(str_replace(' ', '', $key)); ?>"),
                    optionsKertass<?php echo e(str_replace(' ', '', $key)); ?>);
                chartKertass<?php echo e(str_replace(' ', '', $key)); ?>.render();
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php $__currentLoopData = $home_data['perkainsByMonth']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $kains): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                var optionsKains<?php echo e(preg_replace('/[^a-zA-Z0-9\s]/', '', str_replace(' ', '', $key))); ?> = {
                    chart: {
                        height: 180,
                        type: 'area',
                        toolbar: {
                            show: false,
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: 2,
                        curve: 'smooth'
                    },
                    series: [{
                        name: 'Total ',
                        data: <?php echo json_encode(array_values($home_data['perkainsByMonth'][$key])); ?>

                    }, ],
                    xaxis: {
                        categories: <?php echo json_encode(array_keys($home_data['perkainsByMonth'][$key])); ?>,
                    },
                    colors: ['#fff'],
                    fill: {
                        type: 'solid',
                    },
                    grid: {
                        strokeDashArray: 4,
                    },
                    legend: {
                        show: true,
                        position: 'top',
                        horizontalAlign: 'right',
                    },
                    // markers: {
                    //     size: 4,
                    //     colors: ['#3ec9d6', '#FF3A6E',],
                    //     opacity: 0.9,
                    //     strokeWidth: 2,
                    //     hover: {
                    //         size: 7,
                    //     }
                    // }
                };
                var chartKains<?php echo e(preg_replace('/[^a-zA-Z0-9\s]/', '', str_replace(' ', '', $key))); ?> = new ApexCharts(
                    document.querySelector(
                        "#chart_penggunaan_kains<?php echo e(preg_replace('/[^a-zA-Z0-9\s]/', '', str_replace(' ', '', $key))); ?>"
                    ),
                    optionsKains<?php echo e(preg_replace('/[^a-zA-Z0-9\s]/', '', str_replace(' ', '', $key))); ?>);
                chartKains<?php echo e(preg_replace('/[^a-zA-Z0-9\s]/', '', str_replace(' ', '', $key))); ?>.render();
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        })();
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Material')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <h5>
            <span class="float-end">
                <form action="<?php echo e(url('material-dashboard')); ?>" method="GET" id="formProjectDashboard">
                    <select name="filter-pcs" id="filter-pcs" class="form-control"
                        onchange="$('#formProjectDashboard').submit();">
                        <option value="tahunan" <?php if(request()->get('filter-pcs') == 'tahunan'): ?> selected <?php endif; ?>>Tahunan
                        </option>
                        <option value="bulanan" <?php if(request()->get('filter-pcs') == 'bulanan'): ?> selected <?php endif; ?>>Bulanan
                        </option>
                        <option value="mingguan" <?php if(request()->get('filter-pcs') == 'mingguan'): ?> selected <?php endif; ?>>Mingguan
                        </option>
                    </select>
                </form>
            </span>
        </h5>
        <hr>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(__('Kain')); ?></h5>
                </div>
                <div class="card-body project_table">

                    <div id="chart_kains"></div>
                    <br>
                    <div class="table-responsive">
                        <div id="chart_harga_kains"></div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(__('Kertas')); ?></h5>
                </div>
                <div class="card-body project_table">

                    <div id="chart_kertass"></div>
                    <br>
                    <div class="table-responsive">
                        <div id="chart_harga_kertass"></div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(__('Tinta')); ?></h5>
                </div>
                <div class="card-body project_table">

                    <div id="chart_tintas"></div>
                    <br>
                    <div class="table-responsive">
                        <div id="chart_harga_tintas"></div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(__('Penggunaan Kain')); ?></h5>
                </div>
                <div class="card-body project_table">

                    <?php $__currentLoopData = $home_data['perkainsByMonth']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $kain): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <b><?php echo e($key); ?></b>
                        <div
                            id="chart_penggunaan_kains<?php echo e(preg_replace('/[^a-zA-Z0-9\s]/', '', str_replace(' ', '', $key))); ?>">
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(__('Penggunaan Kertas')); ?></h5>
                </div>
                <div class="card-body project_table">

                    <?php $__currentLoopData = $home_data['perkertassByMonth']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $kertas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <b><?php echo e($key); ?></b>
                        <div id="chart_penggunaan_kertass<?php echo e(str_replace(' ', '', $key)); ?>"></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(__('Penggunaan Tinta')); ?></h5>
                </div>
                <div class="card-body project_table">

                    <?php $__currentLoopData = $home_data['pertintasByMonth']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tinta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <b><?php echo e($key); ?></b>
                        <div id="chart_penggunaan_tintas<?php echo e(str_replace(' ', '', $key)); ?>"></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(__('Total Cost (Rp/Monthly)')); ?>

                    </h5>

                </div>
                <div class="card-body">
                    <div id="chart_cost"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(__('Total Income (Rp/Monthly)')); ?>

                    </h5>

                </div>
                <div class="card-body">
                    <div id="chart_budget"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(__('Total Efisiensi (Rp/Monthly)')); ?>

                    </h5>

                </div>
                <div class="card-body">
                    <div id="chart_efisiensi"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/erp-sakka/resources/views/dashboard/material-dashboard.blade.php ENDPATH**/ ?>