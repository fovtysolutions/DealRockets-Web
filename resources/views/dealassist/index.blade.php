@extends('layouts.front-end.app')
@push('css_or_js')
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/dealassist.css') }}" />
@endpush
@section('title', translate('Deal Assist' . ' | ' . $web_config['name']->value))
@section('content')
<style>
    .custom-inquiry-btn {
        width: fit-content !important;
        height: 40px !important;
        background: linear-gradient(to right, #FE4E44, #9F0900) !important;
        border-radius: 50px !important;
        border: none !important;
        color: #fff !important;
        font-weight: 500 !important;
        padding: 0 10px !important;
        font-family: Roboto, sans-serif !important;
    }
</style>

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
                        <span class="customized-marketing"><a href="javascript:">Get customized marketing
                                solutions!</a></span>
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
                    <!-- Subheading and Tagline -->
                    <div class="timeline-header">
                        <h2 class="timeline-title">Start your Buying Journey</h2>
                        <!-- Optional tagline -->
                        <!-- <p class="timeline-tagline">End-to-end sourcing assistance from DealRockets — ensuring quality, reliability, and global reach.</p> -->
                    </div>

                    <div class="timeline hide-line">

                        <div class="timeline-container left">
                            <a href="javascript:" class="content-link">
                                <div class="content">
                                    <div class="content-header">Request Initiation</div>
                                    <div class="content-desc">
                                        The buyer begins by sharing their product requirement with DealRockets. This
                                        includes details like what they want to buy, quantity, preferred quality, and target
                                        price. From this point, DealRockets takes over and starts working on the buyer’s
                                        behalf.
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="timeline-container right">
                            <a href="javascript:" class="content-link">
                                <div class="content">
                                    <div class="content-header">Supplier Sourcing</div>
                                    <div class="content-desc">
                                        DealRockets searches and contacts trusted suppliers around the world who can fulfill
                                        the buyer’s needs. We compare prices, quality, reliability, and timelines, and
                                        present the best options with transparent quotations.
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="timeline-container left">
                            <a href="javascript:" class="content-link">
                                <div class="content">
                                    <div class="content-header">Terms Finalization</div>
                                    <div class="content-desc">
                                        Once a suitable supplier is chosen, DealRockets helps both parties agree on clear
                                        terms — including pricing, delivery dates, payment methods, and responsibilities —
                                        to avoid confusion later and ensure a smooth deal.
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="timeline-container right">
                            <a href="javascript:" class="content-link">
                                <div class="content">
                                    <div class="content-header">Due Diligence</div>
                                    <div class="content-desc">
                                        To ensure safety and trust, DealRockets verifies the background and credibility of
                                        both the buyer and supplier. This includes checking registration documents, previous
                                        records, and confirming genuine contact details before proceeding.
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="timeline-container left">
                            <a href="javascript:" class="content-link">
                                <div class="content">
                                    <div class="content-header">Sampling Support</div>
                                    <div class="content-desc">
                                        If needed, DealRockets arranges product samples to be sent to the buyer for
                                        checking. We coordinate with the supplier and ensure the sample meets the
                                        expectations before the full order is approved.
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="timeline-container right">
                            <a href="javascript:" class="content-link">
                                <div class="content">
                                    <div class="content-header">Production Monitoring</div>
                                    <div class="content-desc">
                                        After order confirmation, we keep track of the production timeline to make sure
                                        there are no delays. DealRockets regularly checks progress with the supplier and
                                        keeps the buyer informed at each stage.
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="timeline-container left">
                            <a href="javascript:" class="content-link">
                                <div class="content">
                                    <div class="content-header">Quality Assurance</div>
                                    <div class="content-desc">
                                        Before dispatch, DealRockets arranges a third-party quality check to make sure the
                                        goods match the agreed specifications. This builds trust and avoids surprises or
                                        disputes after delivery.
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="timeline-container right">
                            <a href="javascript:" class="content-link">
                                <div class="content">
                                    <div class="content-header">Logistics Support</div>
                                    <div class="content-desc">
                                        DealRockets can help with shipping arrangements too. Whether it’s FOB (Free on
                                        Board) or another method, we guide the buyer and work with logistics companies to
                                        ensure smooth and cost-effective transport.
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="timeline-container left">
                            <a href="javascript:" class="content-link">
                                <div class="content">
                                    <div class="content-header">Documentation & Operations</div>
                                    <div class="content-desc">
                                        We help prepare and manage all required documents — like invoices, contracts,
                                        shipping papers, and compliance certificates — so that the shipment process is
                                        legally correct and smooth at customs and banks.
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="timeline-container right">
                            <a href="javascript:" class="content-link">
                                <div class="content">
                                    <div class="content-header">Payment & Closure</div>
                                    <div class="content-desc">
                                        After final checks, DealRockets helps collect any remaining payment from the buyer
                                        securely. Once payment is done, the deal is marked complete and both parties receive
                                        a closure confirmation.
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="timeline-container left">
                            <a href="javascript:" class="content-link">
                                <div class="content">
                                    <div class="content-header">Successful Completion</div>
                                    <div class="content-desc">
                                        The buyer successfully receives the product, all conditions are fulfilled, and the
                                        transaction is completed. DealRockets ensures everything ends on a positive note
                                        with full support even after the deal closes.
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                    </div>
                    
                </div>
                <div id="supplierTimeline" class="dealassist-tab supplier d-none">
                    <!-- Optional Header -->
                    <div class="timeline-header">
                        <h2 class="timeline-title">Supplier Journey with DealRockets</h2>
                        <!-- <p class="timeline-tagline">Helping suppliers grow globally through trusted buyer connections and full-service support.</p> -->
                    </div>

                    <div class="timeline hide-line">

                        <div class="timeline-container left">
                            <a href="javascript:" class="content-link">
                                <div class="content">
                                    <div class="content-header">Buyer Matching</div>
                                    <div class="content-desc">
                                        DealRockets helps suppliers find genuine buyers who are actively looking for their
                                        products in the international market. We act as a bridge between verified demand and
                                        your offerings.
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="timeline-container right">
                            <a href="javascript:" class="content-link">
                                <div class="content">
                                    <div class="content-header">Terms Finalization</div>
                                    <div class="content-desc">
                                        Once a buyer is matched, DealRockets helps both sides finalize key terms such as
                                        price, delivery time, payment conditions, and responsibilities — ensuring everything
                                        is clearly understood and agreed upon.
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="timeline-container left">
                            <a href="javascript:" class="content-link">
                                <div class="content">
                                    <div class="content-header">Due Diligence</div>
                                    <div class="content-desc">
                                        DealRockets verifies and shares trusted business profiles of both buyer and
                                        supplier. This step builds trust and protects both parties from fraud or
                                        miscommunication.
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="timeline-container right">
                            <a href="javascript:" class="content-link">
                                <div class="content">
                                    <div class="content-header">Sampling & Approval</div>
                                    <div class="content-desc">
                                        We help coordinate the sending of samples to the buyer. Once the buyer approves, the
                                        supplier receives confirmation and can confidently proceed with production.
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="timeline-container left">
                            <a href="javascript:" class="content-link">
                                <div class="content">
                                    <div class="content-header">Advance Payment Assistance</div>
                                    <div class="content-desc">
                                        If advance payment is involved, DealRockets ensures that the process is smooth and
                                        secure. We help confirm that the funds are received correctly before production
                                        begins.
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="timeline-container right">
                            <a href="javascript:" class="content-link">
                                <div class="content">
                                    <div class="content-header">Production Lead Time</div>
                                    <div class="content-desc">
                                        DealRockets helps track and manage the production schedule to ensure timely
                                        delivery. We assist in keeping everything on track so deadlines are met.
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="timeline-container left">
                            <a href="javascript:" class="content-link">
                                <div class="content">
                                    <div class="content-header">Packing & Dispatch</div>
                                    <div class="content-desc">
                                        We support proper packing and safe dispatch at the warehouse or port. This includes
                                        coordination during loading to make sure the goods are secure and properly
                                        documented.
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="timeline-container right">
                            <a href="javascript:" class="content-link">
                                <div class="content">
                                    <div class="content-header">Logistics Support</div>
                                    <div class="content-desc">
                                        Whether by air or sea, DealRockets helps arrange transportation for the shipment. We
                                        coordinate with freight partners to ensure smooth shipping and delivery.
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="timeline-container left">
                            <a href="javascript:" class="content-link">
                                <div class="content">
                                    <div class="content-header">Documentation & Operations</div>
                                    <div class="content-desc">
                                        From invoices to shipping papers, DealRockets helps suppliers prepare and manage all
                                        required documents. This reduces errors and avoids delays at customs or banks.
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="timeline-container right">
                            <a href="javascript:" class="content-link">
                                <div class="content">
                                    <div class="content-header">Balance Payment Assistance</div>
                                    <div class="content-desc">
                                        DealRockets supports the final payment process, whether it's done via direct bank
                                        transfer (TT) or through a financial institution. We ensure funds are securely
                                        received.
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="timeline-container left">
                            <a href="javascript:" class="content-link">
                                <div class="content">
                                    <div class="content-header">Successful Deal Closure</div>
                                    <div class="content-desc">
                                        Once everything is complete, DealRockets confirms the successful closure of the deal
                                        — ensuring both parties are satisfied and all conditions are met.
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="timeline-container right">
                            <a href="javascript:" class="content-link">
                                <div class="content">
                                    <div class="content-header">Product Promotion</div>
                                    <div class="content-desc">
                                        DealRockets promotes the supplier’s products across its platform and in various
                                        countries through digital campaigns — helping expand global visibility and generate
                                        more leads.
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="timeline-container left">
                            <a href="javascript:" class="content-link">
                                <div class="content">
                                    <div class="content-header">Membership Preference</div>
                                    <div class="content-desc">
                                        Suppliers with higher membership levels get priority in deals, better visibility,
                                        and exclusive tools to promote their brand and products on the DealRockets platform.
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="timeline-container right">
                            <a href="javascript:" class="content-link">
                                <div class="content">
                                    <div class="content-header">Global Brand Building</div>
                                    <div class="content-desc">
                                        By consistently participating in quality deals and showcasing products worldwide,
                                        the supplier builds a strong and trustworthy global brand with the help of
                                        DealRockets.
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end " style="padding:1rem; background: #f7f7f7;">
      
   <button type="button" class="btn custom-inquiry-btn" data-toggle="modal" data-target="#inquiryModal">
    <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/0882f754e189daab8d1153c2e9654e9a14108c4f"
        alt="Inquire" class="inquire-icon" loading="lazy">
    Inquire Now
</button>
    </div>
    <div class="modal fade" id="inquiryModal" tabindex="-1" aria-labelledby="inquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header" style="background-color:rgba(235, 235, 235, 1);">
                <h5 class="modal-title" id="inquiryModalLabel">Send a direct inquiry to this supplier</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="inquiryForm">
                    <div class="mb-3">
                        <label for="supplier" class="form-label">To</label>
                        <div class="form-control">XYZ Store45454</div>
                    </div>

                    <input type="hidden" id="sender_id1" name="sender_id" value="">
                    <input type="hidden" id="sender_type1" name="sender_type" value="guest">
                    <input type="hidden" id="receiver_id1" name="receiver_id" value="14">
                    <input type="hidden" id="receiver_type1" name="receiver_type" value="seller">
                    <input type="hidden" id="product_id1" name="product_id" value="353">
                    <input type="hidden" id="type" name="type" value="products">

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail Address</label>
                        <input type="email" class="form-control" id="email1"
                            placeholder="Please enter your business e-mail address" required>
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message1" rows="4"
                            placeholder="Enter product details..." required></textarea>
                    </div>

                    <button type="button" onclick="sendtologin()" class="btn btn-primary">Send Inquiry Now</button>
                </form>
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
