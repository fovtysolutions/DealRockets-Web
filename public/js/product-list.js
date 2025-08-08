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
            
            // Handle hierarchical category search differently
            if (targetSelector === "#hierarchicalcategory") {
                const allItems = container.querySelectorAll(".checkbox-item");
                let visibleCount = 0;

                allItems.forEach(item => {
                    const label = item.textContent.toLowerCase();
                    const matches = label.includes(searchTerm);

                    if (matches && visibleCount < 20) {
                        // Check if item should be visible based on hierarchy rules
                        let shouldShow = false;
                        
                        if (item.classList.contains('main-category-item')) {
                            // Main categories can always be shown if they match
                            shouldShow = true;
                        } else if (item.classList.contains('sub-category-item')) {
                            // Sub-categories should only show if their parent is checked
                            const parentId = item.getAttribute('data-parent-id');
                            const parentCheckbox = container.querySelector(`input[name="industry[]"][value="${parentId}"]`);
                            shouldShow = parentCheckbox && parentCheckbox.checked;
                            
                            // Also show the parent if this sub-category matches
                            if (shouldShow) {
                                const parentItem = container.querySelector(`[data-category-id="${parentId}"]`);
                                if (parentItem) {
                                    parentItem.style.setProperty('display', 'flex', 'important');
                                }
                            }
                        } else if (item.classList.contains('sub-sub-category-item')) {
                            // Sub-sub-categories should only show if their parent sub-category is checked
                            const subParentId = item.getAttribute('data-sub-parent-id');
                            const subParentCheckbox = container.querySelector(`input[name="sub_category[]"][value="${subParentId}"]`);
                            shouldShow = subParentCheckbox && subParentCheckbox.checked;
                            
                            // Also show the parent hierarchy if this sub-sub-category matches
                            if (shouldShow) {
                                const subParentItem = container.querySelector(`[data-sub-category-id="${subParentId}"]`);
                                if (subParentItem) {
                                    subParentItem.style.setProperty('display', 'flex', 'important');
                                    const mainParentId = subParentItem.getAttribute('data-parent-id');
                                    const mainParentItem = container.querySelector(`[data-category-id="${mainParentId}"]`);
                                    if (mainParentItem) {
                                        mainParentItem.style.setProperty('display', 'flex', 'important');
                                    }
                                }
                            }
                        }
                        
                        if (shouldShow) {
                            item.style.setProperty('display', 'flex', 'important');
                            visibleCount++;
                        } else {
                            item.style.setProperty('display', 'none', 'important');
                        }
                    } else if (!searchTerm) {
                        // Reset hierarchy when search is cleared
                        if (item.classList.contains('main-category-item')) {
                            item.style.setProperty('display', 'flex', 'important');
                        } else {
                            // Hide sub items unless their parent is checked
                            const input = item.querySelector('input[type="checkbox"]');
                            if (item.classList.contains('sub-category-item')) {
                                const parentId = item.getAttribute('data-parent-id');
                                const parentCheckbox = container.querySelector(`input[name="industry[]"][value="${parentId}"]`);
                                const displayValue = parentCheckbox && parentCheckbox.checked ? "flex" : "none";
                                item.style.setProperty('display', displayValue, 'important');
                            } else if (item.classList.contains('sub-sub-category-item')) {
                                const subParentId = item.getAttribute('data-sub-parent-id');
                                const subParentCheckbox = container.querySelector(`input[name="sub_category[]"][value="${subParentId}"]`);
                                const displayValue = subParentCheckbox && subParentCheckbox.checked ? "flex" : "none";
                                item.style.setProperty('display', displayValue, 'important');
                            }
                        }
                    } else {
                        item.style.setProperty('display', 'none', 'important');
                    }
                });
            } else {
                // Original logic for other filters
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
            }
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
            sub_category: Array.from(
                document.querySelectorAll('input[name="sub_category[]"]:checked')
            ).map(checkbox => checkbox.value), // For sub-category filtering
            sub_sub_category: Array.from(
                document.querySelectorAll('input[name="sub_sub_category[]"]:checked')
            ).map(checkbox => checkbox.value), // For sub-sub-category filtering
            searchInput: urlParams.get('searchInput') || '',
            category_id: urlParams.get('category_id') || '',
        };

        loadFilteredData(filters);
        
        // Maintain category hierarchy after applying filters
        setTimeout(() => {
            if (typeof maintainCategoryHierarchy === 'function') {
                maintainCategoryHierarchy();
            }
        }, 100);
    }

    $(document).on("click", ".pagination a", function(e) {
        e.preventDefault();

        const urlParams = new URLSearchParams(window.location.search);

        let filters = {
            search_query: document.getElementById("nameFilter").value, // Adjust to your input field ID
            country: Array.from(
                document.querySelectorAll('input[name="country[]"]:checked')
            ).map(checkbox => checkbox.value), // For multiple checkboxes
            industry: Array.from(
                document.querySelectorAll('input[name="industry[]"]:checked')
            ).map(checkbox => checkbox.value), // For multiple checkboxes
            sub_category: Array.from(
                document.querySelectorAll('input[name="sub_category[]"]:checked')
            ).map(checkbox => checkbox.value), // For sub-category filtering
            sub_sub_category: Array.from(
                document.querySelectorAll('input[name="sub_sub_category[]"]:checked')
            ).map(checkbox => checkbox.value), // For sub-sub-category filtering
            searchInput: urlParams.get('searchInput') || '',
            category_id: urlParams.get('category_id') || '',
        };

        var page = $(this).data("page");
        loadFilteredData(filters, page);
    });

    applyFilters();
});

// Function to maintain category hierarchy after AJAX calls
function maintainCategoryHierarchy() {
    const container = document.querySelector("#hierarchicalcategory");
    if (!container) return;
    
    // Hide all sub and sub-sub categories first
    container.querySelectorAll('.sub-category-item, .sub-sub-category-item').forEach(item => {
        item.style.setProperty('display', 'none', 'important');
    });
    
    // Show sub-categories only if their parent main category is checked
    container.querySelectorAll('input[name="industry[]"]:checked').forEach(input => {
        const categoryId = input.value;
        const subCategories = container.querySelectorAll(`[data-parent-id="${categoryId}"]`);
        subCategories.forEach(subCategory => {
            subCategory.style.setProperty('display', 'flex', 'important');
        });
    });
    
    // Show sub-sub-categories only if their parent sub-category is checked
    container.querySelectorAll('input[name="sub_category[]"]:checked').forEach(input => {
        const subCategoryId = input.value;
        const subSubCategories = container.querySelectorAll(`[data-sub-parent-id="${subCategoryId}"]`);
        subSubCategories.forEach(subSubCategory => {
            subSubCategory.style.setProperty('display', 'flex', 'important');
        });
    });
}

// Call maintainCategoryHierarchy after page load and after any filter changes
document.addEventListener('DOMContentLoaded', function() {
    maintainCategoryHierarchy();
});
