@extends('layouts.back-end.app')

@section('title', translate('Homepage Second Settings'))

@section('content')
<div class="content container-fluid">
    <div class="mb-4 pb-2">
        <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
            <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/system-setting.png') }}" alt="">
            {{ translate('Homepage Second Setting') }}
        </h2>
    </div>
    @include('admin-views.business-settings.theme-pages.theme-pages-selector')

    <div class="card mb-4">
        <h3 class="pt-4 pl-4 pb-2">{{ translate('Quotation Settings') }}</h3>
        <div class="card-body">
            <form action="{{ route('admin.webtheme.updatequotation') }}" method="POST">
                @csrf

                <!-- Toggle for Quotation -->
                <div class="mb-2 border p-3 rounded">
                    <div class="form-check form-switch mb-1">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            name="quotation_enabled" 
                            id="quotationToggle" 
                            {{ isset($existingDatae['enabled']) && $existingDatae['enabled'] == 1 ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="quotationToggle">{{ translate('Toggle Quotation Section') }}</label>
                    </div>

                    <!-- Current Status -->
                    <p class="mt-2 text-muted">
                        {{ translate('Current Status:') }}
                        <span class="font-weight-bold">
                            {{ isset($existingDatae['enabled']) && $existingDatae['enabled'] == 1 
                                ? translate('Enabled') 
                                : translate('Disabled') }}
                        </span>
                    </p>

                    <div class="form-check form-switch mb-1">
                        <label class="form-check-label" for="quotationToggle">{{ translate('Pick a Time') }}</label>
                        <input 
                            class="form-control" 
                            type="text" 
                            name="hours_convert" 
                            value = "{{ isset($existingDatae['runtime']) && $existingDatae['runtime'] ? $existingDatae['runtime'] : 24 }}"
                        >
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">{{ translate('Save Settings') }}</button>
            </form>
        </div>
     
    </div>    

    <div class="card">
        <h3 class="pt-4 pl-4 pb-2">{{ translate('Boxes Settings') }}</h3>
        <div class="card-body">
            <form action="{{ route('admin.webtheme.updatehomepagesec') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                @for ($i = 1; $i <= 3; $i++)
                <div class="mb-4 border p-3 rounded">
                    <h5>{{ translate('Section') }} {{ $i }}</h5>
                    
                    <div class="mb-3">
                        <label class="form-label">{{ translate('Image') }}</label>
                        <input type="file" name="image_{{ $i }}" class="form-control">
                        @if(!empty($existingData["image_$i"]))
                            <img src="{{ asset('storage/' . $existingData["image_$i"]) }}" alt="Image {{ $i }}" class="mt-2" width="100">
                        @endif
                    </div>
                    <input type="hidden" name="existing_image_{{ $i }}" value="{{ $existingData["image_$i"] }}">
                    
                    <div class="mb-3">
                        <label class="form-label">{{ translate('Heading') }}</label>
                        <input type="text" name="heading_{{ $i }}" class="form-control" value="{{ $existingData["heading_$i"] ?? '' }}">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">{{ translate('Sub Text') }}</label>
                        <input type="text" name="sub_text_{{ $i }}" class="form-control" value="{{ $existingData["sub_text_$i"] ?? '' }}">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">{{ translate('Link') }}</label>
                        <input type="text" name="link_{{ $i }}" class="form-control" value="{{ $existingData["link_$i"] ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ translate('Sub Text Font Color') }}</label>
                        <input type="color" name="sub_text_color_{{ $i }}" class="form-control form-control-color" value="{{ $existingData["sub_text_color_$i"] ?? '#000000' }}">
                    </div>
                    
                    @for ($j = 1; $j <= 4; $j++)
                    <div class="mb-3">
                        <label class="form-label">{{ translate('Bauble Icon') }} {{ $j }}</label>
                        <input type="file" name="bauble_icon_{{ $i }}_{{ $j }}" class="form-control">
                        @if(!empty($existingData["bauble_icon_{$i}_{$j}"]))
                            <img src="{{ asset('storage/' . $existingData["bauble_icon_{$i}_{$j}"]) }}" alt="Bauble Icon {{ $j }}" class="mt-2" width="50">
                        @endif
                    </div>
                    <input type="hidden" name="existing_bauble_icon_{{$i}}_{{$j}}" value="{{ $existingData["bauble_icon_{$i}_{$j}"] }}">

                    <div class="mb-3">
                        <label class="form-label">{{ translate('Bauble Text') }} {{ $j }}</label>
                        <input type="text" name="bauble_text_{{ $i }}_{{ $j }}" class="form-control" value="{{ $existingData["bauble_text_{$i}_{$j}"] ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ translate('Bauble Link') }} {{ $j }}</label>
                        <input type="text" name="bauble_link_{{ $i }}_{{ $j }}" class="form-control form-control-color" value="{{ $existingData["bauble_link_{$i}_{$j}"] ?? '' }}">
                    </div>
                    @endfor
                    
                    <div class="mb-3">
                        <label class="form-label">{{ translate('Bauble Text Font Color') }}</label>
                        <input type="color" name="bauble_text_color_{{ $i }}" class="form-control form-control-color" value="{{ $existingData["bauble_text_color_$i"] ?? '#000000' }}">
                    </div>
                </div>
                @endfor

                <button type="submit" class="btn btn-primary">{{ translate('Save Settings') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
