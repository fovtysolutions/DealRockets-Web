function showHiddenTables() {
    // Show all hidden tables
    const hiddenTables = document.querySelectorAll(".specs-table.hide");
    hiddenTables.forEach(table => {
        table.classList.remove("hide");
    });

    // Hide the button after click
    const btn = document.querySelector(".see-more-btn");
    if (btn) {
        btn.style.display = "none";
    }
}

function sendtologin() {
    window.location.href = "/customer/auth/login";
}

document.addEventListener("DOMContentLoaded", function() {
    new Swiper(".swiper", {
        direction: "horizontal",
        loop: true,
        slidesPerView: 3, // or 'auto'
        spaceBetween: 20,
        mousewheel: {
            forceToAxis: true, // prevents vertical scroll conflict
            invert: false
        },
        breakpoints: {
            640: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 3 }
        }
    });

    // Handle thumbnail clicks
    const mainImage = document.getElementById("mainImage");
    const thumbnails = document.querySelectorAll(".thumbnail");

    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener("click", function() {
            mainImage.src = this.src;
        });
    });

    // Handle tab switching
    const tabs = document.querySelectorAll(".tab");
    const tabdata = document.querySelectorAll(".tabdata");
    tabs.forEach(tab => {
        tab.addEventListener("click", function() {
            var toggleId = this.getAttribute("data-toggleid");
            var toggleElement = document.getElementById(toggleId);
            // Remove active class from all tabs
            tabs.forEach(t => t.classList.remove("active"));
            tabdata.forEach(t => (t.style.display = "none"));
            // Add active class to clicked tab
            this.classList.add("active");
            toggleElement.style.display = "block";
        });
    });

    // Handle subtab switching
    const subtabs = document.querySelectorAll(".subtab");
    const subtabsdatas = document.querySelectorAll(".subtabdata");
    subtabs.forEach(subtab => {
        subtab.addEventListener("click", function() {
            var toggleId = this.getAttribute("data-toggleid");
            var toggleElement = document.getElementById(toggleId);
            // Remove active class from all subtabs
            subtabs.forEach(t => t.classList.remove("active"));
            subtabsdatas.forEach(t => (t.style.display = "none"));
            // Add active class to clicked subtab
            this.classList.add("active");
            toggleElement.style.display = "block";
        });
    });

    // Handle quantity input
    const quantityInput = document.querySelector(".quantity-input");
    if (quantityInput) {
        quantityInput.addEventListener("click", function() {
            // Add quantity selection logic here
            console.log("Quantity input clicked");
        });
    }

    // Handle Add to Cart
    const addToCartBtn = document.querySelector(".btn-cart");
    if (addToCartBtn) {
        addToCartBtn.addEventListener("click", function() {
            // Add to cart logic here
            console.log("Add to cart clicked");
            alert("Product added to cart!");
        });
    }

    // Handle Inquire Now
    const inquireBtn = document.querySelector(".btn-inquire");
    if (inquireBtn) {
        inquireBtn.addEventListener("click", function() {
            // Scroll to inquiry form
            const inquiryForm = document.querySelector(".inquiry-form");
            inquiryForm.scrollIntoView({
                behavior: "smooth"
            });
        });
    }

    // Handle inquiry form submission
    const inquiryForm = document.getElementById("inquiryForm");
    if (inquiryForm) {
        inquiryForm.addEventListener("submit", function(e) {
            e.preventDefault();
            const email = document.getElementById("email").value;
            const message = document.getElementById("message").value;

            console.log("Inquiry submitted:", {
                email,
                message
            });

            // Reset form
            inquiryForm.reset();

            // Show success message
            alert("Your inquiry has been sent successfully!");
        });
    }

    // Handle start order buttons
    const startOrderBtns = document.querySelectorAll(".start-order-btn");
    startOrderBtns.forEach(btn => {
        btn.addEventListener("click", function() {
            console.log("Start order clicked");
            alert("Order process initiated!");
        });
    });

    // Handle "Buy Sample" link click
    const buySampleLink = document.querySelector(".buy-sample");
    if (buySampleLink) {
        buySampleLink.addEventListener("click", function() {
            console.log("Buy sample clicked");
            alert("Sample purchase process initiated!");
        });
    }
});
