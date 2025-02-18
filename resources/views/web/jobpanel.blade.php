@extends('layouts.front-end.app')

@section('title',translate('Job Panel'. ' | ' . $web_config['name']->value))

@push('css_or_js')
    <link rel="stylesheet"
        href="{{ theme_asset(path: 'public/assets/front-end/vendor/nouislider/distribute/nouislider.min.css') }}" />
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/front-end/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/front-end/css/address.css') }}">
    <link rel="stylesheet"
        href="{{ theme_asset(path: 'public/assets/front-end/plugin/intl-tel-input/css/intlTelInput.css') }}">
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/jobpanel.css') }}">
@endpush

@section('content')
<?php 
$userId = Auth('customer')->id();
use App\Models\User;
$user = User::where('id',$userId)->first();
?>
<div class="container py-4 rtl __account-address text-align-direction">
    <div class="row g-3">
        <section class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="font-bold m-0 fs-16">{{ translate('Job_Panel') }}</h5>
                    <div class="jobpanelbox">
                        <div class="jobpanelaside m-2">
                            <a class="tiles btn btn-default border border-1" href="#"
                                data-section="createjobs_panel">Create Job</a>
                            <a class="tiles btn btn-default border border-1" href="#" data-section="addedjobs_panel">See
                                Added Jobs</a>
                            <a class="tiles btn btn-default border border-1" href="#"
                                data-section="job_applicationspanel">Job Applications</a>
                            <a class="tiles btn btn-default border border-1" href="#"
                                data-section="shortlisted_candidatespanel">Shortlisted Candidates</a>
                        </div>
                        <div class="jobpanelcontent m-2">
                            <div id="createjobs_panel" class="content-section">
                                @include('web.partials._create_jobs')
                            </div>
                            <div id="addedjobs_panel" class="content-section" style="display: none;">
                                @include('web.partials._added_jobs')
                            </div>
                            <div id="job_applicationspanel" class="content-section" style="display: none;">
                                @include('web.partials._job_applications')
                            </div>
                            <div id="shortlisted_candidatespanel" class="content-section" style="display: none;">
                                @include('web.partials._shortlisted_candidates')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@push('script')
    <script src="{{ theme_asset(path: 'public/assets/front-end/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ theme_asset(path: 'public/assets/front-end/plugin/intl-tel-input/js/intlTelInput.js') }}"></script>
    <script src="{{ theme_asset(path: 'public/assets/front-end/js/country-picker-init.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.getElementsByClassName('tiles');

            Array.from(buttons).forEach(element => {
                element.addEventListener('click', function () {
                    const sectionToShow = this.getAttribute('data-section');

                    const sections = document.getElementsByClassName('content-section');
                    Array.from(sections).forEach(section => {
                        section.style.display = 'none';
                    });

                    const targetSection = document.getElementById(sectionToShow);
                    if (targetSection) {
                        targetSection.style.display = 'block';
                    }
                });
            });
        });
    </script>
@endpush