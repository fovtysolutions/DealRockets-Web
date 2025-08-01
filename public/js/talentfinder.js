function filterdrop() {
    const section = document.getElementById("sidebarhidden");
    if (section.style.display === "none" || section.style.display === "") {
        section.style.display = "block";
    } else {
        section.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", function() {
    // Range Slider functionality
    const minInput = document.getElementById("min-salary");
    const maxInput = document.getElementById("max-salary");
    const sliderFill = document.querySelector(".slider-fill");
    const leftThumb = document.querySelector(".slider-thumb.left");
    const rightThumb = document.querySelector(".slider-thumb.right");

    // Update slider based on input values
    function updateSlider() {
        const min = parseInt(minInput.value) || 0;
        const max = parseInt(maxInput.value) || 500;

        const range = 100000000; // Max possible value
        const leftPos = (min / range) * 100;
        const rightPos = (max / range) * 100;

        sliderFill.style.left = leftPos + "%";
        sliderFill.style.width = rightPos - leftPos + "%";
    }

    minInput.addEventListener("input", updateSlider);
    maxInput.addEventListener("input", updateSlider);

    // Pagination functionality
    const pageNumbers = document.querySelectorAll(".page-number");
    const prevButton = document.querySelector(".prev-page");
    const nextButton = document.querySelector(".next-page");

    // Set active page
    pageNumbers.forEach(button => {
        button.addEventListener("click", function() {
            pageNumbers.forEach(btn => btn.classList.remove("active"));
            this.classList.add("active");
        });
    });

    // Previous page
    prevButton.addEventListener("click", function() {
        const activePage = document.querySelector(".page-number.active");
        const prevPage = activePage.previousElementSibling;

        if (prevPage && prevPage.classList.contains("page-number")) {
            activePage.classList.remove("active");
            prevPage.classList.add("active");
        }
    });

    // Next page
    nextButton.addEventListener("click", function() {
        const activePage = document.querySelector(".page-number.active");
        const nextPage = activePage.nextElementSibling;

        if (nextPage && nextPage.classList.contains("page-number")) {
            activePage.classList.remove("active");
            nextPage.classList.add("active");
        }
    });

    // Checkbox functionality
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", function() {
            // In a real application, this would filter the job listings
            console.log(
                `${this.id} is ${this.checked ? "checked" : "unchecked"}`
            );
        });
    });

    // Search box functionality for filter sections
    const searchInputs = document.querySelectorAll(".search-box input");

    searchInputs.forEach(input => {
        input.addEventListener("input", function() {
            const searchTerm = this.value.toLowerCase();
            const filterSection = this.closest('.filter-section');
            
            if (filterSection) {
                const options = filterSection.querySelectorAll('.filter-option, .currency-option');
                
                options.forEach(option => {
                    const label = option.querySelector('label:last-child');
                    if (label) {
                        const text = label.textContent.toLowerCase();
                        if (text.includes(searchTerm)) {
                            option.style.display = 'block';
                        } else {
                            option.style.display = 'none';
                        }
                    }
                });
            }
        });
    });

    // Message button functionality
    const messageButtons = document.querySelectorAll(".message-btn");

    messageButtons.forEach(button => {
        button.addEventListener("click", function() {
            // In a real application, this would open a message dialog
            const jobTitle = this.closest(".job-card").querySelector(
                ".job-title-location h3"
            ).textContent;
            alert(`You're about to message regarding the ${jobTitle} position`);
        });
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("filterFormIndustryJobs");

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
        const form = document.getElementById("filterFormIndustryJobs");

        let filters = {
            search_filter: form.querySelector("input[name='search_filter']")?.value || "",

            min_salary: form.querySelector("#min_salary")?.value || 0,
            max_salary: form.querySelector("#max_salary")?.value || 100000,

            currencies: Array.from(
                form.querySelectorAll('input[name="currencies[]"]:checked')
            ).map(cb => cb.value),

            keywords: Array.from(
                form.querySelectorAll('input[name="keywords[]"]:checked')
            ).map(cb => cb.value),

            job_types: Array.from(
                form.querySelectorAll('input[name="job_types[]"]:checked')
            ).map(cb => cb.value),

            countries: Array.from(
                form.querySelectorAll('input[name="countries[]"]:checked')
            ).map(cb => cb.value),

            jobtitles: Array.from(
                form.querySelectorAll('input[name="jobtitles[]"]:checked')
            ).map(cb => cb.value),

            min_experience: form.querySelector("input[name='min_experience']")?.value || "",
            max_experience: form.querySelector("input[name='max_experience']")?.value || "",
        };

        filters.page = page;

        loadFilteredData(filters, page);
    }

    // Function to handle search button click
    function performSearch() {
        const searchInput = document.querySelector('.search-input-tab');
        const hiddenSearchInput = document.querySelector('#search_filter');
        
        if (searchInput && hiddenSearchInput) {
            hiddenSearchInput.value = searchInput.value;
            applyFilters(1);
        }
    }

    $(document).on("click", ".pagination a", function(e) {
        e.preventDefault();

        let filters = {
            search_query: document.getElementById("nameFilter").value, // Adjust to your input field ID
            country: Array.from(
                document.querySelectorAll('input[name="country[]"]:checked')
            ).map(checkbox => checkbox.value), // For multiple checkboxes
            industry: Array.from(
                document.querySelectorAll('input[name="industry[]"]:checked')
            ).map(checkbox => checkbox.value) // For multiple checkboxes
        };

        var page = $(this).data("page");
        loadFilteredData(filters, page);
    });

    applyFilters();
});
