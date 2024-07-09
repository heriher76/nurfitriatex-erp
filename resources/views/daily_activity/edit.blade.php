{{ Form::model($daily_activity, ['route' => ['daily_activity.update', $daily_activity->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    {{-- start for ai module --}}
    @php
        $plan = \App\Models\Utility::getChatGPTSettings();
    @endphp
    {{-- end for ai module --}}
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('subject', __('Subject'), ['class' => 'form-label']) }}
            {{ Form::text('subject', null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('end_date', __('Date'), ['class' => 'form-label']) }}
            {{ Form::date('end_date', null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>

    </div>
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
            {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '3']) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('attachment', __('Attachment'), ['class' => 'form-label']) }}
        <label for="document" class="form-label">
            <input type="file" class="form-control" name="attachment" id="attachment"
                data-filename="attachment_create">
        </label>
        @if ($daily_activity->attachment)
            <img id="image" class="mt-2"
                src="{{ asset(Storage::url('uploads/supports')) . '/' . $daily_activity->attachment }}"
                style="width:25%;" />
        @endif

    </div>

</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn  btn-primary">
</div>
{{ Form::close() }}


<script>
    document.getElementById('attachment').onchange = function() {
        var src = URL.createObjectURL(this.files[0])
        document.getElementById('image').src = src
    }
</script>
