@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{ __('Activity Daily') }}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 ">{{ __('Activity Daily') }}</h5>
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('daily_activity.index') }}">{{ __('Activity Daily') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Activity Daily') }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="#" data-size="lg" data-url="{{ route('daily_activity.edit', $support->id) }}" data-ajax-popup="true"
            data-bs-toggle="tooltip" title="{{ __('Edit') }}" data-title="{{ __('Edit Activity Daily') }}"
            class="btn btn-sm btn-primary">
            <i class="ti ti-pencil"></i>
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row gy-4">
                <div class="col-lg-6">
                    <div class="row">
                        <h5 class="mb-3">{{ __('Reply Ticket') }} - <span
                                class="text-primary">{{ $support->ticket_code }}</span></h5>
                        <div class="card border">
                            <div class="card-body p-0">
                                <div class="p-4 border-bottom">

                                    <p class="mb-0">
                                        <b> {{ !empty($support->createdBy) ? $support->createdBy->name : '' }}</b>
                                        .
                                        <span> {{ !empty($support->createdBy) ? $support->createdBy->email : '' }}</span>
                                        .
                                        <span
                                            class="text-muted">{{ \Auth::user()->dateFormat($support->created_at) }}</span>
                                    </p>
                                </div>
                                @if (!empty($support->description))
                                    <div class="p-4">
                                        <p class="">{{ $support->description }}</p>
                                        @if (!empty($support->attachment))
                                            <h6>{{ __('Attachments') }} :</h6>
                                            <a href="{{ asset(Storage::url('uploads/supports')) . '/' . $support->attachment }}"
                                                download="" class="bg-secondary d-inline-flex p-2 rounded text-white "
                                                target="_blank">
                                                <i class="ti ti-download text-white me-2 mt-1" data-bs-toggle="tooltip"></i>

                                                {{ $support->attachment }}
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <div class="row ">
                                    <div class="col-6">
                                        <h5 class="mb-3">{{ __('Comments') }}</h5>
                                    </div>
                                    @php
                                        $plan = \App\Models\Utility::getChatGPTSettings();
                                    @endphp

                                </div>
                                {{ Form::open(['route' => ['daily_activity.reply.answer', $support->id]]) }}
                                <textarea class="form-control form-control-light mb-2 grammer_textarea" name="description" placeholder="Your comment"
                                    id="example-textarea" rows="3" required=""></textarea>
                                <div class="text-end">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary w-100"> <i
                                                class="ti ti-circle-plus me-1 mb-0"></i> {{ __('Send') }}</button>
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <h5 class="mb-3">{{ __('Replies') }}</h5>
                    @foreach ($replyes as $reply)
                        <div class="card border">
                            <div class="card-header row d-flex align-items-center justify-content-between">
                                <div class="header-right col d-flex align-items-start">
                                    <a href="#" class="avatar avatar-sm me-3">
                                        <img alt="" class=" "
                                            @if (!empty($reply->users) && !empty($reply->users->avatar)) src="{{ asset(Storage::url('uploads/avatar/')) . '/' . $reply->users->avatar }}" @else  src="{{ asset(Storage::url('uploads/avatar/')) . '/avatar.png' }}" @endif>
                                    </a>
                                    <h6 class="mb-0">{{ !empty($reply->users) ? $reply->users->name : '' }}
                                        <div class="d-block text-muted">
                                            {{ !empty($reply->users) ? $reply->users->email : '' }}
                                        </div>
                                    </h6>
                                </div>
                                <p class="col-auto ms-1 mb-0"> <span
                                        class="text-muted">{{ $reply->created_at->diffForHumans() }}</span></p>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $reply->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection
