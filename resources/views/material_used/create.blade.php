{{ Form::open(['route' => ['task.material_used.store', $project_id]]) }}
<div class="modal-body">
    {{-- start for ai module --}}
    @php
        $user = \App\Models\User::find(\Auth::user()->creatorId());
        $plan = \App\Models\Plan::getPlan($user->plan);
    @endphp
    {{-- end for ai module --}}
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('product_id', __('Material'), ['class' => 'form-label']) }}
            {!! Form::select('product_id', $products, null, ['class' => 'form-control select', 'required' => 'required']) !!}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('date', __('Date'), ['class' => 'form-label']) }}
            {{ Form::date('date', '', ['class' => 'form-control', 'required' => 'required']) }}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('quantity', __('Quantity'), ['class' => 'form-label']) }}
            {{ Form::number('quantity', '', ['class' => 'form-control', 'required' => 'required', 'step' => 'any']) }}
        </div>
    </div>
    <div class="row">
        <div class="form-group  col-md-12">
            {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
            {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '2']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
</div>
{{ Form::close() }}
