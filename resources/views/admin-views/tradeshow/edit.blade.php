@extends('layouts.back-end.app')

@section('title', translate('Edit Tradeshow'))

@push('css_or_js')
    <link href="{{ dynamicAsset('public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset('public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset('public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="content container-fluid">
    <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
        <h2 class="h1 mb-0 d-flex gap-2">
            <img src="{{ dynamicAsset('public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
            {{ translate('Update Tradeshow') }}
        </h2>
    </div>

    <form class="product-form text-start" action="{{ route('admin.tradeshow.update', $tradeshow->id) }}" method="POST"
        enctype="multipart/form-data" id="tradeshowForm">
        @csrf
        <div class="card">
            <div class="px-4 pt-3 d-flex justify-content-between">
                <ul class="nav nav-tabs w-fit-content mb-4">
                    @foreach ($languages as $lang)
                        <li class="nav-item">
                            <span
                                class="nav-link text-capitalize form-system-language-tab {{ $lang == $defaultLanguage ? 'active' : '' }} cursor-pointer"
                                id="{{ $lang }}-link">
                                {{ getLanguageName($lang) . '(' . strtoupper($lang) . ')' }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="card-body">
                @foreach ($languages as $lang)
                                <div class="{{ $lang != $defaultLanguage ? 'd-none' : '' }} form-system-language-form"
                                    id="{{ $lang }}-form">

                                    <!-- Added Form -->
                                    <div class="row mb-4">
                                        <!-- Industry -->
                                        <div class="col">
                                            <label class="title-color" for="{{ $lang }}_name">{{ translate('Name') }}
                                                ({{ strtoupper($lang) }})</label>
                                            <input type="text" name="name" id="{{ $lang }}_name" class="form-control"
                                                placeholder="{{ translate('Enter Name') }}" value="{{ old('name', $tradeshow->name)}}">
                                        </div>
                                        <!-- Show Date -->
                                        <div class="col">
                                            <!-- Stand -->
                                            <label class="title-color" for="{{ $lang }}_description">{{ translate('Description') }}
                                                ({{ strtoupper($lang) }})</label>
                                            <textarea name="description" id="{{ $lang }}_description" class="form-control"
                                                placeholder="{{ translate('Enter Description') }}"
                                                rows="3">{{ old('description', $tradeshow->description) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <!-- Email -->
                                        <div class="col">
                                            <div class="row ml-1 mb-4">
                                                <label class="title-color" for="{{ $lang }}_email">{{ translate('Email') }}
                                                    ({{ strtoupper($lang) }})</label>
                                                <input type="text" name="email" id="{{ $lang }}_email" class="form-control"
                                                    placeholder="{{ translate('Enter Email') }}" value="{{ old('email', $tradeshow->email)}}">
                                            </div>
                                            <div class="row ml-1 mb-4">
                                                <label class="title-color" for="{{ $lang }}_phone">{{ translate('Phone') }}
                                                        ({{ strtoupper($lang) }})</label>
                                                <input type="text" name="phone" id="{{ $lang }}_phone" class="form-control"
                                                    placeholder="{{ translate('Enter Phone') }}" value="{{ old('phone', $tradeshow->phone)}}">
                                            </div>
                                        </div>
                                        <!-- Address -->
                                        <div class="col">
                                            <!-- Stand -->
                                            <label class="title-color" for="{{ $lang }}_address">{{ translate('Address') }}
                                                ({{ strtoupper($lang) }})</label>
                                            <textarea name="address" id="{{ $lang }}_address" class="form-control"
                                                placeholder="{{ translate('Enter Address') }}"
                                                rows="5">{{ old('address', $tradeshow->address) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col">
                                            <label class="title-color" for="{{ $lang }}_company_name">{{ translate('Company Name') }}
                                                ({{ strtoupper($lang) }})
                                                @if($lang == $defaultLanguage)
                                                    <span class="input-required-icon">*</span>
                                                @endif
                                            </label>
                                            <input type="text" {{ $lang == $defaultLanguage ? 'required' : '' }} name="company_name"
                                                id="{{ $lang }}_company_name"
                                                value="{{ old('company_name', $tradeshow->company_name) }}"
                                                class="form-control {{ $lang == $defaultLanguage ? 'product-title-default-language' : '' }}"
                                                placeholder="{{ translate('Enter Company Name') }}">
                                        </div>
                                        <div class="col">
                                            <label class="title-color" for="company_icon">{{ translate('Company_Icon') }}</label>
                                            <input type="file" name="company_icon" id="company_icon" class="form-control">
                                            <img src="/storage/{{$tradeshow->company_icon}}" alt="Image">
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <!-- Industry -->
                                        <div class="col">
                                            <!-- Hall -->
                                            <label class="title-color" for="{{ $lang }}_hall">{{ translate('Hall') }}
                                                ({{ strtoupper($lang) }})</label>
                                            <input type="text" name="hall" id="{{ $lang }}_hall" class="form-control"
                                                value="{{ old('hall', $tradeshow->hall) }}" placeholder="{{ translate('Enter Hall') }}">
                                        </div>
                                        <!-- Show Date -->
                                        <div class="col">
                                            <!-- Stand -->
                                            <label class="title-color" for="{{ $lang }}_stand">{{ translate('Stand') }}
                                                ({{ strtoupper($lang) }})</label>
                                            <input type="text" name="stand" id="{{ $lang }}_stand" class="form-control"
                                                value="{{ old('stand', $tradeshow->stand) }}"
                                                placeholder="{{ translate('Enter Stand') }}">
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <!-- Industry -->
                                        <div class="col">
                                            <label class="title-color" for="industry">{{ translate('Industry') }}</label>
                                            <select name="industry" id="industry" class="form-control">
                                                <option selected value="{{ $tradeshow->industry }}">
                                                    {{ \App\Models\TradeCategory::where('id', $tradeshow->industry)->first()->name ?? 'N/A'}}
                                                </option> @foreach($industries as $industry)
                                                    <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- Start Date -->
                                        <div class="col">
                                            <label class="title-color" for="start_date">{{ translate('Start Date') }}</label>
                                            <input type="date" value="{{ $tradeshow->start_date }}" name="start_date" id="start_date" class="form-control">
                                        </div>
                                        <!-- End Date -->
                                        <div class="col">
                                            <label class="title-color" for="end_date">{{ translate('End Date') }}</label>
                                            <input type="date" value="{{ $tradeshow->end_date }}" name="end_date" id="end_date" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="timeline">Timeline</label>
                                                <textarea name="timeline" id="timeline" class="form-control" rows="5" placeholder="Enter timeline, one event per line">{{ isset($tradeshow) ? implode("\n", json_decode($tradeshow->timeline, true) ?? []) : '' }}</textarea>
                                                <small class="form-text text-muted">Enter each timeline event on a new line (e.g., "10:00 am - 10:30 am: Intro and Welcoming").</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col">
                                            <label class="title-color" for="{{ $lang }}_country">{{ translate('country') }}
                                                ({{ strtoupper($lang) }})
                                                @if($lang == $defaultLanguage)
                                                    <span class="input-required-icon">*</span>
                                                @endif
                                            </label>
                                            <select name="country" id="country" class="form-control">
                                                <option value="{{ $tradeshow->country }}" selected>
                                                    {{ \App\Utils\ChatManager::getCountryDetails($tradeshow->country)['countryName'] ?? 'N/A' }}
                                                </option> @foreach($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="{{ $lang }}_city">{{ translate('City') }}</label>
                                            <select name="city" id="city" class="form-control">
                                                <option value="{{ $tradeshow->city }}" selected>
                                                    {{ \App\Models\City::where('id', $tradeshow->city)->first()->name ?? 'N/A'}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col">
                                            <label class="title-color" for="{{ $lang }}_website">{{ translate('Website') }}
                                                ({{ strtoupper($lang) }})</label>
                                            <input type="url" name="website" id="{{ $lang }}_website" class="form-control"
                                                value="{{ old('website', $tradeshow->website) }}"
                                                placeholder="{{ translate('Enter Website URL') }}">
                                        </div>
                                        <div class="col">
                                            <label class="title-color" for="{{ $lang }}_image">{{ translate('Images') }}
                                                ({{ strtoupper($lang) }})</label>
                                            <input type="file" name="image[]" id="{{ $lang }}_image" class="form-control" multiple>
                                            <div class="mt-2">
                                                @php
                                                    $imagePaths = json_decode($tradeshow->image, true) ?? [];  // Decode existing image JSON
                                                @endphp
                                        
                                                @foreach($imagePaths as $image)
                                                    <div class="mb-2">
                                                        <img src="{{ asset('storage/' . $image) }}" alt="Existing Image"
                                                            style="width: 100px; margin-right: 10px;">
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="removeImage(this, '{{ $image }}')">Remove</button>
                                                        <input type="hidden" name="existing_images[]" value="{{ $image }}">
                                                        <!-- Hidden field to keep track of existing images -->
                                                    </div>
                                                @endforeach
                                            </div>
                                            <!-- Hidden input to track removed images -->
                                            <input type="hidden" name="removed_images" id="removed_images" value="">
                                        </div>                                        
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col">
                                            <label class="title-color" for="featured">{{ translate('Featured')}}</label>
                                            <select name="featured" class="form-control" id="featured">
                                                <option selected value="{{ $tradeshow->featured }}">
                                                    {{ $tradeshow->featured == 1 ? 'Featured' : 'Not Featured'}}</option>
                                                <option value="1">Featured</option>
                                                <option value="0">Not Featured</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="title-color" for="popularity">{{ translate('Popularity') }}</label>
                                            <select name="popularity" class="form-control" id="popularity">
                                                <option selected value="{{ (int) $tradeshow->popularity }}">
                                                    {{ (int) $tradeshow->popularity + 1 }}</option>
                                                <?php 
                                                        $i = 0;
                                                    ?>
                                                @for($i; $i < 10; $i++)
                                                    <option value="{{ $i + 1 }}">{{ $i + 1 }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <!-- End Added Form -->
                                </div>
                @endforeach
            </div>

            <div class="row justify-content-end gap-3 mt-3 mx-1 my-3">
                <button type="reset" class="btn btn-secondary px-5">{{ translate('Reset') }}</button>
                <button type="submit" class="btn btn--primary px-5">
                    {{ translate('Update') }}
                </button>
            </div>
        </div>
    </form>
</div>

@endsection

@push('script')
    <script src="{{ dynamicAsset('public/assets/back-end/js/tags-input.min.js') }}"></script>
    <script src="{{ dynamicAsset('public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script>
        $(document).ready(function () {
            // Get the selected country ID from the form (if available)
            var selectedCountryId = $('#country').val();

            // Function to fetch cities based on selected country
            function fetchCities(countryId) {
                if (!countryId) return; // If no country selected, don't proceed

                $.ajax({
                    url: '/get-city-by-country/' + countryId,  // Replace with your actual route
                    type: 'GET',
                    success: function (data) {
                        // Clear existing options
                        $('#city').empty().append('<option value="{{ $tradeshow->city }}">{{ \App\Models\City::where('id', $tradeshow->city)->first()->name ?? 'N/A'}}</option>');

                        // Loop through the cities and append them to the select dropdown
                        data.forEach(function (city) {
                            var isSelected = city.id == $('#city').data('selected-city-id') ? 'selected' : '';
                            $('#city').append('<option value="' + city.id + '" ' + isSelected + '>' + city.name + '</option>');
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error("Error fetching cities: ", error);
                    }
                });
            }

            // Fetch cities on page load based on selected country
            if (selectedCountryId) {
                fetchCities(selectedCountryId);
            }

            // Re-fetch cities when the country is changed
            $('#country').on('change', function () {
                var selectedCountryId = $(this).val();
                fetchCities(selectedCountryId);
            });
        });
    </script>
    <script>
        function removeImage(button, imagePath) {
            // Remove the image container
            const imageContainer = button.closest('.mb-2');
            imageContainer.remove();
    
            // Add the removed image path to the hidden input
            const removedImagesInput = document.getElementById('removed_images');
            let removedImages = removedImagesInput.value ? JSON.parse(removedImagesInput.value) : [];
            removedImages.push(imagePath);
            removedImagesInput.value = JSON.stringify(removedImages);
        }
    </script>
@endpush