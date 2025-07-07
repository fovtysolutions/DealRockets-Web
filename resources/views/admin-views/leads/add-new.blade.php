@extends('layouts.back-end.app-partial')

@section('title', translate('Leads_Add'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
    
        <form class="product-form text-start" 
            action="{{ route('admin.store.leads') }}" 
            method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="card" style="width: 100%;margin: 0 auto;max-width: 1128px;">
                <div class="card-body">
                    @include('admin-views.leads.partials._leads_fields')
                </div>
            </div>
        </form>
    </div>
@endsection

@push('script')

@endpush
