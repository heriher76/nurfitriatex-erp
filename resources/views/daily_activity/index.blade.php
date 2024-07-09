@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{ __('Daily Activity') }}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 ">{{ __('Daily Activity') }}</h5>
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Daily Activity') }}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        <a href="{{ route('daily_activity.grid') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
            title="{{ __('Grid View') }}">
            <i class="ti ti-layout-grid text-white"></i>
        </a>
        <a href="#" data-size="lg" data-url="{{ route('daily_activity.create') }}" data-ajax-popup="true"
            data-bs-toggle="tooltip" title="{{ __('Create') }}" data-title="{{ __('Create Daily Activity') }}"
            class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    </div>
@endsection

@section('content')
    <div class="row">

    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('Created By') }}</th>
                                    <th scope="col">{{ __('Subject') }}</th>
                                    <th scope="col">{{ __('Attachment') }}</th>
                                    <th scope="col">{{ __('Created At') }}</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @php
                                    $supportpath = \App\Models\Utility::get_file('uploads/supports');
                                @endphp
                                @foreach ($supports as $support)
                                    <tr>
                                        <td scope="row">
                                            <div class="media align-items-center">
                                                <div>
                                                    <div class="avatar-parent-child">
                                                        <img alt="" class="avatar rounded-circle avatar-sm me-1"
                                                            @if (
                                                                !empty($support->createdBy) &&
                                                                    !empty($support->createdBy->avatar) &&
                                                                    file_exists('storage/uploads/avatar/' . $support->createdBy->avatar)) src="{{ asset(Storage::url('uploads/avatar')) . '/' . $support->createdBy->avatar }}" @else  src="{{ asset(Storage::url('uploads/avatar')) . '/avatar.png' }}" @endif>
                                                        @if ($support->replyUnread() > 0)
                                                            <span class="avatar-child avatar-badge bg-success"></span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    {{ !empty($support->createdBy) ? $support->createdBy->name : '' }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $support->subject }}</td>
                                        <td>
                                            @if (!empty($support->attachment))
                                                <a class="action-btn bg-primary ms-2 btn btn-sm align-items-center"
                                                    href="{{ $supportpath . '/' . $support->attachment }}" download=""
                                                    data-bs-toggle="tooltip" title="{{ __('Download') }}" target="_blank">
                                                    <i class="ti ti-download text-white"></i>
                                                </a>
                                                <a href="{{ $supportpath . '/' . $support->attachment }}"
                                                    class="action-btn bg-secondary ms-2 mx-3 btn btn-sm align-items-center">
                                                    <span class="btn-inner--icon"><i
                                                            class="ti ti-crosshair text-white"></i></span>
                                                </a>
                                            @else
                                                -
                                            @endif

                                        </td>
                                        <td>{{ \Auth::user()->dateFormat($support->created_at) }}</td>
                                        <td class="Action">
                                            <span>
                                                <div class="action-btn bg-warning ms-2">
                                                    <a href="{{ route('daily_activity.reply', \Crypt::encrypt($support->id)) }}"
                                                        data-title="{{ __('Support Reply') }}"
                                                        class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip"
                                                        title="{{ __('Reply') }}"
                                                        data-original-title="{{ __('Reply') }}">
                                                        <i class="ti ti-corner-up-left text-white"></i>
                                                    </a>
                                                </div>
                                                @if (\Auth::user()->type == 'company' || \Auth::user()->id == $support->created_by)
                                                    <div class="action-btn bg-primary ms-2">
                                                        <a href="#" data-size="lg"
                                                            data-url="{{ route('daily_activity.edit', $support->id) }}"
                                                            data-ajax-popup="true"
                                                            data-title="{{ __('Edit Daily Activity') }}"
                                                            class="mx-3 btn btn-sm align-items-center"
                                                            data-bs-toggle="tooltip" title="{{ __('Edit') }}"
                                                            data-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'route' => ['daily_activity.destroy', $support->id],
                                                            'id' => 'delete-form-' . $support->id,
                                                        ]) !!}
                                                        <a href="#!"
                                                            class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                            data-bs-toggle="tooltip"
                                                            data-original-title="{{ __('Delete') }}"
                                                            data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?"
                                                            title="{{ __('Delete') }}"
                                                            data-confirm-yes="document.getElementById('delete-form-{{ $support->id }}').submit();">
                                                            <i class="ti ti-trash text-white"></i>
                                                        </a>
                                                        {!! Form::close() !!}
                                                    </div>
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
