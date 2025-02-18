<h4>Added Jobs</h4>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Status</th>
            <th>Featured</th>
            <th>Applications</th>
            <th>Approved</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($userjobs as $job)
            <tr>
                <td>{{ $job->id }}</td>
                <td>{{ $job->title }}</td>
                <td>
                    {{ $job->status }}
                </td>
                <td>{{ $job->featured ? 'Yes' : 'No' }}</td>
                <td>{{ $job->applications_received }}</td>
                <td>{{ $job->Approved == 2 ? 'Rejected' : ($job->Approved ? 'Approved' : 'Pending Review') }}</td>
                <td>
                    <button type="button" class="btn btn-primary m-1 showModal" data-bs-toggle="modal"
                        data-bs-target="#exampleModal" data-id="{{ $job->id ?? '' }}" data-title="{{ $job->title ?? ''}}"
                        data-category="{{ \App\Utils\CategoryManager::get_category_name($job->category) ?? ''}}"
                        data-description="{{ $job->description ?? '' }}" data-salary="{{ $job->salary ?? '' }}"
                        data-employment_type="{{ $job->employment_type ?? '' }}"
                        data-status="{{ ucfirst($job->status ?? '') }}" data-company_name="{{ $job->company_name ?? '' }}"
                        data-country="{{ $country ?? '' }}" data-state="{{ $state ?? '' }}" data-city="{{ $city ?? '' }}"
                        data-experience_required="{{ $job->experience_required ?? '' }}"
                        data-education_level="{{ $job->education_level ?? '' }}"
                        data-skills_required="{{ \App\Utils\ChatManager::decoder($job->skills_required) ?? '' }}"
                        data-certifications_required="{{ \App\Utils\ChatManager::decoder($job->certifications_required) ?? '' }}"
                        data-benefits="{{ \App\Utils\ChatManager::decoder($job->benefits) ?? '' }}"
                        data-application_deadline="{{ \Carbon\Carbon::parse($job->application_deadline)->format('F j, Y') ?? '' }}"
                        data-company_address="{{ $job->company_address ?? '' }}"
                        data-company_website="{{ $job->company_website ?? '' }}"
                        data-company_logo="{{ $job->company_logo ?? '' }}">
                        View Details
                    </button>
                    <button type="button" class="btn btn-secondary m-1" data-bs-toggle="modal" data-bs-target="#editModal"
                        data-id="{{ $job->id }}" data-status="{{ $job->status }}">Edit</button>
                    <form action="{{ route("customerjob_destroy", ['id' => $job->id]) }}" method="POST"
                        style="display:inline;">
                        <button type="submit" class="btn btn-danger m-1">Delete</o>
                    </form>
                    @if(\App\Utils\ChatManager::daysexpiry($job->updated_at) == 0)
                        <form action="{{ route('customerjob_extend', ['id' => $job->id]) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-secondary m-1">Extend Validity</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5" id="exampleModalLabel">Job Details</h4>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6"><strong>Job Title:</strong>
                            <p id="modalJobTitle"></p>
                        </div>
                        <div class="col-md-6"><strong>Category:</strong>
                            <p id="modalJobCategory"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"><strong>Description:</strong>
                            <p id="modalJobDescription"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><strong>Salary:</strong>
                            <p id="modalJobSalary"></p>
                        </div>
                        <div class="col-md-6"><strong>Employment Type:</strong>
                            <p id="modalJobEmploymentType"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><strong>Status:</strong>
                            <p id="modalJobStatus"></p>
                        </div>
                        <div class="col-md-6"><strong>Company Name:</strong>
                            <p id="modalJobCompanyName"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><strong>Country:</strong>
                            <p id="modalJobCountry"></p>
                        </div>
                        <div class="col-md-6"><strong>State:</strong>
                            <p id="modalJobState"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><strong>City:</strong>
                            <p id="modalJobCity"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><strong>Experience Required:</strong>
                            <p id="modalJobExperience"></p>
                        </div>
                        <div class="col-md-6"><strong>Education Level:</strong>
                            <p id="modalJobEducationLevel"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><strong>Skills Required:</strong>
                            <p id="modalJobSkills"></p>
                        </div>
                        <div class="col-md-6"><strong>Certifications Required:</strong>
                            <p id="modalJobCertifications"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><strong>Benefits:</strong>
                            <p id="modalJobBenefits"></p>
                        </div>
                        <div class="col-md-6"><strong>Application Deadline:</strong>
                            <p id="modalJobApplicationDeadline"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><strong>Company Address:</strong>
                            <p id="modalJobCompanyAddress"></p>
                        </div>
                        <div class="col-md-6"><strong>Company Website:</strong>
                            <p id="modalJobCompanyWebsite"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Company Logo:</strong>
                            <img id="modalJobCompanyLogo" src="" alt="Company Logo" class="img-fluid"
                                style="max-width: 200px;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5" id="editModalLabel">Job Edit</h4>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form action="{{ route('customerjob-status')}}" id="statusForm" method="POST">
                        @csrf
                        <!-- Hidden Input for Job ID -->
                        <input type="hidden" id="jobid" name="job_id" value="">
                        
                        <label for="Change Status">Job Status</label>
                        <!-- Select for Job Status -->
                        <select id="changestatus" name="job_status" class="form-select">
                            <option value="" disabled>Select an Option</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="closed">Closed</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateBtn">Update</button>
            </div> -->
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const jobDetailsModal = new bootstrap.Modal(document.getElementById('exampleModal'));

        document.getElementsByClassName('showModal').forEach(function (button) {
            button.addEventListener('click', function (event) {
                const modalFields = {
                    title: button.getAttribute('data-title'),
                    category: button.getAttribute('data-category'),
                    description: button.getAttribute('data-description'),
                    salary: button.getAttribute('data-salary'),
                    employmentType: button.getAttribute('data-employment_type'),
                    status: button.getAttribute('data-status'),
                    companyName: button.getAttribute('data-company_name'),
                    country: button.getAttribute('data-country'),
                    state: button.getAttribute('data-state'),
                    city: button.getAttribute('data-city'),
                    experienceRequired: button.getAttribute('data-experience_required'),
                    educationLevel: button.getAttribute('data-education_level'),
                    skillsRequired: button.getAttribute('data-skills_required'),
                    certificationsRequired: button.getAttribute('data-certifications_required'),
                    benefits: button.getAttribute('data-benefits'),
                    applicationDeadline: button.getAttribute('data-application_deadline'),
                    companyAddress: button.getAttribute('data-company_address'),
                    companyWebsite: button.getAttribute('data-company_website'),
                    companyLogo: button.getAttribute('data-company_logo')
                };

                document.getElementById('modalJobTitle').textContent = modalFields.title || 'N/A';
                document.getElementById('modalJobCategory').textContent = modalFields.category || 'N/A';
                document.getElementById('modalJobDescription').textContent = modalFields.description || 'N/A';
                document.getElementById('modalJobSalary').textContent = modalFields.salary
                    ? `$${parseFloat(modalFields.salary).toFixed(2)}`
                    : 'N/A';
                document.getElementById('modalJobEmploymentType').textContent = modalFields.employmentType || 'N/A';
                document.getElementById('modalJobStatus').textContent = modalFields.status || 'N/A';
                document.getElementById('modalJobCompanyName').textContent = modalFields.companyName || 'N/A';
                document.getElementById('modalJobCountry').textContent = modalFields.country || 'N/A';
                document.getElementById('modalJobState').textContent = modalFields.state || 'N/A';
                document.getElementById('modalJobCity').textContent = modalFields.city || 'N/A';
                document.getElementById('modalJobExperience').textContent = modalFields.experienceRequired
                    ? `${modalFields.experienceRequired} Years`
                    : 'N/A';
                document.getElementById('modalJobEducationLevel').textContent = modalFields.educationLevel || 'N/A';
                document.getElementById('modalJobSkills').textContent = modalFields.skillsRequired || 'N/A';
                document.getElementById('modalJobCertifications').textContent = modalFields.certificationsRequired || 'N/A';
                document.getElementById('modalJobBenefits').textContent = modalFields.benefits || 'N/A';
                document.getElementById('modalJobApplicationDeadline').textContent = modalFields.applicationDeadline || 'N/A';
                document.getElementById('modalJobCompanyAddress').textContent = modalFields.companyAddress || 'N/A';
                document.getElementById('modalJobCompanyWebsite').innerHTML = modalFields.companyWebsite
                    ? `<a href="${modalFields.companyWebsite}" target="_blank">${modalFields.companyWebsite}</a>`
                    : 'N/A';
                document.getElementById('modalJobCompanyLogo').src = modalFields.companyLogo || 'default-logo.png'; // Fallback for missing logo

                jobDetailsModal.show();
            });
        });
    });
</script>
<script>
    // When the modal is triggered, preload data
    document.addEventListener('click', function (e) {
        const jobEditModal = new bootstrap.Modal(document.getElementById('editModal'));

        if (e.target && e.target.dataset.bsTarget === "#editModal") {
            var jobId = e.target.getAttribute('data-id');
            var jobStatus = e.target.getAttribute('data-status');

            // Set the hidden job ID input value
            document.getElementById('jobid').value = jobId;

            // Pre-select the status in the dropdown
            var selectElement = document.getElementById('changestatus');
            selectElement.value = jobStatus || "";
            jobEditModal.show();
        }
    });

    // Handle the update button click
    document.getElementById('updateBtn').addEventListener('click', function () {
        var jobId = document.getElementById('jobid').value;
        var status = document.getElementById('changestatus').value;

        if (jobId && status) {
            var baseUrl = window.location.origin;

            fetch(baseUrl + '/customerjob-status/' + jobId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ status: status })
            })
                .then(response => response.json())
                .then(data => {
                    alert('Job status updated successfully!');
                    // Close modal after update
                    var modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
                    modal.hide();
                })
                .catch(error => {
                    alert('Job Status Update Error');
                });
        } else {
            alert('Please select a status.');
        }
    });
</script>