<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/multitab.css') }}" />
<div class="mainpagesection shadow">
    <div class="tabs-container" id="tabs1">
        <div class="tabs">
            <div class="tab-links">
                <button class="tab-link active" data-tab="tab-1" style="outline: none;"><i class="fas fa-info-circle"></i>
                    Deal Assist</button>
                <button class="tab-link" data-tab="tab-2" style="outline: none;"><i class="fas fa-list"></i>Stock
                    Sell</button>
                <button class="tab-link" data-tab="tab-3" style="outline: none;"><i class="fas fa-envelope"></i>
                    Industry Jobs</button>
            </div>

            <div class="tab-content active" id="tab-1">
                @include('web-views.partials._dealassist')
            </div>

            <div class="tab-content" id="tab-2">
                @include('web-views.partials._stocksalesticker')
            </div>

            <div class="tab-content" id="tab-3">
                @include('web-views.partials._sendcv')
            </div>
        </div>
    </div>
</div>
<script>
    // Click Links
    document.getElementById('industryjobs').addEventListener('click', function() {
        window.location.href = "{{ route('sendcv') }}";
    });
    document.getElementById('stocksell').addEventListener('click', function() {
        window.location.href = "{{ route('stocksale') }}";
    });

    // Tab functionality
    const tabLink = document.querySelectorAll('.tab-link');
    const tabContents = document.querySelectorAll('.tab-content');

    let activeTabIndex = 0; // Start with the first tab
    let tabInterval; // Declare interval variable
    let isTabClicked = false; // Track if a tab was clicked

    // Function to switch to the next tab
    function switchToNextTab() {
        if (isTabClicked) return; // Stop automatic switching if a tab was clicked

        // Remove 'active' class from the current tab link and content
        tabLink[activeTabIndex].classList.remove('active');
        tabContents[activeTabIndex].classList.remove('active');

        // Move to the next tab
        activeTabIndex = (activeTabIndex + 1) % tabLink.length; // Loop back to the first tab

        // Add 'active' class to the next tab link and content
        tabLink[activeTabIndex].classList.add('active');
        tabContents[activeTabIndex].classList.add('active');
    }

    // Event listener for manual tab switching
    tabLink.forEach((link) => {
        link.addEventListener('click', () => {
            // Remove active class from all links and contents
            tabLink.forEach((link) => link.classList.remove('active'));
            tabContents.forEach((content) => content.classList.remove('active'));

            // Add active class to the clicked tab
            link.classList.add('active');
            const targetTab = document.getElementById(link.dataset.tab);
            targetTab.classList.add('active');

            // Update the activeTabIndex
            activeTabIndex = Array.from(tabLink).indexOf(link);

            // Stop the automatic tab switching
            clearInterval(tabInterval);
            isTabClicked = true; // Mark as manually controlled
        });
    });

    // Add dynamic gradient to tab-links
    document.addEventListener('DOMContentLoaded', function() {
        const wideBannerTexts = document.querySelectorAll('.tab-link');

        wideBannerTexts.forEach((text) => {
            // Generate two random, visually appealing colors
            const randomColor1 = `hsl(${Math.floor(Math.random() * 360)}, 70%, 40%)`; // Darker hue
            const randomColor2 =
            `hsl(${Math.floor(Math.random() * 360)}, 70%, 50%)`; // Medium-light hue

            // Apply gradient as a background to the tab link
            text.style.background = `linear-gradient(45deg, ${randomColor1}, ${randomColor2})`;
        });

        // Automatically change tabs every 3 seconds
        tabInterval = setInterval(switchToNextTab, 3000);

        // Pause automatic tab switching on hover
        const tabsContainer = document.getElementById('tabs1');
        if (tabsContainer) {
            tabsContainer.addEventListener('mouseenter', () => {
                clearInterval(tabInterval);
            });
            tabsContainer.addEventListener('mouseleave', () => {
                if (!isTabClicked) {
                    tabInterval = setInterval(switchToNextTab, 3000);
                }
            });
        }
    });
</script>
