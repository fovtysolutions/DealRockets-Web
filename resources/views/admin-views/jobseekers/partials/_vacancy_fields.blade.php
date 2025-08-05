@php
    $isEdit = isset($vacancy);
@endphp

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
        <h1>{{ $isEdit ? 'Edit Vacancy' : 'Create Vacancy' }}</h1>
        <p>{{ $isEdit ? 'Update the details of your Job Vacancy' : 'Fill in the required details to create Job Vacancy' }}
        </p>
    </div>
    
    <!-- Step 1: Basic Information -->
    <div class="step-section" data-step="1">
        <div class="form-row">
            <div class="form-group">
                <label for="title" class="title-color">
                    {{ translate('Job Title') }}
                    <span class="input-required-icon">*</span>
                </label>
                <input type="text" class="form-control" id="title" name="title"
                    value="{{ $isEdit ? $vacancy->title : old('title') }}" required>
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="category" class="title-color">
                    {{ translate('Category') }}
                    <span class="input-required-icon">*</span>
                </label>
                <select class="form-control" name="category" id="category" required>
                    <option value="">{{ translate('Select Category') }}</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ ($isEdit ? $vacancy->category : old('category')) == $category->id ? 'selected' : '' }}>
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
                <label for="employment_type" class="title-color">
                    {{ translate('Employment Type') }}
                    <span class="input-required-icon">*</span>
                </label>
                <select class="form-control" name="employment_type" id="employment_type" required>
                    <option value="full-time"
                        {{ ($isEdit ? $vacancy->employment_type : old('employment_type')) == 'full-time' ? 'selected' : '' }}>
                        Full-Time</option>
                    <option value="part-time"
                        {{ ($isEdit ? $vacancy->employment_type : old('employment_type')) == 'part-time' ? 'selected' : '' }}>
                        Part-Time</option>
                    <option value="contract"
                        {{ ($isEdit ? $vacancy->employment_type : old('employment_type')) == 'contract' ? 'selected' : '' }}>
                        Contract</option>
                    <option value="freelance"
                        {{ ($isEdit ? $vacancy->employment_type : old('employment_type')) == 'freelance' ? 'selected' : '' }}>
                        Freelance</option>
                </select>
                @error('employment_type')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="employment_space" class="title-color">
                    {{ translate('Employment Space') }}
                    <span class="input-required-icon">*</span>
                </label>
                <select class="form-control" name="employment_space" id="employment_space" required>
                    <option value="work-from-home"
                        {{ ($isEdit ? $vacancy->employment_space : old('employment_space')) == 'work-from-home' ? 'selected' : '' }}>
                        Work From Home</option>
                    <option value="in-office"
                        {{ ($isEdit ? $vacancy->employment_space : old('employment_space')) == 'in-office' ? 'selected' : '' }}>
                        In Office</option>
                    <option value="hybrid"
                        {{ ($isEdit ? $vacancy->employment_space : old('employment_space')) == 'hybrid' ? 'selected' : '' }}>
                        Hybrid</option>
                </select>
                @error('employment_space')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-single">
                <label for="description" class="title-color">
                    {{ translate('Description') }}
                    <span class="input-required-icon">*</span>
                </label>
                <textarea class="form-control" id="description" name="description" rows="4" required>{{ $isEdit ? $vacancy->description : old('description') }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <div></div>
            <button type="button" class="next-btn" data-next="2">Next</button>
        </div>
    </div>

    <!-- Step 2: Salary & Status -->
    <div class="step-section d-none" data-step="2">
        <div class="form-row">
            <div class="form-group">
                <label for="salary_low" class="title-color">{{ translate('Salary Low') }}</label>
                <input type="number" class="form-control" id="salary_low" name="salary_low"
                    step="0.01" value="{{ $isEdit ? $vacancy->salary_low : old('salary_low') }}">
                @error('salary_low')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="salary_high" class="title-color">{{ translate('Salary High') }}</label>
                <input type="number" class="form-control" id="salary_high" name="salary_high"
                    step="0.01" value="{{ $isEdit ? $vacancy->salary_high : old('salary_high') }}">
                @error('salary_high')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="currency" class="title-color">{{ translate('Currency') }}</label>
                <input type="text" class="form-control" id="currency" name="currency"
                    value="{{ $isEdit ? $vacancy->currency : old('currency') }}">
                @error('currency')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="status" class="title-color">
                    {{ translate('Status') }}
                    <span class="input-required-icon">*</span>
                </label>
                <select class="form-control" name="status" id="status" required>
                    <option value="active" {{ ($isEdit ? $vacancy->status : old('status')) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ ($isEdit ? $vacancy->status : old('status')) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="closed" {{ ($isEdit ? $vacancy->status : old('status')) == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
                @error('status')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="vacancies" class="title-color">
                    {{ translate('Number of Vacancies') }}
                    <span class="input-required-icon">*</span>
                </label>
                <input type="number" class="form-control" id="vacancies" name="vacancies"
                    value="{{ $isEdit ? $vacancy->vacancies : old('vacancies', 1) }}" min="1" required>
                @error('vacancies')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="featured" class="title-color">{{ translate('Featured Job') }}</label>
                <select class="form-control" id="featured" name="featured">
                    <option value="0" {{ ($isEdit ? $vacancy->featured : old('featured')) == '0' ? 'selected' : '' }}>
                        {{ translate('No') }}</option>
                    <option value="1" {{ ($isEdit ? $vacancy->featured : old('featured')) == '1' ? 'selected' : '' }}>
                        {{ translate('Yes') }}</option>
                </select>
                @error('featured')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="button" class="prev-btn" data-prev="1">Previous</button>
            <button type="button" class="next-btn" data-next="3">Next</button>
        </div>
    </div>

    <!-- Step 3: Company Information -->
    <div class="step-section d-none" data-step="3">
        <div class="form-row">
            <div class="form-group">
                <label for="company_name" class="title-color">
                    {{ translate('Company Name') }}
                    <span class="input-required-icon">*</span>
                </label>
                <input type="text" class="form-control" id="company_name" name="company_name"
                    value="{{ $isEdit ? $vacancy->company_name : old('company_name') }}" required>
                @error('company_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="company_employees" class="title-color">
                    {{ translate('Company Employees') }}
                    <span class="input-required-icon">*</span>
                </label>
                <input type="text" class="form-control" id="company_employees" name="company_employees"
                    value="{{ $isEdit ? $vacancy->company_employees : old('company_employees') }}" required>
                @error('company_employees')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="company_type" class="title-color">
                    {{ translate('Company Type') }}
                    <span class="input-required-icon">*</span>
                </label>
                <input type="text" class="form-control" id="company_type" name="company_type"
                    value="{{ $isEdit ? $vacancy->company_type : old('company_type') }}" required>
                @error('company_type')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="company_logo" class="title-color">{{ translate('Company Logo') }}</label>
                <input type="file" class="form-control" name="company_logo" id="company_logo" accept="image/*">
                @error('company_logo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        @if ($isEdit && $vacancy->company_logo)
            <div class="form-row mb-3">
                <div class="form-single">
                    <h4>Current Logo</h4>
                    <img style="width: 250px; height:250px; aspect-ratio: 4/3;" src="/storage/{{ $vacancy->company_logo }}" alt="company logo" />
                </div>
            </div>
        @endif

        <div class="form-row">
            <div class="form-group">
                <label for="company_website" class="title-color">{{ translate('Company Website') }}</label>
                <input type="url" class="form-control" id="company_website"
                    name="company_website" value="{{ $isEdit ? $vacancy->company_website : old('company_website') }}">
                @error('company_website')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="company_email" class="title-color">{{ translate('Company Email') }}</label>
                <input type="email" class="form-control" id="company_email"
                    name="company_email" value="{{ $isEdit ? $vacancy->company_email : old('company_email') }}">
                @error('company_email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="company_phone" class="title-color">{{ translate('Company Phone') }}</label>
                <input type="tel" class="form-control" id="company_phone"
                    name="company_phone" value="{{ $isEdit ? $vacancy->company_phone : old('company_phone') }}">
                @error('company_phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="remote" class="title-color">
                    {{ translate('Remote Work') }}
                    <span class="input-required-icon">*</span>
                </label>
                <select class="form-control" id="remote" name="remote" required>
                    <option value="0" {{ ($isEdit ? $vacancy->remote : old('remote')) == '0' ? 'selected' : '' }}>
                        {{ translate('No') }}</option>
                    <option value="1" {{ ($isEdit ? $vacancy->remote : old('remote')) == '1' ? 'selected' : '' }}>
                        {{ translate('Yes') }}</option>
                </select>
                @error('remote')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-single">
                <label for="company_address" class="title-color">{{ translate('Company Address') }}</label>
                <textarea class="form-control" id="company_address" name="company_address" rows="3">{{ $isEdit ? $vacancy->company_address : old('company_address') }}</textarea>
                @error('company_address')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="button" class="prev-btn" data-prev="2">Previous</button>
            <button type="button" class="next-btn" data-next="4">Next</button>
        </div>
    </div>

    <!-- Step 4: Location & Requirements -->
    <div class="step-section d-none" data-step="4">
        <div class="form-row">
            <div class="form-group">
                <label for="location" class="title-color">{{ translate('Location') }}</label>
                <input type="text" class="form-control" id="location" name="location"
                    value="{{ $isEdit ? $vacancy->location : old('location') }}">
                @error('location')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="country" class="title-color">{{ translate('Country') }}</label>
                <select class="form-control" id="country" name="country">
                    <option value="">Select a Country</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}"
                            {{ ($isEdit ? $vacancy->country : old('country')) == $country->id ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
                @error('country')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="state" class="title-color">{{ translate('State') }}</label>
                <select class="form-control" id="state" name="state">
                    <option value="">Select a State</option>
                </select>
                @error('state')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="city" class="title-color">{{ translate('City') }}</label>
                <select class="form-control" id="city" name="city">
                    <option value="">Select a City</option>
                </select>
                @error('city')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="experience_required" class="title-color">{{ translate('Experience Required (in years)') }}</label>
                <input type="number" class="form-control" id="experience_required"
                    name="experience_required" value="{{ $isEdit ? $vacancy->experience_required : old('experience_required') }}"
                    min="0" placeholder="e.g., 3">
                @error('experience_required')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="education_level" class="title-color">{{ translate('Education Level') }}</label>
                <input type="text" class="form-control" id="education_level"
                    name="education_level" value="{{ $isEdit ? $vacancy->education_level : old('education_level') }}"
                    placeholder="e.g., Bachelor's Degree">
                @error('education_level')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="visa_sponsorship" class="title-color">{{ translate('Visa Sponsorship') }}</label>
                <select class="form-control" id="visa_sponsorship" name="visa_sponsorship">
                    <option value="0" {{ ($isEdit ? $vacancy->visa_sponsorship : old('visa_sponsorship')) == '0' ? 'selected' : '' }}>
                        {{ translate('No') }}</option>
                    <option value="1" {{ ($isEdit ? $vacancy->visa_sponsorship : old('visa_sponsorship')) == '1' ? 'selected' : '' }}>
                        {{ translate('Yes') }}</option>
                </select>
                @error('visa_sponsorship')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="application_deadline" class="title-color">{{ translate('Application Deadline') }}</label>
                <input type="date" class="form-control" id="application_deadline"
                    name="application_deadline" value="{{ $isEdit ? $vacancy->application_deadline : old('application_deadline') }}">
                @error('application_deadline')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="skills_required" class="title-color">{{ translate('Skills Required') }}</label>
                <textarea class="form-control" id="skills_required" name="skills_required" rows="3"
                    placeholder="e.g., JavaScript, Python, Communication">{{ $isEdit ? $vacancy->skills_required : old('skills_required') }}</textarea>
                @error('skills_required')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="certifications_required" class="title-color">{{ translate('Certifications Required') }}</label>
                <textarea class="form-control" id="certifications_required" name="certifications_required" rows="3"
                    placeholder="e.g., AWS Certified, PMP">{{ $isEdit ? $vacancy->certifications_required : old('certifications_required') }}</textarea>
                @error('certifications_required')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="benefits" class="title-color">{{ translate('Benefits') }}</label>
                <textarea class="form-control" id="benefits" name="benefits" rows="3"
                    placeholder="e.g., Health Insurance, 401(k), Paid Time Off">{{ $isEdit ? $vacancy->benefits : old('benefits') }}</textarea>
                @error('benefits')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="application_process" class="title-color">{{ translate('Application Process') }}</label>
                <textarea class="form-control" id="application_process" name="application_process" rows="3"
                    placeholder="e.g., Submit resume and cover letter">{{ $isEdit ? $vacancy->application_process : old('application_process') }}</textarea>
                @error('application_process')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-single">
                <label for="application_link" class="title-color">{{ translate('Application Link') }}</label>
                <input type="url" class="form-control" id="application_link"
                    name="application_link" value="{{ $isEdit ? $vacancy->application_link : old('application_link') }}"
                    placeholder="e.g., https://company.com/apply">
                @error('application_link')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="button" class="prev-btn" data-prev="3">Previous</button>
            <button type="submit" class="submit-btn">{{ $isEdit ? 'Update Vacancy' : 'Create Vacancy' }}</button>
        </div>
    </div>
</div>