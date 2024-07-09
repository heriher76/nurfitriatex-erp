<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Material Used')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('projects.index')); ?>"><?php echo e(__('Project')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('projects.show', $project->id)); ?>"><?php echo e(ucwords($project->project_name)); ?></a>
    </li>
    <li class="breadcrumb-item"><?php echo e(__('Material Used')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <a href="#" data-size="lg" data-url="<?php echo e(route('task.material_used.create', $project->id)); ?>"
            data-ajax-popup="true" data-bs-toggle="tooltip" title="<?php echo e(__('Create New Material')); ?>"
            class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th> <?php echo e(__('Number')); ?></th>
                                    <th> <?php echo e(__('Product')); ?></th>
                                    <th> <?php echo e(__('Quantity')); ?></th>
                                    <th> <?php echo e(__('Date')); ?></th>
                                    <th> <?php echo e(__('Description')); ?></th>
                                    <th> <?php echo e(__('Created By')); ?></th>
                                    <th width="10%"> <?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($material->product->name); ?></td>
                                        <td><?php echo e($material->quantity); ?></td>
                                        <td><?php echo e(Auth::user()->dateFormat($material->date)); ?></td>
                                        <td><?php echo e($material->description); ?></td>
                                        <td><?php echo e($material->createdBy->name); ?></td>
                                        <td class="Action" width="10%">

                                            <div class="action-btn bg-danger ms-2">
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['task.material_used.destroy', $project->id, $material->id]]); ?>

                                                <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                    data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>"><i
                                                        class="ti ti-trash text-white"></i></a>
                                                <?php echo Form::close(); ?>

                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/erp-sakka/resources/views/material_used/index.blade.php ENDPATH**/ ?>