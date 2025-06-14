@extends('layouts.front-end.app')
@push('css_or_js')
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/dealassist.css') }}" />
@endpush
@section('title', translate('Deal Assist' . ' | ' . $web_config['name']->value))
@section('content')
    <div class="dealassist">
        <div class="main-container">
            <div class="max1440">
                <div class="header-section">
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
                </div>
            </div>
            <div class="max1440">
                <div class="group"></div>
                <span class="business-partners">Reach business partners through multiple channels</span>
                <span class="quality-buyers dealassist-desc-tab buyer">DealRockets facilitates buyers to search verified
                    supplier for their required
                    products and get the product without any hassle of chasing the supplier on production and
                    shipment operation. Deal rocket has the pool of verified suppliers around the world listed on
                    the platform.
                    fast.
                </span>
                <span class="quality-buyers dealassist-desc-tab supplier d-none">This facilitates supplier to find the buyer
                    of their desired products. Supplier
                    can request deal rocket team to use this feature by taking the highest membership.
                </span>
                <div class="rectangle" id="currentdata" data-current="buyer">
                    <div class="rectangle-1" id="moveableRedBox"></div>
                    <span class="for-buyer" id="buyerClick">For Buyer</span>
                    <span class="for-seller" id="sellerClick">For Seller</span>
                </div>
                <div id="buyerTimeline" class="dealassist-tab buyer">
                    <div class="timeline hide-line">
                        <div class="timeline-container left">
                            <a href="#" class="content-link">
                                <div class="content">
                                    Buyer requests the DR to find the supplier of his product in the international market
                                </div>
                            </a>
                        </div>
                        <div class="timeline-container right">
                            <a href="#" class="content-link">
                                <div class="content">
                                    DR will provide the best quote from the top supplier
                                </div>
                            </a>
                        </div>
                        <div class="timeline-container left">
                            <a href="#" class="content-link">
                                <div class="content">
                                    Assist in the finalization of terms and condition
                                </div>
                            </a>
                        </div>
                        <div class="timeline-container right">
                            <a href="#" class="content-link">
                                <div class="content">
                                    Assist and provide due diligence of both the parties and exchange with each other
                                </div>
                            </a>
                        </div>
                        <div class="timeline-container left">
                            <a href="#" class="content-link">
                                <div class="content">
                                    Assist in the sampling process and take approval
                                </div>
                            </a>
                        </div>
                        <div class="timeline-container right">
                            <a href="#" class="content-link">
                                <div class="content">
                                    Take care of the production lead time
                                </div>
                            </a>
                        </div>
                        <div class="timeline-container left">
                            <a href="#" class="content-link">
                                <div class="content">
                                    Provide full report about quality and dispatch by verified 3rd party
                                </div>
                            </a>
                        </div>
                        <div class="timeline-container right">
                            <a href="#" class="content-link">
                                <div class="content">
                                    Provide logistic support if buyer wants to import on FOB
                                </div>
                            </a>
                        </div>
                        <div class="timeline-container left">
                            <a href="#" class="content-link">
                                <div class="content">
                                    Assist in the documentation and operation process
                                </div>
                            </a>
                        </div>
                        <div class="timeline-container right">
                            <a href="#" class="content-link">
                                <div class="content">
                                    Collect the balance payment and close the deal
                                </div>
                            </a>
                        </div>
                        <div class="timeline-container left">
                            <a href="#" class="content-link">
                                <div class="content">
                                    Successfully completion of the deal
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div id="supplierTimeline" class="dealassist-tab supplier d-none">
                    <div class="timeline hide-line">
                        <div class="timeline-container left">
                            <a href="#" class="content-link">
                                <div class="content">
                                    Find buyer for desired products
                                </div>
                            </a>
                        </div>
                        <div class="timeline-container right">
                            <a href="#" class="content-link">
                                <div class="content">
                                    Assist in the finalization of terms and condition
                                </div>
                            </a>
                        </div>
                        <div class="timeline-container left">
                            <a href="#" class="content-link">
                                <div class="content">
                                    Assist and provide due diligence of both the parties and exchange with each other
                                </div>
                            </a>
                        </div>
                        <div class="timeline-container right">
                            <a href="#" class="content-link">
                                <div class="content">
                                    Assist in the sampling process and take approval
                                </div>
                            </a>
                        </div>
                        <div class="timeline-container left">
                            <a href="#" class="content-link">
                                <div class="content">
                                    Take care of payment if advance
                                </div>
                            </a>
                        </div>
                        <div class="timeline-container right">
                            <a href="#" class="content-link">
                                <div class="content">
                                    Take care of production lead time
                                </div>
                            </a>
                        </div>
                        <div class="timeline-container left">
                            <a href="#" class="content-link">
                                <div class="content">
                                    Provides assistance in packing and dispatch at the time of loading at warehouse or port
                                </div>
                            </a>
                        </div>
                        <div class="timeline-container right">
                            <a href="#" class="content-link">
                                <div class="content">
                                    Provide logistic support for air and sea cargo
                                </div>
                            </a>
                        </div>
                        <div class="timeline-container left">
                            <a href="#" class="content-link">
                                <div class="content">
                                    Assist in the documentation and operation process
                                </div>
                            </a>
                        </div>
                        <div class="timeline-container right">
                            <a href="#" class="content-link">
                                <div class="content">
                                    Take care of the balance payment direct TT or through bank
                                </div>
                            </a>
                        </div>
                        <div class="timeline-container left">
                            <a href="#" class="content-link">
                                <div class="content">
                                    Make the deal successful for supplier
                                </div>
                            </a>
                        </div>
                        <div class="timeline-container right">
                            <a href="#" class="content-link">
                                <div class="content">
                                    Additionally, advertise the supplier’s product on the platform and in various countries
                                    to
                                    promote their products.
                                </div>
                            </a>
                        </div>
                        <div class="timeline-container left">
                            <a href="#" class="content-link">
                                <div class="content">
                                    Supplier get the highest membership and preference on deal rocket platform to adv their
                                    company and products.
                                </div>
                            </a>
                        </div>
                        <div class="timeline-container right">
                            <a href="#" class="content-link">
                                <div class="content">
                                    Creates brand image in the global market
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Timeline intersection observer
            const timelineContainers = document.querySelectorAll('.timeline-container');
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('show');
                        entry.target.closest('.timeline').classList.add('show-line');
                        entry.target.closest('.timeline').classList.remove('hide-line');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.8
            });

            timelineContainers.forEach(container => observer.observe(container));

            // Scroll listener for line toggle
            window.addEventListener('scroll', () => {
                document.querySelectorAll('.timeline').forEach(timeline => {
                    const rect = timeline.getBoundingClientRect();
                    const top = rect.top;
                    const bottom = rect.bottom;
                    if (top > window.innerHeight / 2 || bottom < window.innerHeight / 2) {
                        timeline.classList.remove('show-line');
                        timeline.classList.add('hide-line');
                    } else {
                        timeline.classList.add('show-line');
                        timeline.classList.remove('hide-line');
                    }
                });
            });

            // Red box & tab toggle
            const buyerBtn = document.getElementById('buyerClick');
            const sellerBtn = document.getElementById('sellerClick');
            const redBox = document.getElementById('moveableRedBox');
            const buyerSection = document.getElementById('buyerTimeline');
            const supplierSection = document.getElementById('supplierTimeline');
            const descBuyer = document.querySelector('.dealassist-desc-tab.buyer');
            const descSupplier = document.querySelector('.dealassist-desc-tab.supplier');
            const tabBuyer = document.querySelector('.dealassist-tab.buyer');
            const tabSupplier = document.querySelector('.dealassist-tab.supplier');
            const currentData = document.getElementById('currentdata');

            function switchTab(type) {
                console.log(type);
                // Move red box and color text
                if (type === 'buyer') {
                    redBox.style.transform = "translateX(0px)";
                    buyerBtn.style.color = 'white';
                    sellerBtn.style.color = 'black';
                } else {
                    redBox.style.transform = "translateX(150px)";
                    sellerBtn.style.color = 'white';
                    buyerBtn.style.color = 'black';
                }

                currentData.dataset.current = type;

                // Toggle sections
                buyerSection.style.display = type === 'buyer' ? 'block' : 'none';
                supplierSection.style.display = type === 'seller' ? 'block' : 'none';

                descBuyer.classList.toggle('d-none', type !== 'buyer');
                descSupplier.classList.toggle('d-none', type !== 'seller');

                tabBuyer.classList.toggle('d-none', type !== 'buyer');
                tabSupplier.classList.toggle('d-none', type !== 'seller');
            }

            buyerBtn.addEventListener('click', () => {
                switchTab('buyer');
            });

            sellerBtn.addEventListener('click', () => {
                switchTab('seller');
            });

            // Optional: Default to buyer tab on page load
            switchTab('buyer');
        });
    </script>
@endpush
