@extends('layouts.back-end.app')

@section('title', translate('Top Supplier Setting'))

@section('content')
<div class="content container-fluid">
    <div class="mb-4 pb-2">
        <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
            <img src="{{dynamicAsset(path: 'public/assets/back-end/img/system-setting.png')}}" alt="">
            {{translate('Top Supplier Setting')}}
        </h2>
    </div>
    @include('admin-views.business-settings.theme-pages.theme-pages-selector')
    <div class="d-flex card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.webtheme.topsupplierform') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="limit">Number of Suppliers to Show</label>
                        <input type="number" name="limit" id="limit" class="form-control"
                               placeholder="Enter the number of top suppliers to display"
                               value="{{ $data ? json_decode($data->value)->limit : '' }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
