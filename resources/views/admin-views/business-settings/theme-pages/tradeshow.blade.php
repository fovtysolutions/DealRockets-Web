@extends('layouts.back-end.app')

@section('title', translate('Trade Show Setting'))

@section('content')
<div class="content container-fluid">
    <div class="mb-4 pb-2">
        <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
            <img src="{{dynamicAsset(path: 'public/assets/back-end/img/system-setting.png')}}" alt="">
            {{translate('Trade Show Setting')}}
        </h2>
    </div>
    @include('admin-views.business-settings.theme-pages.theme-pages-selector')
    <div class="d-flex card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.webtheme.tradeshowbannerrotatingbox') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="banner1">Rotating Box First Slide</label>
                        <input type="file" name="banner1" id="banner1" class="form-control"
                            placeholder="Enter the image to display">
                        @if($bannerarray && isset($bannerarray['tradeshowbannerrotatingbox']['banner1']))
                            <img src="/storage/{{ $bannerarray['tradeshowbannerrotatingbox']['banner1'] }}" alt="No Image"
                                class="mt-2" width="150">
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="banner2">Rotating Box Second Slide</label>
                        <input type="file" name="banner2" id="banner2" class="form-control"
                            placeholder="Enter the image to display">
                        @if($bannerarray && isset($bannerarray['tradeshowbannerrotatingbox']['banner2']))
                            <img src="/storage/{{ $bannerarray['tradeshowbannerrotatingbox']['banner2'] }}" alt="No Image"
                                class="mt-2" width="150">
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="banner3">Rotating Box Third Slide</label>
                        <input type="file" name="banner3" id="banner3" class="form-control"
                            placeholder="Enter the image to display">
                        @if($bannerarray && isset($bannerarray['tradeshowbannerrotatingbox']['banner3']))
                            <img src="/storage/{{ $bannerarray['tradeshowbannerrotatingbox']['banner3'] }}" alt="No Image"
                                class="mt-2" width="150">
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="banner4">Rotating Box Fourth Slide</label>
                        <input type="file" name="banner4" id="banner4" class="form-control"
                            placeholder="Enter the image to display">
                        @if($bannerarray && isset($bannerarray['tradeshowbannerrotatingbox']['banner4']))
                            <img src="/storage/{{ $bannerarray['tradeshowbannerrotatingbox']['banner4'] }}" alt="No Image"
                                class="mt-2" width="150">
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
    <div class="d-flex card mt-4">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.webtheme.tradeshowform') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="limit">Number of Trade Shows to Show</label>
                        <input type="number" name="limit" id="limit" class="form-control"
                            placeholder="Enter the number of trade shows to display"
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
    <div class="d-flex card mt-4">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.webtheme.tradeshowlimit') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="bannerlimit">Banners To Show in Tradeshow</label>
                        <input type="number" name="bannerlimit" id="bannerlimit" class="form-control"
                            placeholder="Enter the number of trade shows to display"
                            value="{{ $tradeshowlimit ? json_decode($tradeshowlimit->value)->tradeshowbannerlimit : '' }}"
                            required>
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
    <div class="d-flex card mt-4">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.webtheme.tradeshowrotatingbox') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="carousel1">Rotating Banner First Slide</label>
                        <input type="file" name="carousel1" id="carousel1" class="form-control"
                            placeholder="Enter the image to display">
                        @if($carouselarray && isset($carouselarray['tradeshowrotatingbox']['carousel1']))
                            <img src="/storage/{{ $carouselarray['tradeshowrotatingbox']['carousel1'] }}" alt="No Image"
                                class="mt-2" width="150">
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="carousel2">Rotating Banner Second Slide</label>
                        <input type="file" name="carousel2" id="carousel2" class="form-control"
                            placeholder="Enter the image to display">
                        @if($carouselarray && isset($carouselarray['tradeshowrotatingbox']['carousel2']))
                            <img src="/storage/{{ $carouselarray['tradeshowrotatingbox']['carousel2'] }}" alt="No Image"
                                class="mt-2" width="150">
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="carousel3">Rotating Banner Third Slide</label>
                        <input type="file" name="carousel3" id="carousel3" class="form-control"
                            placeholder="Enter the image to display">
                        @if($carouselarray && isset($carouselarray['tradeshowrotatingbox']['carousel3']))
                            <img src="/storage/{{ $carouselarray['tradeshowrotatingbox']['carousel3'] }}" alt="No Image"
                                class="mt-2" width="150">
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="carousel4">Rotating Banner Fourth Slide</label>
                        <input type="file" name="carousel4" id="carousel4" class="form-control"
                            placeholder="Enter the image to display">
                        @if($carouselarray && isset($carouselarray['tradeshowrotatingbox']['carousel4']))
                            <img src="/storage/{{ $carouselarray['tradeshowrotatingbox']['carousel4'] }}" alt="No Image"
                                class="mt-2" width="150">
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
    <div class="d-flex card mt-4">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.webtheme.tradeshowhomepage') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="title1">Homepage First Title</label>
                        <input type="text" name="title1" id="title1" class="form-control"
                            placeholder="Enter the Title to display" value="{{ old('title1',$imagesArray['tradeshowhomepage']['title1'] ?? '')}}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="carousel1">Homepage First Image</label>
                        <input type="file" name="carousel1" id="carousel1" class="form-control"
                            placeholder="Enter the image to display">
                        @if($imagesArray && isset($imagesArray['tradeshowhomepage']['carousel1']))
                            <img src="/storage/{{ $imagesArray['tradeshowhomepage']['carousel1'] }}" alt="No Image"
                                class="mt-2" width="150">
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="textcolor1">Homepage First Title Color</label>
                        <input type="color" name="textcolor1" id="textcolor1" class="form-control"
                            value="{{ old('textcolor1', $imagesArray['tradeshowhomepage']['textcolor1'] ?? '#000000') }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="title2">Homepage Second Title</label>
                        <input type="text" name="title2" id="title2" class="form-control"
                            placeholder="Enter the Title to display" value="{{ old('title2',$imagesArray['tradeshowhomepage']['title2'] ?? '')}}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="carousel2">Homepage Second Image</label>
                        <input type="file" name="carousel2" id="carousel2" class="form-control"
                            placeholder="Enter the image to display">
                        @if($imagesArray && isset($imagesArray['tradeshowhomepage']['carousel2']))
                            <img src="/storage/{{ $imagesArray['tradeshowhomepage']['carousel2'] }}" alt="No Image"
                                class="mt-2" width="150">
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="textcolor2">Homepage Second Title Color</label>
                        <input type="color" name="textcolor2" id="textcolor2" class="form-control"
                            value="{{ old('textcolor2', $imagesArray['tradeshowhomepage']['textcolor2'] ?? '#000000') }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="title3">Homepage Third Title</label>
                        <input type="text" name="title3" id="title3" class="form-control"
                            placeholder="Enter the Title to display" value="{{ old('title3',$imagesArray['tradeshowhomepage']['title3'] ?? '')}}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="carousel3">Homepage Third Image</label>
                        <input type="file" name="carousel3" id="carousel3" class="form-control"
                            placeholder="Enter the image to display">
                        @if($imagesArray && isset($imagesArray['tradeshowhomepage']['carousel3']))
                            <img src="/storage/{{ $imagesArray['tradeshowhomepage']['carousel3'] }}" alt="No Image"
                                class="mt-2" width="150">
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="textcolor3">Homepage Third Title Color</label>
                        <input type="color" name="textcolor3" id="textcolor3" class="form-control"
                            value="{{ old('textcolor3', $imagesArray['tradeshowhomepage']['textcolor3'] ?? '#000000') }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="title4">Homepage Fourth Title</label>
                        <input type="text" name="title4" id="title4" class="form-control"
                            placeholder="Enter the Title to display" value="{{ old('title4',$imagesArray['tradeshowhomepage']['title4'] ?? '')}}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="newimage4">Homepage Fourth Image Overlay</label>
                        <input type="file" name="newimage4" id="newimage4" class="form-control"
                            placeholder="Enter the image to display">
                        @if($imagesArray && isset($imagesArray['tradeshowhomepage']['newimage4']))
                            <img src="/storage/{{ $imagesArray['tradeshowhomepage']['newimage4'] }}" alt="No Image"
                                class="mt-2" width="150">
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="carousel4">Homepage Fourth Image</label>
                        <input type="file" name="carousel4" id="carousel4" class="form-control"
                            placeholder="Enter the image to display">
                        @if($imagesArray && isset($imagesArray['tradeshowhomepage']['carousel4']))
                            <img src="/storage/{{ $imagesArray['tradeshowhomepage']['carousel4'] }}" alt="No Image"
                                class="mt-2" width="150">
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="textcolor4">Homepage Fourth Title Color</label>
                        <input type="color" name="textcolor4" id="textcolor4" class="form-control"
                            value="{{ old('textcolor4', $imagesArray['tradeshowhomepage']['textcolor4'] ?? '#000000') }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="title5">Homepage Fifth Title</label>
                        <input type="text" name="title5" id="title5" class="form-control"
                            placeholder="Enter the Title to display" value="{{ old('title5',$imagesArray['tradeshowhomepage']['title5'] ?? '')}}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="carousel5">Homepage Fifth Image</label>
                        <input type="file" name="carousel5" id="carousel5" class="form-control"
                            placeholder="Enter the image to display">
                        @if($imagesArray && isset($imagesArray['tradeshowhomepage']['carousel5']))
                            <img src="/storage/{{ $imagesArray['tradeshowhomepage']['carousel5'] }}" alt="No Image"
                                class="mt-2" width="150">
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="newimage5">Homepage Fifth Image Overlay</label>
                        <input type="file" name="newimage5" id="newimage5" class="form-control"
                            placeholder="Enter the image to display">
                        @if($imagesArray && isset($imagesArray['tradeshowhomepage']['newimage5']))
                            <img src="/storage/{{ $imagesArray['tradeshowhomepage']['newimage5'] }}" alt="No Image"
                                class="mt-2" width="150">
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="textcolor5">Homepage Fifth Title Color</label>
                        <input type="color" name="textcolor5" id="textcolor5" class="form-control"
                            value="{{ old('textcolor5', $imagesArray['tradeshowhomepage']['textcolor5'] ?? '#000000') }}">
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