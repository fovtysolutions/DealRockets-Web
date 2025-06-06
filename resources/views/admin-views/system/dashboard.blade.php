@php use App\Utils\Helpers; @endphp
@extends('layouts.back-end.app')
@section('title', translate('dashboard'))
@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    @if(auth('admin')->user()->admin_role_id==1 || Helpers::module_permission_check('dashboard_management'))
        <div class="content container-fluid">
            <div class="page-header pb-0 mb-0 border-0">
                <div class="flex-between align-items-center">
                    <div>
                        <h1 class="page-header-title">{{translate('welcome').' '.auth('admin')->user()->name}}</h1>
                        <p>{{ translate('monitor_your_business_analytics_and_statistics').'.'}}</p>
                    </div>
                </div>
            </div>
            <div class="mb-4 border-0" style="background: unset; box-shadow: unset;">
                <div class="row">
                    @include('admin-views.system.partials.dashboard_icons')
                </div>
            </div>
    @else
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-12 mb-2 mb-sm-0">
                        <h3 class="text-center">{{translate('hi')}} {{auth('admin')->user()->name}}
                            {{' , '.translate('welcome_to_dashboard')}}.</h3>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
