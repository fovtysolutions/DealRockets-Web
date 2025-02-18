<h4>Create Job</h4>
<form action="{{ route('customer-create-job') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col">
                    <!-- Job Title -->
                    <div class="form-group">
                        <label for="title">{{ translate('Job Title') }}</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="{{ old('title') }}" required>
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
                        <select class="form-control" name="employment_type" id="employment_type" required>
                            <option value="full-time" {{ old('employment_type') == 'full-time' ? 'selected' : '' }}>
                                Full-Time</option>
                            <option value="part-time" {{ old('employment_type') == 'part-time' ? 'selected' : '' }}>
                                Part-Time</option>
                            <option value="contract" {{ old('employment_type') == 'contract' ? 'selected' : '' }}>
                                Contract</option>
                            <option value="freelance" {{ old('employment_type') == 'freelance' ? 'selected' : '' }}>
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
                <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
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
                <input type="number" class="form-control" id="salary" name="salary" step="0.01"
                    value="{{ old('salary') }}">
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
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                    </option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                        Inactive
                    </option>
                    <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed
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
                        <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>
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
                    value="{{ old('company_name') }}" required>
                @error('company_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col">
            <!-- Company Logo -->
            <div class="form-group">
                <label for="company_logo">{{ translate('Company Logo') }}</label>
                <input type="file" class="form-control" name="company_logo" id="company_logo">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <!-- Company Address -->
            <div class="form-group">
                <label for="company_address">{{ translate('Company Address') }}</label>
                <textarea class="form-control" id="company_address" name="company_address" rows="3">{{ old('company_address') }}</textarea>
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
                <input type="url" class="form-control" id="company_website" name="company_website"
                    value="{{ old('company_website') }}">
                @error('company_website')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col">
            <!-- Company Email -->
            <div class="form-group">
                <label for="company_email">{{ translate('Company Email') }}</label>
                <input type="email" class="form-control" id="company_email" name="company_email"
                    value="{{ old('company_email') }}">
                @error('company_email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col">
            <!-- Company Phone -->
            <div class="form-group">
                <label for="company_phone">{{ translate('Company Phone') }}</label>
                <input type="tel" class="form-control" id="company_phone" name="company_phone"
                    value="{{ old('company_phone') }}">
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
                    value="{{ old('vacancies', 1) }}" min="1" required>
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
                    value="{{ old('location') }}">
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
                    <option value="0" {{ old('remote') == '0' ? 'selected' : '' }}>
                        {{ translate('No') }}</option>
                    <option value="1" {{ old('remote') == '1' ? 'selected' : '' }}>
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
                <label for="country" class="form-label">{{ translate('Country') }}</label>
                <select type="text" class="form-control" id="countrynew" name="country">
                    <option value="" name="country">Select a Country</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}" name="{{ $country->short_name }}">
                            {{ $country->country_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="state" class="form-label">{{ translate('State') }}</label>
                <select type="text" class="form-control" id="statenew" name="state">
                    <option value="">Select a Country</option>
                </select>

            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="city" class="form-label">{{ translate('City') }}</label>
                <select type="text" class="form-control" id="citynew" name="city">
                    <option value="">Select a State</option>
                </select>

            </div>
        </div>
    </div>
    <div class="row">
        <!-- Experience Required -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="experience_required">{{ translate('Experience Required (in years)') }}</label>
                <input type="number" class="form-control" id="experience_required" name="experience_required"
                    value="{{ old('experience_required') }}" min="0" placeholder="e.g., 3">
                @error('experience_required')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Education Level -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="education_level">{{ translate('Education Level') }}</label>
                <input type="text" class="form-control" id="education_level" name="education_level"
                    value="{{ old('education_level') }}" placeholder="e.g., Bachelor's Degree">
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
                    <option value="0" {{ old('visa_sponsorship') == '0' ? 'selected' : '' }}>
                        {{ translate('No') }}</option>
                    <option value="1" {{ old('visa_sponsorship') == '1' ? 'selected' : '' }}>
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
                    placeholder="e.g., JavaScript, Python, Communication">{{ old('skills_required') }}</textarea>
                @error('skills_required')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Certifications Required -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="certifications_required">{{ translate('Certifications Required') }}</label>
                <textarea class="form-control" id="certifications_required" name="certifications_required" rows="3"
                    placeholder="e.g., AWS Certified, PMP">{{ old('certifications_required') }}</textarea>
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
                    placeholder="e.g., Health Insurance, 401(k), Paid Time Off">{{ old('benefits') }}</textarea>
                @error('benefits')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Application Deadline -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="application_deadline">{{ translate('Application Deadline') }}</label>
                <input type="date" class="form-control" id="application_deadline" name="application_deadline"
                    value="{{ old('application_deadline') }}">
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
                    placeholder="e.g., Submit resume and cover letter">{{ old('application_process') }}</textarea>
                @error('application_process')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Application Link -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="application_link">{{ translate('Application Link') }}</label>
                <input type="url" class="form-control" id="application_link" name="application_link"
                    value="{{ old('application_link') }}" placeholder="e.g., https://company.com/apply">
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
                    <option value="0" {{ old('featured') == '0' ? 'selected' : '' }}>
                        {{ translate('No') }}</option>
                    <option value="1" {{ old('featured') == '1' ? 'selected' : '' }}>
                        {{ translate('Yes') }}</option>
                </select>
                @error('featured')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary">{{ translate('Add Vacancy') }}</button>
</form>
<script>
    function populateState() {
        const country_id = document.getElementById('countrynew').value;
        const base_url = window.location.origin;
        // Reset state and city dropdowns
        const stateDropdown = document.getElementById('statenew');
        const cityDropdown = document.getElementById('citynew');

        stateDropdown.innerHTML = '<option value="">Select State</option>';
        cityDropdown.innerHTML = '<option value="">Select City</option>';

        // Fetch states based on selected country
        fetch(`${base_url}/get-state-by-id/${country_id}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(obj => {
                    const option = document.createElement('option');
                    option.value = obj.id;
                    option.textContent = obj.name;
                    stateDropdown.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching states:', error));
    }

    function populateCity(state) {
        const state_id = document.getElementById('statenew').value;
        const base_url = window.location.origin;
        // Reset city dropdown
        const cityDropdown = document.getElementById('citynew');
        cityDropdown.innerHTML = '<option value="">Select City</option>';

        // Fetch cities based on selected state
        fetch(`${base_url}/get-city-by-id/${state_id}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(obj => {
                    const option = document.createElement('option');
                    option.value = obj.id;
                    option.textContent = obj.name;
                    cityDropdown.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching cities:', error));
    }
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('countrynew').addEventListener('change', populateState);
        document.getElementById('statenew').addEventListener('change', populateCity);
    });
</script>
