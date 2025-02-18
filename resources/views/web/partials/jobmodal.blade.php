<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Job Description</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> -->
            <div class="job-card">
                <div class="job-card-header">
                    <img src="default-logo.png" alt="Company Logo" class="company-logo" id="ncompany-logo">
                    <div class="job-details">
                        <h5 id="njob-title">Software Engineer</h5>
                        <div class="company-name-location">
                            <span class="company-name" id="ncompany-name">Tech Innovators</span>
                            <span class="location" id="njob-location">San Francisco, CA</span>
                        </div>
                        <div class="time-applicants">
                            <span class="posted-time" id="nposted-time">Posted 3 hours ago</span>
                            <span class="applicants" id="napplicants">15 Applicants</span>
                        </div>
                        @if (auth('customer')->check() && auth('customer')->user()->id)
                            <button class="apply-button" id="applybuttonn">Apply Now</button>
                        @else
                            <button class="apply-button" id="applybuttonn" onclick="openLoginModal()">Apply Now</button>
                        @endif
                    </div>
                </div>

                <div class="job-description-box">
                    <h5>Job Description</h5>
                    <p id="njob-description">
                        As a Software Engineer, you'll be responsible for building and maintaining
                        software systems. You will work alongside a team of engineers to design, test,
                        and deploy scalable solutions. The ideal candidate will have a passion for
                        technology and a desire to continuously learn and grow.
                    </p>
                </div>

                <div class="company-details-box">
                    <h5>Company Details</h5>
                    <p><strong>Company Name:</strong> <span id="ncompany-namedet">Tech Innovators</span></p>
                    <p><strong>Company Website:</strong> <a href="#" id="ncompany-website">techinnovators.com</a></p>
                    <p><strong>Company Address:</strong> <span id="ncompany-address">123 Silicon Valley,
                            SF</span></p>
                    <p><strong>Company Email:</strong> <span id="ncompany-email">info@techinnovators.com</span></p>
                    <p><strong>Company Phone:</strong> <span id="ncompany-phone">(123) 456-7890</span>
                    </p>
                    <p><strong>Company Location:</strong> <span id="ncompany-location">San Francisco, CA,
                            USA</span></p>
                </div>

                <div class="additional-info-box">
                    <h5>Additional Information</h5>
                    <p><strong>Visa:</strong> <span id="nvisa">Sponsorship available</span></p>
                    <p><strong>Benefits:</strong> <span id="nbenefits">Health Insurance, Paid Time
                            Off</span></p>
                </div>

                <div class="application-details-box">
                    <h5>Application Details</h5>
                    <p><strong>Application Deadline:</strong> <span id="napplication-deadline">January
                            31, 2025</span></p>
                    <p><strong>Application Process:</strong> <span id="napplication-process">Submit your
                            resume via the link below.</span></p>
                    <p><strong>Application Link:</strong> <a href="#" id="napplication-link">Click here
                            to apply</a></p>
                </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> --}}
        </div>
    </div>
</div>
</div>