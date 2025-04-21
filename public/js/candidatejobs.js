const jobCards = document.querySelectorAll('.job-card');
const modal = document.getElementById('jobDetailModal');
const modalContent = document.getElementById('modalJobDetails');
const closeBtn = document.querySelector('.close-modal');
const jobDetailsPanel = document.querySelector('.job-details-panel');

jobCards.forEach((card) => {
  card.addEventListener('click', () => {
    if (window.innerWidth <= 768) {
      // Show job-details-panel content in the modal instead of cloning the card
      modalContent.innerHTML = ''; // Clear previous content
      modalContent.innerHTML = jobDetailsPanel.innerHTML; // Copy job-details-panel content
      modal.style.display = 'block';
    } else {
      // Scroll to or highlight jobDetailsPanel
      jobDetailsPanel.scrollIntoView({ behavior: 'smooth' });
    }
  });
});

closeBtn.addEventListener('click', () => {
  modal.style.display = 'none';
});

window.addEventListener('click', (e) => {
  if (e.target === modal) {
    modal.style.display = 'none';
  }
});

document.addEventListener("DOMContentLoaded", function () {
    // Salary Range Slider Functionality
    const minThumb = document.getElementById("min-thumb");
    const maxThumb = document.getElementById("max-thumb");
    const sliderTrack = document.querySelector(".slider-track");
    const sliderFill = document.querySelector(".slider-fill");
    const salaryMin = document.querySelector(".salary-min");
    const salaryMax = document.querySelector(".salary-max");

    let isDraggingMin = false;
    let isDraggingMax = false;
    let minValue = 0;
    let maxValue = 500;

    function updateSlider() {
        const trackWidth = sliderTrack.offsetWidth;
        const minPos = (minValue / 500) * trackWidth;
        const maxPos = (maxValue / 500) * trackWidth;

        minThumb.style.left = `${minPos}px`;
        maxThumb.style.left = `${maxPos}px`;
        sliderFill.style.left = `${minPos}px`;
        sliderFill.style.width = `${maxPos - minPos}px`;

        salaryMin.textContent = `$${minValue} USD`;
        salaryMax.textContent = `$${maxValue} USD`;
    }

    minThumb.addEventListener("mousedown", (e) => {
        isDraggingMin = true;
        e.preventDefault();
    });

    maxThumb.addEventListener("mousedown", (e) => {
        isDraggingMax = true;
        e.preventDefault();
    });

    document.addEventListener("mousemove", (e) => {
        if (!isDraggingMin && !isDraggingMax) return;

        const trackRect = sliderTrack.getBoundingClientRect();
        const position = Math.max(
            0,
            Math.min(e.clientX - trackRect.left, trackRect.width)
        );
        const value = Math.round((position / trackRect.width) * 500);

        if (isDraggingMin) {
            minValue = Math.min(value, maxValue - 10);
        } else if (isDraggingMax) {
            maxValue = Math.max(value, minValue + 10);
        }

        updateSlider();
    });

    document.addEventListener("mouseup", () => {
        isDraggingMin = false;
        isDraggingMax = false;
    });

    // Initialize the slider
    updateSlider();

    // Custom Checkbox Functionality
    const checkboxes = document.querySelectorAll(
        ".currency-option input, .filter-option input"
    );
    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", function () {
            const customCheckbox = this.nextElementSibling;
            if (this.checked) {
                customCheckbox.classList.add("checked");
            } else {
                customCheckbox.classList.remove("checked");
            }
        });
    });

    // Job Card Selection
    const jobCards = document.querySelectorAll(".job-card");
    jobCards.forEach((card) => {
        card.addEventListener("click", function () {
            jobCards.forEach((c) => c.classList.remove("selected"));
            this.classList.add("selected");
        });
    });

    // Pagination
    const pageButtons = document.querySelectorAll(".page-btn");
    pageButtons.forEach((button) => {
        button.addEventListener("click", function () {
            pageButtons.forEach((btn) => btn.classList.remove("active"));
            this.classList.add("active");
        });
    });

    // Apply Button
    const applyButtons = document.querySelectorAll(
        ".apply-btn, .apply-now-btn"
    );
    applyButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
            e.stopPropagation();
            alert("Application submitted successfully!");
        });
    });

    // Save Button
    const saveButton = document.querySelector(".save-btn");
    if (saveButton) {
        saveButton.addEventListener("click", function () {
            this.classList.toggle("saved");
            if (this.classList.contains("saved")) {
                this.textContent = "Saved";
                this.style.backgroundColor = "#f0f0f0";
            } else {
                this.textContent = "Save";
                this.style.backgroundColor = "var(--white)";
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    // Show and hide dropdowns on click
    const dropdownButtons = document.querySelectorAll(".dropdown-button");
    dropdownButtons.forEach((button) => {
        button.addEventListener("click", function (event) {
            const list = this.nextElementSibling;
            document.querySelectorAll(".dropdown-list").forEach((dropdown) => {
                if (dropdown !== list) {
                    dropdown.style.display = "none"; // Close other dropdowns
                }
            });
            const isVisible = list.style.display === "block";
            list.style.display = isVisible ? "none" : "block"; // Toggle visibility of current dropdown
        });
    });

    const inputs = document.querySelectorAll(
        "input[type='search'], input[type='number']"
    );
    inputs.forEach((input) => {
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
            document.querySelectorAll(".dropdown-list").forEach((dropdown) => {
                dropdown.style.display = "none"; // Close dropdown if clicked outside
            });
        }
    });

    // Filter function for dropdown search
    function filterList(searchId, listId) {
        const searchInput = document.getElementById(searchId);
        const listItems = document.querySelectorAll(
            `#${listId} .dropdown-item`
        );

        searchInput.addEventListener("input", function () {
            const query = searchInput.value.toLowerCase();
            listItems.forEach(function (item) {
                const text = item.textContent || item.innerText;
                if (text.toLowerCase().includes(query)) {
                    item.style.display = "block";
                } else {
                    item.style.display = "none";
                }
            });
        });
    }

    // Initialize filtering for Location and Company dropdowns
    filterList("location-search", "location-list");
    filterList("company-search", "company-list");

    // Handle item selection in dropdown
    const dropdownItems = document.querySelectorAll(".dropdown-item");
    dropdownItems.forEach((item) => {
        item.addEventListener("click", function () {
            const dropdownLabel = this.closest(
                ".dropdown-container"
            ).querySelector(".dropdown-label");
            dropdownLabel.textContent = this.textContent; // Update the label to selected item

            // Close the dropdown after selection
            this.closest(".dropdown-list").style.display = "none";

            applyFilters(); // Apply selected filters
        });
    });

    // Apply filters when an option is selected
    function applyFilters() {
        const location = document.querySelector(
            "input[name='location']:checked"
        )?.value;
        const time = document.querySelector(
            "input[name='time']:checked"
        )?.value;
        const company = document.querySelector(
            "input[name='company']:checked"
        )?.value;
        const jobType = document.querySelector(
            "input[name='job_type']:checked"
        )?.value;
        const experienceLevel = document.querySelector(
            "input[name='experience_level']:checked"
        )?.value;

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
        document
            .querySelectorAll('input[type="radio"]')
            .forEach((input) => (input.checked = false));
        document.querySelectorAll(".dropdown-label").forEach((label) => {
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
                        button.onclick = applyjob; // Define this function as per your need
                        button.style.pointerEvents = "auto";
                    }

                    if (job_self_status) {
                        button.innerText = "Self Job";
                        button.onclick = null;
                        button.style.pointerEvents = "none";
                    }

                    // Populate job details
                    $("#job-title").text(job.title || "Title not provided");
                    $("#job-location").text(
                        job.location || "Location not provided"
                    );
                    var postedTimeFormatted = formatTimeAgo(job.created_at);
                    var applicants = getApplicants(job.id);
                    $("#posted-time").text(
                        postedTimeFormatted || "Posted time not available"
                    );
                    $("#applicants").text(
                        applicants || "Applicants not available"
                    );

                    // Description
                    $("#job-description").text(
                        job.description || "Job description not provided"
                    );

                    // Company Details
                    $("#company-name").text(
                        job.company_name || "Company name not provided"
                    );
                    $("#company-namedet").text(
                        job.company_name || "Company name not provided"
                    );
                    $("#company-website")
                        .text(
                            job.company_website ||
                                "Company website not available"
                        )
                        .attr("href", job.company_website || "#");
                    $("#company-address").text(
                        job.company_address || "Company address not specified"
                    );
                    $("#company-email").text(
                        job.company_email || "Company email not available"
                    );
                    $("#company-phone").text(
                        job.company_phone || "Company phone not available"
                    );
                    updateCompanyLocation(job);
                    // $("#company-location").text(cityName + ", " + stateName + ", " + countryName|| "Location not available");

                    // Additional Information
                    $("#visa").text(
                        job.visa_sponsorship
                            ? "Visa sponsorship available"
                            : "Visa sponsorship not available"
                    );
                    $("#benefits").text(
                        job.benefits
                            ? Array.isArray(job.benefits)
                                ? job.benefits.array === 1
                                    ? job.benefits[0]
                                    : job.benefits.join(", ")
                                : JSON.parse(job.benefits).join(", ")
                            : "Benefits not specified"
                    );

                    // Application Details
                    $("#application-deadline").text(
                        job.application_deadline
                            ? new Date(
                                  job.application_deadline
                              ).toLocaleDateString("en-US")
                            : "Deadline not specified"
                    );
                    $("#application-process").text(
                        job.application_process ||
                            "Application process not specified"
                    );
                    $("#application-link")
                        .text(
                            job.application_link ||
                                "Application link not available"
                        )
                        .attr("href", job.application_link || "#");

                    // Company Logo
                    $("#company-logo").attr(
                        "src",
                        job.company_logo
                            ? "/storage/" + job.company_logo
                            : "default-logo.png"
                    );
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
                    $("#njob-location").text(
                        job.location || "Location not provided"
                    );
                    var postedTimeFormatted = formatTimeAgo(job.created_at);
                    var applicants = getApplicants(job.id);
                    $("#nposted-time").text(
                        postedTimeFormatted || "Posted time not available"
                    );
                    $("#napplicants").text(
                        applicants || "Applicants not available"
                    );

                    // Description
                    $("#njob-description").text(
                        job.description || "Job description not provided"
                    );

                    // Company Details
                    $("#ncompany-name").text(
                        job.company_name || "Company name not provided"
                    );
                    $("#ncompany-namedet").text(
                        job.company_name || "Company name not provided"
                    );
                    $("#ncompany-website")
                        .text(
                            job.company_website ||
                                "Company website not available"
                        )
                        .attr("href", job.company_website || "#");
                    $("#ncompany-address").text(
                        job.company_address || "Company address not specified"
                    );
                    $("#ncompany-email").text(
                        job.company_email || "Company email not available"
                    );
                    $("#ncompany-phone").text(
                        job.company_phone || "Company phone not available"
                    );
                    updateCompanyLocation(job);
                    // $("#ncompany-location").text(cityName + ", " + stateName + ", " + countryName || "Location not available");

                    // Additional Information
                    $("#nvisa").text(
                        job.visa_sponsorship
                            ? "Visa sponsorship available"
                            : "Visa sponsorship not available"
                    );
                    $("#nbenefits").text(
                        job.benefits
                            ? Array.isArray(job.benefits)
                                ? job.benefits.array === 1
                                    ? job.benefits[0]
                                    : job.benefits.join(", ")
                                : JSON.parse(job.benefits).join(", ")
                            : "Benefits not specified"
                    );

                    // Application Details
                    $("#napplication-deadline").text(
                        job.application_deadline
                            ? new Date(
                                  job.application_deadline
                              ).toLocaleDateString("en-US")
                            : "Deadline not specified"
                    );
                    $("#napplication-process").text(
                        job.application_process ||
                            "Application process not specified"
                    );
                    $("#napplication-link")
                        .text(
                            job.application_link ||
                                "Application link not available"
                        )
                        .attr("href", job.application_link || "#");

                    // Company Logo
                    $("#ncompany-logo").attr(
                        "src",
                        job.company_logo
                            ? "/storage/" + job.company_logo
                            : "default-logo.png"
                    );
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
function getLocationName(type, id) {
    return new Promise(function (resolve, reject) {
        if (!id) {
            resolve("Location not available");
            return;
        }

        var url = `/${type}name/${id}`;

        $.ajax({
            url: url,
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                resolve(response || "Location not available");
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
                reject("Error loading location.");
            },
        });
    });
}
// Function to update company location
function updateCompanyLocation(job) {
    // Fetch country, state, and city asynchronously
    var countryPromise = getLocationName("country", job.country);
    var statePromise = getLocationName("state", job.state);
    var cityPromise = getLocationName("city", job.city);

    // Use Promise.all to wait for all the responses
    Promise.all([countryPromise, statePromise, cityPromise])
        .then(function ([countryName, stateName, cityName]) {
            // Update location element with the company location
            $("#company-location").text(
                cityName + ", " + stateName + ", " + countryName
            );
            $("#ncompany-location").text(
                cityName + ", " + stateName + ", " + countryName
            );
        })
        .catch(function (error) {
            // Handle error case if any AJAX call fails
            console.error("Error in loading location details:", error);
            $("#company-location").text(
                cityName + ", " + stateName + ", " + countryName
            );
            $("#ncompany-location").text(
                cityName + ", " + stateName + ", " + countryName
            );
        });
}
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
function getApplicants(jobId) {
    if (!jobId) {
        $("#applicants").text("Invalid job ID.");
        return;
    }

    $.ajax({
        url: `/applicants/${jobId}`,
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            // Assuming the response is just the count
            $("#applicants").text(
                response + " Applicants" || "Applicants not available"
            );
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
            $("#applicants").text("Error loading applicants.");
        },
    });
}
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
// Function to open the login modal
function openLoginModal() {
    $("#loginModal").modal("show");
}
document
    .getElementById("viewMoreBtn")
    .addEventListener("click", function (event) {
        event.preventDefault(); // Prevent the default anchor link behavior
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
        document.getElementById("grgrer").style.overflowY = "scroll";
    });

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
