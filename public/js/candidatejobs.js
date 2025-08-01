document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("candidateJobsForm");

    if (form) {
        // Debounced input for text fields
        form.querySelectorAll('input[type="text"]').forEach(function(input) {
            let timeout;

            input.addEventListener("input", function() {
                applyFilters();
            });
        });

        form.querySelectorAll('input[type="number"]').forEach(function(input) {
            let timeout;

            input.addEventListener("input", function() {
                applyFilters();
            });
        });

        // Submit when checkboxes are changed
        form.querySelectorAll('input[type="checkbox"]').forEach(function(
            checkbox
        ) {
            checkbox.addEventListener("change", function() {
                applyFilters();
            });
        });

        // Handle search icon click
        form.querySelectorAll(".search-icon").forEach(function(icon) {
            icon.addEventListener("click", function() {
                applyFilters();
            });
        });
    }

    function applyFilters(page = 1) {
        const form = document.getElementById("candidateJobsForm");
        
        // Get slider values instead of non-existent min/max salary inputs
        const minSalarySlider = document.getElementById("slider-1");
        const maxSalarySlider = document.getElementById("slider-2");

        let filters = {
            search_filter:
                form.querySelector("input[name=search_filter]").value || "",
            min_salary: minSalarySlider ? minSalarySlider.value : 0,
            max_salary: maxSalarySlider ? maxSalarySlider.value : 100000,

            currencies: Array.from(
                form.querySelectorAll('input[name="currencies[]"]:checked')
            ).map(cb => cb.value),
            specializations: Array.from(
                form.querySelectorAll('input[name="specializations[]"]:checked')
            ).map(cb => cb.value),
            job_types: Array.from(
                form.querySelectorAll('input[name="job_types[]"]:checked')
            ).map(cb => cb.value),
            posted_by: Array.from(
                form.querySelectorAll('input[name="posted_by[]"]:checked')
            ).map(cb => cb.value),

            // New experience range
            min_experience:
                form.querySelector('input[name="min_experience"]').value || "",
            max_experience:
                form.querySelector('input[name="max_experience"]').value || ""
        };

        filters.page = page;

        // Debug: uncomment the line below to see filter data
        // console.log('ApplyFilters called with:', filters);
        loadFilteredData(filters, page);
    }

    $(document).on("click", ".pagination a", function(e) {
        e.preventDefault();

        const form = document.getElementById("candidateJobsForm");
        
        // Get slider values for pagination as well
        const minSalarySlider = document.getElementById("slider-1");
        const maxSalarySlider = document.getElementById("slider-2");
        
        let filters = {
            search_filter: form.querySelector("input[name=search_filter]").value || "",
            min_salary: minSalarySlider ? minSalarySlider.value : 0,
            max_salary: maxSalarySlider ? maxSalarySlider.value : 100000,
            currencies: Array.from(
                form.querySelectorAll('input[name="currencies[]"]:checked')
            ).map(cb => cb.value),
            specializations: Array.from(
                form.querySelectorAll('input[name="specializations[]"]:checked')
            ).map(cb => cb.value),
            job_types: Array.from(
                form.querySelectorAll('input[name="job_types[]"]:checked')
            ).map(cb => cb.value),
            posted_by: Array.from(
                form.querySelectorAll('input[name="posted_by[]"]:checked')
            ).map(cb => cb.value),
            min_experience: form.querySelector('input[name="min_experience"]').value || "",
            max_experience: form.querySelector('input[name="max_experience"]').value || ""
        };

        var page = $(this).data("page");
        loadFilteredData(filters, page);
    });

    applyFilters();

    // Function to auto-select first job card
    function autoSelectFirstJobCard() {
        // Remove existing selection styling from all job cards
        const allJobCards = document.querySelectorAll('.job-card');
        allJobCards.forEach(card => {
            card.style.border = '1px solid lightgrey';
            card.style.boxShadow = 'var(--shadow)';
        });

        // Apply styling to first job card
        const firstJobCard = document.querySelector('.job-card');
        if (firstJobCard) {
            firstJobCard.style.border = '1px solid var(--primary-color)';
            firstJobCard.style.boxShadow = 'var(--shadow)';
        }
    }

    // Make function globally accessible
    window.autoSelectFirstJobCard = autoSelectFirstJobCard;

    // Auto-select first job card on page load
    // setTimeout(function() {
    //     autoSelectFirstJobCard();
    //     if (typeof loadFirstJobDetails === 'function') {
    //         loadFirstJobDetails();
    //     }
    // }, 200);

    // Buttons to toggle sections
    const applyResumeButton = document.getElementById("applyResumeButton");
    const applyFormButton = document.getElementById("applyFormButton");
    const resumeSection = document.getElementById("resumeSection");
    const formSection = document.getElementById("formSection");

    // Show Resume Upload Section
    applyResumeButton.addEventListener("click", function() {
        resumeSection.classList.remove("d-none");
        formSection.classList.add("d-none");
    });

    // Show Form Section
    applyFormButton.addEventListener("click", function() {
        formSection.classList.remove("d-none");
        resumeSection.classList.add("d-none");
    });

    $("#filtertoggle").on("click", function() {
        $("#sidebartoggle").toggle(); // Hides if visible, shows if hidden
    });

    // Add search functionality for filter sections
    function addFilterSearch() {
        // Search functionality for currencies
        const currencySearch = document.querySelector('.filter-section:has(.currency-options) .search-box input');
        if (currencySearch) {
            currencySearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const options = document.querySelectorAll('.currency-option');
                options.forEach(option => {
                    const text = option.textContent.toLowerCase();
                    option.style.display = text.includes(searchTerm) ? 'block' : 'none';
                });
            });
        }

        // Search functionality for specializations
        const specializationSearch = document.querySelector('.filter-section:has([name="specializations[]"]) .search-box input');
        if (specializationSearch) {
            specializationSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const options = document.querySelectorAll('.filter-section:has([name="specializations[]"]) .filter-option');
                options.forEach(option => {
                    const text = option.textContent.toLowerCase();
                    option.style.display = text.includes(searchTerm) ? 'block' : 'none';
                });
            });
        }

        // Search functionality for job types
        const jobTypeSearch = document.querySelector('.filter-section:has([name="job_types[]"]) .search-box input');
        if (jobTypeSearch) {
            jobTypeSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const options = document.querySelectorAll('.filter-section:has([name="job_types[]"]) .filter-option');
                options.forEach(option => {
                    const text = option.textContent.toLowerCase();
                    option.style.display = text.includes(searchTerm) ? 'block' : 'none';
                });
            });
        }

        // Search functionality for posted by
        const postedBySearch = document.querySelector('.filter-section:has([name="posted_by[]"]) .search-box input');
        if (postedBySearch) {
            postedBySearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const options = document.querySelectorAll('.filter-section:has([name="posted_by[]"]) .filter-option');
                options.forEach(option => {
                    const text = option.textContent.toLowerCase();
                    option.style.display = text.includes(searchTerm) ? 'block' : 'none';
                });
            });
        }
    }

    // Initialize search functionality
    addFilterSearch();
});
