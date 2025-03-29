@extends('layouts.front-end.app')
@push('css_or_js')
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/dealassist.css') }}" />
@endpush
@section('title', translate('Deal Assist' . ' | ' . $web_config['name']->value))
@section('content')
    <div class="dealassist">
        <div class="main-container">
            <span class="global-success">Empowering Your Marketplace for Global Success</span>
            <span class="trusted-platform">For over 50 years, we’ve established ourselves as a trusted,
                internationally recognized platform, connecting genuine buyers and
                sellers across the globe. Our marketplace offers seamless, tailored
                solutions to foster meaningful connections, drive growth, and adapt to
                the ever-changing dynamics of global trade. With innovative tools,
                reliable market insights, and user-focused features, we empower
                businesses to seize opportunities and thrive in today’s competitive
                landscape.</span>
            <div class="frame">
                <span class="customized-marketing"><a href="#">Get customized marketing solutions!</a></span>
            </div>
            <span class="business-partners">Reach business partners through multiple channels</span><span
                class="quality-buyers">Global Sources connects suppliers with quality buyers through diverse
                content and marketing channels to enable suppliers to take advantage of
                the market trends, expand sales channels, and win buyers’ trust
                fast.</span>
            <div class="rectangle" id="currentdata" data-current="buyer">
                <div class="rectangle-1" id="moveableRedBox"></div>
                <span class="for-buyer" id="buyerClick">For Buyer</span>
                <span class="for-seller" id="sellerClick">For Seller</span>
            </div>
            <div class="group"></div>
            <div class="mobile-responsive-box">
                <div class="frame-2">
                    <div class="group-3">
                        <span class="source-products-buyer">We Source Products On Behalf of Buyer</span>
                        <div class="deal-rocket">
                            <span class="deal-rocket-4">Deal Rocket</span><span class="online-platform-international-trade">, as
                                the world’s first online platform for international trade,
                                connects buyers with top-tier suppliers across the globe. Our
                                mission is to help buyers source high-quality products from China,
                                Asia, and beyond with ease. We provide comprehensive sourcing
                                information and a network of verified suppliers, ensuring you get
                                the best deals while saving time and effort in product
                                selection.</span>
                        </div>
                    </div>
                    <div class="laptop"></div>
                </div>
                <div class="vector"></div>
                <div class="frame-5">
                    <div class="laptop-6"></div>
                    <div class="group-7">
                        <span class="provides-best-competitive">Provides Best Competitive Quotes from top suppliers</span>
                        <div class="with-deal-rocket">
                            <span class="with">With </span><span class="deal-rocket-8">Deal Rocket</span><span
                                class="direct-access">, buyers have direct access to the most competitive quotes from
                                trusted suppliers. Our platform allows buyers to easily request
                                quotes, compare products, and connect with suppliers who offer the
                                best value. Real-time communication with suppliers enables quick
                                decision-making and smooth transactions, ensuring that buyers
                                never miss a great deal.</span>
                        </div>
                    </div>
                </div>
                <div class="frame-9">
                    <div class="group-a">
                        <span class="negotiation-assist">Assist in Negotiations</span>
                        <div class="negotiation-support">
                            <span class="deal-rocket-b">Deal Rocket</span><span class="negotiation-support-c">
                                not only connects buyers with suppliers but also provides
                                essential tools to facilitate successful negotiations. Through
                                exclusive virtual and in-person trade events, we support buyers
                                with negotiation strategies, helping you secure favorable terms
                                and build lasting relationships with suppliers across global
                                markets.</span>
                        </div>
                    </div>
                    <div class="laptop-d"></div>
                </div>
                <div class="frame-e">
                    <div class="laptop-f"></div>
                    <div class="group-10">
                        <span class="assist-in-logistics">Assist in Logistics</span>
                        <div class="navigating-international-shipping">
                            <span class="navigating-international-shipping-11">Navigating the complexities of international
                                shipping can be
                                challenging, but </span><span class="deal-rocket-12">Deal Rocket</span><span
                                class="makes-it-easier-for-buyers">
                                makes it easier for buyers. Our logistics support ensures that all
                                products are delivered efficiently and on time. With our trusted
                                network of logistics partners, buyers can be confident that their
                                orders are handled securely and cost-effectively.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        // Add click event to buttons
        document.querySelectorAll('.animate-button').forEach((button) => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent default action
                const targetId = this.getAttribute('data-target'); // Get target section

                // Add loading state
                this.classList.add('loading');
                const originalText = this.innerHTML;
                this.innerHTML = "Loading...";

                // Simulate loading
                setTimeout(() => {
                    this.innerHTML = "Loaded";
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.classList.remove('loading');

                        // Scroll to target section after the animation
                        document.querySelector(targetId).scrollIntoView({
                            behavior: "smooth",
                        });
                    }, 400); // Show "Loaded" text for 0.4 seconds
                }, 1000); // Show "Loading..." text for 1 second
            });
        });
    </script>
    <script>
        var buyerlist = document.getElementById('buyer');
        var supplierlist = document.getElementById('supplier');
        var buyerbutton = document.getElementById('buyerbutton');
        var supplierbutton = document.getElementById('supplierbutton');

        function showElement(elementToShow, elementToHide) {
            // Show the target element with animation
            elementToShow.style.display = 'block'; // Make it visible
            setTimeout(() => {
                elementToShow.classList.add('active'); // Trigger animation
            }, 10); // Slight delay to ensure transition works

            // Hide the other element gracefully
            elementToHide.classList.remove('active'); // Start hide animation
            setTimeout(() => {
                elementToHide.style.display = 'none'; // Completely hide after animation
            }, 700); // Match the animation duration
        }

        buyerbutton.addEventListener('click', function() {
            showElement(buyerlist, supplierlist);
        });

        supplierbutton.addEventListener('click', function() {
            showElement(supplierlist, buyerlist);
        });
    </script>
    <script>
        $(document).ready(function(){
            $("#buyerClick").click(function(){
                let currentData = $("#currentdata").data("current");
                $('#sellerClick').css('color','black');
                if (currentData === "seller") {
                    $("#moveableRedBox").css("transform", "translateX(0px)");
                    $(this).css('color','white');
                    $("#currentdata").data("current", "buyer");
                }
            });

            $("#sellerClick").click(function(){
                let currentData = $("#currentdata").data("current");
                $('#buyerClick').css('color','black');
                if (currentData === "buyer") {
                    $("#moveableRedBox").css("transform", "translateX(150px)");
                    $(this).css('color','white');
                    $("#currentdata").data("current", "seller");
                }
            });
        });
    </script>
@endpush
