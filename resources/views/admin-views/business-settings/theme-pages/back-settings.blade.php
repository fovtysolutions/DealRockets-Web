@extends('layouts.back-end.app')

@section('title', translate('Website Setting'))

@section('content')
    @php
        // Ensure $bgimages is an array with 8 slots (fill with null if fewer images exist)
        $bgimages = $bgimages ?? [];
        $bgimages = array_pad($bgimages, 8, null); // Ensure exactly 8 slots, filling with null if necessary
    @endphp

    <div class="content container-fluid">
        <div class="mb-4 pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/system-setting.png') }}" alt="">
                {{ translate('web_background_Setting') }}
            </h2>
        </div>
        @include('admin-views.business-settings.theme-pages.theme-pages-selector')
        <div class="d-flex card">
            <div class="card-title">
                <h3 class="m-3">Background Images</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.webtheme.backgroundimages') }}" enctype="multipart/form-data">
                    @csrf
                    @foreach ($bgimages as $key => $bgimage)
                        <div class="col-md-6 form-group">
                            <label for="image">Image {{ $key + 1 }} <span
                                    class="badge badge-soft-info">(1602x640px)</span></label>
                            <input type="file" name="image{{ $key + 1 }}" id="image{{ $key + 1 }}"
                                class="form-control">
                            @if (isset($bgimage['img_path']))
                                <img style="width: 200px;" src="/storage/{{ $bgimage['img_path'] }}" alt="Banner Image">
                                <div class="form-check mt-2">
                                    <input type="checkbox" name="delete_image{{ $key + 1 }}"
                                        id="delete_image{{ $key + 1 }}" class="form-check-input" value="1">
                                    <label class="form-check-label" for="delete_image{{ $key + 1 }}">Delete this
                                        image</label>
                                </div>
                            @endif
                        </div>
                    @endforeach
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
