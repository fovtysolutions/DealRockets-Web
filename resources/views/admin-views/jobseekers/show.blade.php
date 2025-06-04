@extends('layouts.back-end.app-partial')

@section('title', translate('Show_Vacancies'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container-fluid mt-4 mb-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{ translate('Show Vacancy Details') }}</h5>
                    </div>
                    <div class="card-body">
                        <!-- Display Vacancy Details -->
                        <div class="row">
                            <!-- Job Title -->
                            <div class="col-md-6">
                                <strong>{{ translate('Job Title') }}:</strong>
                                <p>{{ $vacancy->title }}</p>
                            </div>

                            <!-- Category -->
                            <div class="col-md-6">
                                <strong>{{ translate('Category') }}:</strong>
                                <p>{{ $category }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Description -->
                            <div class="col-md-12">
                                <strong>{{ translate('Description') }}:</strong>
                                <p>{!! nl2br(e($vacancy->description)) !!}</p>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Salary -->
                            <div class="col-md-6">
                                <strong>{{ translate('Salary') }}:</strong>
                                <p>${{ number_format($vacancy->salary, 2) }}</p>
                            </div>

                            <!-- Employment Type -->
                            <div class="col-md-6">
                                <strong>{{ translate('Employment Type') }}:</strong>
                                <p>{{ ucfirst($vacancy->employment_type) }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Status -->
                            <div class="col-md-6">
                                <strong>{{ translate('Status') }}:</strong>
                                <p>{{ ucfirst($vacancy->status) }}</p>
                            </div>

                            <!-- Company Name -->
                            <div class="col-md-6">
                                <strong>{{ translate('Company Name') }}:</strong>
                                <p>{{ $vacancy->company_name }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Country -->
                            <div class="col-md-6">
                                <strong>{{ translate('Country') }}:</strong>
                                <p>{{ $country }}</p>
                            </div>

                            <!-- State -->
                            <div class="col-md-6">
                                <strong>{{ translate('State') }}:</strong>
                                <p>{{ $state }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <!-- City -->
                            <div class="col-md-6">
                                <strong>{{ translate('City') }}:</strong>
                                <p>{{ $city }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Experience Required -->
                            <div class="col-md-6">
                                <strong>{{ translate('Experience Required') }}:</strong>
                                <p>{{ $vacancy->experience_required }} {{ translate('Years') }}</p>
                            </div>

                            <!-- Education Level -->
                            <div class="col-md-6">
                                <strong>{{ translate('Education Level') }}:</strong>
                                <p>{{ $vacancy->education_level }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Skills Required -->
                            <div class="col-md-6">
                                <strong>{{ translate('Skills Required') }}:</strong>
                                <p>{{ implode(',',json_decode($vacancy->skills_required,true)) }}</p>
                            </div>

                            <!-- Certifications Required -->
                            <div class="col-md-6">
                                <strong>{{ translate('Certifications Required') }}:</strong>
                                <p>{{ implode(',',json_decode($vacancy->certifications_required,true)) }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Benefits -->
                            <div class="col-md-6">
                                <strong>{{ translate('Benefits') }}:</strong>
                                <p>{{ implode(',',json_decode($vacancy->benefits,true)) }}</p>
                            </div>

                            <!-- Application Deadline -->
                            <div class="col-md-6">
                                <strong>{{ translate('Application Deadline') }}:</strong>
                                <p>{{ \Carbon\Carbon::parse($vacancy->application_deadline)->format('F j, Y') }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Company Address -->
                            <div class="col-md-6">
                                <strong>{{ translate('Company Address') }}:</strong>
                                <p>{{ $vacancy->company_address }}</p>
                            </div>

                            <!-- Company Website -->
                            <div class="col-md-6">
                                <strong>{{ translate('Company Website') }}:</strong>
                                <p>
                                    <a href="{{ $vacancy->company_website }}" target="_blank">
                                        {{ $vacancy->company_website }}
                                    </a>
                                </p>
                            </div>
                        </div>

                        <!-- Company Logo -->
                        @if ($vacancy->company_logo)
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <strong>{{ translate('Company Logo') }}:</strong>
                                    <img src="{{ asset('storage/' . $vacancy->company_logo) }}" alt="Company Logo"
                                        class="img-fluid" style="max-width: 200px;">
                                </div>
                            </div>
                        @endif
                    </div>


                    <!-- Back Button -->
                    <div class="row mt-4">
                        <div class="col-md-12 text-end">
                            <a href="{{ route('admin.jobvacancy.list') }}"
                                class="btn btn-primary m-3">{{ translate('Back to List') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/tags-input.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/product-add-update.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/product-add-colors-img.js') }}"></script>
@endpush
