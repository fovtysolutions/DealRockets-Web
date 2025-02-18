<section class="mainpagesection deal-assist-banner custom-dealrock-banner-small" style="background-color: white;">
    <span style="position: absolute;top: 20px;left: 20px;">
        <h4 class="custom-dealrock-head">
            Making Trade Simple, Reliable, and Successful with Deal Assist
        </h4>
    </span>
    <div class="h-100">
        <div class="steps-wrapper">
            <!-- Step Indicator (on the left) -->
            <div class="step-indicatoru">
                <div class="stepu active" data-step="0">1</div>
                <div class="stepu" data-step="1">2</div>
                <div class="stepu" data-step="2">3</div>
                <div class="stepu" data-step="3">4</div>
            </div>

            <!-- Step Content (Text and Images) -->
            <div class="steps-content">
                <!-- Text Content -->
                <div class="step-text">
                    <h3 id="step-titleu" class="custom-dealrock-subhead">Step 1: Browse Products</h3>
                    <h4 class="step-subtitle custom-dealrock-text">Discover the Best Selection</h4>
                    <p class="custom-dealrock-text" id="step-descriptionu">
                        Explore our wide variety of products to find what fits your needs perfectly.
                        Take your time to explore and learn about the features that will best serve your needs.
                        We offer top-rated items, ranging from electronics to everyday essentials.
                    </p>
                    <p class="custom-dealrock-text" class="step-extra">
                        Whether you're looking for the latest tech gadgets or home essentials, we have something for
                        everyone.
                        Browse through categories and check out detailed reviews to make informed decisions!
                    </p>
                </div>

                <!-- Image Content -->
                <div class="step-images">
                    <img id="step-imageu" src="/images/infinite_scroll.gif" alt="Step 1 Image" />
                </div>
            </div>
        </div>

        <!-- Start Now Button -->
        <a href="#" class="cta-button custom-dealrock-text" style="color: white;" id="start-btn">Find out More >></a>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const steps = document.querySelectorAll('.stepu');
        const stepTitles = [
            'Step 1: Browse Products',
            'Step 2: Add to Cart',
            'Step 3: Apply Coupons',
            'Step 4: Checkout'
        ];
        const stepDescriptions = [
            'Explore our wide variety of products to find what fits your needs perfectly. Take your time to explore!',
            'Select the items you want to purchase and add them to your shopping cart. You can review them at any time!',
            'Check out available discount codes and apply them to save even more. We always have great deals waiting for you!',
            'Review your cart, provide payment details, and confirm your purchase to get the best deals delivered straight to you.'
        ];
        const stepImages = [
            '/images/infinite_scroll.gif',
            '/images/image2.png',
            '/images/coupon-applied.gif',
            '/images/image4.png'
        ];

        let currentStep = 0;

        // Function to update the step content
        function updateStep(stepIndex) {
            steps.forEach((step, index) => {
                step.classList.toggle('active', index === stepIndex);
            });

            document.getElementById('step-titleu').textContent = stepTitles[stepIndex];
            document.getElementById('step-descriptionu').textContent = stepDescriptions[stepIndex];
            document.getElementById('step-imageu').src = stepImages[stepIndex];
        }

        // Function to handle step change when a step indicator is clicked
        function switchToStep(stepIndex) {
            currentStep = stepIndex;
            updateStep(currentStep);
        }

        // Handle Start Button Click (Next Step logic)
        const startButton = document.getElementById('start-btn');
        startButton.addEventListener('click', (event) => {
            event.preventDefault(); // Prevent the default link behavior

            if (currentStep < steps.length - 1) {
                // If not the last step, move to the next step
                currentStep++;
                updateStep(currentStep);
            } else {
                // If it's the last step, redirect to the dealassist page
                window.location.href = '{{ route('dealassist') }}'; // Replace with the correct route
            }
        });

        // Add event listeners to step indicators
        steps.forEach(step => {
            step.addEventListener('click', (event) => {
                const stepIndex = parseInt(event.target.getAttribute('data-step'));
                switchToStep(stepIndex);
            });
        });

        updateStep(currentStep); // Initialize first step
    });
</script>
