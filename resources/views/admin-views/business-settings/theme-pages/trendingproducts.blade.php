@extends('layouts.back-end.app-partial')

@section('title', translate('Trending Products Setting'))

@section('content')
    <div class="content container-fluid">
        <div class="mb-4 pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/system-setting.png') }}" alt="">
                {{ translate('Trending Products Setting') }}
            </h2>
        </div>
        @include('admin-views.business-settings.theme-pages.theme-pages-selector')
        <div class="d-flex card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.webtheme.trendingproductsform') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="limit">Number of Products to Show</label>
                            <input type="number" name="limit" id="limit" class="form-control"
                                placeholder="Enter the number of trending products to display"
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

        <!-- Register Banner Form -->
        <div class="d-flex card mt-4">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.webtheme.registerforfree') }}" enctype="multipart/form-data">
                    @csrf
                    <h4>Register Banner</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="register_banner">Banner</label>
                            <input type="file" name="banner" id="register_banner" class="form-control"
                                onchange="previewImage(event, 'register_preview')">
                        </div>
                        <div class="col-md-6 text-center">
                            <img id="register_preview"
                                src="{{ $registerbanner ? asset('storage/' . $registerbanner['banner'] ?? 'public/assets/default-banner.jpg') : asset('public/assets/default-banner.jpg') }}"
                                alt="Register Banner" class="img-fluid mt-3" style="max-width: 200px;">
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

        <!-- Quotation Banner Form -->
        <div class="d-flex card mt-4">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.webtheme.quotationbanner') }}" enctype="multipart/form-data">
                    @csrf
                    <h4>Quotation</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="quotation_heading">Heading</label>
                            <input type="text" name="quotation_header" placeholder="Enter Heading" class="form-control" 
                                value="{{ old('quotation_header', $quotation['header'] ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="header_color">Heading Color</label>
                            <input type="color" name="header_color" class="form-control form-control-color" 
                                value="{{ old('header_color', $quotation['header_color'] ?? '#000000') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="quotation_sub_text">Sub Text</label>
                            <textarea name="quotation_Subtext" placeholder="Enter Sub Text" class="form-control">
                                {{ old('quotation_subtext', $quotation['subtext'] ?? '') }}
                            </textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="subtext_color">Sub Text Color</label>
                            <input type="color" name="subtext_color" class="form-control form-control-color" 
                                value="{{ old('subtext_color', $quotation['subtext_color'] ?? '#000000') }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="quotation_banner">Banner</label>
                            <input type="file" name="banner" id="quotation_banner" class="form-control"
                                onchange="previewImage(event, 'quotation_preview')">
                        </div>
                        <div class="col-md-6 text-center">
                            <img id="quotation_preview"
                                src="{{ $quotation ? asset('storage/' . $quotation['banner'] ?? 'public/assets/default-banner.jpg') : asset('public/assets/default-banner.jpg') }}"
                                alt="Quotation Banner" class="img-fluid mt-3" style="max-width: 200px;">
                            <input type="hidden" name="banner_prev" value="{{ $quotation['banner'] ?? '' }}">
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

        <!-- Marketplace Background and Text Form -->
        {{-- <div class="d-flex card mt-4">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.webtheme.marketplacebanner') }}" enctype="multipart/form-data">
                    @csrf
                    <h4>Marketplace</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="background_image">Background Image</label>
                            <input type="file" name="background_image" id="background_image" class="form-control"
                                onchange="previewImage(event, 'marketplace_preview')">
                        </div>
                        <div class="col-md-6 text-center">
                            <img id="marketplace_preview"
                                src="{{ $marketplace ? asset('storage/'. $marketplace['background_image'] ?? 'public/assets/default-background.jpg') : asset('public/assets/default-background.jpg') }}"
                                alt="Marketplace Background" class="img-fluid mt-3" style="max-width: 200px;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="header_text">Header Text</label>
                            <input type="text" name="header_text" id="header_text" class="form-control"
                                placeholder="Enter header text" value="{{ $marketplace['header_text'] ?? '' }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="text_field_1">Text Field 1</label>
                            <input type="text" name="text_field_1" id="text_field_1" class="form-control"
                                placeholder="Enter text field 1" value="{{ $marketplace['text_field_1'] ?? '' }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="text_field_2">Text Field 2</label>
                            <input type="text" name="text_field_2" id="text_field_2" class="form-control"
                                placeholder="Enter text field 2" value="{{ $marketplace['text_field_2'] ?? '' }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="text_field_3">Text Field 3</label>
                            <input type="text" name="text_field_3" id="text_field_3" class="form-control"
                                placeholder="Enter text field 3" value="{{ $marketplace['text_field_3'] ?? '' }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary mt-3">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div> --}}
    </div><!-- JavaScript for Image Preview -->
    <script>
        function previewImage(event, previewId) {
            let reader = new FileReader();
            reader.onload = function() {
                let output = document.getElementById(previewId);
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
