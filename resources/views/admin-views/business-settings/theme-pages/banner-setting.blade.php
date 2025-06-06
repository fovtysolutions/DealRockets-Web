@extends('layouts.back-end.app-partial')

@section('title', translate('Website Setting'))

@section('content')
<div class="content container-fluid">
    <div class="mb-4 pb-2">
        <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
            <img src="{{dynamicAsset(path: 'public/assets/back-end/img/system-setting.png')}}" alt="">
            {{translate('web_banner_Setting')}}
        </h2>
    </div>
    @include('admin-views.business-settings.theme-pages.theme-pages-selector')
    <div class="d-flex card">
        @php
            // Decode stored banner data
            $banners = json_decode(optional(App\Models\BusinessSetting::where('type', 'bannersetting')->first())->value, true) ?? [];
            $tradeBanners = json_decode(optional(App\Models\BusinessSetting::where('type', 'bannertradesetting')->first())->value, true) ?? [];
        @endphp
        <div class="card-title">
            <h3 class="m-3">Banner Settings</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.webtheme.bannersettingform') }}" enctype="multipart/form-data">
                @csrf
                @for ($i = 1; $i <= 3; $i++)
                    @php
                        $banner = $banners[$i - 1] ?? ['image' => null, 'title' => null, 'content' => null, 'url' => null, 'color' => '#000000'];
                    @endphp
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Banner {{ $i }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="image_{{ $i }}">Image <span class="badge badge-soft-info">(333x200px)</span></label>
                                    <input type="file" name="image_{{ $i }}" id="image_{{ $i }}" class="form-control">
                                    @if($banner['image'])
                                        <img style="width: 200px; margin-top: 10px;" src="{{ asset('storage/' . $banner['image']) }}" alt="Banner Image">
                                    @endif
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="title_{{ $i }}">Title</label>
                                    <input type="text" name="title_{{ $i }}" id="title_{{ $i }}" class="form-control"
                                        placeholder="Enter Featured Title" value="{{ $banner['title'] ?? '' }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="content_{{ $i }}">Content</label>
                                    <textarea name="content_{{ $i }}" id="content_{{ $i }}" class="form-control"
                                        placeholder="Enter Description">{{ $banner['content'] ?? '' }}</textarea>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="url_{{ $i }}">Feature URL</label>
                                    <input type="text" name="url_{{ $i }}" id="url_{{ $i }}" class="form-control"
                                        placeholder="Enter a URL for feature" value="{{ $banner['url'] ?? '' }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="color_{{ $i }}">Font Color</label>
                                    <input type="color" name="color_{{ $i }}" id="color_{{ $i }}" class="form-control"
                                        value="{{ $banner['color'] ?? '#000000' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
                <div class="row">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="card-title">
            <h3 class="m-3">Trade Banner Settings</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.webtheme.bannertradeform') }}" enctype="multipart/form-data">
                @csrf
                @for ($i = 1; $i <= 3; $i++) 
                    @php
                        $tradeBanner = $tradeBanners[$i - 1] ?? ['image' => null, 'title' => null, 'content' => null, 'url' => null, 'color' => '#000000'];
                    @endphp
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Trade Banner {{ $i }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="mage_{{ $i }}">Image <span class="badge badge-soft-info">(333x200px)</span></label>
                                    <input type="file" name="image_{{ $i }}" id="image_{{ $i }}" class="form-control">
                                    @if($tradeBanner['image'])
                                        <img style="width: 200px; margin-top: 10px;" src="{{ asset('storage/' . $tradeBanner['image']) }}" alt="Trade Banner Image">
                                    @endif
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="trade_title_{{ $i }}">Title</label>
                                    <input type="text" name="title_{{ $i }}" id="title_{{ $i }}" class="form-control"
                                        placeholder="Enter Trade Featured Title" value="{{ $tradeBanner['title'] ?? '' }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="trade_content_{{ $i }}">Content</label>
                                    <textarea name="content_{{ $i }}" id="content_{{ $i }}" class="form-control"
                                        placeholder="Enter Trade Description">{{ $tradeBanner['content'] ?? '' }}</textarea>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="trade_url_{{ $i }}">Feature URL</label>
                                    <input type="text" name="url_{{ $i }}" id="url_{{ $i }}" class="form-control"
                                        placeholder="Enter a URL for Trade feature" value="{{ $tradeBanner['url'] ?? '' }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="trade_color_{{ $i }}">Font Color</label>
                                    <input type="color" name="color_{{ $i }}" id="color_{{ $i }}" class="form-control"
                                        value="{{ $tradeBanner['color'] ?? '#000000' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
                <div class="row">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </div>
                </div>
            </form>
        </div>        
        <div class="card-title">
            <h3 class="m-3">First Box</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.webtheme.firstbox') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="image">Image <span class="badge badge-soft-info">(85x70px)</span></label>
                        <input type="file" name="image" id="image" class="form-control">
                        @if(isset($data['image']))
                            <img style="width: 200px;" src="/storage/{{ $firstbox['image'] ?? ''}}">
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="title">Title</label>
                        @if(isset($data['title']))
                            <input type="text" name="title" id="title" class="form-control"
                                placeholder="Enter Featured Title" value="{{ $firstbox['title'] ?? '' }}">
                        @else
                            <input type="text" name="title" id="title" class="form-control"
                                placeholder="Enter Featured Title">
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="content">Inner Text</label>
                        @if(isset($data['content']))
                            <textarea name="content" id="content" class="form-control"
                                placeholder="Enter Description">{{ $firstbox['content']  ?? ''}}</textarea>
                        @else
                            <textarea name="content" id="content" class="form-control"
                                placeholder="Enter Description"></textarea>
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="url">Feature URL</label>
                        @if(isset($data['url']))
                            <input type="text" name="url" id="url" class="form-control"
                                placeholder="Enter a URL for feature" value="{{ $firstbox['url'] ?? '' }}">
                        @else
                            <input type="text" name="url" id="url" class="form-control"
                                placeholder="Enter a URL for feature">
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
        <div class="card-title">
            <h3 class="m-3">Second Box</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.webtheme.secondbox') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="image">Image <span class="badge badge-soft-info">(85x70px)</span></label>
                        <input type="file" name="image" id="image" class="form-control">
                        @if(isset($data['image']))
                            <img style="width: 200px;" src="/storage/{{ $secondbox['image'] ?? ''}}">
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="title">Title</label>
                        @if(isset($data['title']))
                            <input type="text" name="title" id="title" class="form-control"
                                placeholder="Enter Featured Title" value="{{ $secondbox['title'] ?? '' }}">
                        @else
                            <input type="text" name="title" id="title" class="form-control"
                                placeholder="Enter Featured Title">
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="content">Inner Text</label>
                        @if(isset($data['content']))
                            <textarea name="content" id="content" class="form-control"
                                placeholder="Enter Description">{{ $secondbox['content']  ?? ''}}</textarea>
                        @else
                            <textarea name="content" id="content" class="form-control"
                                placeholder="Enter Description"></textarea>
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="url">Feature URL</label>
                        @if(isset($data['url']))
                            <input type="text" name="url" id="url" class="form-control"
                                placeholder="Enter a URL for feature" value="{{ $secondbox['url'] ?? '' }}">
                        @else
                            <input type="text" name="url" id="url" class="form-control"
                                placeholder="Enter a URL for feature">
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
        <div class="card-title">
            <h3 class="m-3">Third Box</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.webtheme.thirdbox') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="image">Image <span class="badge badge-soft-info">(85x70px)</span></label>
                        <input type="file" name="image" id="image" class="form-control">
                        @if(isset($data['image']))
                            <img style="width: 200px;" src="/storage/{{ $thirdbox['image'] ?? ''}}">
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="title">Title</label>
                        @if(isset($data['title']))
                            <input type="text" name="title" id="title" class="form-control"
                                placeholder="Enter Featured Title" value="{{ $thirdbox['title'] ?? '' }}">
                        @else
                            <input type="text" name="title" id="title" class="form-control"
                                placeholder="Enter Featured Title">
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="content">Inner Text</label>
                        @if(isset($data['content']))
                            <textarea name="content" id="content" class="form-control"
                                placeholder="Enter Description">{{ $thirdbox['content']  ?? ''}}</textarea>
                        @else
                            <textarea name="content" id="content" class="form-control"
                                placeholder="Enter Description"></textarea>
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="url">Feature URL</label>
                        @if(isset($data['url']))
                            <input type="text" name="url" id="url" class="form-control"
                                placeholder="Enter a URL for feature" value="{{ $thirdbox['url'] ?? '' }}">
                        @else
                            <input type="text" name="url" id="url" class="form-control"
                                placeholder="Enter a URL for feature">
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
        <div class="card-title">
            <h3 class="m-3">Fourth Box</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.webtheme.fourthbox') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="image">Image <span class="badge badge-soft-info">(85x70px)</span></label>
                        <input type="file" name="image" id="image" class="form-control">
                        @if(isset($data['image']))
                            <img style="width: 200px;" src="/storage/{{ $fourthbox['image'] ?? ''}}">
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="title">Title</label>
                        @if(isset($data['title']))
                            <input type="text" name="title" id="title" class="form-control"
                                placeholder="Enter Featured Title" value="{{ $fourthbox['title'] ?? '' }}">
                        @else
                            <input type="text" name="title" id="title" class="form-control"
                                placeholder="Enter Featured Title">
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="content">Inner Text</label>
                        @if(isset($data['content']))
                            <textarea name="content" id="content" class="form-control"
                                placeholder="Enter Description">{{ $fourthbox['content']  ?? ''}}</textarea>
                        @else
                            <textarea name="content" id="content" class="form-control"
                                placeholder="Enter Description"></textarea>
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="url">Feature URL</label>
                        @if(isset($data['url']))
                            <input type="text" name="url" id="url" class="form-control"
                                placeholder="Enter a URL for feature" value="{{ $fourthbox['url'] ?? '' }}">
                        @else
                            <input type="text" name="url" id="url" class="form-control"
                                placeholder="Enter a URL for feature">
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
        <div class="card-title">
            <h3 class="m-3">Fifth Box</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.webtheme.fifthbox') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="image">Image <span class="badge badge-soft-info">(85x70px)</span></label>
                        <input type="file" name="image" id="image" class="form-control">
                        @if(isset($data['image']))
                            <img style="width: 200px;" src="/storage/{{ $fifthbox['image'] ?? ''}}">
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="title">Title</label>
                        @if(isset($data['title']))
                            <input type="text" name="title" id="title" class="form-control"
                                placeholder="Enter Featured Title" value="{{ $fifthbox['title'] ?? '' }}">
                        @else
                            <input type="text" name="title" id="title" class="form-control"
                                placeholder="Enter Featured Title">
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="content">Inner Text</label>
                        @if(isset($data['content']))
                            <textarea name="content" id="content" class="form-control"
                                placeholder="Enter Description">{{ $fifthbox['content']  ?? ''}}</textarea>
                        @else
                            <textarea name="content" id="content" class="form-control"
                                placeholder="Enter Description"></textarea>
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="url">Feature URL</label>
                        @if(isset($data['url']))
                            <input type="text" name="url" id="url" class="form-control"
                                placeholder="Enter a URL for feature" value="{{ $fifthbox['url'] ?? '' }}">
                        @else
                            <input type="text" name="url" id="url" class="form-control"
                                placeholder="Enter a URL for feature">
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