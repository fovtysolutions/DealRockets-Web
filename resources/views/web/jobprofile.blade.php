@extends('layouts.front-end.app')

@section('title', translate('Job Profile' . ' | ' . $web_config['name']->value))

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
                        <h5 class="font-bold m-0 fs-16">{{ translate('Job_Profile') }}</h5>
                        <form action="{{ route('job-prof-submit') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <!-- Full Name and Date of Birth in one row -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="full_name" class="form-label">{{ translate('Full Name') }}</label>
                                    <input type="text" class="form-control" id="full_name" name="full_name"
                                        value="{{ old('full_name', $profile->full_name ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="date_of_birth" class="form-label">{{ translate('Date of Birth') }}</label>
                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                        value="{{ old('date_of_birth', $profile->date_of_birth ?? '') }}">
                                </div>
                            </div>

                            <!-- Gender and Phone in one row -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="gender" class="form-label">{{ translate('Gender') }}</label>
                                    <select class="form-select" id="gender" name="gender">
                                        <option value="male"
                                            {{ old('gender', $profile->gender ?? '') == 'male' ? 'selected' : '' }}>
                                            {{ translate('Male') }}</option>
                                        <option value="female"
                                            {{ old('gender', $profile->gender ?? '') == 'female' ? 'selected' : '' }}>
                                            {{ translate('Female') }}</option>
                                        <option value="other"
                                            {{ old('gender', $profile->gender ?? '') == 'other' ? 'selected' : '' }}>
                                            {{ translate('Other') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">{{ translate('Phone') }}</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ old('phone', $profile->phone ?? '') }}">
                                </div>
                            </div>

                            <!-- Alternate Phone and Email in one row -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="alternate_phone"
                                        class="form-label">{{ translate('Alternate Phone') }}</label>
                                    <input type="text" class="form-control" id="alternate_phone" name="alternate_phone"
                                        value="{{ old('alternate_phone', $profile->alternate_phone ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">{{ translate('Email') }}</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email', $profile->email ?? '') }}">
                                </div>
                            </div>

                            <!-- Alternate Email and Address in one row -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="alternate_email"
                                        class="form-label">{{ translate('Alternate Email') }}</label>
                                    <input type="email" class="form-control" id="alternate_email" name="alternate_email"
                                        value="{{ old('alternate_email', $profile->alternate_email ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="address" class="form-label">{{ translate('Address') }}</label>
                                    <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $profile->address ?? '') }}</textarea>
                                </div>
                            </div>

                            <!-- City, State, and Postal Code in one row -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="country" class="form-label">{{ translate('Country') }}</label>
                                    <select type="text" class="form-control" id="country" name="country">
                                        <option value="{{ isset($profile->country) ? $profile->country : '' }}" name="country">Select a Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" name="{{ $country->name }}">
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="state" class="form-label">{{ translate('State') }}</label>
                                    <select type="text" class="form-control" id="state" name="state">
                                        <option value="{{ isset($profile->state) ? $profile->state : '' }}">Select a Country</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="city" class="form-label">{{ translate('City') }}</label>
                                    <select type="text" class="form-control" id="city" name="city">
                                        <option value="{{ isset($profile->city) ? $profile->city : '' }}">Select a State</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Country and Nationality in one row -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="postal_code" class="form-label">{{ translate('Postal Code') }}</label>
                                    <input type="text" class="form-control" id="postal_code" name="postal_code"
                                        value="{{ old('postal_code', $profile->postal_code ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="nationality" class="form-label">{{ translate('Nationality') }}</label>
                                    <input type="text" class="form-control" id="nationality" name="nationality"
                                        value="{{ old('nationality', $profile->nationality ?? '') }}">
                                </div>
                            </div>

                            <!-- Marital Status and Profile Photo in one row -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="marital_status"
                                        class="form-label">{{ translate('Marital Status') }}</label>
                                    <select class="form-select" id="marital_status" name="marital_status">
                                        <option value="single"
                                            {{ old('marital_status', $profile->marital_status ?? '') == 'single' ? 'selected' : '' }}>
                                            {{ translate('Single') }}</option>
                                        <option value="married"
                                            {{ old('marital_status', $profile->marital_status ?? '') == 'married' ? 'selected' : '' }}>
                                            {{ translate('Married') }}</option>
                                        <option value="divorced"
                                            {{ old('marital_status', $profile->marital_status ?? '') == 'divorced' ? 'selected' : '' }}>
                                            {{ translate('Divorced') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="profile_photo"
                                        class="form-label">{{ translate('Profile Photo') }}</label>
                                    <input type="file" class="form-control" id="profile_photo" name="profile_photo">
                                    @if ($profile && $profile->profile_photo)
                                        <img src="{{ asset('storage/' . $profile->profile_photo) }}" alt="Profile Photo"
                                            width="100">
                                    @endif
                                </div>
                            </div>

                            <!-- Highest Education and Field of Study in one row -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="highest_education"
                                        class="form-label">{{ translate('Highest Education') }}</label>
                                    <input type="text" class="form-control" id="highest_education"
                                        name="highest_education"
                                        value="{{ old('highest_education', $profile->highest_education ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="field_of_study"
                                        class="form-label">{{ translate('Field of Study') }}</label>
                                    <input type="text" class="form-control" id="field_of_study" name="field_of_study"
                                        value="{{ old('field_of_study', $profile->field_of_study ?? '') }}">
                                </div>
                            </div>

                            <!-- University Name and Graduation Year in one row -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="university_name"
                                        class="form-label">{{ translate('University Name') }}</label>
                                    <input type="text" class="form-control" id="university_name"
                                        name="university_name"
                                        value="{{ old('university_name', $profile->university_name ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="graduation_year"
                                        class="form-label">{{ translate('Graduation Year') }}</label>
                                    <input type="year" pattern="\d{4}" class="form-control" id="graduation_year"
                                        name="graduation_year"
                                        value="{{ old('graduation_year', $profile->graduation_year ?? '') }}">
                                </div>
                            </div>

                            <div class="row">
                                <!-- Additional Courses -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="additional_courses"
                                            class="form-label">{{ translate('Additional Courses') }}</label>
                                        <textarea class="form-control" id="additional_courses" name="additional_courses">{{ old('additional_courses', $profile->additional_courses ?? '') }}</textarea>
                                    </div>
                                </div>

                                <!-- Currency -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="currency" class="form-label">{{ translate('Currency') }}</label>
                                        <input class="form-control" id="currency" name="currency"
                                            value="{{ old('currency', $profile->currency ?? '') }}"></input>
                                    </div>
                                </div>

                                <!-- Previous Employees -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="previous_employers"
                                            class="form-label">{{ translate('Previous Employers') }}</label>
                                        <textarea class="form-control" id="previous_employers" name="previous_employers" rows="6"
                                            placeholder="Example:&#10;Emirates Trading LLC - Sales Manager (Present)&#10;Gulf Info - Sales Executive (2019 - 2021)">
                                            {{ old('previous_employers', $profile->previous_employers ?? '') }}
                                        </textarea>
                                        <small class="text-muted">Format: Company Name - Job Title (Years)</small>
                                    </div>
                                </div>


                                <!-- Certifications -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="certifications"
                                            class="form-label">{{ translate('Certifications') }}</label>
                                        <textarea class="form-control" id="certifications" name="certifications">{{ old('certifications', $profile->certifications ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <!-- Languages -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="languages" class="form-label">{{ translate('Languages') }}</label>
                                        <textarea class="form-control" id="languages" name="languages">{{ old('languages', $profile->languages ?? '') }}</textarea>
                                    </div>
                                </div>

                                <!-- Skills -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="skills" class="form-label">{{ translate('Skills') }}</label>
                                        <textarea class="form-control" id="skills" name="skills">{{ old('skills', $profile->skills ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Bio -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bio" class="form-label">{{ translate('Bio') }}</label>
                                        <textarea class="form-control" id="bio" name="bio">{{ old('bio', $profile->bio ?? '') }}</textarea>
                                    </div>
                                </div>

                                <!-- LinkedIn Profile -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="linkedin_profile"
                                            class="form-label">{{ translate('LinkedIn Profile') }}</label>
                                        <input type="url" class="form-control" id="linkedin_profile"
                                            name="linkedin_profile"
                                            value="{{ old('linkedin_profile', $profile->linkedin_profile ?? '') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Portfolio URL -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="portfolio_url"
                                            class="form-label">{{ translate('Portfolio URL') }}</label>
                                        <input type="url" class="form-control" id="portfolio_url"
                                            name="portfolio_url"
                                            value="{{ old('portfolio_url', $profile->portfolio_url ?? '') }}">
                                    </div>
                                </div>

                                <!-- Resume -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="resume" class="form-label">{{ translate('Resume') }}</label>
                                        <input type="file" class="form-control" id="resume" name="resume">
                                        @if ($profile && $profile->resume)
                                            <a href="{{ asset('storage/' . $profile->resume) }}"
                                                target="_blank">{{ translate('View Current Resume') }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Years of Experience -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="years_of_experience"
                                            class="form-label">{{ translate('Years of Experience') }}</label>
                                        <input type="number" class="form-control" id="years_of_experience"
                                            name="years_of_experience"
                                            value="{{ old('years_of_experience', $profile->years_of_experience ?? '') }}">
                                    </div>
                                </div>

                                <!-- Current Position -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="current_position"
                                            class="form-label">{{ translate('Current Position') }}</label>
                                        <input type="text" class="form-control" id="current_position"
                                            name="current_position"
                                            value="{{ old('current_position', $profile->current_position ?? '') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Current Employer -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="current_employer"
                                            class="form-label">{{ translate('Current Employer') }}</label>
                                        <input type="text" class="form-control" id="current_employer"
                                            name="current_employer"
                                            value="{{ old('current_employer', $profile->current_employer ?? '') }}">
                                    </div>
                                </div>

                                <!-- Work Experience -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="work_experience"
                                            class="form-label">{{ translate('Work Experience') }}</label>
                                        <textarea class="form-control" id="work_experience" name="work_experience">{{ old('work_experience', $profile->work_experience ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Desired Position -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="desired_position"
                                            class="form-label">{{ translate('Desired Position') }}</label>
                                        <input type="text" class="form-control" id="desired_position"
                                            name="desired_position"
                                            value="{{ old('desired_position', $profile->desired_position ?? '') }}">
                                    </div>
                                </div>

                                <!-- Employment Type -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="employment_type"
                                            class="form-label">{{ translate('Employment Type') }}</label>
                                        <select class="form-control" id="employment_type" name="employment_type">
                                            <option value="">Select Job Type</option>
                                            <option value="Full-Time"
                                                {{ old('employment_type', $profile->employment_type ?? '') == 'Full-Time' ? 'selected' : '' }}>
                                                Full-Time</option>
                                            <option value="Part-Time"
                                                {{ old('employment_type', $profile->employment_type ?? '') == 'Part-Time' ? 'selected' : '' }}>
                                                Part-Time</option>
                                            <option value="Weekly"
                                                {{ old('employment_type', $profile->employment_type ?? '') == 'Weekly' ? 'selected' : '' }}>
                                                Weekly</option>
                                            <option value="Hourly"
                                                {{ old('employment_type', $profile->employment_type ?? '') == 'Hourly' ? 'selected' : '' }}>
                                                Hourly</option>
                                            <option value="Contract"
                                                {{ old('employment_type', $profile->employment_type ?? '') == 'Contract' ? 'selected' : '' }}>
                                                Contract</option>
                                            <option value="Freelancing"
                                                {{ old('employment_type', $profile->employment_type ?? '') == 'Freelancing' ? 'selected' : '' }}>
                                                Freelancing</option>
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <!-- Desired Salary -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="desired_salary"
                                            class="form-label">{{ translate('Desired Salary') }}</label>
                                        <input type="number" step="0.01" class="form-control" id="desired_salary"
                                            name="desired_salary"
                                            value="{{ old('desired_salary', $profile->desired_salary ?? '') }}">
                                    </div>
                                </div>

                                <!-- Relocation -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="relocation" class="form-label">{{ translate('Relocation') }}</label>
                                        <select class="form-control" id="relocation" name="relocation">
                                            <option value="1"
                                                {{ old('relocation', $profile->relocation ?? 0) == 1 ? 'selected' : '' }}>
                                                {{ translate('Yes') }}</option>
                                            <option value="0"
                                                {{ old('relocation', $profile->relocation ?? 0) == 0 ? 'selected' : '' }}>
                                                {{ translate('No') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Industry -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="industry" class="form-label">{{ translate('Industry') }}</label>
                                        <select class="form-control" id="industry" name="industry">
                                            <option value="">Select Industry</option>
                                            @foreach ($industries as $industry)
                                                <option value="{{ $industry }}"
                                                    {{ old('industry', $profile->industry ?? '') == $industry ? 'selected' : '' }}>
                                                    {{ $industry->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Preferred Locations -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="preferred_locations"
                                            class="form-label">{{ translate('Preferred Locations') }}</label>
                                        <textarea class="form-control" id="preferred_locations" name="preferred_locations">{{ old('preferred_locations', $profile->preferred_locations ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Open to Remote -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="open_to_remote"
                                            class="form-label">{{ translate('Open to Remote') }}</label>
                                        <select class="form-control" id="open_to_remote" name="open_to_remote">
                                            <option value="1"
                                                {{ old('open_to_remote', $profile->open_to_remote ?? 0) == 1 ? 'selected' : '' }}>
                                                {{ translate('Yes') }}</option>
                                            <option value="0"
                                                {{ old('open_to_remote', $profile->open_to_remote ?? 0) == 0 ? 'selected' : '' }}>
                                                {{ translate('No') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Available Immediately -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="available_immediately"
                                            class="form-label">{{ translate('Available Immediately') }}</label>
                                        <select class="form-control" id="available_immediately"
                                            name="available_immediately">
                                            <option value="1"
                                                {{ old('available_immediately', $profile->available_immediately ?? 0) == 1 ? 'selected' : '' }}>
                                                {{ translate('Yes') }}</option>
                                            <option value="0"
                                                {{ old('available_immediately', $profile->available_immediately ?? 0) == 0 ? 'selected' : '' }}>
                                                {{ translate('No') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Availability Date -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="availability_date"
                                            class="form-label">{{ translate('Availability Date') }}</label>
                                        <input type="date" class="form-control" id="availability_date"
                                            name="availability_date"
                                            value="{{ old('availability_date', $profile->availability_date ?? '') }}">
                                    </div>
                                </div>

                                <!-- References -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="references" class="form-label">{{ translate('References') }}</label>
                                        <textarea class="form-control" id="references" name="references">{{ old('references', $profile->references ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Hobbies -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="hobbies" class="form-label">{{ translate('Hobbies') }}</label>
                                        <textarea class="form-control" id="hobbies" name="hobbies">{{ old('hobbies', $profile->hobbies ?? '') }}</textarea>
                                    </div>
                                </div>

                                <!-- Has Driver's License -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="has_drivers_license"
                                            class="form-label">{{ translate('Has Driver\'s License') }}</label>
                                        <select class="form-control" id="has_drivers_license" name="has_drivers_license">
                                            <option value="1"
                                                {{ old('has_drivers_license', $profile->has_drivers_license ?? 0) == 1 ? 'selected' : '' }}>
                                                {{ translate('Yes') }}</option>
                                            <option value="0"
                                                {{ old('has_drivers_license', $profile->has_drivers_license ?? 0) == 0 ? 'selected' : '' }}>
                                                {{ translate('No') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Visa Status -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="visa_status"
                                            class="form-label">{{ translate('Visa Status') }}</label>
                                        <input type="text" class="form-control" id="visa_status" name="visa_status"
                                            value="{{ old('visa_status', $profile->visa_status ?? '') }}">
                                    </div>
                                </div>

                                <!-- Passport Number -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="passport_number"
                                            class="form-label">{{ translate('Passport Number') }}</label>
                                        <input type="text" class="form-control" id="passport_number"
                                            name="passport_number"
                                            value="{{ old('passport_number', $profile->passport_number ?? '') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Has Criminal Record -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="has_criminal_record"
                                            class="form-label">{{ translate('Has Criminal Record') }}</label>
                                        <select class="form-control" id="has_criminal_record" name="has_criminal_record">
                                            <option value="1"
                                                {{ old('has_criminal_record', $profile->has_criminal_record ?? 0) == 1 ? 'selected' : '' }}>
                                                {{ translate('Yes') }}</option>
                                            <option value="0"
                                                {{ old('has_criminal_record', $profile->has_criminal_record ?? 0) == 0 ? 'selected' : '' }}>
                                                {{ translate('No') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Is Verified -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="is_verified"
                                            class="form-label">{{ translate('Is Verified') }}</label>
                                        <select class="form-control" id="is_verified" name="is_verified">
                                            <option value="1"
                                                {{ old('is_verified', $profile->is_verified ?? 0) == 1 ? 'selected' : '' }}>
                                                {{ translate('Yes') }}</option>
                                            <option value="0"
                                                {{ old('is_verified', $profile->is_verified ?? 0) == 0 ? 'selected' : '' }}>
                                                {{ translate('No') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Short Term Goal -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="short_term_goal"
                                            class="form-label">{{ translate('Short Term Goal') }}</label>
                                        <input type="text" class="form-control" id="short_term_goal"
                                            name="short_term_goal"
                                            value="{{ old('short_term_goal', $profile->short_term_goal ?? '') }}">
                                    </div>
                                </div>

                                <!-- Long Term Goal -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="long_term_goal"
                                            class="form-label">{{ translate('Long Term Goal') }}</label>
                                        <input type="text" class="form-control" id="long_term_goal"
                                            name="long_term_goal"
                                            value="{{ old('long_term_goal', $profile->long_term_goal ?? '') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Seeking Internship -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="seeking_internship"
                                            class="form-label">{{ translate('Seeking Internship') }}</label>
                                        <select class="form-control" id="seeking_internship" name="seeking_internship">
                                            <option value="1"
                                                {{ old('seeking_internship', $profile->seeking_internship ?? 0) == 1 ? 'selected' : '' }}>
                                                {{ translate('Yes') }}</option>
                                            <option value="0"
                                                {{ old('seeking_internship', $profile->seeking_internship ?? 0) == 0 ? 'selected' : '' }}>
                                                {{ translate('No') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Open to Contract -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="open_to_contract"
                                            class="form-label">{{ translate('Open to Contract') }}</label>
                                        <select class="form-control" id="open_to_contract" name="open_to_contract">
                                            <option value="1"
                                                {{ old('open_to_contract', $profile->open_to_contract ?? 0) == 1 ? 'selected' : '' }}>
                                                {{ translate('Yes') }}</option>
                                            <option value="0"
                                                {{ old('open_to_contract', $profile->open_to_contract ?? 0) == 0 ? 'selected' : '' }}>
                                                {{ translate('No') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- GitHub Profile -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="github_profile"
                                            class="form-label">{{ translate('GitHub Profile') }}</label>
                                        <input type="url" class="form-control" id="github_profile"
                                            name="github_profile"
                                            value="{{ old('github_profile', $profile->github_profile ?? '') }}">
                                    </div>
                                </div>

                                <!-- Behance Profile -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="behance_profile"
                                            class="form-label">{{ translate('Behance Profile') }}</label>
                                        <input type="url" class="form-control" id="behance_profile"
                                            name="behance_profile"
                                            value="{{ old('behance_profile', $profile->behance_profile ?? '') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Twitter Profile -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="twitter_profile"
                                            class="form-label">{{ translate('Twitter Profile') }}</label>
                                        <input type="url" class="form-control" id="twitter_profile"
                                            name="twitter_profile"
                                            value="{{ old('twitter_profile', $profile->twitter_profile ?? '') }}">
                                    </div>
                                </div>

                                <!-- Personal Website -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="personal_website"
                                            class="form-label">{{ translate('Personal Website') }}</label>
                                        <input type="url" class="form-control" id="personal_website"
                                            name="personal_website"
                                            value="{{ old('personal_website', $profile->personal_website ?? '') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Portfolio Items -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="portfolio_items"
                                            class="form-label">{{ translate('Portfolio Items') }}</label>
                                        <textarea class="form-control" id="portfolio_items" name="portfolio_items">{{ old('portfolio_items', $profile->portfolio_items ?? '') }}</textarea>
                                    </div>
                                </div>

                                <!-- Videos -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="videos" class="form-label">{{ translate('Videos') }}</label>
                                        <textarea class="form-control" id="videos" name="videos">{{ old('videos', $profile->videos ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Profile Views -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="profile_views"
                                            class="form-label">{{ translate('Profile Views') }}</label>
                                        <input type="number" class="form-control" id="profile_views"
                                            name="profile_views"
                                            value="{{ old('profile_views', $profile->profile_views ?? 0) }}" readonly>
                                    </div>
                                </div>

                                <!-- Applications Sent -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="applications_sent"
                                            class="form-label">{{ translate('Applications Sent') }}</label>
                                        <input type="number" class="form-control" id="applications_sent"
                                            name="applications_sent"
                                            value="{{ old('applications_sent', $profile->applications_sent ?? 0) }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Connections -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="connections"
                                            class="form-label">{{ translate('Connections') }}</label>
                                        <input type="number" class="form-control" id="connections" name="connections"
                                            value="{{ old('connections', $profile->connections ?? 0) }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                            </div>
                        </form>
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
        $('body').ready(function() {
            $(document).on('change', '#country', function() {
                var country_id = $(this).val();
                var base_url = $("#base_url").val();
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
                var base_url = $("#base_url").val();
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
