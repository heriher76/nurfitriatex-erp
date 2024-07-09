<?php echo e(Form::open(['route' => ['task.material_used.store', $project_id]])); ?>

<div class="modal-body">
    
    <?php
        $user = \App\Models\User::find(\Auth::user()->creatorId());
        $plan = \App\Models\Plan::getPlan($user->plan);
    ?>
    
    <div class="row">
        <div class="form-group col-md-6">
            <?php echo e(Form::label('product_id', __('Material'), ['class' => 'form-label'])); ?>

            <?php echo Form::select('product_id', $products, null, ['class' => 'form-control select', 'required' => 'required']); ?>

        </div>
        <div class="form-group  col-md-6">
            <?php echo e(Form::label('date', __('Date'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::date('date', '', ['class' => 'form-control', 'required' => 'required'])); ?>

        </div>
        <div class="form-group  col-md-6">
            <?php echo e(Form::label('quantity', __('Quantity'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::number('quantity', '', ['class' => 'form-control', 'required' => 'required', 'step' => 'any'])); ?>

        </div>
    </div>
    <div class="row">
        <div class="form-group  col-md-12">
            <?php echo e(Form::label('description', __('Description'), ['class' => 'form-label'])); ?>

            <?php echo Form::textarea('description', null, ['class' => 'form-control', 'rows' => '2']); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn  btn-primary">
</div>
<?php echo e(Form::close()); ?>

<?php /**PATH /Applications/MAMP/htdocs/erp-sakka/resources/views/material_used/create.blade.php ENDPATH**/ ?>