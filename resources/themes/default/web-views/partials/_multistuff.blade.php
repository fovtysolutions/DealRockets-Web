<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/multitab1.css') }}" />
<div class="mainpagesection custom-dealrock-banner-large">
    <div class="tab-containeruno" id="tabs2">
        <div class="tabsuno">
            <div class="tab-linkssuno d-flex flex-row mb-3" style="justify-content: end;">
                <div class="leadstitle2 active" data-tab="tab-4" style="outline: none;position: absolute;left: 44%;top: 7px;text-transform: uppercase;">
                    Trade shows</div>
                <a href="{{ route('tradeshow') }}" class="top-movers-viewall" style="text-decoration: none;">View All <i style="color:#ED4553;" class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left mr-1 ml-n1 mt-1 float-left' : 'right ml-1 mr-n1'}}"></i></a>
                {{-- <button class="tab-linksuno" data-tab="tab-5" style="outline: none;"><i class="fas fa-list"></i>Marketplace</button> --}}
            </div>

            <div class="tab-contentuno active" id="tab-4">
                @include('web-views.partials._tradeshow')
            </div>

            <div class="tab-contentuno" id="tab-5">
                @include('web-views.partials._marketplacesticker')
            </div>
        </div>
    </div>
</div>
<script>
    // Tab functionality
    const tabLinksuno = document.querySelectorAll('.tab-linksuno');
    const tabContentsuno = document.querySelectorAll('.tab-contentuno');

    let activeTabIndexuno = 0; // Start with the first tab
    let tabIntervaluno; // Declare interval variable
    let isTabClickeduno = false; // Track if a tab was clicked

    // Function to switch to the next tab
    function switchToNextTabuno() {
        if (isTabClickeduno) return; // Stop automatic switching if a tab was clicked

        // Remove 'active' class from the current tab link and content
        tabLinksuno[activeTabIndexuno].classList.remove('active');
        tabContentsuno[activeTabIndexuno].classList.remove('active');

        // Move to the next tab
        activeTabIndexuno = (activeTabIndexuno + 1) % tabLinksuno.length; // Loop back to the first tab

        // Add 'active' class to the next tab link and content
        tabLinksuno[activeTabIndexuno].classList.add('active');
        tabContentsuno[activeTabIndexuno].classList.add('active');
    }

    // Event listener for manual tab switching
    tabLinksuno.forEach((link) => {
        link.addEventListener('click', () => {
            // Remove active class from all links and contents
            tabLinksuno.forEach((link) => link.classList.remove('active'));
            tabContentsuno.forEach((content) => content.classList.remove('active'));

            // Add active class to the clicked tab
            link.classList.add('active');
            const targetTab1 = document.getElementById(link.dataset.tab);
            targetTab1.classList.add('active');

            // Update the activeTabIndexuno
            activeTabIndexuno = Array.from(tabLinksuno).indexOf(link);

            // Stop the automatic tab switching
            clearInterval(tabIntervaluno);
            isTabClickeduno = true; // Mark as manually controlled
        });
    });

    // Add dynamic gradient to tab-links
    document.addEventListener('DOMContentLoaded', function() {
        const wideBannerTexts1 = document.querySelectorAll('.tab-linksuno');

        // Automatically change tabs every 3 seconds
        tabIntervaluno = setInterval(switchToNextTabuno, 3000);

        // Pause automatic tab switching on hover
        const tabsContainer1 = document.getElementById('tabs2');
        if (tabsContainer1) {
            tabsContainer1.addEventListener('mouseenter', () => {
                clearInterval(tabIntervaluno);
            });
            tabsContainer1.addEventListener('mouseleave', () => {
                if (!isTabClickeduno) {
                    tabIntervaluno = setInterval(switchToNextTabuno, 3000);
                }
            });
        }
    });
</script>
