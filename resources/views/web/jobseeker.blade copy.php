@extends('layouts.front-end.app')
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/jobseeker.css') }}" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@section('title', translate('Job Seeker' . ' | ' . $web_config['name']->value))
@section('content')
<?php
    use App\Utils\CategoryManager;
        $categories = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
    use App\Utils\ChatManager;
        $unread = ChatManager::unread_messages();
        if (auth('customer')->check()){
            $userid = auth('customer')->user()->id;
            $terms = App\Models\User::where('id',$userid)->first()->terms_accepted;
        } else {
            $terms = 0;
        }
?>
<style>
    .dropdown-item:hover {
        background-color: white;
        transform: scale(1) !important;
        cursor: pointer;
    }
</style>
<div class="mainpagesection" style="background-color: unset;">
    <div class="jobbannermain">
        <div class="jobbannerleft">
            <div class="nav-item {{ !request()->is('/') ? 'dropdown' : '' }}">
                <a class="spanatag" href="javascript:" style="z-index: 0;">
                    <svg class="spanimage" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                        <rect x="5" y="6" width="20" height="2" fill="black" />
                        <rect x="5" y="13" width="20" height="2" fill="black" />
                        <rect x="5" y="20" width="20" height="2" fill="black" />
                    </svg>
                    <span class="spantitlenew custom-dealrock-subhead">
                        {{ translate('categories') }}
                    </span>
                </a>
            </div>
            <ul class="navbar-nav" id="grgrer" style="overflow-y:hidden; overflow-x:hidden; height: 87%;">
                <div class="megamenu">
                    <div class="megamenucontainer">
                        <div class="category-menu-wrapper">
                            <ul class="category-menu-items" id="dpcontainerbox">
                                @foreach ($newcategories->take(17) as $key => $category)
                                    <li>
                                        <a class="text-truncate custom-dealrock-text"
                                            href="{{ route('jobseeker', ['categoryid' => $category->id]) }}">{{ $category->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </ul>
            <div class="text-center" id="viewMoreBtn">
                <a href="#" class="text-primary font-weight-bold justify-content-center mt-2 custom-dealrock-subhead">
                    {{ translate('View_More') }}
                </a>
            </div>
        </div>
        <div class="jobbannerrightbox">
            <div class="jobbannerrighttop">
                <div class="buttonsbox">
                    <form method="GET" action="{{ route('jobseeker') }}"
                        style="flex-direction: row; margin-top: 13px; display: flex;">
                        <div class="dropdown-container">
                            <div class="dropdown-button noselect">
                                <div class="dropdown-label custom-dealrock-text" data-default-label="Location">Location</div>
                            </div>
                            <div class="dropdown-list custom-dealrock-text" style="display: none;">
                                <input type="search" placeholder="Search locations" class="dropdown-search"
                                    id="location-search" name="location" />
                                <ul id="location-list">
                                    @foreach($locations as $location)
                                        <li class="dropdown-item pr-2 pl-2">
                                            <label>
                                                <input type="radio" name="location" value="{{ $location }}" />
                                                {{ $location }}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- Time Filter Dropdown -->
                        <div class="dropdown-container">
                            <div class="dropdown-button noselect">
                                <div class="dropdown-label custom-dealrock-text" data-default-label="Time">Time</i>
                                </div>
                            </div>
                            <div class="dropdown-list custom-dealrock-text" style="display: none;">
                                <ul id="time-list">
                                    <li class="dropdown-item pr-2 pl-2">
                                        <label>
                                            <input type="radio" name="time" value="7" /> Last 7 Days
                                        </label>
                                    </li>
                                    <li class="dropdown-item pr-2 pl-2">
                                        <label>
                                            <input type="radio" name="time" value="30" /> Last 30 Days
                                        </label>
                                    </li>
                                    <li class="dropdown-item pr-2 pl-2">
                                        <label>
                                            <input type="radio" name="time" value="90" /> Last 3 Months
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="dropdown-container">
                            <div class="dropdown-button noselect">
                                <div class="dropdown-label custom-dealrock-text" data-default-label="Company">Company</div>
                            </div>
                            <div class="dropdown-list custom-dealrock-text" style="display: none;">
                                <input type="search" placeholder="Search companies" class="dropdown-search"
                                    id="company-search" />
                                <ul id="company-list">
                                    @foreach($companies as $company)
                                        <li class="dropdown-item pr-2 pl-2">
                                            <label>
                                                <input type="radio" name="company" value="{{ $company }}" />
                                                {{ $company }}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="dropdown-container">
                            <div class="dropdown-button noselect">
                                <div class="dropdown-label custom-dealrock-text" data-default-label="Job Type">Job Type</div>
                            </div>
                            <div class="dropdown-list custom-dealrock-text" style="display: none;">
                                <ul id="job-type-list">
                                    @foreach($jobTypes as $jobType)
                                        <li class="dropdown-item pr-2 pl-2">
                                            <label>
                                                <input class="text-capitalize" type="radio" name="job_type"
                                                    value="{{ $jobType }}" />
                                                {{ str_replace("-"," ",$jobType) }}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- Experience Level Filter -->
                        <div class="dropdown-container">
                            <div class="dropdown-button noselect">
                                <div class="dropdown-label custom-dealrock-text" data-default-label="Experience Level">Experience Level</div>
                            </div>
                            <div class="dropdown-list custom-dealrock-text" style="display: none;">
                                <ul id="experience-level-list">
                                    <li class="dropdown-item d-flex justify-content-end pr-2 pl-2">
                                        <label>
                                            From:
                                            <input type="number" name="experience_level_from" min="0"
                                                placeholder="From experience" />
                                        </label>
                                    </li>
                                    <li class="dropdown-item d-flex justify-content-end pr-2 pl-2">
                                        <label>
                                            To:
                                            <input type="number" name="experience_level_to" min="0"
                                                placeholder="To experience" />
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="dropdown-container">
                            <div class="dropdown-button noselect">
                                <div class="dropdown-label custom-dealrock-text" data-default-label="Remote">Remote</div>
                            </div>
                            <div class="dropdown-list custom-dealrock-text" style="display: none;">
                                <ul id="remote-list">
                                    <li class="dropdown-item pr-2 pl-2">
                                        <label>
                                            <input type="checkbox" name="remote" value="1" />
                                            Remote
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Filter Buttons -->
                        <div class="clear-filters mr-2" style="margin-top: 10px;">
                            <button type="submit" id="filters-btn">Filters</button>
                        </div>
                    </form>
                    <div class="clear-filters">
                        <button id="clear-filters-btn">Clear Filters</button>
                    </div>
                    <!-- <select class="buttonsboxq" id="location_filter" name="location_filter">
                        <option selected value="">Exact Location</option>
                        <option value="city1">City 1</option>
                        <option value="city2">City 2</option>
                        <option value="city3">City 3</option>
                        <option value="city4">City 4</option>
                    </select> -->
                </div>
            </div>
            <div class="jobbannerrightbottom">
                <div class="jobbannercenter">
                    <ul class="navbar-nav hiddenonscreens">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:" id="dropdownMenuCat" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false"
                                onclick="toggleDropdown('dropdownMenuCat', 'dropdownmenu-cat')"
                                style="position: absolute;">
                                <svg class="spanimage" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="5" y="6" width="20" height="2" fill="black" />
                                    <rect x="5" y="13" width="20" height="2" fill="black" />
                                    <rect x="5" y="20" width="20" height="2" fill="black" />
                                </svg>
                            </a>
                            <ul class="dropdown-menu" id="dropdownmenu-cat" aria-labelledby="dropdownMenuButton"
                                style="padding-top:50px;">
                                @foreach ($categories as $category)
                                    <li>
                                        <a
                                            href="{{ route('jobseeker', ['categoryid' => $category->id]) }}">{{ $category->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                    <div class="tilebox">
                        @if ($jobseeker->isEmpty())
                            <p>No Jobs Found!</p>
                        @else
                            @foreach ($jobseeker as $data)
                                <input style="display: none;" value={{ $data->id }} id="jobid" />
                                <div class="tile">
                                    <div class="tile-content" onclick="fetchJobData({{ $data->id }})">
                                        <!-- Company Logo -->
                                        <div class="icon">
                                            <img class="ico" src="/storage/{{ $data->company_logo }}" />
                                        </div>
                                        <!-- Job Details Section -->
                                        <div class="details">
                                            <div class="title custom-dealrock-subhead">{{ $data->title }}</div>
                                            <div class="company-name custom-dealrock-text" style="font-weight: bold !important;">{{ $data->company_name }}</div>
                                            <div class="location text-truncate custom-dealrock-text">{{ $data->company_address }}</div>
                                            <div id="checkviewed" class="viewed-status custom-dealrock-text">Not Applied</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        @if ($jobseeker->isEmpty())
                            <!-- No Show -->
                        @else
                            {{ $jobseeker->links() }}
                        @endif
                    </div>
                </div>
                <div class="jobbannerright" id="jobdetails">
                    <div class="jobbox">
                        <div class="card shadow-sm" style="border-radius: 0px;">
                            <div class="job-card">
                                <div class="job-card-header">
                                    <img src="default-logo.png" alt="Company Logo" class="company-logo"
                                        id="company-logo">
                                    <div class="job-details">
                                        <h5 id="job-title" class="custom-dealrock-head">Software Engineer</h5>
                                        <div class="company-name-location">
                                            <span class="company-name custom-dealrock-subhead" id="company-name">Tech Innovators</span>
                                            <span class="location custom-dealrock-subhead" id="job-location">San Francisco, CA</span>
                                        </div>
                                        <div class="time-applicants">
                                            <span class="posted-time custom-dealrock-text" id="posted-time">Posted 3 hours ago</span>
                                            <span class="applicants custom-dealrock-text" id="applicants">15 Applicants</span>
                                        </div>
                                        @if (auth('customer')->check() && auth('customer')->user()->id)
                                            <button class="apply-button custom-dealrock-subhead" style="background-color:var(--web-hover); color:white;" id="applybutton">Apply Now</button>
                                        @else
                                            <button class="apply-button custom-dealrock-subhead" style="background-color:var(--web-hover); color:white;" id="applybutton" onclick="openLoginModal()">Apply
                                                Now</button>
                                        @endif
                                    </div>
                                </div>

                                <div class="job-description-box">
                                    <h5 class="custom-dealrock-subhead">Job Description</h5>
                                    <p id="job-description" class="custom-dealrock-text">
                                        As a Software Engineer, you'll be responsible for building and maintaining
                                        software systems. You will work alongside a team of engineers to design, test,
                                        and deploy scalable solutions. The ideal candidate will have a passion for
                                        technology and a desire to continuously learn and grow.
                                    </p>
                                </div>

                                <div class="company-details-box">
                                    <h5 class="custom-dealrock-subhead">Company Details</h5>
                                    <p class="custom-dealrock-text"><strong>Company Name:</strong> <span id="company-namedet">Tech Innovators</span>
                                    </p>
                                    <p class="custom-dealrock-text"><strong>Company Website:</strong> <a href="#"
                                            id="company-website">techinnovators.com</a></p>
                                    <p class="custom-dealrock-text"><strong>Company Address:</strong> <span id="company-address">123 Silicon Valley,
                                            SF</span></p>
                                    <p class="custom-dealrock-text"><strong>Company Email:</strong> <span
                                            id="company-email">info@techinnovators.com</span></p>
                                    <p class="custom-dealrock-text"><strong>Company Phone:</strong> <span id="company-phone">(123) 456-7890</span>
                                    </p>
                                    <p class="custom-dealrock-text"><strong>Company Location:</strong> <span id="company-location">San Francisco, CA,
                                            USA</span></p>
                                </div>

                                <div class="additional-info-box">
                                    <h5 class="custom-dealrock-subhead">Additional Information</h5>
                                    <p class="custom-dealrock-text"><strong>Visa:</strong> <span id="visa">Sponsorship available</span></p>
                                    <p class="custom-dealrock-text"><strong>Benefits:</strong> <span id="benefits">Health Insurance, Paid Time
                                            Off</span></p>
                                </div>

                                <div class="application-details-box">
                                    <h5 class="custom-dealrock-subhead">Application Details</h5>
                                    <p class="custom-dealrock-text"><strong>Application Deadline:</strong> <span id="application-deadline">January
                                            31, 2025</span></p>
                                    <p class="custom-dealrock-text"><strong>Application Process:</strong> <span id="application-process">Submit your
                                            resume via the link below.</span></p>
                                    <p class="custom-dealrock-text"><strong>Application Link:</strong> <a href="#" id="application-link">Click here
                                            to apply</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Right Section with Ads -->
    <div class="leadrightdivision">
        <div class="ad-section">
            <div class="vendor-ad w-100">
                <div class="ad-content">
                    <!-- Replace with actual vendor ad content -->
                    <img src="/images/banner/D7z2EogpjPPb2nkuJ7hDWOR67xVhbqjybdOkdpLr.png" alt="Vendor Ad" class="ad-image">
                </div>
            </div>
            {{-- <div class="google-ad">
                <div class="ad-content">
                    <!-- Google Ad code goes here -->
                    <img src="/images/banner/wpnBmaWcxCSnIC0ATIVVbwIST2ybhqHbd1SQLVYa.png" alt="Google Ad" class="ad-image">
                </div>
            </div> --}}
        </div>
    </div>
</div>
@if($terms == 0)
    @include('web.partials.policyaccept')
@endif
@include('web.partials.jobmodal')
@include('web.partials.applymodal')
@include('web.partials.loginmodal')
<script>
    document.getElementById("viewMoreBtn").addEventListener("click", function (event) {
        event.preventDefault();  // Prevent the default anchor link behavior
        // Dynamically load the remaining categories, assuming they are available
        const fullCategoryList = `
            @foreach ($newcategories->slice(17) as $category)  <!-- Starting from the 18th category -->
                <li>
                    <a href="{{ route('jobseeker', ['categoryid' => $category->id]) }}">{{ $category->name }}</a>
                </li>
            @endforeach
        `;
        // Append the remaining categories to the current list
        document.getElementById("dpcontainerbox").innerHTML += fullCategoryList;
        
        // Enable scrolling
        document.getElementById('grgrer').style.overflowY = 'scroll';
    });
</script>
<script>
    $(document).ready(function () {
        const cvForm = $("#cvForm");

        if (cvForm.length) {
            cvForm.on("submit", function (event) {
                event.preventDefault();

                // Create FormData object
                const formData = new FormData(this);

                // Perform AJAX request
                $.ajax({
                    url: "/cv", // Your server endpoint
                    type: "POST",
                    data: formData,
                    processData: false, // Required for FormData
                    contentType: false, // Required for FormData
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}", // Laravel CSRF token
                    },
                    success: function (response) {
                        alert("CV submitted successfully!");
                        location.reload(); // Reload the page after successful submission
                    },
                    error: function (xhr) {
                        let errorMessage = "An error occurred!";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        console.error("Error:", errorMessage);
                        alert(errorMessage); // Display error message
                    },
                });
            });
        }
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Show and hide dropdowns on click
        const dropdownButtons = document.querySelectorAll(".dropdown-button");
        dropdownButtons.forEach(button => {
            button.addEventListener("click", function (event) {
                const list = this.nextElementSibling;
                document.querySelectorAll(".dropdown-list").forEach(dropdown => {
                    if (dropdown !== list) {
                        dropdown.style.display = "none"; // Close other dropdowns
                    }
                });
                const isVisible = list.style.display === "block";
                list.style.display = isVisible ? "none" : "block"; // Toggle visibility of current dropdown
            });
        });

        const inputs = document.querySelectorAll("input[type='search'], input[type='number']");
        inputs.forEach(input => {
            input.addEventListener("click", function (event) {
                event.stopPropagation(); // Prevent closing dropdown when clicking inside the input field
            });
        });

        // Close dropdowns if clicked outside
        document.addEventListener("click", function (event) {
            const isDropdownButton = event.target.closest(".dropdown-button");
            const isDropdownItem = event.target.closest(".dropdown-item");
            const isDropdownSearch = event.target.closest("input[type='search']");

            // Close dropdown if clicked outside of the dropdown button, dropdown item, or search input
            if (!isDropdownButton && !isDropdownItem && !isDropdownSearch) {
                document.querySelectorAll(".dropdown-list").forEach(dropdown => {
                    dropdown.style.display = "none"; // Close dropdown if clicked outside
                });
            }
        });

        // Filter function for dropdown search
        function filterList(searchId, listId) {
            const searchInput = document.getElementById(searchId);
            const listItems = document.querySelectorAll(`#${listId} .dropdown-item`);

            searchInput.addEventListener('input', function () {
                const query = searchInput.value.toLowerCase();
                listItems.forEach(function (item) {
                    const text = item.textContent || item.innerText;
                    if (text.toLowerCase().includes(query)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }

        // Initialize filtering for Location and Company dropdowns
        filterList('location-search', 'location-list');
        filterList('company-search', 'company-list');

        // Handle item selection in dropdown
        const dropdownItems = document.querySelectorAll(".dropdown-item");
        dropdownItems.forEach(item => {
            item.addEventListener("click", function () {
                const dropdownLabel = this.closest(".dropdown-container").querySelector(".dropdown-label");
                dropdownLabel.textContent = this.textContent; // Update the label to selected item

                // Close the dropdown after selection
                this.closest(".dropdown-list").style.display = "none";

                applyFilters(); // Apply selected filters
            });
        });

        // Apply filters when an option is selected
        function applyFilters() {
            const location = document.querySelector("input[name='location']:checked")?.value;
            const time = document.querySelector("input[name='time']:checked")?.value;
            const company = document.querySelector("input[name='company']:checked")?.value;
            const jobType = document.querySelector("input[name='job_type']:checked")?.value;
            const experienceLevel = document.querySelector("input[name='experience_level']:checked")?.value;

            // Add filter logic here to apply the filters as needed
            console.log("Filters Applied:");
            console.log("Location:", location);
            console.log("Time:", time);
            console.log("Company:", company);
            console.log("Job Type:", jobType);
            console.log("Experience Level:", experienceLevel);
        }

        // Function to clear all filters
        function clearFilters() {
            // Reset all input fields and checkboxes
            document.querySelectorAll('input[type="radio"]').forEach(input => input.checked = false);
            document.querySelectorAll(".dropdown-label").forEach(label => {
                label.textContent = label.getAttribute("data-default-label");
            });

            // Reapply filters after clearing (if needed)
            applyFilters();
        }

        // Clear Filters Button
        const clearFiltersBtn = document.querySelector("#clear-filters-btn");
        if (clearFiltersBtn) {
            clearFiltersBtn.addEventListener("click", function () {
                clearFilters();
            });
        }
    });
</script>
<script>
    function fetchJobData(jobId) {
        if ($("#jobdetails").css("display") === "block") {
            var baseUrl = window.location.origin;
            var dataUrl = baseUrl + "/get-data-from-job/" + jobId;

            $.ajax({
                url: dataUrl,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function (response) {
                    if (response.job_data) {
                        var job = response.job_data;
                        var job_applied_status = response.job_applied;
                        var job_self_status = response.self_job;

                        // Handle Apply Button Based on Application Status
                        var button = document.getElementById("applybutton");
                        if (job_applied_status) {
                            button.innerText = "Applied";
                            button.onclick = null;
                            button.style.pointerEvents = "none";
                        } else {
                            button.innerText = "Apply Now";
                            button.onclick = applyjob;  // Define this function as per your need
                            button.style.pointerEvents = "auto";
                        }

                        if (job_self_status) {
                            button.innerText = "Self Job";
                            button.onclick = null;
                            button.style.pointerEvents = "none";
                        }

                        // Populate job details
                        $("#job-title").text(job.title || "Title not provided");
                        $("#job-location").text(job.location || "Location not provided");
                        var postedTimeFormatted = formatTimeAgo(job.created_at);
                        var applicants = getApplicants(job.id);
                        $("#posted-time").text(postedTimeFormatted || "Posted time not available");
                        $("#applicants").text(applicants || "Applicants not available");

                        // Description
                        $("#job-description").text(job.description || "Job description not provided");

                        // Company Details
                        $("#company-name").text(job.company_name || "Company name not provided");
                        $('#company-namedet').text(job.company_name || "Company name not provided");
                        $("#company-website").text(job.company_website || "Company website not available").attr("href", job.company_website || "#");
                        $("#company-address").text(job.company_address || "Company address not specified");
                        $("#company-email").text(job.company_email || "Company email not available");
                        $("#company-phone").text(job.company_phone || "Company phone not available");
                        updateCompanyLocation(job);
                        // $("#company-location").text(cityName + ", " + stateName + ", " + countryName|| "Location not available");

                        // Additional Information
                        $("#visa").text(job.visa_sponsorship ? "Visa sponsorship available" : "Visa sponsorship not available");
                        $("#benefits").text(job.benefits
                            ? Array.isArray(job.benefits)
                                ? job.benefits.array === 1
                                    ? job.benefits[0]
                                    : job.benefits.join(", ")
                                : JSON.parse(job.benefits).join(", ")
                            : "Benefits not specified");

                        // Application Details
                        $("#application-deadline").text(job.application_deadline ? new Date(job.application_deadline).toLocaleDateString("en-US") : "Deadline not specified");
                        $("#application-process").text(job.application_process || "Application process not specified");
                        $("#application-link").text(job.application_link || "Application link not available").attr("href", job.application_link || "#");

                        // Company Logo
                        $("#company-logo").attr("src", job.company_logo ? "/storage/" + job.company_logo : "default-logo.png");
                    } else {
                        console.error("No job data found.");
                        alert("Job data not found.");
                    }
                },

                error: function (xhr, status, error) {
                    console.error("Error fetching job data: ", error.message);
                    alert("Error fetching job data. Please try again.");
                },
            });
        } else {
            $("#exampleModalLong").modal("show");
            var baseUrl = window.location.origin;
            var dataUrl = baseUrl + "/get-data-from-job/" + jobId;

            $.ajax({
                url: dataUrl,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function (response) {
                    if (response.job_data) {
                        var job = response.job_data;
                        var job_applied_status = response.job_applied;
                        var job_self_status = response.self_job;

                        if (job_applied_status == true) {
                            console.log("Applied Button Lock");
                            var button = document.getElementById("applybuttonn");
                            button.innerText = "Applied";
                            button.onclick = null;
                            button.style.pointerEvents = "none";
                        }
                        if (job_applied_status == false) {
                            console.log("Setting Button Apply Now");
                            var button = document.getElementById("applybuttonn");
                            button.innerText = "Apply Now";
                            button.onclick = applyjob;
                            button.style.pointerEvents = "auto";
                        }
                        if (job_self_status == true) {
                            console.log("Self Job");
                            button.innerText = "Self Job";
                            button.onclick = null;
                            button.style.pointerEvents = "none";
                        }


                        // Populate job details
                        $("#njob-title").text(job.title || "Title not provided");
                        $("#njob-location").text(job.location || "Location not provided");
                        var postedTimeFormatted = formatTimeAgo(job.created_at);
                        var applicants = getApplicants(job.id);
                        $("#nposted-time").text(postedTimeFormatted || "Posted time not available");
                        $("#napplicants").text(applicants || "Applicants not available");

                        // Description
                        $("#njob-description").text(job.description || "Job description not provided");

                        // Company Details
                        $("#ncompany-name").text(job.company_name || "Company name not provided");
                        $('#ncompany-namedet').text(job.company_name || "Company name not provided");
                        $("#ncompany-website").text(job.company_website || "Company website not available").attr("href", job.company_website || "#");
                        $("#ncompany-address").text(job.company_address || "Company address not specified");
                        $("#ncompany-email").text(job.company_email || "Company email not available");
                        $("#ncompany-phone").text(job.company_phone || "Company phone not available");
                        updateCompanyLocation(job);
                        // $("#ncompany-location").text(cityName + ", " + stateName + ", " + countryName || "Location not available");

                        // Additional Information
                        $("#nvisa").text(job.visa_sponsorship ? "Visa sponsorship available" : "Visa sponsorship not available");
                        $("#nbenefits").text(job.benefits
                            ? Array.isArray(job.benefits)
                                ? job.benefits.array === 1
                                    ? job.benefits[0]
                                    : job.benefits.join(", ")
                                : JSON.parse(job.benefits).join(", ")
                            : "Benefits not specified");

                        // Application Details
                        $("#napplication-deadline").text(job.application_deadline ? new Date(job.application_deadline).toLocaleDateString("en-US") : "Deadline not specified");
                        $("#napplication-process").text(job.application_process || "Application process not specified");
                        $("#napplication-link").text(job.application_link || "Application link not available").attr("href", job.application_link || "#");

                        // Company Logo
                        $("#ncompany-logo").attr("src", job.company_logo ? "/storage/" + job.company_logo : "default-logo.png");
                    } else {
                        console.error("No job data found.");
                        alert("Job data not found.");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching job data: ", error);
                    alert("Error fetching job data. Please try again.");
                },
            });
            $("#exampleModalLong").modal("show");
        }
    }
</script>
<script>
    function getLocationName(type, id) {
        return new Promise(function (resolve, reject) {
            if (!id) {
                resolve("Location not available");
                return;
            }

            var url = `/${type}name/${id}`;

            $.ajax({
                url: url,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    resolve(response || "Location not available");
                },
                error: function (xhr, status, error) {
                    console.error("Error:", error);
                    reject("Error loading location.");
                }
            });
        });
    }
    // Function to update company location
    function updateCompanyLocation(job) {
        // Fetch country, state, and city asynchronously
        var countryPromise = getLocationName('country', job.country);
        var statePromise = getLocationName('state', job.state);
        var cityPromise = getLocationName('city', job.city);

        // Use Promise.all to wait for all the responses
        Promise.all([countryPromise, statePromise, cityPromise])
            .then(function ([countryName, stateName, cityName]) {
                // Update location element with the company location
                $("#company-location").text(cityName + ", " + stateName + ", " + countryName);
                $("#ncompany-location").text(cityName + ", " + stateName + ", " + countryName);
            })
            .catch(function (error) {
                // Handle error case if any AJAX call fails
                console.error("Error in loading location details:", error);
                $("#company-location").text(cityName + ", " + stateName + ", " + countryName);
                $("#ncompany-location").text(cityName + ", " + stateName + ", " + countryName);
            });
    }
</script>
<script>
    function formatTimeAgo(dateString) {
        const now = new Date();
        const postedDate = new Date(dateString);
        const timeDiff = now - postedDate; // difference in milliseconds

        const daysAgo = Math.floor(timeDiff / (1000 * 3600 * 24)); // converting milliseconds to days

        if (daysAgo === 0) {
            return "Posted today";
        } else if (daysAgo === 1) {
            return "Posted 1 day ago";
        } else {
            return `Posted ${daysAgo} days ago`;
        }
    }
</script>
<script>
    function getApplicants(jobId) {
        if (!jobId) {
            $('#applicants').text("Invalid job ID.");
            return;
        }

        $.ajax({
            url: `/applicants/${jobId}`,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                // Assuming the response is just the count
                $('#applicants').text(response + " Applicants" || "Applicants not available");
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
                $('#applicants').text("Error loading applicants.");
            }
        });
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var urlParams = new URLSearchParams(window.location.search);
        var jobid = urlParams.get("jobid");
        var job_first_id = document.getElementById("jobid")
            ? document.getElementById("jobid").value
            : null;

        var jobDetailsVisible =
            $("#jobdetails").length && $("#jobdetails").css("display") === "block";

        if (jobid) {
            if (jobDetailsVisible) {
                fetchJobData(jobid);
            } else {
                $("#exampleModalLong").modal("show");
                fetchJobData(jobid);
            }
        } else if (job_first_id) {
            fetchJobData(job_first_id);
        } else {
            console.error("No job ID found in URL or default input.");
        }
    });
</script>
<script>
    function toggleDropdown(buttonId, menuClass) {
        const dropdownToggle = document.getElementById(buttonId);
        const dropdownMenu = document.getElementById(menuClass);

        // Toggle the dropdown visibility
        if (dropdownMenu.classList.contains("show")) {
            dropdownMenu.classList.remove("show"); // Hide dropdown
        } else {
            dropdownMenu.classList.add("show"); // Show dropdown
        }
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Buttons to toggle sections
        const applyResumeButton = document.getElementById("applyResumeButton");
        const applyFormButton = document.getElementById("applyFormButton");
        const resumeSection = document.getElementById("resumeSection");
        const formSection = document.getElementById("formSection");

        // Show Resume Upload Section
        applyResumeButton.addEventListener("click", function () {
            resumeSection.classList.remove("d-none");
            formSection.classList.add("d-none");
        });

        // Show Form Section
        applyFormButton.addEventListener("click", function () {
            formSection.classList.remove("d-none");
            resumeSection.classList.add("d-none");
        });
    });
</script>
<script>
    function applyjob(jobId) {
        $("#exampleModalLong").modal("hide");
        $("#modalJobApply").modal("show");
    }
    function populateState() {
        const country_id = document.getElementById("countrynew").value;
        const base_url = window.location.origin;
        // Reset state and city dropdowns
        const stateDropdown = document.getElementById("statenew");
        const cityDropdown = document.getElementById("citynew");

        stateDropdown.innerHTML = '<option value="">Select State</option>';
        cityDropdown.innerHTML = '<option value="">Select City</option>';

        // Fetch states based on selected country
        fetch(`${base_url}/get-state-by-id/${country_id}`)
            .then((response) => response.json())
            .then((data) => {
                data.forEach((obj) => {
                    const option = document.createElement("option");
                    option.value = obj.id;
                    option.textContent = obj.name;
                    stateDropdown.appendChild(option);
                });
            })
            .catch((error) => console.error("Error fetching states:", error));
    }

    function populateCity(state) {
        const state_id = document.getElementById("statenew").value;
        const base_url = window.location.origin;
        // Reset city dropdown
        const cityDropdown = document.getElementById("citynew");
        cityDropdown.innerHTML = '<option value="">Select City</option>';

        // Fetch cities based on selected state
        fetch(`${base_url}/get-city-by-id/${state_id}`)
            .then((response) => response.json())
            .then((data) => {
                data.forEach((obj) => {
                    const option = document.createElement("option");
                    option.value = obj.id;
                    option.textContent = obj.name;
                    cityDropdown.appendChild(option);
                });
            })
            .catch((error) => console.error("Error fetching cities:", error));
    }
    document.addEventListener("DOMContentLoaded", function () {
        document
            .getElementById("countrynew")
            .addEventListener("change", populateState);
        document
            .getElementById("statenew")
            .addEventListener("change", populateCity);
    });
</script>
<script>
    // Function to open the login modal
    function openLoginModal() {
        $('#loginModal').modal('show');
    }
</script>
@endsection
