@extends('layouts.back-end.app')

@section('title', translate('Stock Sale Setting'))

@section('content')
<div class="content container-fluid">
    <div class="mb-4 pb-2">
        <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
            <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/system-setting.png') }}" alt="">
            {{ translate('StockSale Setting') }}
        </h2>
    </div>
    @include('admin-views.business-settings.theme-pages.theme-pages-selector')
    <div class="d-flex card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.webtheme.stocksaleform') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="color">Stocksale Theme Color</label>
                        <input type="color" name="color" id="color" class="form-control"
                            value="{{ $data['color'] ?? '#000000' }}" required>
                    </div>
                </div>
                <hr>
                <h4>Ad Banner 1</h4>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="ad1_image">Banner Image <span class="badge badge-soft-info">(300x300px) up to (1200x1200px)</span></label>
                        <input type="file" name="ad1_image" id="ad1_image" class="form-control">
                        @if (!empty($data['ad1_image']))
                            <img style="width: 200px;" src="/storage/{{ $data['ad1_image'] }}">
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="ad1_title">Banner Title</label>
                        <input type="text" name="ad1_title" id="ad1_title" class="form-control"
                            placeholder="Enter Banner Title" value="{{ $data['ad1_title'] ?? '' }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="ad1_url">Banner URL</label>
                        <input type="url" name="ad1_url" id="ad1_url" class="form-control"
                            placeholder="Enter Banner URL" value="{{ $data['ad1_url'] ?? '' }}">
                    </div>
                </div>
                <hr>
                <h4>Ad Banner 2</h4>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="ad2_image">Banner Image <span class="badge badge-soft-info">(300x300px) up to (1200x1200px)</span></label>
                        <input type="file" name="ad2_image" id="ad2_image" class="form-control">
                        @if (!empty($data['ad2_image']))
                            <img style="width: 200px;" src="/storage/{{ $data['ad2_image'] }}">
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="ad2_title">Banner Title</label>
                        <input type="text" name="ad2_title" id="ad2_title" class="form-control"
                            placeholder="Enter Banner Title" value="{{ $data['ad2_title'] ?? '' }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="ad2_url">Banner URL</label>
                        <input type="url" name="ad2_url" id="ad2_url" class="form-control"
                            placeholder="Enter Banner URL" value="{{ $data['ad2_url'] ?? '' }}">
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
    <div class="d-flex card mt-3">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.webtheme.stocksalebanner') }}" enctype="multipart/form-data">
                @csrf
                <hr>
                    <h4>Stock Sale Banner</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="banner_image1">Banner Image <span class="badge badge-soft-info">(1440x300px)</span></label>
                            <input type="file" name="banner_image1" id="banner_image1" class="form-control">
                            @if (!empty($bannerimage['banner_image1']))
                                <img style="width: 200px;" src="/storage/{{ $bannerimage['banner_image1'] }}">
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="banner_image2">Banner Image <span class="badge badge-soft-info">(1440x300px)</span></label>
                            <input type="file" name="banner_image2" id="banner_image2" class="form-control">
                            @if (!empty($bannerimage['banner_image2']))
                                <img style="width: 200px;" src="/storage/{{ $bannerimage['banner_image2'] }}">
                            @endif
                        </div>
                    </div>
                <hr>
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
