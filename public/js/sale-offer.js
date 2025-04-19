document.addEventListener("DOMContentLoaded", function () {

    $('#toggleSidebarBtn').on('click', function () {
        const sidebar = $('#sidebar-mobile-content-saleoffer');
        const isHidden = sidebar.css('display') === 'none';
        sidebar.css('display',isHidden ? 'block' : 'none');
    });

    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("view-detail-btn")) {
            const index = e.target.getAttribute("data-index");
            const product = allProducts[index];

            const modalContent = `
                <div class="product-details-col col-md-6">
                    <table class="table table-bordered">
                    <tr><td><strong>Rate</strong></td><td>${product.price} /Piece</td></tr>
                    <tr><td><strong>Size</strong></td><td>${product.size}</td></tr>
                    <tr><td><strong>Type</strong></td><td>${product.type}</td></tr>
                    <tr><td><strong>Terms</strong></td><td>${product.terms}</td></tr>
                    <tr><td><strong>Payment</strong></td><td>${product.payment}</td></tr>
                    <tr><td><strong>Brand</strong></td><td>${product.brand}</td></tr>
                    </table>
                </div>
                <div class="contact-seller-col col-md-6">
                    <img src="${product.image}" alt="${product.title}" class="img-fluid mb-3">
                    <i class="far fa-heart favorite-icon fs-4 mb-2"></i>
                    <button class="btn btn-success w-100 mb-2">Contact Seller</button>
                    <div class="seller-name fw-bold">${product.sellerName}</div>
                    <div class="company-name text-muted">${product.companyName}</div>
                </div>
                `;

            document.getElementById("modalContent").innerHTML = modalContent;
            const modal = new bootstrap.Modal(
                document.getElementById("productDetailModal")
            );
            modal.show();
        }
    });

    const checkboxItems = document.querySelectorAll(".checkbox-item");
    checkboxItems.forEach((item) => {
        item.addEventListener("click", function () {
            const checkbox = this.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;
            this.classList.toggle("checked", checkbox.checked);
        });
    });

    const favoriteIcons = document.querySelectorAll(".favorite-icon");
    favoriteIcons.forEach((icon) => {
        icon.addEventListener("click", function () {
            this.classList.toggle("active");
            this.classList.toggle("fas");
            this.classList.toggle("far");
        });
    });

    const paginationNumbers = document.querySelectorAll(".pagination-number");
    paginationNumbers.forEach((number) => {
        number.addEventListener("click", function () {
            paginationNumbers.forEach((num) => num.classList.remove("active"));
            this.classList.add("active");
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        });
    });

    const prevPageBtn = document.getElementById("prev-page");
    const nextPageBtn = document.getElementById("next-page");

    prevPageBtn.addEventListener("click", function () {
        const activePage = document.querySelector(".pagination-number.active");
        const prevPage = activePage?.previousElementSibling;
        if (prevPage?.classList.contains("pagination-number")) {
            activePage.classList.remove("active");
            prevPage.classList.add("active");
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        }
    });

    nextPageBtn.addEventListener("click", function () {
        const activePage = document.querySelector(".pagination-number.active");
        const nextPage = activePage?.nextElementSibling;
        if (nextPage?.classList.contains("pagination-number")) {
            activePage.classList.remove("active");
            nextPage.classList.add("active");
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        }
    });

    const rfqForm = document.querySelector(".rfq-form");
    rfqForm?.addEventListener("submit", function (e) {
        e.preventDefault();
        alert("Request for Quotation submitted!");
        this.reset();
    });
});