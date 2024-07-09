<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Dashboard')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>
        (function() {
            function getRandomColor() {
                var letters = '0123456789ABCDEF';
                var color = '#';
                for (var i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }

            var options = {
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
                series: [
                    <?php $__currentLoopData = $home_data['task_overview']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $overview): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        {
                            name: '<?php echo e($index); ?>',
                            data: <?php echo json_encode(array_values($overview)); ?>

                        },
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                ],
                xaxis: {
                    categories: <?php echo json_encode(array_keys($overview)); ?>,
                },
                colors: ['#2E93fA', '#66DA26', '#546E7A', '#E91E63', '#FF9800'],
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
            var chart = new ApexCharts(document.querySelector("#task_overview"), options);
            chart.render();
        })();

        (function() {
            var options = {
                chart: {
                    height: 300,
                    type: 'bar',
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        borderRadius: 10,
                        dataLabels: {
                            position: 'top',
                        },
                    }
                },
                colors: ["#3ec9d6"],
                dataLabels: {
                    enabled: true,
                    offsetX: -6,
                    style: {
                        fontSize: '12px',
                        colors: ['#fff']
                    }
                },
                stroke: {
                    show: true,
                    width: 1,
                    colors: ['#fff']
                },
                grid: {
                    strokeDashArray: 4,
                },
                series: [{
                    data: <?php echo json_encode(array_values($home_data['timesheet_logged'])); ?>

                }],
                xaxis: {
                    categories: <?php echo json_encode(array_keys($home_data['timesheet_logged'])); ?>,
                },
            };
            var chart = new ApexCharts(document.querySelector("#timesheet_logged"), options);
            chart.render();
        })();
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Project')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-6"></div>
        <div class="col-lg-6">
            <span class="float-end">
                <form method="GET" id="formDivisionActivityDashboard">
                    <select name="filter-division" id="filter-division" class="form-control"
                        onchange="$('#formDivisionActivityDashboard').submit();">
                        <option disabled <?php if(empty(request()->get('filter-division'))): ?> selected <?php endif; ?>>Pilih Divisi</option>
                        <?php $__currentLoopData = $home_data['list_division']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $divisi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($divisi->id); ?>" <?php if(request()->get('filter-division') == $divisi->id): ?> selected <?php endif; ?>>
                                <?php echo e($divisi->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <input type="hidden" name="filter-task" value="<?php echo e(request()->get('filter-task')); ?>">
                </form>
            </span>
        </div>
    </div>
    <div class="row">

        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-primary">
                                    <i class="ti ti-cast"></i>
                                </div>
                                <div class="ms-3">
                                    <small class="text-muted"><?php echo e(__('Total')); ?></small>
                                    <h6 class="m-0"><?php echo e(__('Activities')); ?></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto text-end">
                            <h4 class="m-0"><?php echo e($home_data['total_project']['total']); ?></h4>
                            <small class="text-muted"><span
                                    class="text-success"><?php echo e($home_data['total_project']['percentage']); ?>%</span>
                                <?php echo e(__('completd')); ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-info">
                                    <i class="ti ti-activity"></i>
                                </div>
                                <div class="ms-3">
                                    <small class="text-muted"><?php echo e(__('Total')); ?></small>
                                    <h6 class="m-0"><?php echo e(__('Tasks')); ?></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto text-end">
                            <h4 class="m-0"><?php echo e($home_data['total_task']['total']); ?></h4>
                            <small class="text-muted"><span
                                    class="text-success"><?php echo e($home_data['total_task']['percentage']); ?>%</span>
                                <?php echo e(__('completd')); ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(__('Top Due Projects')); ?></h5>
                </div>
                <div class="card-body project_table">
                    <div class="table-responsive ">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Name')); ?></th>
                                    <th><?php echo e(__('End Date')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($home_data['due_project']->count() > 0): ?>
                                    <?php $__currentLoopData = $home_data['due_project']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $due_project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="<?php echo e(asset(Storage::url('/' . $due_project->project_image))); ?>"
                                                        class="wid-40 rounded-circle me-3">
                                                    <div>
                                                        <h6 class="mb-0"><?php echo e($due_project->project_name); ?></h6>
                                                        

                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo e(Utility::getDateFormated($due_project->end_date)); ?></td>
                                            <td class="">
                                                <span
                                                    class=" status_badge p-2 px-3 rounded badge bg-<?php echo e(\App\Models\Project::$status_color[$due_project->status]); ?>"><?php echo e(__(\App\Models\Project::$project_status[$due_project->status])); ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr class="py-5">
                                        <td class="text-center mb-0" colspan="3"><?php echo e(__('No Due Projects Found.')); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">

                    <h5><?php echo e(__('Project Status')); ?></h5>
                </div>
                <div class="card-body">
                    <div class="row ">
                        <?php $__currentLoopData = $home_data['project_status']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-6 col-sm-6 mb-5">
                                <div class="align-items-start">

                                    <div class="ms-2">
                                        <p class="text-muted text-sm mb-0">
                                            <?php echo e(__(\App\Models\Project::$project_status[$status])); ?></p>
                                        <h3 class="mb-0 text-<?php echo e(\App\Models\Project::$status_color[$status]); ?>">
                                            <?php echo e($val['total']); ?>%</h3>
                                        <div class="progress mb-0">
                                            <div class="progress-bar bg-<?php echo e(\App\Models\Project::$status_color[$status]); ?>"
                                                style="width: <?php echo e($val['percentage']); ?>%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(__('Tasks Overview')); ?>

                        <span class="float-end">
                            <form method="GET" id="formActivityDashboard">
                                <select name="filter-task" id="filter-task" class="form-control"
                                    onchange="$('#formActivityDashboard').submit();">
                                    <option value="harian" <?php if(request()->get('filter-task') == 'harian'): ?> selected <?php endif; ?>>Harian
                                    </option>
                                    <option value="mingguan" <?php if(request()->get('filter-task') == 'mingguan'): ?> selected <?php endif; ?>>Mingguan
                                    </option>
                                    <option value="bulanan" <?php if(request()->get('filter-task') == 'bulanan'): ?> selected <?php endif; ?>>Bulanan
                                    </option>
                                    <option value="tahunan" <?php if(request()->get('filter-task') == 'tahunan'): ?> selected <?php endif; ?>>Tahunan
                                    </option>
                                </select>
                                <input type="hidden" name="filter-division"
                                    value="<?php echo e(request()->get('filter-division')); ?>">
                            </form>
                        </span>
                    </h5>

                </div>
                <div class="card-body">
                    <div id="task_overview"></div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Name')); ?></th>
                                    <th><?php echo e(__('Low')); ?></th>
                                    <th><?php echo e(__('Medium')); ?></th>
                                    <th><?php echo e(__('High')); ?></th>
                                    <th><?php echo e(__('Critical')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($home_data['all_task_overview'])): ?>
                                    <?php $__currentLoopData = $home_data['all_task_overview']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task_overview): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="font-style">
                                            <td><?php echo e($task_overview['name'] ?? ''); ?></td>
                                            <td><?php echo e($task_overview['low'] ?? 0); ?></td>
                                            <td><?php echo e($task_overview['medium'] ?? 0); ?></td>
                                            <td><?php echo e($task_overview['high'] ?? 0); ?></td>
                                            <td><?php echo e($task_overview['critical'] ?? 0); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(__('Top Due Tasks')); ?></h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <?php $__currentLoopData = $home_data['due_tasks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $due_task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="">
                                                    <small class="text-muted"><?php echo e(__('Task')); ?>:</small>
                                                    <h6 class="m-0"><a
                                                            href="<?php echo e(route('projects.tasks.index', $due_task->project->id)); ?>"
                                                            class="name mb-0 h6 text-sm"><?php echo e($due_task->name); ?></a></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <small class="text-muted"><?php echo e(__('Divisi')); ?>:</small>
                                            <h6 class="m-0 h6 text-sm">
                                                <?php if(!empty($due_task->task_user)): ?>
                                                    <?php if(!empty($due_task->task_user->roles)): ?>
                                                        <?php echo e($due_task->task_user->roles->pluck('name')[0] ?? '-'); ?>

                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </h6>
                                        </td>
                                        <td>
                                            <small class="text-muted"><?php echo e(__('Project')); ?>:</small>
                                            <h6 class="m-0 h6 text-sm"><?php echo e($due_task->project->project_name); ?></h6>
                                        </td>
                                        <td>

                                            <small class="text-muted"><?php echo e(__('Stage')); ?>:</small>
                                            <div class="d-flex align-items-center h6 text-sm mt-2">
                                                <span
                                                    class="full-circle bg-<?php echo e(\App\Models\ProjectTask::$priority_color[$due_task->priority]); ?>"></span>
                                                <span
                                                    class="ms-1"><?php echo e(\App\Models\ProjectTask::$priority[$due_task->priority]); ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <small class="text-muted"><?php echo e(__('Completion')); ?>:</small>
                                            <h6 class="m-0 h6 text-sm">
                                                <?php echo e($due_task->taskProgress($due_task)['percentage']); ?></h6>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(__('PIC Tasks')); ?></h5>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Name')); ?></th>
                                    <th><?php echo e(__('Title')); ?></th>
                                    <th><?php echo e(__('End Date')); ?></th>
                                    <th><?php echo e(__('Description')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($home_data['all_tasks'])): ?>
                                    <?php $__currentLoopData = $home_data['all_tasks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="font-style">
                                            <td><?php echo e($task->task_user->name ?? ''); ?></td>
                                            <td><?php echo e($task->name ?? ''); ?></td>
                                            <td><?php echo e(Auth::user()->dateFormat($task->end_date)); ?></td>
                                            <td><?php echo e($task->description); ?> </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/erp-sakka/resources/views/dashboard/activity-dashboard.blade.php ENDPATH**/ ?>