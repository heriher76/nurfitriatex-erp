<?php $__env->startSection('page-title'); ?>
    <?php echo e(ucwords($project->project_name)); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>
        (function() {
            var options = {
                chart: {
                    type: 'area',
                    height: 60,
                    sparkline: {
                        enabled: true,
                    },
                },
                colors: ["#ffa21d"],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2,
                },
                series: [{
                    name: 'Bandwidth',
                    data: <?php echo e(json_encode(array_map('intval', $project_data['timesheet_chart']['chart']))); ?>

                }],

                tooltip: {
                    followCursor: false,
                    fixed: {
                        enabled: false
                    },
                    x: {
                        show: false
                    },
                    y: {
                        title: {
                            formatter: function(seriesName) {
                                return ''
                            }
                        }
                    },
                    marker: {
                        show: false
                    }
                }
            }
            var chart = new ApexCharts(document.querySelector("#timesheet_chart"), options);
            chart.render();
        })();

        (function() {
            var options = {
                chart: {
                    type: 'area',
                    height: 60,
                    sparkline: {
                        enabled: true,
                    },
                },
                colors: ["#ffa21d"],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2,
                },
                series: [{
                    name: 'Bandwidth',
                    data: <?php echo e(json_encode($project_data['task_chart']['chart'])); ?>

                }],

                tooltip: {
                    followCursor: false,
                    fixed: {
                        enabled: false
                    },
                    x: {
                        show: false
                    },
                    y: {
                        title: {
                            formatter: function(seriesName) {
                                return ''
                            }
                        }
                    },
                    marker: {
                        show: false
                    }
                }
            }
            var chart = new ApexCharts(document.querySelector("#task_chart"), options);
            chart.render();
        })();

        $(document).ready(function() {
            loadProjectUser();
            $(document).on('click', '.invite_usr', function() {
                var project_id = $('#project_id').val();
                var user_id = $(this).attr('data-id');

                $.ajax({
                    url: '<?php echo e(route('invite.project.user.member')); ?>',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        'project_id': project_id,
                        'user_id': user_id,
                        "_token": "<?php echo e(csrf_token()); ?>"
                    },
                    success: function(data) {
                        if (data.code == '200') {
                            show_toastr(data.status, data.success, 'success')
                            setInterval('location.reload()', 5000);
                            loadProjectUser();
                        } else if (data.code == '404') {
                            show_toastr(data.status, data.errors, 'error')
                        }
                    }
                });
            });
        });

        function loadProjectUser() {
            var mainEle = $('#project_users');
            var project_id = '<?php echo e($project->id); ?>';

            $.ajax({
                url: '<?php echo e(route('project.user')); ?>',
                data: {
                    project_id: project_id
                },
                beforeSend: function() {
                    $('#project_users').html(
                        '<tr><th colspan="2" class="h6 text-center pt-5"><?php echo e(__('Loading...')); ?></th></tr>');
                },
                success: function(data) {
                    mainEle.html(data.html);
                    $('[id^=fire-modal]').remove();
                    // loadConfirm();
                }
            });
        }
    </script>

    
    <script>
        function copyToClipboard(element) {

            var copyText = element.id;
            navigator.clipboard.writeText(copyText);
            // document.addEventListener('copy', function (e) {
            //     e.clipboardData.setData('text/plain', copyText);
            //     e.preventDefault();
            // }, true);
            //
            // document.execCommand('copy');
            show_toastr('success', 'Url copied to clipboard', 'success');
        }
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('projects.index')); ?>"><?php echo e(__('Project')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(ucwords($project->project_name)); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('share project')): ?>
            
            
            
            
            
            
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view grant chart')): ?>
            
        <?php endif; ?>
        <?php if(\Auth::user()->type != 'client' || \Auth::user()->type == 'client'): ?>
            
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view expense')): ?>
            
        <?php endif; ?>
        <?php if(\Auth::user()->type != 'client'): ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view timesheet')): ?>
                
            <?php endif; ?>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage bug report')): ?>
            
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create project task')): ?>
            <?php if(Auth::user()->type != 'client'): ?>
                <?php if(request()->channel != 'activity'): ?>
                    <a href="<?php echo e(route('task.material_used', $project->id)); ?><?php echo e(request()->channel == 'activity' ? '?channel=activity' : ''); ?>"
                        class="btn btn-sm btn-primary">
                        <?php echo e(__('Material Used')); ?>

                    </a>
                <?php endif; ?>
                <a href="<?php echo e(route('projects.tasks.index', $project->id)); ?><?php echo e(request()->channel == 'activity' ? '?channel=activity' : ''); ?>"
                    class="btn btn-sm btn-primary">
                    <?php echo e(__('Task')); ?>

                </a>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit project')): ?>
            <a href="#" data-size="lg"
                data-url="<?php echo e(route('projects.edit', $project->id)); ?><?php echo e(request()->channel == 'activity' ? '?channel=activity' : ''); ?>"
                data-ajax-popup="true" data-bs-toggle="tooltip"
                title="<?php echo e(request()->channel == 'activity' ? 'Edit Activity' : 'Edit Project'); ?>"
                class="btn btn-sm btn-primary">
                <i class="ti ti-pencil"></i>
            </a>
        <?php endif; ?>


    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php if(
            (Auth::user()->type == 'super admin' || Auth::user()->type == 'company' || Auth::user()->type == 'Admin') &&
                request()->channel != 'activity'): ?>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto mb-3 mb-sm-0">
                                <div class="d-flex align-items-center">
                                    <div class="theme-avtar bg-warning">
                                        <i class="ti ti-report-money"></i>
                                    </div>
                                    <div class="ms-3">
                                        <small class="text-muted h6"><?php echo e(__('Total')); ?></small>
                                        <h6 class="m-0">Budget</h6>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="">
                                
                                <center>
                                    <h4 class="m-0"><?php echo e(\Auth::user()->priceFormat($project->budget)); ?></h4>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto mb-3 mb-sm-0">
                                <div class="d-flex align-items-center">
                                    <div class="theme-avtar bg-danger">
                                        <i class="ti ti-report-money"></i>
                                    </div>
                                    <div class="ms-3">
                                        <small class="text-muted"><?php echo e(__('Total')); ?></small>
                                        <h6 class="m-0"><?php echo e(__('Expense')); ?></h6>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="">
                                
                                <center>
                                    <h4 class="m-0"><?php echo e(\Auth::user()->priceFormat($project_data['expense']['total'])); ?>

                                    </h4>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto mb-3 mb-sm-0">
                                <div class="d-flex align-items-center">
                                    <div class="theme-avtar bg-primary">
                                        <i class="ti ti-report-money"></i>
                                    </div>
                                    <div class="ms-3">
                                        <small class="text-muted"><?php echo e(__('Total')); ?></small>
                                        <h6 class="m-0"><?php echo e(__('Margin')); ?></h6>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="">
                                
                                <center>
                                    <h4 class="m-0">
                                        <?php echo e(\Auth::user()->priceFormat($project->budget - $project_data['expense']['total'])); ?>

                                    </h4>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto mb-3 mb-sm-0">
                                <div class="d-flex align-items-center">
                                    <div class="theme-avtar bg-success">
                                        <i class="ti ti-report-money"></i>
                                    </div>
                                    <div class="ms-3">
                                        <small class="text-muted h6"><?php echo e(__('Total')); ?></small>
                                        <h6 class="m-0">Pcs</h6>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="">
                                
                                <center>
                                    <h4 class="m-0"><?php echo e($total_pcs); ?></h4>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            
        <?php endif; ?>
        <div class="col-lg-8 col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <img <?php echo e($project->img_image); ?> alt="" class="img-user wid-45 rounded-circle">
                        </div>
                        <div class="d-block  align-items-center justify-content-between w-100">
                            <div class="mb-3 mb-sm-0">
                                <h5 class="mb-1"> <?php echo e($project->project_name); ?></h5>
                                <p class="mb-0 text-sm">
                                    <?php
                                        $projectProgress = $project->project_progress($project, $last_task->id)[
                                            'percentage'
                                        ];
                                    ?>
                                <div class="progress-wrapper">
                                    <span class="progress-percentage"><small
                                            class="font-weight-bold"><?php echo e(__('Completed:')); ?> :
                                        </small><?php echo e($projectProgress); ?></span>
                                    <div class="progress progress-xs mt-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            aria-valuenow="<?php echo e($projectProgress); ?>" aria-valuemin="0" aria-valuemax="100"
                                            style="width: <?php echo e($projectProgress); ?>;"></div>
                                    </div>
                                </div>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-10">
                            <h4 class="mt-3 mb-1"></h4>
                            <p> <?php echo e($project->description); ?></p>
                        </div>
                    </div>
                    <div class="card bg-primary mb-0">
                        <div class="card-body">
                            <div class="d-block d-sm-flex align-items-center justify-content-between">
                                <div class="row align-items-center">
                                    <span class="text-white text-sm"><?php echo e(__('Start Date')); ?></span>
                                    <h5 class="text-white text-nowrap">
                                        <?php echo e(Utility::getDateFormated($project->start_date)); ?></h5>
                                </div>
                                <div class="row align-items-center">
                                    <span class="text-white text-sm"><?php echo e(__('End Date')); ?></span>
                                    <h5 class="text-white text-nowrap"><?php echo e(Utility::getDateFormated($project->end_date)); ?>

                                    </h5>
                                </div>

                            </div>
                            <div class="row">
                                <span class="text-white text-sm"><?php echo e(__('Client')); ?></span>
                                <h5 class="text-white text-nowrap">
                                    <?php echo e(!empty($project->client) ? $project->client->name : '-'); ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="theme-avtar bg-primary">
                            <i class="ti ti-clipboard-list"></i>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-0"><?php echo e(__('Last 7 days task done')); ?></p>
                            <h4 class="mb-0"><?php echo e($project_data['task_chart']['total']); ?></h4>

                        </div>
                    </div>
                    <div id="task_chart"></div>
                </div>

                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                            <span class="text-muted"><?php echo e(__('Day Left')); ?></span>
                        </div>
                        <span><?php echo e($project_data['day_left']['day']); ?></span>
                    </div>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-primary"
                            style="width: <?php echo e($project_data['day_left']['percentage']); ?>%"></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">

                            <span class="text-muted"><?php echo e(__('Open Task')); ?></span>
                        </div>
                        <span><?php echo e($project_data['open_task']['tasks']); ?></span>
                    </div>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-primary"
                            style="width: <?php echo e($project_data['open_task']['percentage']); ?>%"></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                            <span class="text-muted"><?php echo e(__('Completed Milestone')); ?></span>
                        </div>
                        <span><?php echo e($project_data['milestone']['total']); ?></span>
                    </div>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-primary"
                            style="width: <?php echo e($project_data['milestone']['percentage']); ?>%"></div>
                    </div>
                </div>
            </div>

        </div>
        

        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view activity')): ?>
            <div class="col-xl-6">
                <div class="card activity-scroll">
                    <div class="card-header">
                        <h5><?php echo e(__('Activity Log')); ?></h5>
                        <small><?php echo e(__('Activity Log of this project')); ?></small>
                    </div>
                    <div class="card-body vertical-scroll-cards">
                        <?php $__currentLoopData = $project->activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="card p-2 mb-2">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="theme-avtar bg-primary">
                                            <i class="ti <?php echo e($activity->logIcon($activity->log_type)); ?>"></i>
                                        </div>
                                        <div class="ms-3">
                                            <h6 class="mb-0"><?php echo e(__($activity->log_type)); ?></h6>
                                            <p class="text-muted text-sm mb-0"><?php echo $activity->getRemark(); ?></p>
                                        </div>
                                    </div>
                                    <p class="text-muted text-sm mb-0"><?php echo e($activity->created_at->diffForHumans()); ?></p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-lg-6 col-md-6">
            <div class="card activity-scroll">
                <div class="card-header">
                    <h5><?php echo e(__('Attachments')); ?></h5>
                    <small><?php echo e(__('Attachment that uploaded in this project')); ?></small>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <?php if($project->projectAttachments()->count() > 0): ?>
                            <?php $__currentLoopData = $project->projectAttachments(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item px-0">
                                    <div class="row align-items-center justify-content-between">
                                        <div class="col mb-3 mb-sm-0">
                                            <div class="d-flex align-items-center">
                                                <div class="div">
                                                    <h6 class="m-0"><?php echo e($attachment->name); ?></h6>
                                                    <small class="text-muted"><?php echo e($attachment->file_size); ?></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto text-sm-end d-flex align-items-center">
                                            <div class="action-btn bg-info ms-2">
                                                <a href="<?php echo e(asset(Storage::url('tasks/' . $attachment->file))); ?>"
                                                    data-bs-toggle="tooltip" title="<?php echo e(__('Download')); ?>"
                                                    class="btn btn-sm" download>
                                                    <i class="ti ti-download text-white"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="py-5">
                                <h6 class="h6 text-center"><?php echo e(__('No Attachments Found.')); ?></h6>
                            </div>
                        <?php endif; ?>
                    </ul>

                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5><?php echo e(__('Members')); ?></h5>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit project')): ?>
                            <div class="float-end">
                                <a href="#" data-size="lg"
                                    data-url="<?php echo e(route('invite.project.member.view', $project->id)); ?>" data-ajax-popup="true"
                                    data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
                                    data-bs-original-title="<?php echo e(__('Add Member')); ?>">
                                    <i class="ti ti-plus"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush list" id="project_users">
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/erp-sakka/resources/views/projects/view.blade.php ENDPATH**/ ?>