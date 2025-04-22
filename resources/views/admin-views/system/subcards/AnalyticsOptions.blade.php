@php use App\Utils\Helpers; @endphp
@extends('layouts.back-end.app')
@section('title', translate('dashboard - Analytics'))
@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="content container-fluid">
    <div class="page-header pb-0 mb-0 border-0">
        <div class="flex-between align-items-center">
            <div>
                <h1 class="page-header-title">{{translate('welcome').' '.auth('admin')->user()->name}}</h1>
                <p>{{ translate('Welcome to Analytics Options').'.'}}</p>
            </div>
        </div>
    </div>
    <div class="mb-4 border-0" style="background: unset; box-shadow: unset;">
        <div class="row">
            <div class="col-sm-6 col-lg-3 mb-3">
                <a class="business-analytics card p-4 text-center" href="#">
                    <h1>{{translate('Overall Analytics')}}</h1>
                    {{-- <h2 class="business-analytics__title">{{ $data['order'] }}</h2> --}}
                </a>
            </div>
            <div class="col-sm-6 col-lg-3 mb-3">
                <a class="business-analytics card p-4 text-center" href="#">
                    <h1>{{translate('Sales & Transactions Reports')}}</h1>
                    {{-- <h2 class="business-analytics__title">{{ $data['order'] }}</h2> --}}
                </a>
            </div>
            <div class="col-sm-6 col-lg-3 mb-3">
                <a class="business-analytics card p-4 text-center" href="#">
                    <h1>{{translate('Product Reports')}}</h1>
                    {{-- <h2 class="business-analytics__title">{{ $data['order'] }}</h2> --}}
                </a>
            </div>
            <div class="col-sm-6 col-lg-3 mb-3">
                <a class="business-analytics card p-4 text-center" href="#">
                    <h1>{{translate('Order Reports')}}</h1>
                    {{-- <h2 class="business-analytics__title">{{ $data['order'] }}</h2> --}}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection