function initializeStockSellCarousel() {
    $(".stocksale-carousel").owlCarousel({
        loop: true, // Enable looping
        margin: 30, // Space between items
        nav: false, // Show navigation arrows
        dots: false, // Show dots navigation
        autoplay: true, // Auto slide
        autoplayTimeout: 3000, // Auto slide delay (in ms)
        autoplayHoverPause: true, // Pause on hover
        responsive: {
            0: {
                items: 1
            }, // 1 item for small screens
            600: {
                items: 1
            }, // 2 items for medium screens
            1000: {
                items: 1
            } // 1 item for large screens
        }
    });
}

function populateDetailedBox(card) {
    var id = $(card).data("id");
    // console.log('box populated', id);
    document.querySelectorAll(".product-card-inner").forEach(inner => {
        inner.classList.remove("product-card-featured");
    });
    card.querySelector(".product-card-inner").classList.add(
        "product-card-featured"
    );
    if (window.innerWidth < 768) {
        toggleDetailBox(); // Show modal or detail box
    }
    loadStockSellData(id);
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
        specific_id: urlParams.get('specific_id') || '',
    };

    loadFilteredData(filters);
}
function initializeDetailCarousel() {
    // Initialize Owl Carousel
    $(".details-carousel").owlCarousel({
        loop: true,
        margin: 30,
        autoplay: false,
        nav: false, // Show navigation arrows
        dots: true, // Show dots for navigation
        responsive: {
            0: {
                items: 1
            }, // 1 item on small screens
            600: {
                items: 1
            }, // 3 items on medium screens
            1000: {
                items: 1
            } // 5 items on large screens
        }
    });
}
function initializeIconCarousel() {
    // Initialize Owl Carousel
    $(".icon-carousel").owlCarousel({
        items: 1, // Show 1 image at a time
        margin: 30,
        loop: true, // Enable looping
        autoplay: false, // Disable autoplay by default
        nav: false, // Disable next/prev buttons
        dots: false // Disable pagination dots
    });

    // Play carousel on hover
    $(".icon-carousel").hover(
        function() {
            $(this).trigger("play.owl.autoplay", [1500]); // Start autoplay on hover
        },
        function() {
            $(this).trigger("stop.owl.autoplay"); // Stop autoplay when hover is removed
        }
    );
}
function toggleDetailBox() {
    const element = document.querySelector("#productModal");
    const currentDisplay = window.getComputedStyle(element).display;

    if (currentDisplay === "none") {
        element.style.display = "flex";
    } else {
        element.style.display = "none";
    }
}

function toggleFilters(e) {
    e.preventDefault();
    if (window.innerWidth < 768) {
        const elements = document.querySelectorAll(".togglebelow768");
        elements.forEach(el => {
            if (
                el.style.display === "none" ||
                getComputedStyle(el).display === "none"
            ) {
                el.style.display = "block";
            } else {
                el.style.display = "none";
            }
        });
    }
}

function sendtologin() {
    window.location.href = "/customer/auth/login";
}

document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("filterFormStockSale");

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
            specific_id: urlParams.get('specific_id') || '',
        };

        var page = $(this).data("page");
        loadFilteredData(filters, page);
    });

    applyFilters();

    // Show only first 6 items initially
    document.querySelectorAll(".filter-options").forEach(container => {
        const items = container.querySelectorAll(".checkbox-item");
        items.forEach((item, index) => {
            item.style.display = index < 160 ? "flex" : "none";
        });
    });

    // Tab switching functionality
    document.querySelectorAll(".detail-tab").forEach(tab => {
        tab.addEventListener("click", function() {
            document.querySelectorAll(".detail-tab").forEach(t => {
                t.classList.remove("active");
            });
            document
                .querySelectorAll(".detail-tab-content")
                .forEach(content => {
                    content.classList.remove("active");
                });

            this.classList.add("active");

            const targetId = this.id.replace("tab-", "content-");
            const targetContent = document.getElementById(targetId);

            targetContent.classList.add("active");
        });
    });

    // Checkbox toggle functionality
    document.querySelectorAll(".checkbox").forEach(checkbox => {
        checkbox.addEventListener("click", function() {
            this.classList.toggle("checkbox-checked");
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
    initializeDetailCarousel();

    initializeIconCarousel();
    initializeStockSellCarousel();
    const dropdownButton = document.querySelector(".dropdown-button");
    const dropdownList = document.querySelector(".dropdown-list");
    const dropdownArrow = document.querySelector(".dropdown-arrow");

    // Toggle dropdown and arrow rotation
    dropdownButton.addEventListener("click", function(event) {
        event.stopPropagation(); // Prevent closing the dropdown when clicking inside
        const isVisible = dropdownList.style.display === "block";
        dropdownList.style.display = isVisible ? "none" : "block";
        dropdownArrow.classList.toggle("rotate", !isVisible); // Toggle rotation
    });

    // Close dropdown when clicking outside
    document.addEventListener("click", function() {
        dropdownList.style.display = "none";
        dropdownArrow.classList.remove("rotate"); // Reset arrow rotation
    });

    var dropdownbutton = document.getElementById("locationdropdown");
    var dropdownchild = document.getElementById("locationdropdownchild");

    document
        .getElementById("country-search")
        .addEventListener("click", function(event) {
            event.stopPropagation();
        });

    dropdownbutton.addEventListener("click", function() {
        if (
            dropdownchild.style.display === "none" ||
            dropdownchild.style.display === ""
        ) {
            dropdownchild.style.display = "block";
        } else {
            dropdownchild.style.display = "none";
        }
    });
});
