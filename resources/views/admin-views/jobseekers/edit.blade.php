@extends('layouts.back-end.app-partial')

@section('title', translate('Edit_Vacancies'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ theme_asset('public/assets/custom-css/progress-form.css') }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <h2 class="h1 mb-0 d-flex gap-2">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
                {{ translate('Edit Vacancy') }}
            </h2>
        </div>

        <form class="vacancy-form text-start" method="POST" action="{{ route('admin.jobvacancy.update', ['id' => $vacancy->id]) }}"
            enctype="multipart/form-data" id="vacancy_form">
            @csrf
            <div class="card">
                <div class="card-body">
                    @include('admin-views.jobseekers.partials._vacancy_fields')
                </div>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script src="{{ theme_asset('public/js/progress-form.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/tags-input.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.js') }}"></script>
    <script>
        $('body').ready(function() {
            $(document).on('change', '#country', function() {
                var country_id = $(this).val();
                var base_url = window.location.origin;
                $('#state').empty().append($('<option>', {
                    value: '',
                    text: 'Select State'
                }));
                $('#city').empty().append($('<option>', {
                    value: '',
                    text: 'Select City'
                }));
                $.ajax({
                    type: "GET",
                    url: base_url + "/get-state-by-id/" + country_id,
                    success: function(GetData) {
                        const data = JSON.parse(GetData);
                        $.each(data, function(i, obj) {
                            const fetchdata = `
                            <option value="${obj.id}"> ${obj.name} </option>
                            `;
                            $('#state').append(fetchdata);
                        });
                    }
                });
            });

            $(document).on('change', '#state', function() {
                console.log("F3");
                var new_state = $(this).val();
                var base_url = window.location.origin;
                $('#city').empty();
                $.ajax({
                    type: "GET",
                    url: base_url + "/get-city-by-id/" + new_state,
                    success: function(GetData) {
                        const data = JSON.parse(GetData);
                        $.each(data, function(i, obj) {
                            const fetchdata = `
                            <option value="${obj.id}"> ${obj.name} </option>
                            `;
                            $('#city').append(fetchdata);
                        });
                    }
                });
            });
        });
    </script>
@endpush