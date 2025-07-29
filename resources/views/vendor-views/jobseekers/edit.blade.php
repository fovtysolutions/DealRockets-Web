@extends('layouts.back-end.app-partialseller')

@section('title', translate('Edit_Vacancies'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ theme_asset('public/assets/custom-css/progress-form.css') }}">
@endpush

@section('content')
    <div class="container mt-5">
        <form method="POST" action="{{ route('vendor.jobvacancy.update', ['id' => $vacancy->id]) }}" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="progress-form-main">
                        <div class="progress-container">
                            <div class="step active">
                                <div class="step-circle">1</div>
                            </div>
                            <div class="step-line"></div>
                            <div class="step">
                                <div class="step-circle">2</div>
                            </div>
                            <div class="step-line"></div>
                            <div class="step">
                                <div class="step-circle">3</div>
                            </div>
                            <div class="step-line"></div>
                            <div class="step">
                                <div class="step-circle">4</div>
                            </div>
                        </div>
                        <div class="form-header">
                            <h1>{{ translate('Edit Vacancy') }}</h1>
                            <p>Update the job vacancy details</p>
                        </div>
                        
                        <!-- Step 1: Basic Job Information -->
                        <div class="step-section" data-step="1">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="title" class="form-label">{{ translate('Job Title') }}</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        value="{{ old('title', $vacancy->title) }}" required>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="category" class="form-label">{{ translate('Category') }}</label>
                                    <select class="form-control" name="category" id="category" required>
                                        <option value="">{{ translate('Select Category') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category', $vacancy->category) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="employment_type" class="form-label">{{ translate('Employment Type') }}</label>
                                    <select class="form-control" name="employment_type" id="employment_type" required>
                                        <option value="full-time" {{ old('employment_type', $vacancy->employment_type) == 'full-time' ? 'selected' : '' }}>
                                            Full-Time</option>
                                        <option value="part-time" {{ old('employment_type', $vacancy->employment_type) == 'part-time' ? 'selected' : '' }}>
                                            Part-Time</option>
                                        <option value="contract" {{ old('employment_type', $vacancy->employment_type) == 'contract' ? 'selected' : '' }}>
                                            Contract</option>
                                        <option value="freelance" {{ old('employment_type', $vacancy->employment_type) == 'freelance' ? 'selected' : '' }}>
                                            Freelance</option>
                                    </select>
                                    @error('employment_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="employment_space" class="form-label">{{ translate('Employment Space') }}</label>
                                    <select class="form-control" name="employment_space" id="employment_space" required>
                                        <option value="work-from-home" {{ old('employment_space', $vacancy->employment_space) == 'work-from-home' ? 'selected' : '' }}>
                                            Work From Home</option>
                                        <option value="in-office" {{ old('employment_space', $vacancy->employment_space) == 'in-office' ? 'selected' : '' }}>
                                            In Office</option>
                                        <option value="hybrid" {{ old('employment_space', $vacancy->employment_space) == 'hybrid' ? 'selected' : '' }}>
                                            Hybrid</option>
                                    </select>
                                    @error('employment_space')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-single">
                                    <label for="description" class="form-label">{{ translate('Description') }}</label>
                                    <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $vacancy->description) }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <button type="button" class="next-btn" data-next="2">Next</button>
                        </div>

                        <!-- Step 2: Salary & Status -->
                        <div class="step-section" data-step="2">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="salary_low" class="form-label">{{ translate('Salary Low') }}</label>
                                    <input type="number" class="form-control" id="salary_low" name="salary_low"
                                        step="0.01" value="{{ old('salary_low', $vacancy->salary_low) }}">
                                    @error('salary_low')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="salary_high" class="form-label">{{ translate('Salary High') }}</label>
                                    <input type="number" class="form-control" id="salary_high" name="salary_high"
                                        step="0.01" value="{{ old('salary_high', $vacancy->salary_high) }}">
                                    @error('salary_high')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="currency" class="form-label">{{ translate('Currency') }}</label>
                                    <input type="text" class="form-control" id="currency" name="currency"
                                     value="{{ old('currency', $vacancy->currency) }}">
                                    @error('currency')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="status" class="form-label">{{ translate('Status') }}</label>
                                    <select class="form-control" name="status" id="status" required>
                                        <option value="active" {{ old('status', $vacancy->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $vacancy->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="closed" {{ old('status', $vacancy->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="vacancies" class="form-label">{{ translate('Number of Vacancies') }}</label>
                                    <input type="number" class="form-control" id="vacancies" name="vacancies"
                                        value="{{ old('vacancies', $vacancy->vacancies ?? 1) }}" min="1" required>
                                    @error('vacancies')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="remote" class="form-label">{{ translate('Remote Work') }}</label>
                                    <select class="form-control" id="remote" name="remote" required>
                                        <option value="0" {{ old('remote', $vacancy->remote) == '0' ? 'selected' : '' }}>{{ translate('No') }}</option>
                                        <option value="1" {{ old('remote', $vacancy->remote) == '1' ? 'selected' : '' }}>{{ translate('Yes') }}</option>
                                    </select>
                                    @error('remote')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <button type="button" class="prev-btn" data-prev="1">Prev</button>
                            <button type="button" class="next-btn" data-next="3">Next</button>
                        </div>

                        <!-- Step 3: Company Information -->
                        <div class="step-section" data-step="3">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="company_name" class="form-label">{{ translate('Company Name') }}</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name"
                                        value="{{ old('company_name', $vacancy->company_name) }}" required>
                                    @error('company_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="company_logo" class="form-label">{{ translate('Company Logo') }}</label>
                                    <input type="file" class="form-control" name="company_logo" id="company_logo" accept="image/*">
                                    @if($vacancy->company_logo)
                                        <div class="mt-2">
                                            <small>Current Logo:</small><br>
                                            <img style="width: 100px; height: 100px; object-fit: cover;" src="/storage/{{ $vacancy->company_logo }}" alt="company logo" />
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="company_employees" class="form-label">{{ translate('Company Employees') }}</label>
                                    <input type="text" class="form-control" id="company_employees" name="company_employees"
                                        value="{{ old('company_employees', $vacancy->company_employees) }}" required>
                                    @error('company_employees')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="company_type" class="form-label">{{ translate('Company Type') }}</label>
                                    <input type="text" class="form-control" id="company_type" name="company_type"
                                        value="{{ old('company_type', $vacancy->company_type) }}" required>
                                    @error('company_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="company_website" class="form-label">{{ translate('Company Website') }}</label>
                                    <input type="url" class="form-control" id="company_website"
                                        name="company_website" value="{{ old('company_website', $vacancy->company_website) }}">
                                    @error('company_website')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="company_email" class="form-label">{{ translate('Company Email') }}</label>
                                    <input type="email" class="form-control" id="company_email"
                                        name="company_email" value="{{ old('company_email', $vacancy->company_email) }}">
                                    @error('company_email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="company_phone" class="form-label">{{ translate('Company Phone') }}</label>
                                    <input type="tel" class="form-control" id="company_phone"
                                        name="company_phone" value="{{ old('company_phone', $vacancy->company_phone) }}">
                                    @error('company_phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="location" class="form-label">{{ translate('Location') }}</label>
                                    <input type="text" class="form-control" id="location" name="location"
                                        value="{{ old('location', $vacancy->location) }}">
                                    @error('location')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-single">
                                    <label for="company_address" class="form-label">{{ translate('Company Address') }}</label>
                                    <textarea class="form-control" id="company_address" name="company_address" rows="3">{{ old('company_address', $vacancy->company_address) }}</textarea>
                                    @error('company_address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <button type="button" class="prev-btn" data-prev="2">Prev</button>
                            <button type="button" class="next-btn" data-next="4">Next</button>
                        </div>
                        
                        <!-- Step 4: Job Requirements & Application Details -->
                        <div class="step-section" data-step="4">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="country" class="form-label">{{ translate('Country') }}</label>
                                    <select type="text" class="form-control" id="country" name="country">
                                        <option value="" name="country">Select a Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" name="{{ $country->iso2 }}"
                                                {{ old('country', $vacancy->country) == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('country')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="state" class="form-label">{{ translate('State') }}</label>
                                    <select type="text" class="form-control" id="state" name="state">
                                        <option value="">Select a Country</option>
                                        @if(isset($states))
                                            @foreach($states as $state)
                                                <option value="{{ $state->id }}" {{ old('state', $vacancy->state) == $state->id ? 'selected' : '' }}>
                                                    {{ $state->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('state')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="city" class="form-label">{{ translate('City') }}</label>
                                    <select type="text" class="form-control" id="city" name="city">
                                        <option value="">Select a State</option>
                                        @if(isset($cities))
                                            @foreach($cities as $city)
                                                <option value="{{ $city->id }}" {{ old('city', $vacancy->city) == $city->id ? 'selected' : '' }}>
                                                    {{ $city->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('city')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="experience_required" class="form-label">{{ translate('Experience Required (in years)') }}</label>
                                    <input type="number" class="form-control" id="experience_required"
                                        name="experience_required" value="{{ old('experience_required', $vacancy->experience_required) }}"
                                        min="0" placeholder="e.g., 3">
                                    @error('experience_required')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="education_level" class="form-label">{{ translate('Education Level') }}</label>
                                    <input type="text" class="form-control" id="education_level"
                                        name="education_level" value="{{ old('education_level', $vacancy->education_level) }}"
                                        placeholder="e.g., Bachelor's Degree">
                                    @error('education_level')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="visa_sponsorship" class="form-label">{{ translate('Visa Sponsorship') }}</label>
                                    <select class="form-control" id="visa_sponsorship" name="visa_sponsorship">
                                        <option value="0" {{ old('visa_sponsorship', $vacancy->visa_sponsorship) == '0' ? 'selected' : '' }}>
                                            {{ translate('No') }}</option>
                                        <option value="1" {{ old('visa_sponsorship', $vacancy->visa_sponsorship) == '1' ? 'selected' : '' }}>
                                            {{ translate('Yes') }}</option>
                                    </select>
                                    @error('visa_sponsorship')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="skills_required" class="form-label">{{ translate('Skills Required') }}</label>
                                    <textarea class="form-control" id="skills_required" name="skills_required" rows="3"
                                        placeholder="e.g., JavaScript, Python, Communication">{{ old('skills_required', $vacancy->skills_required) }}</textarea>
                                    @error('skills_required')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="certifications_required" class="form-label">{{ translate('Certifications Required') }}</label>
                                    <textarea class="form-control" id="certifications_required" name="certifications_required" rows="3"
                                        placeholder="e.g., AWS Certified, PMP">{{ old('certifications_required', $vacancy->certifications_required) }}</textarea>
                                    @error('certifications_required')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="benefits" class="form-label">{{ translate('Benefits') }}</label>
                                    <textarea class="form-control" id="benefits" name="benefits" rows="3"
                                        placeholder="e.g., Health Insurance, 401(k), Paid Time Off">{{ old('benefits', $vacancy->benefits) }}</textarea>
                                    @error('benefits')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="application_deadline" class="form-label">{{ translate('Application Deadline') }}</label>
                                    <input type="date" class="form-control" id="application_deadline"
                                        name="application_deadline" value="{{ old('application_deadline', $vacancy->application_deadline) }}">
                                    @error('application_deadline')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="application_process" class="form-label">{{ translate('Application Process') }}</label>
                                    <textarea class="form-control" id="application_process" name="application_process" rows="3"
                                        placeholder="e.g., Submit resume and cover letter">{{ old('application_process', $vacancy->application_process) }}</textarea>
                                    @error('application_process')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="application_link" class="form-label">{{ translate('Application Link') }}</label>
                                    <input type="url" class="form-control" id="application_link"
                                        name="application_link" value="{{ old('application_link', $vacancy->application_link) }}"
                                        placeholder="e.g., https://company.com/apply">
                                    @error('application_link')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="featured" class="form-label">{{ translate('Featured Job') }}</label>
                                    <select class="form-control" id="featured" name="featured">
                                        <option value="0" {{ old('featured', $vacancy->featured) == '0' ? 'selected' : '' }}>
                                            {{ translate('No') }}</option>
                                        <option value="1" {{ old('featured', $vacancy->featured) == '1' ? 'selected' : '' }}>
                                            {{ translate('Yes') }}</option>
                                    </select>
                                    @error('featured')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <button type="button" class="prev-btn" data-prev="3">Prev</button>
                            <button type="submit" class="submit-btn">{{ translate('Update Vacancy') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/tags-input.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/product-add-update.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/product-add-colors-img.js') }}"></script>
    <script src="{{ theme_asset('public/js/progress-form.js') }}"></script>
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