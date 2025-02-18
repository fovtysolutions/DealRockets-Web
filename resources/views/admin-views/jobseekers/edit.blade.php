@extends('layouts.back-end.app')

@section('title', translate('Edit_Vacancies'))

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
                        <h5 class="card-title">{{ translate('Edit Vacancy') }}</h5>
                    </div>
                    <div class="card-body">
                        <!-- Edit Job Vacancy Form -->
                        <form method="POST" action="{{ route('admin.jobvacancy.update', ['id' => $vacancy->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col">
                                            <!-- Job Title -->
                                            <div class="form-group">
                                                <label for="title">{{ translate('Job Title') }}</label>
                                                <input type="text" class="form-control" id="title" name="title"
                                                    value="{{ old('title', $vacancy->title) }}" required>
                                                @error('title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <!-- Employment Type -->
                                            <div class="form-group">
                                                <label for="employment_type">{{ translate('Employment Type') }}</label>
                                                <select class="form-control" name="employment_type" id="employment_type"
                                                    required>
                                                    <option value="full-time"
                                                        {{ old('employment_type', $vacancy->employment_type) == 'full-time' ? 'selected' : '' }}>
                                                        Full-Time</option>
                                                    <option value="part-time"
                                                        {{ old('employment_type', $vacancy->employment_type) == 'part-time' ? 'selected' : '' }}>
                                                        Part-Time</option>
                                                    <option value="contract"
                                                        {{ old('employment_type', $vacancy->employment_type) == 'contract' ? 'selected' : '' }}>
                                                        Contract</option>
                                                    <option value="freelance"
                                                        {{ old('employment_type', $vacancy->employment_type) == 'freelance' ? 'selected' : '' }}>
                                                        Freelance</option>
                                                </select>
                                                @error('employment_type')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Description -->
                                    <div class="form-group">
                                        <label for="description">{{ translate('Description') }}</label>
                                        <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $vacancy->description) }}</textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <!-- Salary -->
                                    <div class="form-group">
                                        <label for="salary">{{ translate('Salary') }}</label>
                                        <input type="number" class="form-control" id="salary" name="salary"
                                            step="0.01" value="{{ old('salary', $vacancy->salary) }}">
                                        @error('salary')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col">
                                    <!-- Status -->
                                    <div class="form-group">
                                        <label for="status">{{ translate('Status') }}</label>
                                        <select class="form-control" name="status" id="status" required>
                                            <option value="active"
                                                {{ old('status', $vacancy->status) == 'active' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="inactive"
                                                {{ old('status', $vacancy->status) == 'inactive' ? 'selected' : '' }}>
                                                Inactive
                                            </option>
                                            <option value="closed"
                                                {{ old('status', $vacancy->status) == 'closed' ? 'selected' : '' }}>Closed
                                            </option>
                                        </select>
                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col">
                                    <!-- Category -->
                                    <div class="form-group">
                                        <label for="category">{{ translate('Category') }}</label>
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
                            </div>

                            <div class="row">
                                <div class="col">
                                    <!-- Company Name -->
                                    <div class="form-group">
                                        <label for="company_name">{{ translate('Company Name') }}</label>
                                        <input type="text" class="form-control" id="company_name" name="company_name"
                                            value="{{ old('company_name', $vacancy->company_name) }}" required>
                                        @error('company_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Company Logo -->
                                    <div class="form-group">
                                        <label for="company_logo">{{ translate('Company Logo') }}</label>
                                        <input type="file" class="form-control" name="company_logo" id="company_logo"
                                            accept="image/*">
                                    </div>
                                    <div>
                                        Current Logo:
                                        <img style="width: 250px; height:250px; aspect-ratio: 4/3;" src="/storage/{{ old('company_logo', $vacancy->company_logo) }}" alt="company logo" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <!-- Company Address -->
                                    <div class="form-group">
                                        <label for="company_address">{{ translate('Company Address') }}</label>
                                        <textarea class="form-control" id="company_address" name="company_address" rows="3">{{ old('company_address', $vacancy->company_address) }}</textarea>
                                        @error('company_address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <!-- Company Website -->
                                    <div class="form-group">
                                        <label for="company_website">{{ translate('Company Website') }}</label>
                                        <input type="url" class="form-control" id="company_website"
                                            name="company_website"
                                            value="{{ old('company_website', $vacancy->company_website) }}">
                                        @error('company_website')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Company Email -->
                                    <div class="form-group">
                                        <label for="company_email">{{ translate('Company Email') }}</label>
                                        <input type="email" class="form-control" id="company_email"
                                            name="company_email"
                                            value="{{ old('company_email', $vacancy->company_email) }}">
                                        @error('company_email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Company Phone -->
                                    <div class="form-group">
                                        <label for="company_phone">{{ translate('Company Phone') }}</label>
                                        <input type="tel" class="form-control" id="company_phone"
                                            name="company_phone"
                                            value="{{ old('company_phone', $vacancy->company_phone) }}">
                                        @error('company_phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Vacancies -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="vacancies">{{ translate('Number of Vacancies') }}</label>
                                        <input type="number" class="form-control" id="vacancies" name="vacancies"
                                            value="{{ old('vacancies', $vacancy->vacancies) }}" min="1" required>
                                        @error('vacancies')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Location -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="location">{{ translate('Location') }}</label>
                                        <input type="text" class="form-control" id="location" name="location"
                                            value="{{ old('location', $vacancy->location) }}">
                                        @error('location')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Remote -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="remote">{{ translate('Remote Work') }}</label>
                                        <select class="form-control" id="remote" name="remote" required>
                                            <option value="0"
                                                {{ old('remote', $vacancy->remote) == '0' ? 'selected' : '' }}>
                                                {{ translate('No') }}</option>
                                            <option value="1"
                                                {{ old('remote', $vacancy->remote) == '1' ? 'selected' : '' }}>
                                                {{ translate('Yes') }}</option>
                                        </select>
                                        @error('remote')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Country -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="country">{{ translate('Country') }}</label>
                                        <select class="form-control" id="country" name="country">
                                            <option value="{{$vacancy->country ?? ''}}">{{ \App\Utils\ChatManager::getCountryDetails($vacancy->country)['countryName'] ?? 'Select a Country' }}</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ old('country', $vacancy->country) == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('country')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- State -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="state">{{ translate('State') }}</label>
                                        <select class="form-control" id="state" name="state">
                                            @if(isset($vacancy->state))
                                                <option value="{{ $vacancy->state }}" selected>{{ \App\Models\State::where('id',$vacancy->state)->first()->name ?? 'Invalid State Id' }}</option>
                                            @else
                                                <option value="" selected>ReSelect a Country</option>
                                            @endif
                                        </select>
                                        @error('state')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- City -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="city">{{ translate('City') }}</label>
                                        <select class="form-control" id="city" name="city">
                                            @if(isset($vacancy->city))
                                                <option value="{{ $vacancy->city }}" selected>{{ \App\Models\State::where('id',$vacancy->city)->first()->name ?? 'Invalid City Id' }}</option>
                                            @else
                                                <option value="" selected>ReSelect a State</option>
                                            @endif
                                        </select>
                                        @error('city')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Experience Required -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label
                                            for="experience_required">{{ translate('Experience Required (in years)') }}</label>
                                        <input type="number" class="form-control" id="experience_required"
                                            name="experience_required"
                                            value="{{ old('experience_required', $vacancy->experience_required) }}"
                                            min="0" placeholder="e.g., 3">
                                        @error('experience_required')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Education Level -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="education_level">{{ translate('Education Level') }}</label>
                                        <input type="text" class="form-control" id="education_level"
                                            name="education_level"
                                            value="{{ old('education_level', $vacancy->education_level) }}"
                                            placeholder="e.g., Bachelor's Degree">
                                        @error('education_level')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Visa Sponsorship -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="visa_sponsorship">{{ translate('Visa Sponsorship') }}</label>
                                        <select class="form-control" id="visa_sponsorship" name="visa_sponsorship">
                                            <option value="0"
                                                {{ old('visa_sponsorship', $vacancy->visa_sponsorship) == '0' ? 'selected' : '' }}>
                                                {{ translate('No') }}</option>
                                            <option value="1"
                                                {{ old('visa_sponsorship', $vacancy->visa_sponsorship) == '1' ? 'selected' : '' }}>
                                                {{ translate('Yes') }}</option>
                                        </select>
                                        @error('visa_sponsorship')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Skills Required -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="skills_required">{{ translate('Skills Required') }}</label>
                                        <textarea class="form-control" id="skills_required" name="skills_required" rows="3"
                                            placeholder="e.g., JavaScript, Python, Communication">{{ old('skills_required', $vacancy->skills_required) }}</textarea>
                                        @error('skills_required')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Certifications Required -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            for="certifications_required">{{ translate('Certifications Required') }}</label>
                                        <textarea class="form-control" id="certifications_required" name="certifications_required" rows="3"
                                            placeholder="e.g., AWS Certified, PMP">{{ old('certifications_required', $vacancy->certifications_required) }}</textarea>
                                        @error('certifications_required')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <!-- Benefits -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="benefits">{{ translate('Benefits') }}</label>
                                        <textarea class="form-control" id="benefits" name="benefits" rows="3"
                                            placeholder="e.g., Health Insurance, 401(k), Paid Time Off">{{ old('benefits', $vacancy->benefits) }}</textarea>
                                        @error('benefits')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Application Deadline -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="application_deadline">{{ translate('Application Deadline') }}</label>
                                        <input type="date" class="form-control" id="application_deadline"
                                            name="application_deadline"
                                            value="{{ old('application_deadline', $vacancy->application_deadline) }}">
                                        @error('application_deadline')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Application Process -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="application_process">{{ translate('Application Process') }}</label>
                                        <textarea class="form-control" id="application_process" name="application_process" rows="3"
                                            placeholder="e.g., Submit resume and cover letter">{{ old('application_process', $vacancy->application_process) }}</textarea>
                                        @error('application_process')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Application Link -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="application_link">{{ translate('Application Link') }}</label>
                                        <input type="url" class="form-control" id="application_link"
                                            name="application_link"
                                            value="{{ old('application_link', $vacancy->application_link) }}"
                                            placeholder="e.g., https://company.com/apply">
                                        @error('application_link')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Featured -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="featured">{{ translate('Featured Job') }}</label>
                                        <select class="form-control" id="featured" name="featured">
                                            <option value="0"
                                                {{ old('featured', $vacancy->featured) == '0' ? 'selected' : '' }}>
                                                {{ translate('No') }}
                                            </option>
                                            <option value="1"
                                                {{ old('featured', $vacancy->featured) == '1' ? 'selected' : '' }}>
                                                {{ translate('Yes') }}
                                            </option>
                                        </select>
                                        @error('featured')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">{{ translate('Update Vacancy') }}</button>
                        </form>
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
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
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
