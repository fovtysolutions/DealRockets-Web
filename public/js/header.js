$("#togglenavbar").on("click", function (event) {
    $("#navbarCollapse").show();
});
$("#navbarbutton").on("click", function (event) {
    $("#navbarCollapse").hide();
});
$("#closebutton").on("click", function (event) {
    $("#searchformclose").removeClass("active");
});
$(document).ready(function () {
    let activeRequest = null;

    $("#searchInput").on("input", function () {
        let rawInput = $(this).val();
        let search = rawInput.trim();
        let type = $(this).data("type");
        let dropdown = $("#suggestions");

        // Hide dropdown and abort request if search is empty
        if (search.length < 1) {
            if (activeRequest) {
                activeRequest.abort();
                activeRequest = null;
            }
            dropdown.hide();
            return;
        }

        // Abort any ongoing AJAX request
        if (activeRequest) {
            activeRequest.abort();
        }

        activeRequest = $.ajax({
            url: "/product-by-search",
            method: "GET",
            data: { search: search, type: type },
            success: function (response) {
                // Double check current input value hasn't changed or been cleared
                let currentInput = $("#searchInput").val().trim();
                if (currentInput.length < 1) {
                    dropdown.hide();
                    return;
                }

                dropdown.empty();
                let link = "";

                if (type === "products") {
                    link = "/product/";
                } else if (type === "buyer") {
                    link = "/buy-leads/specific_id=";
                } else if (type === "seller") {
                    link = "/sell-offer/specific_id=";
                } else {
                    dropdown.hide();
                    return;
                }

                if (response.length > 0) {
                    response.forEach((item) => {
                        let href =
                            type === "products"
                                ? `${link}${item.slug}`
                                : `${link}${item.id}`;
                        dropdown.append(
                            `<li class="data-suggest" data-id="${item.id}">
                            <a target="_blank" href="${href}" data-id="${item.id}">${item.name}</a>
                        </li>`
                        );
                    });
                    dropdown.css("display", "flex");
                } else {
                    dropdown.append("<li>No results found</li>");
                    dropdown.hide();
                }
            },
            error: function (xhr, status) {
                if (status !== "abort") {
                    console.error("Error fetching suggestions.");
                }
            },
        });
    });

    $("#dropdownbar").on("mouseenter", function () {
        $(this).css({
            "box-shadow": "0px 4px 15px rgba(0, 0, 0, 0.5)",
            "z-index": "1000",
        });

        $(this).find(".dropdownmenucat").css({
            display: "flex",
            "flex-wrap": "wrap",
            "pointer-events": "auto",
        });
    });

    $("#dropdownbar").on("mouseleave", function () {
        $(this).css({
            "background-color": "",
            "box-shadow": "",
        });

        $(this).find(".dropdownmenucat").css({
            display: "none",
            "pointer-events": "none",
        });
    });

    var dropdownbutton = document.getElementById("productssearch");
    var dropdownbuttonu = document.getElementById("leadsbuy");
    var dropdownbuttonm = document.getElementById("leadssell");
    var changehere = document.getElementById("searchInput");

    if (dropdownbutton && changehere) {
        dropdownbutton.addEventListener("click", function () {
            changehere.name = "searchInput";
        });
    }

    if (dropdownbuttonu && changehere) {
        dropdownbuttonu.addEventListener("click", function () {
            changehere.name = "search_query";
        });
    }

    if (dropdownbuttonm && changehere) {
        dropdownbuttonm.addEventListener("click", function () {
            changehere.name = "search_query";
        });
    }

    const links = document.querySelectorAll("[data-menu]");
    const currentPath = window.location.pathname;

    links.forEach((link, index) => {
        const menuPath = link.getAttribute("data-menu");
        const hasHomeCheck = link.hasAttribute("data-home");

        // If data-home is true, only evaluate the first link
        if (hasHomeCheck && index !== 0) return;

        // If data-home is not set, skip first link
        if (!hasHomeCheck && index === 0) return;

        let isMatch = false;

        if (menuPath === "/") {
            // Exact match only for Home
            isMatch = currentPath === "/";
        } else {
            // Use prefix match for everything else
            isMatch = currentPath.startsWith(menuPath);
        }

        if (isMatch) {
            link.classList.add("active-menu");
        } else {
            link.classList.remove("active-menu");
        }
    });

    function toggleDropdown() {
        document.getElementById("dropdownNav").classList.toggle("show");
    }

    window.addEventListener("click", function (e) {
        const nav = document.getElementById("dropdownNav");
        const menuBtn = document.querySelector(".hamburger");

        if (!nav.contains(e.target) && !menuBtn.contains(e.target)) {
            nav.classList.remove("show");
        }
    });

    const toggleBtn = document.getElementById("languageToggleBtn");
    const dropdown = document.getElementById("languageDropdown-class");

    toggleBtn.addEventListener("click", function (e) {
        if (e.target === toggleBtn) {
            console.log("Button clicked directly ✅");
        } else {
            console.log("Button child clicked (e.g., span inside)");
        }

        dropdown.style.display =
            dropdown.style.display === "flex" ? "none" : "flex";

        e.stopPropagation();
    });

    document.addEventListener("click", function (event) {
        if (!dropdown.contains(event.target) && event.target !== toggleBtn) {
            dropdown.style.display = "none";
        }
    });

    const dropdownP = document.querySelector(".dropdown");
    const defaultOption = document.querySelector(".default_option");
    const dropdownList = document.querySelector(".dropdown ul");
    const prosup = document.getElementById("prosup");

    // Preselect the first option
    defaultOption.textContent = dropdownList.querySelector("li").textContent;

    dropdownP.addEventListener("click", function () {
        dropdownList.classList.toggle("active"); // Toggle dropdown visibility
    });

    // Close the dropdown if an option is selected or clicked
    dropdownList.querySelectorAll("li").forEach((item) => {
        item.addEventListener("click", function () {
            defaultOption.textContent = this.textContent; // Update selected option
            prosup.action = item.dataset.route;
            dropdownList.classList.remove("active"); // Close dropdown
        });
    });

    // Close dropdown when clicking outside
    document.addEventListener("click", function (event) {
        if (!dropdownP.contains(event.target)) {
            dropdownList.classList.remove("active"); // Close dropdown if clicked outside
        }
    });

    const dropdownN = document.getElementById("productDropdown");
    const defaultOptionN = dropdownN.querySelector(".default_option");
    const searchInput = document.getElementById("searchInput");

    // Toggle dropdownN visibility when the dropdownN is clicked
    dropdownN.addEventListener("click", function () {
        const ul = dropdownN.querySelector("ul");
        ul.style.display = ul.style.display === "block" ? "none" : "block";
    });

    // Add click event listener to each dropdownN item
    dropdownN.querySelectorAll("li").forEach((item) => {
        item.addEventListener("click", function () {
            // Update the default option text
            defaultOptionN.textContent = this.textContent;

            // Change the placeholder based on the selected option
            const placeholder = this.getAttribute("data-placeholder");
            const suggest = this.getAttribute("data-suggest");
            const type = this.getAttribute("data-type");

            // Assign Data
            searchInput.placeholder = placeholder;
            searchInput.setAttribute("data-suggest", suggest);
            searchInput.setAttribute("data-type", type);

            // Close the dropdownN after selection
            dropdownN.querySelector("ul").style.display = "none";
        });
    });

    // Close dropdownN when clicking outside
    document.addEventListener("click", function (event) {
        // Check if the click is outside the dropdownN
        if (!dropdownN.contains(event.target)) {
            dropdownN.querySelector("ul").style.display = "none"; // Hide dropdown
        }
    });
});
