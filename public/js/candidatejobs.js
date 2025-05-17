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

        let filters = {
            search_filter:
                form.querySelector("input[name=search_filter]").value || "",
            min_salary:
                form.querySelector('input[name="min_salary"]').value || 0,
            max_salary:
                form.querySelector('input[name="max_salary"]').value || 500,

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

        loadFilteredData(filters, page);
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
});
