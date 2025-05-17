<style>
    #employer-post-new-job .res-steps-container .res-steps {
        width: 25%;
        text-align: center;
        float: left;
        cursor: pointer
    }

    #employer-post-new-job .res-steps-container .res-steps .res-step-bar {
        -webkit-border-radius: 50% !important;
        -moz-border-radius: 50% !important;
        -ms-border-radius: 50% !important;
        border-radius: 50% !important;
        background: #0aa7e1;
        display: inline-block;
        height: 40px;
        width: 40px;
        margin-top: 10px;
        text-align: center;
        color: #fff;
        padding-top: 7px;
        font-size: 20px
    }

    #employer-post-new-job .res-steps-container .res-steps .res-progress-title {
        text-align: center;
        font-size: 15px;
        padding-top: 10px;
        display: block
    }

    #employer-post-new-job .res-steps-container .res-steps .res-progress-bar {
        height: 5px;
        background: #0aa7e1;
        width: 50%;
        margin: -22px 0 0 50%;
        float: left
    }

    #employer-post-new-job .res-steps-container .res-step-two .res-progress-bar, #employer-post-new-job .res-steps-container .res-step-three .res-progress-bar, #employer-post-new-job .res-steps-container .res-step-four .res-progress-bar {
        width: 100%;
        margin-left: 0%
    }

    #employer-post-new-job .res-steps-container .res-step-four .res-progress-bar {
        width: 50%;
        margin-right: 50%
    }

    #employer-post-new-job .res-step-form {
        /* border: 1px solid #d2d2d2; */
        /* box-shadow: 0px 6px 4px -2px silver; */
        position:relative;
    }

    #employer-post-new-job .res-step-form h3,
    #employer-post-new-job .res-step-form h4 {
        margin: 10px 0;
        color: #0aa7e1 !important;
        font-size: 18px
    }

    #employer-post-new-job .res-step-form .form-horizontal label {
        font-weight: normal
    }

    /* #employer-post-new-job .res-form-two, #employer-post-new-job .res-form-three, #employer-post-new-job .res-form-four {
        left: 150%
    } */

    #employer-post-new-job .active .res-step-bar {
        background: #f19b20 !important
    }

    #employer-post-new-job .active .res-progress-title {
        color: #0aa7e1
    }
</style>
<div class="modal fade" id="modalJobApply" tabindex="-1" role="dialog" aria-labelledby="modalJobApplyTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalJobApplyTitle">Job Application</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-around mb-3">
                    <button class="btn btn-primary" id="applyResumeButton">Apply by Resume</button>
                    <button class="btn btn-secondary" id="applyFormButton">Apply by Form</button>
                </div>

                <!-- Upload Resume Section -->
                <div id="resumeSection" class="apply-section d-none">
                    <h6>Upload Your Resume</h6>
                    <form id="cvForm" action="{{ route('storecv') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input class="jobidselected" id="jobidselected" name="jobid" value="" type="hidden">
                        <div class="loader" id="loader" style="display: none;"></div>
                        <div class="mb-3">
                            <label for="resumeUpload" class="form-label">Upload Resume</label>
                            <input type="file" class="form-control" id="cv" name="cv" />
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>

                <!-- Fill Form Section -->
                <div id="formSection" class="apply-section d-none">
                    <h6>Fill Out the Application Form</h6>
                    <form action="{{ route('apply_by_form') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input class="jobidselected" id="jobidselected" name="jobid" value="" type="hidden">
                        <section id="employer-post-new-job">
                            <div>
                                <div>
                                    <div>
                                    <div class="col-xs-10 col-xs-offset-1" id="container">
                                        <div class="res-steps-container">
                                            <div class="res-steps res-step-one active" data-class=".res-form-one">
                                                <div class="res-step-bar">1</div>
                                                <div class="res-progress-bar"></div>
                                                <div class="res-progress-title">Personal Information</div>
                                            </div>
                                            <div class="res-steps res-step-two" data-class=".res-form-two">
                                                <div class="res-step-bar">2</div>
                                                <div class="res-progress-bar"></div>
                                                <div class="res-progress-title">Skills/Education</div>
                                            </div>
                                            <div class="res-steps res-step-three" data-class=".res-form-three">
                                                <div class="res-step-bar">3</div>
                                                <div class="res-progress-bar"></div>
                                                <div class="res-progress-title">Previous Records</div>
                                            </div>
                                            <div class="res-steps res-step-four" data-class=".res-form-four">
                                                <div class="res-step-bar">4</div>
                                                <div class="res-progress-bar"></div>
                                                <div class="res-progress-title">Additional Information</div>
                                            </div>
                                        </div>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="clearfix">&nbsp;</div>
        
                                        <div class="res-step-form col-md-12 col-md-offset-2 res-form-one">
                                            <h3 class="text-center">Personal Information</h3>
                                            <h4 class="mb-3 text-primary">{{ translate('Personal Details') }}</h4>
                                            <form class="form-horizontal">
                                                <div class="row">
                                                    <div class="col">
                                                        <!-- Personal Information -->
                                                        <div class="form-group">
                                                            <label for="full_name" class="col-sm-8 control-label">{{ translate('Full Name') }}</label>
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control" id="full_name" name="full_name"
                                                                    value="{{ old('full_name', $profile->full_name ?? '') }}" placeholder="Enter your full name" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="date_of_birth" class="col-sm-8 control-label">{{ translate('Date of Birth') }}</label>
                                                            <div class="col-sm-12">
                                                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                                                    value="{{ old('date_of_birth', $profile->date_of_birth ?? '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="gender" class="col-sm-8 control-label">{{ translate('Gender') }}</label>
                                                            <div class="col-sm-12">
                                                                <select class="form-control" id="gender" name="gender">
                                                                    <option value="" disabled selected>{{ translate('Select Gender') }}</option>
                                                                    <option value="male" {{ old('gender', $profile->gender ?? '') == 'male' ? 'selected' : '' }}>{{ translate('Male') }}</option>
                                                                    <option value="female" {{ old('gender', $profile->gender ?? '') == 'female' ? 'selected' : '' }}>{{ translate('Female') }}</option>
                                                                    <option value="other" {{ old('gender', $profile->gender ?? '') == 'other' ? 'selected' : '' }}>{{ translate('Other') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Contact Information -->
                                                <h4 class="mb-3 text-primary">{{ translate('Contact Information') }}</h4>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="phone" class="col-sm-8 control-label">{{ translate('Phone') }}</label>
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control" id="phone" name="phone"
                                                                    value="{{ old('phone', $profile->phone ?? '') }}" placeholder="Enter your phone number">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="alternate_phone" class="col-sm-8 control-label">{{ translate('Alternate Phone') }}</label>
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control" id="alternate_phone" name="alternate_phone"
                                                                    value="{{ old('alternate_phone', $profile->alternate_phone ?? '') }}" placeholder="Enter an alternate phone number">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="email" class="col-sm-8 control-label">{{ translate('Email') }}</label>
                                                            <div class="col-sm-12">
                                                                <input type="email" class="form-control" id="email" name="email"
                                                                    value="{{ old('email', $profile->email ?? '') }}" placeholder="Enter your email address">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="alternate_email" class="col-sm-8 control-label">{{ translate('Alternate Email') }}</label>
                                                            <div class="col-sm-12">
                                                                <input type="email" class="form-control" id="alternate_email" name="alternate_email"
                                                                    value="{{ old('alternate_email', $profile->alternate_email ?? '') }}" placeholder="Enter an alternate email address">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="address" class="col-sm-8 control-label">{{ translate('Address') }}</label>
                                                            <div class="col-sm-12">
                                                                <textarea class="form-control" id="address" name="address" rows="2" placeholder="Enter your address">{{ old('address', $profile->address ?? '') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="postal_code" class="col-sm-8 control-label">{{ translate('Postal Code') }}</label>
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control" id="postal_code" name="postal_code"
                                                                    value="{{ old('postal_code', $profile->postal_code ?? '') }}" placeholder="Enter your postal code">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Location Information -->
                                                <h4 class="mb-3 text-primary">{{ translate('Location Information') }}</h4>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="country" class="col-sm-8 control-label">{{ translate('Country') }}</label>
                                                            <div class="col-sm-12">
                                                                <select class="form-control" id="countrynew" name="country">
                                                                    <option value="">Select a Country</option>
                                                                    @foreach ($countries as $country)
                                                                        <option value="{{ $country->id }}" {{ old('country', $profile->country ?? '') == $country->id ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="state" class="col-sm-8 control-label">{{ translate('State') }}</label>
                                                            <div class="col-sm-12">
                                                                <select class="form-control" id="statenew" name="state">
                                                                    <option value="">Select a State</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="city" class="col-sm-8 control-label">{{ translate('City') }}</label>
                                                            <div class="col-sm-12">
                                                                <select class="form-control" id="citynew" name="city">
                                                                    <option value="">Select a City</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="text-center">
                                                            <button type="button" class="btn btn-primary col-xs-offset-1 btn res-btn-orange" data-class=".res-form-one">Next</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
        
                                        <div class="res-step-form col-md-12 col-md-offset-2 res-form-two" style="display: none;">
                                            <h3 class="text-center">Skills &amp; Information</h3>
                                            <form class="form-horizontal">
                                                <!-- Education Information -->
                                                <h4 class="mb-3 text-primary">{{ translate('Education Information') }}</h4>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="highest_education" class="col-sm-8 control-label">{{ translate('Highest Education') }}</label>
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control" id="highest_education" name="highest_education"
                                                                    value="{{ old('highest_education', $profile->highest_education ?? '') }}" placeholder="Enter your highest education">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="field_of_study" class="col-sm-8 control-label">{{ translate('Field of Study') }}</label>
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control" id="field_of_study" name="field_of_study"
                                                                    value="{{ old('field_of_study', $profile->field_of_study ?? '') }}" placeholder="Enter your field of study">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="university_name" class="col-sm-8 control-label">{{ translate('University Name') }}</label>
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control" id="university_name" name="university_name"
                                                                    value="{{ old('university_name', $profile->university_name ?? '') }}" placeholder="Enter your university name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Skills and Additional Information -->
                                                <h4 class="mb-3 text-primary">{{ translate('Skills and Additional Information') }}</h4>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="skills" class="col-sm-8 control-label">{{ translate('Skills') }}</label>
                                                            <div class="col-sm-12">
                                                                <textarea class="form-control" id="skills" name="skills" rows="3" placeholder="List your skills">{{ old('skills', $profile->skills ?? '') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="languages" class="col-sm-8 control-label">{{ translate('Languages') }}</label>
                                                            <div class="col-sm-12">
                                                                <textarea class="form-control" id="languages" name="languages" rows="3" placeholder="List the languages you speak">{{ old('languages', $profile->languages ?? '') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="certifications" class="col-sm-8 control-label">{{ translate('Certifications') }}</label>
                                                            <div class="col-sm-12">
                                                                <textarea class="form-control" id="certifications" name="certifications" rows="3" placeholder="List your certifications">{{ old('certifications', $profile->certifications ?? '') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h4 class="mb-3 text-primary">{{ translate('Bio and Professional Information') }}</h4>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="bio" class="col-sm-8 control-label">{{ translate('Bio') }}</label>
                                                            <div class="col-sm-12">
                                                                <textarea class="form-control" id="bio" name="bio" rows="3"
                                                                    placeholder="{{ translate('Write a short bio') }}">{{ old('bio', $profile->bio ?? '') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="linkedin_profile" class="col-sm-8 control-label">{{ translate('LinkedIn Profile') }}</label>
                                                            <div class="col-sm-12">
                                                                <input type="url" class="form-control" id="linkedin_profile" name="linkedin_profile"
                                                                    value="{{ old('linkedin_profile', $profile->linkedin_profile ?? '') }}"
                                                                    placeholder="{{ translate('Enter your LinkedIn profile URL') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="portfolio_url" class="col-sm-8 control-label">{{ translate('Portfolio URL') }}</label>
                                                            <div class="col-sm-12">
                                                                <input type="url" class="form-control" id="portfolio_url" name="portfolio_url"
                                                                    value="{{ old('portfolio_url', $profile->portfolio_url ?? '') }}"
                                                                    placeholder="{{ translate('Enter your portfolio URL') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                <div class="text-center">
                                                        <button type="button" class="btn btn-primary btn res-btn-gray" data-class=".res-form-two">Back</button>
                                                        <button type="button" class="btn btn-primary col-xs-offset-1 btn res-btn-orange" data-class=".res-form-two">Next</button>
                                                </div>
                                                </div>
                                            </form>
                                        </div>
        
                                        <div class="res-step-form col-md-12 col-md-offset-2 res-form-three" style="display: none;">
                                            <h3 class="text-center">Previous Employer / Records</h3>
                                            <form class="form-horizontal">
                                                <!-- Employment Details -->
                                                <h4 class="mb-3 text-primary">{{ translate('Employment Details') }}</h4>
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="years_of_experience" class="col-sm-8 control-label">{{ translate('Years of Experience') }}</label>
                                                            <div class="col-sm-12">
                                                                <input type="number" class="form-control" id="years_of_experience" name="years_of_experience"
                                                                    value="{{ old('years_of_experience', $profile->years_of_experience ?? '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="current_position" class="col-sm-8 control-label">{{ translate('Current Position') }}</label>
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control" id="current_position" name="current_position"
                                                                    value="{{ old('current_position', $profile->current_position ?? '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="current_employer" class="col-sm-8 control-label">{{ translate('Current Employer') }}</label>
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control" id="current_employer" name="current_employer"
                                                                    value="{{ old('current_employer', $profile->current_employer ?? '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Preferences -->
                                                <h4 class="mb-3 text-primary">{{ translate('Preferences') }}</h4>
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="desired_position" class="col-sm-8 control-label">{{ translate('Desired Position') }}</label>
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control" id="desired_position" name="desired_position"
                                                                    value="{{ old('desired_position', $profile->desired_position ?? '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="employment_type" class="col-sm-8 control-label">{{ translate('Employment Type') }}</label>
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control" id="employment_type" name="employment_type"
                                                                    value="{{ old('employment_type', $profile->employment_type ?? '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="desired_salary" class="col-sm-8 control-label">{{ translate('Desired Salary') }}</label>
                                                            <div class="col-sm-12">
                                                                <input type="number" step="0.01" class="form-control" id="desired_salary" name="desired_salary"
                                                                    value="{{ old('desired_salary', $profile->desired_salary ?? '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Additional Information -->
                                                <h4 class="mb-3 text-primary">{{ translate('Additional Information') }}</h4>
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="relocation" class="col-sm-8 control-label">{{ translate('Relocation') }}</label>
                                                            <div class="col-sm-12">
                                                                <select class="form-control" id="relocation" name="relocation">
                                                                    <option value="1" {{ old('relocation', $profile->relocation ?? 0) == 1 ? 'selected' : '' }}>
                                                                        {{ translate('Yes') }}
                                                                    </option>
                                                                    <option value="0" {{ old('relocation', $profile->relocation ?? 0) == 0 ? 'selected' : '' }}>
                                                                        {{ translate('No') }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="open_to_remote" class="col-sm-8 control-label">{{ translate('Open to Remote') }}</label>
                                                            <div class="col-sm-12">
                                                                <select class="form-control" id="open_to_remote" name="open_to_remote">
                                                                    <option value="1" {{ old('open_to_remote', $profile->open_to_remote ?? 0) == 1 ? 'selected' : '' }}>
                                                                        {{ translate('Yes') }}
                                                                    </option>
                                                                    <option value="0" {{ old('open_to_remote', $profile->open_to_remote ?? 0) == 0 ? 'selected' : '' }}>
                                                                        {{ translate('No') }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="availability_date" class="col-sm-8 control-label">{{ translate('Availability Date') }}</label>
                                                            <div class="col-sm-12">
                                                                <input type="date" class="form-control" id="availability_date" name="availability_date"
                                                                    value="{{ old('availability_date', $profile->availability_date ?? '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                <div class="text-center">
                                                        <button type="button" class="btn btn-primary btn res-btn-gray" data-class=".res-form-three">Back</button>
                                                        <button type="button" class="btn btn-primary col-xs-offset-1 btn res-btn-orange" data-class=".res-form-three">Next</button>
                                                </div>
                                                </div>
                                            </form>
                                        </div>
        
                                        <div class="res-step-form col-md-12 col-md-offset-2 res-form-four" style="display: none;">
                                            <h3 class="text-center">Additional Details</h3>
                                            <form class="form-horizontal">
                                                <h4 class="mb-3 text-primary">{{ translate('Critical Information') }}</h4>
                                                <div class="row">
                                                    <div class="col">
                                                        <!-- Open to Contract -->
                                                        <div class="form-group">
                                                            <label for="open_to_contract" class="col-sm-8 control-label">{{ translate('Open to Contract') }}</label>
                                                            <div class="col-sm-12">
                                                                <select class="form-control" id="open_to_contract" name="open_to_contract">
                                                                    <option value="1" {{ old('open_to_contract', $profile->open_to_contract ?? 0) == 1 ? 'selected' : '' }}>
                                                                        {{ translate('Yes') }}
                                                                    </option>
                                                                    <option value="0" {{ old('open_to_contract', $profile->open_to_contract ?? 0) == 0 ? 'selected' : '' }}>
                                                                        {{ translate('No') }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <!-- GitHub Profile -->
                                                        <div class="form-group">
                                                            <label for="github_profile" class="col-sm-8 control-label">{{ translate('GitHub Profile') }}</label>
                                                            <div class="col-sm-12">
                                                                <input type="url" class="form-control" id="github_profile" name="github_profile"
                                                                    value="{{ old('github_profile', $profile->github_profile ?? '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                                                                           
                                                    <div class="col">
                                                        <!-- Behance Profile -->
                                                        <div class="form-group">
                                                            <label for="behance_profile" class="col-sm-8 control-label">{{ translate('Behance Profile') }}</label>
                                                            <div class="col-sm-12">
                                                                <input type="url" class="form-control" id="behance_profile" name="behance_profile"
                                                                    value="{{ old('behance_profile', $profile->behance_profile ?? '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <h4 class="mb-3 text-primary">{{ translate('Work Information') }}</h4>
                                                    <div class="col">
                                                        <!-- Twitter Profile -->
                                                        <div class="form-group">
                                                            <label for="twitter_profile" class="col-sm-8 control-label">{{ translate('Twitter Profile') }}</label>
                                                            <div class="col-sm-12">
                                                                <input type="url" class="form-control" id="twitter_profile" name="twitter_profile"
                                                                    value="{{ old('twitter_profile', $profile->twitter_profile ?? '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <!-- Personal Website -->
                                                        <div class="form-group">
                                                            <label for="personal_website" class="col-sm-8 control-label">{{ translate('Personal Website') }}</label>
                                                            <div class="col-sm-12">
                                                                <input type="url" class="form-control" id="personal_website" name="personal_website"
                                                                    value="{{ old('personal_website', $profile->personal_website ?? '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <!-- Portfolio Items -->
                                                        <div class="form-group">
                                                            <label for="portfolio_items" class="col-sm-8 control-label">{{ translate('Portfolio Items') }}</label>
                                                            <div class="col-sm-12">
                                                                <textarea class="form-control" id="portfolio_items" name="portfolio_items" rows="3"
                                                                    placeholder="{{ translate('List your portfolio items') }}">{{ old('portfolio_items', $profile->portfolio_items ?? '') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <!-- Videos -->
                                                        <div class="form-group">
                                                            <label for="videos" class="col-sm-8 control-label">{{ translate('Videos') }}</label>
                                                            <div class="col-sm-12">
                                                                <textarea class="form-control" id="videos" name="videos" rows="3"
                                                                    placeholder="{{ translate('Add links to your videos') }}">{{ old('videos', $profile->videos ?? '') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                    <div class="form-group">
                                                        <div class="text-center">
                                                            <button type="button" class="btn btn-primary btn res-btn-gray" data-class=".res-form-four">Back</button>
                                                            <button type="submit" class="btn btn-primary col-xs-offset-1 btn res-btn-orange" data-class=".res-form-four">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        var steps = ['.res-step-one','.res-step-two','.res-step-three','.res-step-four'];
        var i = 1;

        $(".res-step-form .res-btn-orange").click(function(){
            var getClass = $(this).attr('data-class');
            $(".res-steps").removeClass('active');
            $(steps[i]).addClass('active');
            i++;
            if(getClass != ".res-form-four"){
                $(getClass).animate({
                    opacity: 0
                }, 500, function(){
                    $(getClass).css('display', 'none');
                });
                $(getClass).next().css('display', 'block').animate({
                    opacity: 1
                }, 500);
            }
        });

        /* step back */
        $(".res-step-form .res-btn-gray").click(function(){
            var getClass = $(this).attr('data-class');
            $(".res-steps").removeClass('active');
            i--;
            $(steps[i-1]).addClass('active');
            $(getClass).animate({
                opacity: 0
            }, 500, function(){
                $(getClass).css('display', 'none');
            });
            $(getClass).prev().css('display', 'block').animate({
                opacity: 1
            }, 500);
        });

        /* click from top bar steps */
        $('.res-step-one').click(function(){
            if(!$(this).hasClass('active')){
                $(".res-steps").removeClass('active');
                i = 0;
                $(steps[i]).addClass('active');
                i++;
                $('.res-form-one').css('display', 'block').animate({
                    opacity: 1
                }, 500);
                $('.res-form-two, .res-form-three, .res-form-four').css('display', 'none').css('opacity', 0);
            }
        });

        $('.res-step-two').click(function(){
            if(!$(this).hasClass('active')){
                $(".res-steps").removeClass('active');
                i = 1;
                $(steps[i]).addClass('active');
                i++;
                $('.res-form-two').css('display', 'block').animate({
                    opacity: 1
                }, 500);
                $('.res-form-one, .res-form-three, .res-form-four').css('display', 'none').css('opacity', 0);
            }
        });

        $('.res-step-three').click(function(){
            if(!$(this).hasClass('active')){
                $(".res-steps").removeClass('active');
                i = 2;
                $(steps[i]).addClass('active');
                i++;
                $('.res-form-three').css('display', 'block').animate({
                    opacity: 1
                }, 500);
                $('.res-form-one, .res-form-two, .res-form-four').css('display', 'none').css('opacity', 0);
            }
        });

        $('.res-step-four').click(function(){
            if(!$(this).hasClass('active')){
                $(".res-steps").removeClass('active');
                i = 3;
                $(steps[i]).addClass('active');
                i++;
                $('.res-form-four').css('display', 'block').animate({
                    opacity: 1
                }, 500);
                $('.res-form-one, .res-form-two, .res-form-three').css('display', 'none').css('opacity', 0);
            }
        });
    });
</script>