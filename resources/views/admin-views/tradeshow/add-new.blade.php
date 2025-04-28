@extends('layouts.back-end.app')

@section('title', translate('Add New Tradeshow'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="content container-fluid">
    <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
        <h2 class="h1 mb-0 d-flex gap-2">
            <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
            {{ translate('Add New Tradeshow') }}
        </h2>
    </div>

    <form class="product-form text-start" action="{{ route('admin.store.tradeshow') }}" method="POST"
        enctype="multipart/form-data" id="tradeshowForm">
        @csrf
        <div class="card">
            <div class="px-4 pt-3 d-flex justify-content-between">
                <ul class="nav nav-tabs w-fit-content mb-4">
                    @foreach ($languages as $lang)
                        <li class="nav-item">
                            <span
                                class="nav-link text-capitalize form-system-language-tab {{ $lang == $defaultLanguage ? 'active' : '' }} cursor-pointer"
                                id="{{ $lang }}-link">{{ getLanguageName($lang) . '(' . strtoupper($lang) . ')' }}</span>
                        </li>
                    @endforeach
                </ul>
                <a class="btn btn--primary btn-sm text-capitalize h-100"
                    href="{{ route('admin.tradeshow.bulk.import') }}">
                    {{ translate('Import Bulk Tradeshow') }}
                </a>
            </div>

            <div class="card-body">
                @foreach ($languages as $lang)
                    <div class="{{ $lang != $defaultLanguage ? 'd-none' : '' }} form-system-language-form"
                        id="{{ $lang }}-form">

                        <div class="row mb-4">
                            <!-- Industry -->
                            <div class="col">
                                <label class="title-color" for="{{ $lang }}_name">{{ translate('Name') }}
                                    ({{ strtoupper($lang) }})</label>
                                <input type="text" name="name" id="{{ $lang }}_name" class="form-control"
                                    placeholder="{{ translate('Enter Name') }}">
                            </div>
                            <!-- Show Date -->
                            <div class="col">
                                <!-- Stand -->
                                <label class="title-color" for="{{ $lang }}_description">{{ translate('Description') }}
                                    ({{ strtoupper($lang) }})</label>
                                <textarea name="description" id="{{ $lang }}_description" class="form-control"
                                    placeholder="{{ translate('Enter Description') }}" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <!-- Email -->
                            <div class="col">
                                <div class="row ml-1 mb-4">
                                    <label class="title-color" for="{{ $lang }}_email">{{ translate('Email') }}
                                        ({{ strtoupper($lang) }})</label>
                                    <input type="text" name="email" id="{{ $lang }}_email" class="form-control"
                                        placeholder="{{ translate('Enter Email') }}">
                                </div>
                                <div class="row ml-1 mb-4">
                                    <label class="title-color" for="{{ $lang }}_phone">{{ translate('Phone') }}
                                            ({{ strtoupper($lang) }})</label>
                                    <input type="text" name="phone" id="{{ $lang }}_phone" class="form-control"
                                        placeholder="{{ translate('Enter Phone') }}">
                                </div>
                            </div>
                            <!-- Address -->
                            <div class="col">
                                <!-- Stand -->
                                <label class="title-color" for="{{ $lang }}_address">{{ translate('Address') }}
                                    ({{ strtoupper($lang) }})</label>
                                <textarea name="address" id="{{ $lang }}_address" class="form-control"
                                    placeholder="{{ translate('Enter Address') }}"
                                    rows="5"></textarea>
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
                                    class="form-control {{ $lang == $defaultLanguage ? 'product-title-default-language' : '' }}"
                                    placeholder="{{ translate('Enter Company Name') }}">
                            </div>
                            <div class="col">
                                <label class="title-color" for="company_icon">{{ translate('Company_Icon') }}</label>
                                <input type="file" name="company_icon" id="company_icon" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <!-- Industry -->
                            <div class="col">
                                <!-- Hall -->
                                <label class="title-color" for="{{ $lang }}_hall">{{ translate('Hall') }}
                                    ({{ strtoupper($lang) }})</label>
                                <input type="text" name="hall" id="{{ $lang }}_hall" class="form-control"
                                    placeholder="{{ translate('Enter Hall') }}">
                            </div>
                            <!-- Show Date -->
                            <div class="col">
                                <!-- Stand -->
                                <label class="title-color" for="{{ $lang }}_stand">{{ translate('Stand') }}
                                    ({{ strtoupper($lang) }})</label>
                                <input type="text" name="stand" id="{{ $lang }}_stand" class="form-control"
                                    placeholder="{{ translate('Enter Stand') }}">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <!-- Industry -->
                            <div class="col">
                                <label class="title-color" for="industry">{{ translate('Industry') }}</label>
                                <select name="industry" id="industry" class="form-control">
                                    <option selected value="">Select a Industry</option>
                                    @foreach($industries as $industry)
                                        <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Start Date -->
                            <div class="col">
                                <label class="title-color" for="start_date">{{ translate('Start Date') }}</label>
                                <input type="date" name="start_date" id="start_date" class="form-control">
                            </div>
                            <!-- End Date -->
                            <div class="col">
                                <label class="title-color" for="end_date">{{ translate('End Date') }}</label>
                                <input type="date" name="end_date" id="end_date" class="form-control">
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
                                    <option value="value" selected>Select a Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label for="{{ $lang }}_city">{{ translate('City') }}</label>
                                <select name="city" id="city" class="form-control">
                                    <option value="" selected>Select a City</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col">
                                <label class="title-color" for="{{ $lang }}_website">{{ translate('Website') }}
                                    ({{ strtoupper($lang) }})</label>
                                <input type="url" name="website" id="{{ $lang }}_website" class="form-control"
                                    placeholder="{{ translate('Enter Website URL') }}">
                            </div>
                            <div class="col">
                                <label class="title-color" for="{{ $lang }}_image">{{ translate('Images') }}
                                    ({{ strtoupper($lang) }})</label>
                                <input type="file" name="image[]" id="{{ $lang }}_image" class="form-control" multiple>
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
                                <label class="title-color" for="featured">{{ translate('Featured')}}</label>
                                <select name="featured" class="form-control" id="featured">
                                    <option selected value="">Select Featured</option>
                                    <option value="1">Featured</option>
                                    <option value="0">Not Featured</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="title-color" for="popularity">{{ translate('Popularity') }}</label>
                                <select name="popularity" class="form-control" id="popularity">
                                    <option selected value="">Select Popularity</option>
                                    <?php 
                                        $i = 0;
                                    ?>
                                    @for($i;$i < 10;$i++)
                                        <option value="{{ $i+1 }}">{{ $i+1 }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="row justify-content-end gap-3 mt-3 mx-1">
            <button type="reset" class="btn btn-secondary px-5">{{ translate('Reset') }}</button>
            <button type="submit" class="btn btn--primary px-5" form="tradeshowForm">
                {{ translate('Submit') }}
            </button>
        </div>
    </form>
</div>

@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/tags-input.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#country').on('change', function () {
                var countryId = $(this).val();

                if (countryId) {
                    $.ajax({
                        url: '/get-city-by-country/' + countryId,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            $('#city').empty(); // Clear existing options
                            $('#city').append('<option value="">Select a City</option>'); // Default option

                            $.each(data, function (key, city) {
                                $('#city').append('<option value="' + city.id + '">' + city.name + '</option>');
                            });
                        },
                        error: function () {
                            alert('Failed to retrieve cities.');
                        }
                    });
                } else {
                    $('#city').empty().append('<option value="">Select a City</option>');
                }
            });
        });
    </script>
@endpush