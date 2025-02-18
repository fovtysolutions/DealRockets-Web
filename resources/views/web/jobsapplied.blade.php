@extends('layouts.front-end.app')
@section('title',translate('Job Applied'. ' | ' . $web_config['name']->value))
@push('css_or_js')
    <link rel="stylesheet"
        href="{{ theme_asset(path: 'public/assets/front-end/vendor/nouislider/distribute/nouislider.min.css') }}" />
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/front-end/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/front-end/css/address.css') }}">
    <link rel="stylesheet"
        href="{{ theme_asset(path: 'public/assets/front-end/plugin/intl-tel-input/css/intlTelInput.css') }}">
@endpush

@section('content')
    <div class="container py-4 rtl __account-address text-align-direction">

        <div class="row g-3">
            @include('web-views.partials._profile-aside')
            <section class="col-lg-9 col-md-8">

                <div class="card">
                    <div class="card-body">
                        <h5 class="font-bold m-0 fs-16">{{ translate('Jobs_Applied') }}</h5>
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Applied Type</th>
                                    <th>CV</th>
                                    <th>Profile</th>
                                    <th>Job Profile</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($applies as $index => $apply)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $apply['apply_type'] }}</td>
                                        <td>
                                            @if ($apply['job_apply_cv'] ?? null)
                                                <a href="/uploads/{{ $apply['job_apply_cv'] }}" class="btn btn-primary btn-sm">View
                                                    or Download</a>
                                            @else
                                                Not Applied
                                            @endif
                                        </td>
                                        <td>
                                            @if ($apply['job_apply_form'] ?? null)
                                                <a href="/account-jobprofile"
                                                    class="btn btn-primary btn-sm">View Profile</a>
                                            @else
                                                Not Applied
                                            @endif
                                        </td>
                                        <td>
                                            @if ($apply['job_data'] ?? null)
                                                <a href="/job-seeker/?jobid={{ $apply['job_data'] }}"
                                                    class="btn btn-primary btn-sm">Job Profile</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
@endpush
