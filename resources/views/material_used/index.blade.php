@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Material Used') }}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">{{ __('Project') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('projects.show', $project->id) }}">{{ ucwords($project->project_name) }}</a>
    </li>
    <li class="breadcrumb-item">{{ __('Material Used') }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="#" data-size="lg" data-url="{{ route('task.material_used.create', $project->id) }}"
            data-ajax-popup="true" data-bs-toggle="tooltip" title="{{ __('Create New Material') }}"
            class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th> {{ __('Number') }}</th>
                                    <th> {{ __('Product') }}</th>
                                    <th> {{ __('Quantity') }}</th>
                                    <th> {{ __('Date') }}</th>
                                    <th> {{ __('Description') }}</th>
                                    <th> {{ __('Created By') }}</th>
                                    <th width="10%"> {{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materials as $key => $material)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $material->product->name }}</td>
                                        <td>{{ $material->quantity }}</td>
                                        <td>{{ Auth::user()->dateFormat($material->date) }}</td>
                                        <td>{{ $material->description }}</td>
                                        <td>{{ $material->createdBy->name }}</td>
                                        <td class="Action" width="10%">

                                            <div class="action-btn bg-danger ms-2">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['task.material_used.destroy', $project->id, $material->id]]) !!}
                                                <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                    data-bs-toggle="tooltip" title="{{ __('Delete') }}"><i
                                                        class="ti ti-trash text-white"></i></a>
                                                {!! Form::close() !!}
                                            </div>
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
