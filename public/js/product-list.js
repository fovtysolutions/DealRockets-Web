let currentView = "grid";
const prodList = document.getElementById("prod-list");
const prodGrid = document.getElementById("prod-grid");
prodList.onclick = function() {
    document.getElementById("productGrid").style.display = "none";
    document.getElementById("productList").style.display = "block";
    currentView = "list";
    renderProducts();
};
prodGrid.onclick = function() {
    document.getElementById("productGrid").style.display = "grid";
    document.getElementById("productList").style.display = "none";
    currentView = "grid";
    renderProducts();
};

function sendtologin() {
    window.location.href = "/customer/auth/login";
}

document.addEventListener("DOMContentLoaded", function() {
    // Show only first 6 items initially
    document.querySelectorAll(".filter-options").forEach(container => {
        const items = container.querySelectorAll(".checkbox-item");
        items.forEach((item, index) => {
            item.style.display = index < 160 ? "flex" : "none";
        });
    });

    // Attach filter logic to all search-filter inputs
    document.querySelectorAll(".search-filter").forEach(input => {
        input.addEventListener("input", function() {
            const targetSelector = this.getAttribute("data-target");
            const container = document.querySelector(targetSelector);
            const searchTerm = this.value.toLowerCase();
            const items = container.querySelectorAll(".checkbox-item");

            let visibleCount = 0;

            items.forEach(item => {
                const label = item.textContent.toLowerCase();
                const matches = label.includes(searchTerm);

                if (matches && visibleCount < 6) {
                    item.style.display = "flex";
                    visibleCount++;
                } else {
                    item.style.display = "none";
                }
            });
        });
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("filterFormProducts");

    if (form) {
        // Debounced input for text fields
        form.querySelectorAll('input[type="text"]').forEach(function(input) {
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

    // Function to gather filter values and make the AJAX request
    function applyFilters(page = 1) {
        const urlParams = new URLSearchParams(window.location.search);

        let filters = {
            search_query: document.getElementById("nameFilter").value, // Adjust to your input field ID
            country: Array.from(
                document.querySelectorAll('input[name="country[]"]:checked')
            ).map(checkbox => checkbox.value), // For multiple checkboxes
            industry: Array.from(
                document.querySelectorAll('input[name="industry[]"]:checked')
            ).map(checkbox => checkbox.value), // For multiple checkboxes
            searchInput: urlParams.get('searchInput') || '',
            category_id: urlParams.get('category_id') || '',
        };

        loadFilteredData(filters);
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
