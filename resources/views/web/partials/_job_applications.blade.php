<style>
    .subtable {
        display: none;
    }
</style>
<h4>Job Applications</h4>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Job Title</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($jobapplys as $index => $job)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $job['jobname'] }}</td>
                <td>
                    <button class="btn btn-sm btn-primary toggle-subtable">View Details</button>
                </td>
            </tr>
            <tr class="subtable">
                <td colspan="3">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Details</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($job['appliers'] as $index => $jobuno)
                                @if($jobuno)
                                    <?php            $jobapplierdetails = \App\Utils\ChatManager::getjobapplierdetails($jobuno->user_id, $jobuno->apply_via); ?>
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $jobapplierdetails[0]['userdata']->f_name }}</td>
                                        <td>{{ $jobapplierdetails[0]['userdata']->email }}</td>
                                        <td>{{ $jobapplierdetails[0]['userdata']->phone }}</td>
                                        <td>
                                            @if ($jobuno->apply_via == 'cv')
                                                <a class="btn btn-primary"
                                                    href="/storage/{{ $jobapplierdetails[0]['jb']->image_path }}">Show CV</a>
                                            @elseif ($jobuno->apply_via == 'form')
                                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                                    data-bs-target="#applicationProfileModal"
                                                    data-id="{{ $jobapplierdetails[0]['jb']->id }}"
                                                    data-fullname="{{ $jobapplierdetails[0]['jb']->full_name }}"
                                                    data-date_of_birth="{{ $jobapplierdetails[0]['jb']->date_of_birth }}"
                                                    data-gender="{{ $jobapplierdetails[0]['jb']->gender }}"
                                                    data-phone="{{ $jobapplierdetails[0]['jb']->phone }}"
                                                    data-alternate_phone="{{ $jobapplierdetails[0]['jb']->alternate_phone }}"
                                                    data-email="{{ $jobapplierdetails[0]['jb']->email }}"
                                                    data-alternate_email="{{ $jobapplierdetails[0]['jb']->alternate_email }}"
                                                    data-address="{{ $jobapplierdetails[0]['jb']->address }}"
                                                    data-city="{{ $jobapplierdetails[0]['jb']->city }}"
                                                    data-state="{{ $jobapplierdetails[0]['jb']->state }}"
                                                    data-country="{{ $jobapplierdetails[0]['jb']->country }}"
                                                    data-postal_code="{{ $jobapplierdetails[0]['jb']->postal_code }}"
                                                    data-nationality="{{ $jobapplierdetails[0]['jb']->nationality }}"
                                                    data-marital_status="{{ $jobapplierdetails[0]['jb']->marital_status }}"
                                                    data-highest_education="{{ $jobapplierdetails[0]['jb']->highest_education }}"
                                                    data-field_of_study="{{ $jobapplierdetails[0]['jb']->field_of_study }}"
                                                    data-university_name="{{ $jobapplierdetails[0]['jb']->university_name }}"
                                                    data-graduation_year="{{ $jobapplierdetails[0]['jb']->graduation_year }}"
                                                    data-skills="{{ implode(',', json_decode($jobapplierdetails[0]['jb']->skills, true)) }}"
                                                    data-languages="{{ implode(',', json_decode($jobapplierdetails[0]['jb']->languages, true)) }}"
                                                    data-bio="{{ $jobapplierdetails[0]['jb']->bio }}"
                                                    data-linkedin_profile="{{ $jobapplierdetails[0]['jb']->linkedin_profile }}"
                                                    data-portfolio_url="{{ $jobapplierdetails[0]['jb']->portfolio_url }}"
                                                    data-resume="{{ $jobapplierdetails[0]['jb']->resume }}"
                                                    data-years_of_experience="{{ $jobapplierdetails[0]['jb']->years_of_experience }}"
                                                    data-current_position="{{ $jobapplierdetails[0]['jb']->current_position }}"
                                                    data-current_employer="{{ $jobapplierdetails[0]['jb']->current_employer }}"
                                                    data-work_experience="{{ $jobapplierdetails[0]['jb']->work_experience }}"
                                                    data-desired_position="{{ $jobapplierdetails[0]['jb']->desired_position }}"
                                                    data-employment_type="{{ $jobapplierdetails[0]['jb']->employment_type }}"
                                                    data-desired_salary="{{ $jobapplierdetails[0]['jb']->desired_salary }}"
                                                    data-relocation="{{ $jobapplierdetails[0]['jb']->relocation }}"
                                                    data-industry="{{ $jobapplierdetails[0]['jb']->industry }}"
                                                    data-preferred_locations="{{ implode(',', json_decode($jobapplierdetails[0]['jb']->preferred_locations, true)) }}"
                                                    data-open_to_remote="{{ $jobapplierdetails[0]['jb']->open_to_remote }}"
                                                    data-available_immediately="{{ $jobapplierdetails[0]['jb']->available_immediately }}"
                                                    data-availability_date="{{ $jobapplierdetails[0]['jb']->availability_date }}"
                                                    data-references="{{ implode(',', json_decode($jobapplierdetails[0]['jb']->references, true)) }}"
                                                    data-hobbies="{{ $jobapplierdetails[0]['jb']->hobbies }}"
                                                    data-has_drivers_license="{{ $jobapplierdetails[0]['jb']->has_drivers_license }}"
                                                    data-visa_status="{{ $jobapplierdetails[0]['jb']->visa_status }}"
                                                    data-passport_number="{{ $jobapplierdetails[0]['jb']->passport_number }}"
                                                    data-has_criminal_record="{{ $jobapplierdetails[0]['jb']->has_criminal_record }}"
                                                    data-is_verified="{{ $jobapplierdetails[0]['jb']->is_verified }}"
                                                    data-short_term_goal="{{ $jobapplierdetails[0]['jb']->short_term_goal }}"
                                                    data-long_term_goal="{{ $jobapplierdetails[0]['jb']->long_term_goal }}"
                                                    data-seeking_internship="{{ $jobapplierdetails[0]['jb']->seeking_internship }}"
                                                    data-open_to_contract="{{ $jobapplierdetails[0]['jb']->open_to_contract }}"
                                                    data-github_profile="{{ $jobapplierdetails[0]['jb']->github_profile }}"
                                                    data-behance_profile="{{ $jobapplierdetails[0]['jb']->behance_profile }}"
                                                    data-twitter_profile="{{ $jobapplierdetails[0]['jb']->twitter_profile }}"
                                                    data-personal_website="{{ $jobapplierdetails[0]['jb']->personal_website }}"
                                                    data-portfolio_items="{{ implode(',', json_decode($jobapplierdetails[0]['jb']->portfolio_items, true)) }}"
                                                    data-videos="{{ implode(',', json_decode($jobapplierdetails[0]['jb']->videos)) }}"
                                                    data-profile_views="{{ $jobapplierdetails[0]['jb']->profile_views }}"
                                                    data-applications_sent="{{ $jobapplierdetails[0]['jb']->applications_sent }}"
                                                    data-connections="{{ $jobapplierdetails[0]['jb']->connections }}">
                                                    See Application Profile
                                                </button>
                                            @else
                                                No Data Added
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <!-- Form for POST request to shortlist -->
                                            <form action="{{ route('customerjob-shortlist') }}" method="POST" id="shortlistForm">
                                                @csrf
                                                <input type="hidden" name="jobid" value="{{ $job['jobid'] }}">
                                                <input type="hidden" name="applier_id" value="{{ $jobapplierdetails[0]['jb']->user_id }}">
                                                <input type="hidden" name="recruiter_id" value="{{ auth('customer')->user()->id }}">

                                                <button type="submit" class="btn btn-success">
                                                    Shortlist
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="modal fade" id="applicationProfileModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Application Profile</h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body" id="modalContent">
                <!-- Modal Content will be dynamically added here -->
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
            </div>
        </div>
    </div>
</div>
<script>
    document.querySelectorAll('.toggle-subtable').forEach(button => {
        button.addEventListener('click', function () {
            const subtable = this.closest('tr').nextElementSibling;
            subtable.style.display = subtable.style.display === 'table-row' ? 'none' : 'table-row';
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-secondary[data-id]').forEach(button => {
            button.addEventListener('click', function () {
                const fields = [
                    'id', 'fullname', 'date_of_birth', 'gender', 'phone',
                    'alternate_phone', 'email', 'alternate_email', 'address',
                    'city', 'state', 'country', 'postal_code', 'nationality',
                    'marital_status', 'highest_education', 'field_of_study',
                    'university_name', 'graduation_year', 'skills', 'languages', 'bio',
                    'linkedin_profile', 'portfolio_url', 'resume', 'years_of_experience',
                    'current_position', 'current_employer', 'work_experience', 'desired_position',
                    'employment_type', 'desired_salary', 'relocation', 'industry', 'preferred_locations',
                    'open_to_remote', 'available_immediately', 'availability_date', 'references',
                    'hobbies', 'has_drivers_license', 'visa_status', 'passport_number',
                    'has_criminal_record', 'is_verified', 'short_term_goal', 'long_term_goal',
                    'seeking_internship', 'open_to_contract', 'github_profile', 'behance_profile',
                    'twitter_profile', 'personal_website', 'portfolio_items', 'videos', 'profile_views',
                    'applications_sent', 'connections'
                ];
                const applicationId = this.getAttribute('data-id'); // Get the data-id value
                const applicationName = this.getAttribute('data-fullname');
                const applicationGender = this.getAttribute('data-gender');
                const applicationPhone = this.getAttribute('data-phone');
                const applicationAltPhone = this.getAttribute('data-alternate_phone');
                const applicationEmail = this.getAttribute('data-email');
                const applicationAltEmail = this.getAttribute('data-alternate_email');
                const applicationDOB = this.getAttribute('data-date_of_birth');
                const applicationAddress = this.getAttribute('data-address')
                const modalElement = document.getElementById('applicationProfileModal'); // Modal element
                const modalContent = document.getElementById('modalContent'); // Modal content container

                modalContent.innerHTML = 'Loading...';

                setTimeout(() => {
                    modalContent.innerHTML = '';
                    fields.forEach(field => {
                        const value = this.getAttribute(`data-${field}`) || 'N/A';
                        const formattedField = field.replace(/_/g, ' ').toUpperCase(); // Format field name

                        // Create row for each field
                        modalContent.innerHTML += `
                            <div class="row mb-3">
                                <div class="col-4 font-weight-bold">${formattedField}:</div>
                                <div class="col-8">${value}</div>
                            </div>
                        `;
                    });
                }, 500);

                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            });
        });
    });
</script>