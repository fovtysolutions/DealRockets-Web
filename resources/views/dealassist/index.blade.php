@extends('layouts.front-end.app')
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/dealassist.css') }}" />
<!-- Include jQuery and Owl Carousel -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/js/swiper.js"
    integrity="sha512-vtbFVybaj5JGg0+f2nzplUxp+5NSqxyInLlVFmUyXEEawwwckoT24Lq2LgWJflhpdlL73s1F0t4AQpFZ9qf9rQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/css/swiper.css"
    integrity="sha512-uMIpMpgk4n6esmgdfJtATLLezuZNRb96YEgJXVeo4diHFOF/gqlgu4Y5fg+56qVYZfZYdiqnAQZlnu4j9501ZQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@section('title', translate('Deal Assist' . ' | ' . $web_config['name']->value))
@section('content')
    <div class="mainpagesection" style="background-color:unset;">
        <div
            class="syp_intro" style="overflow: hidden;margin-bottom: 22px;height: 400px;background-color: white;">
            <div class="syp_con syp_introCon">
                <div class="intro_con">
                    <div class="tit" data-swiper-parallax-y="20">
                        <h1 class="text-black">Empowering Your Marketplace for Global Success</h1>
                    </div>
                    <p class="txt" data-swiper-parallax-y="20">For over 50 years, we’ve established ourselves as a
                        trusted, internationally recognized platform, connecting genuine buyers and sellers across the
                        globe. Our marketplace offers seamless, tailored solutions to foster meaningful connections, drive
                        growth, and adapt to the ever-changing dynamics of global trade. With innovative tools, reliable
                        market insights, and user-focused features, we empower businesses to seize opportunities and thrive
                        in today’s competitive landscape.</p>
                    <a href="#services" class="btn js_sensorBtn" sensor="home_btn_1">Get customized marketing solutions!</a>
                </div>
                <a class="intro_img" href="#"><img src="/images/marketplace.gif"></a>
            </div>
        </div>
        <div id="services" class="syp_services"
            style="background-color: white;">
            <div class="syp_con syp_servicesCon">
                <!-- Top Content -->
                <div class="syp_titCon" id="marketing">
                    <div id="marketing">
                        <h2 class="tit">
                            <a target="_blank" href="/syp/en/marketing/" class="text-decoration-none text-black">
                                Reach business partners through multiple channels
                            </a>
                        </h2>
                        <p class="txt">
                            Global Sources connects suppliers with quality buyers through diverse content and marketing
                            channels
                            to enable suppliers to take advantage of the market trends, expand sales channels, and win
                            buyers’ trust fast.
                        </p>
                        {{-- <a target="_blank" href="/syp/en/marketing/" class="more_btn2">Learn more <i
                                class="iconfont ic_long-arrow"></i></a> --}}
                    </div>
                </div>
                {{-- Bottom Content --}}
                <div class="buttonsbox mt-5">
                    <a href="#buyer" class="btn text-white mr-3 animate-button" id="buyerbutton">
                        For Buyer
                    </a>
                    <a href="#supplier" class="btn text-white animate-button" id="supplierbutton">
                        For Supplier
                    </a>
                </div>
            </div>
        </div>
        {{-- Buyer --}}
        <div class="syp_home_bg" id="buyer">
            <div class="syp_con syp_tradeDetail firstslider">
                <div class="img"><img src="/images/dealassist/screen-gs.png"></div>
                <div class="syp_titCon">
                    <dl>
                        <dt class="tit">We Source Products On Behalf of Buyer</dt>
                        <dd class="txt">DealRocket, as the world’s first online platform for international trade,
                            connects buyers with top-tier suppliers across the globe. Our mission is to help buyers source
                            high-quality products from China, Asia, and beyond with ease. We provide comprehensive sourcing
                            information and a network of verified suppliers, ensuring you get the best deals while saving
                            time and effort in product selection.</dd>
                    </dl>
                </div>
            </div>
            <div class="syp_con syp_tradeDetail firstslider">
                <div class="img"><img src="/images/dealassist/app-1.png"></div>
                <div class="syp_titCon">
                    <dl>
                        <dt class="tit">Provides Best Competitive Quotes from top suppliers</dt>
                        <dd class="txt">With DealRocket, buyers have direct access to the most competitive quotes from
                            trusted suppliers. Our platform allows buyers to easily request quotes, compare products, and
                            connect with suppliers who offer the best value. Real-time communication with suppliers enables
                            quick decision-making and smooth transactions, ensuring that buyers never miss a great deal.
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="syp_con syp_tradeDetail firstslider">
                <div class="img"><img src="/images/dealassist/ts-site.png"></div>
                <div class="syp_titCon">
                    <dl>
                        <dt class="tit">Assist in Negotiations</dt>
                        <dd class="txt">DealRocket not only connects buyers with suppliers but also provides essential
                            tools to facilitate successful negotiations. Through exclusive virtual and in-person trade
                            events, we support buyers with negotiation strategies, helping you secure favorable terms and
                            build lasting relationships with suppliers across global markets.</dd>
                    </dl>
                </div>
            </div>
            <div class="syp_con syp_tradeDetail firstslider">
                <div class="img"><img src="/images/dealassist/magazine.png"></div>
                <div class="syp_titCon">
                    <dl>
                        <dt class="tit">Assist in Logistics</dt>
                        <dd class="txt">Navigating the complexities of international shipping can be challenging, but
                            DealRocket makes it easier for buyers. Our logistics support ensures that all products are
                            delivered efficiently and on time. With our trusted network of logistics partners, buyers can be
                            confident that their orders are handled securely and cost-effectively.</dd>
                    </dl>
                </div>
            </div>
            <div class="syp_con syp_tradeDetail firstslider">
                <div class="img"><img src="/images/dealassist/rb_2148582318.png"></div>
                <div class="syp_titCon">
                    <dl>
                        <dt class="tit">Self Payment System</dt>
                        <dd class="txt">DealRocket’s secure self-payment system gives buyers complete control over their
                            transactions. With clear payment terms and multiple payment options, buyers can complete
                            purchases confidently, knowing their transactions are transparent and protected throughout the
                            process.</dd>
                    </dl>
                </div>
            </div>
            <div class="syp_con syp_tradeDetail firstslider">
                <div class="img"><img src="/images/dealassist/lodging_wellbeingsatwork.jpg"></div>
                <div class="syp_titCon">
                    <dl>
                        <dt class="tit">Global Sources trade magazines</dt>
                        <dd class="txt">Stay informed and ahead of the market with DealRocket’s trade magazines. Our
                            publications provide insights into specific verticals, including electronics, hardware, and
                            more. These magazines deliver the latest industry news, product trends, and sourcing strategies,
                            helping buyers make well-informed decisions.</dd>
                    </dl>
                </div>
            </div>
        </div>
        {{-- End Buyer --}}
        {{-- Supplier --}}
        <div class="syp_home_bg" id="supplier">
            <div class="syp_con syp_tradeDetail secondslider">
                <div class="img"><img src="/images/dealassist/screen-gs.png"></div>
                <div class="syp_titCon">
                    <dl>
                        <dt class="tit">Helping Suppliers to find the buyer of the products</dt>
                        <dd class="txt">DealRocket is committed to helping suppliers connect with the right buyers for
                            their products. Through our global platform, we provide suppliers with enhanced visibility and
                            access to a diverse range of buyers. Our targeted marketing campaigns and trade events ensure
                            that suppliers reach their ideal customers, driving growth and success.</dd>
                    </dl>
                </div>
            </div>
            <div class="syp_con syp_tradeDetail secondslider">
                <div class="img"><img src="/images/dealassist/app-1.png"></div>
                <div class="syp_titCon">
                    <dl>
                        <dt class="tit">Exporting on Behalf of the Suppliers to secure Deals</dt>
                        <dd class="txt">DealRocket offers an export service for suppliers, helping them secure
                            international deals by acting as a bridge to global buyers. Our platform’s international reach
                            and established networks enable suppliers to expand their market presence, while our expert
                            guidance ensures the process is seamless and efficient.</dd>
                    </dl>
                </div>
            </div>
            <div class="syp_con syp_tradeDetail secondslider">
                <div class="img"><img src="/images/dealassist/ts-site.png"></div>
                <div class="syp_titCon">
                    <dl>
                        <dt class="tit">Promote the product in demand of company Market</dt>
                        <dd class="txt">With DealRocket’s marketing tools, suppliers can promote their products directly
                            to the buyers who need them the most. By participating in global trade events, digital marketing
                            campaigns, and product showcases, suppliers can increase their product visibility and drive
                            demand in competitive markets.</dd>
                    </dl>
                </div>
            </div>
            <div class="syp_con syp_tradeDetail secondslider">
                <div class="img"><img src="/images/dealassist/magazine.png"></div>
                <div class="syp_titCon">
                    <dl>
                        <dt class="tit">Operation Assistance</dt>
                        <dd class="txt">DealRocket offers operational assistance to suppliers, helping them optimize
                            their sales and production processes. We provide insights on improving supply chain efficiency,
                            developing new products, and navigating international trade regulations, ensuring that suppliers
                            have the support they need to succeed in a global marketplace.</dd>
                    </dl>
                </div>
            </div>
        </div>
        {{-- End Supplier --}}
    </div>
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
@endsection
