@extends('layouts.back-end.app')

@section('title', translate('Vendor Setting'))

@section('content')
<div class="content container-fluid">
    <div class="mb-4 pb-2">
        <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
            <img src="{{dynamicAsset(path: 'public/assets/back-end/img/system-setting.png')}}" alt="">
            {{translate('Vendor Setting')}}
        </h2>
    </div>
    @include('admin-views.business-settings.theme-pages.theme-pages-selector')
    <div class="d-flex card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.webtheme.vendorsettingform') }}" enctype="multipart/form-data">
                @csrf                
                <h4>Buyer Banner</h4>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="ad1_image">Buyer Banner <span class="badge badge-soft-info">(800px x 500px)</span></label>
                        <input type="file" name="ad1_image" id="ad1_image" class="form-control">
                        @if(!empty($vendorsetting['ad1_image']))
                            <img style="width: 200px;" src="/storage/{{ $vendorsetting['ad1_image'] }}">
                        @endif
                    </div>
                </div>           

                <h4>Supplier Banner</h4>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="ad2_image">Supplier Banner <span class="badge badge-soft-info">(800px x 500px)</span></label>
                        <input type="file" name="ad2_image" id="ad2_image" class="form-control">
                        @if(!empty($vendorsetting['ad2_image']))
                            <img style="width: 200px;" src="/storage/{{ $vendorsetting['ad2_image'] }}">
                        @endif
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
