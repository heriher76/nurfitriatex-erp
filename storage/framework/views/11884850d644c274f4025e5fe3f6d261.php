<?php echo e(Form::open(['url' => 'projects?channel=' . request()->channel, 'method' => 'post', 'enctype' => 'multipart/form-data'])); ?>

<div class="modal-body">
    
    <?php
        $plan = \App\Models\Utility::getChatGPTSettings();
    ?>
    <?php if($plan->chatgpt == 1): ?>
        <div class="text-end">
            <a href="#" data-size="md" class="btn  btn-primary btn-icon btn-sm" data-ajax-popup-over="true"
                data-url="<?php echo e(route('generate', ['project'])); ?>" data-bs-placement="top"
                data-title="<?php echo e(__('Generate content with AI')); ?>">
                <i class="fas fa-robot"></i> <span><?php echo e(__('Generate with AI')); ?></span>
            </a>
        </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <?php if(request()->channel == 'activity'): ?>
                    <?php echo e(Form::label('project_name', __('Activity Name'), ['class' => 'form-label'])); ?>

                <?php else: ?>
                    <?php echo e(Form::label('project_name', __('Project Name'), ['class' => 'form-label'])); ?>

                <?php endif; ?>
                <span class="text-danger">*</span>
                <?php echo e(Form::text('project_name', null, ['class' => 'form-control', 'required' => 'required'])); ?>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('start_date', __('Start Date'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::date('start_date', null, ['class' => 'form-control'])); ?>

            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('end_date', __('End Date'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::date('end_date', null, ['class' => 'form-control'])); ?>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-12 col-md-12">
            <?php echo e(Form::label('project_image', __('Project Image'), ['class' => 'form-label'])); ?><span
                class="text-danger">*</span>
            <div class="form-file mb-3">
                <input type="file" class="form-control" name="project_image" required="">
            </div>

        </div>
        <?php if(request()->channel == 'activity'): ?>
            <input type="hidden" value="4" name="client">
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <?php echo e(Form::label('user', __('User'), ['class' => 'form-label'])); ?><span class="text-danger">*</span>
                    <?php echo Form::select('user[]', $users, null, ['class' => 'form-control', 'required' => 'required']); ?>

                </div>
            </div>
        <?php else: ?>
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <?php echo e(Form::label('client', __('Client'), ['class' => 'form-label'])); ?><span
                        class="text-danger">*</span>
                    <?php echo Form::select('client', $clients, null, ['class' => 'form-control', 'required' => 'required']); ?>

                </div>
            </div>
        <?php endif; ?>
        <?php if(request()->channel == 'activity'): ?>
            <input type="hidden" value="0" name="budget">
        <?php else: ?>
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <?php echo e(Form::label('budget', __('Budget'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::number('budget', null, ['class' => 'form-control'])); ?>

                </div>
            </div>
        <?php endif; ?>
        <div class="col-6 col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('priority', __('Priority'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::number('priority', null, ['class' => 'form-control', 'min' => '0', 'maxlength' => '8'])); ?>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('description', __('Description'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::textarea('description', null, ['class' => 'form-control', 'rows' => '4', 'cols' => '50'])); ?>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('tag', __('Tag'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('tag', null, ['class' => 'form-control', 'data-toggle' => 'tags'])); ?>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('status', __('Status'), ['class' => 'form-label'])); ?>

                <select name="status" id="status" class="form-control main-element">
                    <?php $__currentLoopData = \App\Models\Project::$project_status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($k); ?>"><?php echo e(__($v)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <?php if(request()->channel == 'activity'): ?>
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <?php echo e(Form::label('channel', __('Type'), ['class' => 'form-label'])); ?>

                    <select name="type" id="type" class="form-control main-element">
                        <option value="activity">Activity</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <?php echo e(Form::label('department_id', __('Division'), ['class' => 'form-label'])); ?>

                    <select name="department_id" id="department_id" class="form-control main-element">
                        <?php $__currentLoopData = \App\Models\Department::get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($v->id); ?>"><?php echo e(__($v->name)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        <?php else: ?>
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <?php echo e(Form::label('channel', __('Type'), ['class' => 'form-label'])); ?>

                    <select name="type" id="type" class="form-control main-element">
                        <option value="sales">Sales</option>
                    </select>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn  btn-primary">
</div>
<?php echo e(Form::close()); ?>

<?php /**PATH /Applications/MAMP/htdocs/erp-sakka/resources/views/projects/create.blade.php ENDPATH**/ ?>