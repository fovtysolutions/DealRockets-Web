<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deal-Assist</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background-color: #f7f7f7;
            color: #333;
            overflow-x: hidden;
        }

        .container {
            width: 100%;
            max-width: 1440px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 45px;
        }

        .hero {
            position: relative;
            width: 100%;
            height: 613px;
            background-color: #010140;
            overflow: hidden;
        }

        .hero-image {
            position: absolute;
            top: 0;
            right: 0;
            width: 68%;
            height: 100%;
            background-color: #333;
            background-image: url('https://via.placeholder.com/988x613');
            background-size: cover;
            background-position: center;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            padding: 99px 0 0 80px;
            max-width: 551px;
            color: #fff;
        }

        .hero-title {
            font-size: 38px;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: -0.4px;
        }

        .hero-text {
            font-size: 16px;
            line-height: 1.6;
            color: #e3e3e3;
            margin-bottom: 50px;
        }

        .hero-cta {
            display: inline-flex;
            align-items: center;
            padding: 10px 16px;
            background-color: #fff;
            border-radius: 6px;
            text-decoration: none;
        }

        .hero-cta-text {
            background: linear-gradient(to right, #fe4e44, #9f0900);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 18px;
            font-weight: 700;
        }

        .tab-selector {
            display: flex;
            justify-content: center;
            margin: 45px 0;
        }

        .tab-container {
            position: relative;
            width: 326px;
            height: 60px;
            background-color: #fff;
            border-radius: 60px;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.25);
            display: flex;
            align-items: center;
            padding: 7px 19px;
        }

        .tab-button {
            position: relative;
            z-index: 2;
            padding: 0 20px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 65px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .tab-button.active {
            background: linear-gradient(to right, #fe4e44, #9f0900);
            color: #fff;
            font-weight: 600;
        }

        .tab-button:not(.active) {
            color: #0d0d0f;
            font-weight: 400;
        }

        .content-section {
            display: flex;
            gap: 45px;
            padding: 0 80px;
            margin-bottom: 45px;
        }

        .content-image {
            flex: 0 0 500px;
            height: 500px;
            background-color: #333;
            border-radius: 5px;
            background-size: cover;
            background-position: center;
        }

        .content-details {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .content-title {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.4px;
            color: #010101;
        }

        .content-text {
            font-size: 14px;
            line-height: 1.6;
            color: #435060;
            margin-bottom: 20px;
        }

        .content-text p {
            margin-bottom: 16px;
        }

        .card-container {
            display: flex;
            gap: 16px;
            margin-top: 30px;
        }

        .card {
            background-color: #fff;
            border-radius: 12px;
            padding: 16px 20px;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.15);
            flex: 1;
        }

        .card-icon-container {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: rgba(241, 24, 29, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #fe4e44;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #000;
        }

        .card-text {
            font-size: 12px;
            line-height: 1.6;
            color: #515151;
        }

        .steps-section {
            background-color: #fff;
            padding: 40px 0;
            margin: 45px 0;
        }

        .steps-container {
            max-width: 1280px;
            margin: 0 auto;
        }

        .steps-title {
            font-size: 20px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 30px;
        }

        .steps-timeline {
            position: relative;
            display: flex;
            justify-content: center;
            margin-top: 54px;
        }

        .timeline-line {
            position: absolute;
            top: 54px;
            left: 50%;
            transform: translateX(-50%);
            width: 943px;
            height: 1px;
            background-color: #acacac;
        }

        .steps-list {
            display: flex;
            justify-content: space-between;
            max-width: 1280px;
            margin: 0 auto;
            gap: 55px;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 307px;
        }

        .step-number {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #fff;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            position: relative;
            z-index: 2;
        }

        .step-number i {
            color: #fe4e44;
        }

        .step-title {
            font-size: 16.8px;
            font-weight: 700;
            margin-bottom: 12px;
            text-align: center;
            color: #18181b;
        }

        .step-text {
            font-size: 12.8px;
            line-height: 1.6;
            text-align: center;
            color: #52525b;
        }

        .features-section {
            background-color: #fff;
            padding: 40px 67px;
            margin: 45px 0;
        }

        .features-title {
            font-size: 20px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 30px;
        }

        .features-grid {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .feature-card {
            background-color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 20px;
            width: 305px;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(35px);
        }

        .feature-icon {
            width: 34px;
            height: 34px;
            color: #fe4e44;
            margin-bottom: 20px;
        }

        .feature-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #010101;
        }

        .feature-text {
            font-size: 14px;
            line-height: 1.6;
            color: #555;
        }

        .cta-button {
            display: inline-flex;
            align-items: center;
            padding: 10px 21px;
            background-color: #fe4e44;
            border-radius: 30px;
            text-decoration: none;
            color: #fff;
            font-weight: 700;
            font-size: 16px;
            margin-top: 20px;
            border: none;
            cursor: pointer;
        }

        .final-cta {
            margin: 45px 80px;
            background-color: rgba(254, 78, 68, 0.04);
            border: 1px solid #fe4e44;
            border-radius: 18px;
            padding: 40px 50px;
        }

        .final-cta-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .final-cta-text {
            max-width: 900px;
        }

        .final-cta-title {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 12px;
            letter-spacing: -0.4px;
            color: #010101;
        }

        .final-cta-description {
            font-size: 16px;
            line-height: 1.6;
            color: #010101;
            margin-bottom: 30px;
        }

        .final-cta-note {
            font-size: 16px;
            color: #010101;
        }

        @media (max-width: 1200px) {
            .content-section {
                flex-direction: column;
                align-items: center;
                padding: 0 40px;
            }

            .content-image {
                width: 100%;
                max-width: 500px;
            }

            .card-container {
                flex-direction: column;
            }

            .steps-list {
                flex-wrap: wrap;
                justify-content: center;
            }

            .timeline-line {
                display: none;
            }

            .features-grid {
                justify-content: center;
            }

            .final-cta-content {
                flex-direction: column;
                gap: 30px;
            }
        }

        @media (max-width: 768px) {
            .hero {
                height: auto;
                padding-bottom: 50px;
            }

            .hero-image {
                position: relative;
                width: 100%;
                height: 300px;
                right: auto;
            }

            .hero-content {
                padding: 40px 20px;
                max-width: 100%;
            }

            .hero-title {
                font-size: 28px;
            }

            .content-section {
                padding: 0 20px;
            }

            .steps-container {
                padding: 0 20px;
            }

            .features-section {
                padding: 40px 20px;
            }

            .final-cta {
                margin: 45px 20px;
                padding: 30px 20px;
            }

            .final-cta-title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Hero Section -->
        <div class="hero">
            <div class="hero-image"></div>
            <div class="hero-content">
                <h1 class="hero-title">Empowering Your Marketplace for Global Success</h1>
                <p class="hero-text">For over a years, we've established ourselves as a trusted, internationally recognized platform, connecting genuine buyers and sellers across the globe. Our marketplace offers seamless, tailored solutions to foster meaningful connections, drive growth, and adapt to the ever-changing dynamics of global trade. With innovative tools, reliable market insights, and user-focused features, we empower businesses to seize opportunities and thrive in today's competitive landscape.</p>
                <a href="#" class="hero-cta">
                    <span class="hero-cta-text">Get customized marketing solutions!</span>
                </a>
            </div>
        </div>

        <!-- Tab Selector -->
        <div class="tab-selector">
            <div class="tab-container">
                <div class="tab-button active">
                    <span>For Buyer</span>
                </div>
                <div class="tab-button">
                    <span>For Seller</span>
                </div>
            </div>
        </div>

        <!-- About Section -->
        <section class="content-section">
            <div class="content-image" style="background-image: url('https://via.placeholder.com/500x500');"></div>
            <div class="content-details">
                <h2 class="content-title">About Deal Rockets Trade Assist Program</h2>
                <div class="content-text">
                    <p>The Deal Rockets Trade Assist Program is a complete support system designed to make global sourcing secure, transparent, and hassle-free. It ensures smooth transactions, verified suppliers, and clear communication from enquiry to delivery.</p>
                    <p>Built on proven global trade assistance practices, this program helps you source products with confidence, negotiate favorable terms, and connect with reliable suppliers worldwide — knowing your procurement journey is backed by strong quality checks and trust-focused processes at every step.</p>
                </div>
                <div class="card-container">
                    <div class="card">
                        <div class="card-icon-container">
                            <div class="card-icon">
                                <i data-lucide="eye"></i>
                            </div>
                        </div>
                        <h3 class="card-title">Vision</h3>
                        <p class="card-text">To become the most trusted global B2B marketplace, enabling businesses of every size to connect, trade, and grow with complete transparency, efficiency, and service excellence.</p>
                    </div>
                    <div class="card">
                        <div class="card-icon-container">
                            <div class="card-icon">
                                <i data-lucide="target"></i>
                            </div>
                        </div>
                        <h3 class="card-title">Mission</h3>
                        <p class="card-text">To simplify global trade by connecting buyers and sellers through verified sourcing, reliable vendor networks, and end-to-end procurement assistance that builds trust and long-term partnerships.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Buying Journey Section -->
        <section class="steps-section">
            <div class="steps-container">
                <h2 class="steps-title">Start your Buying Journey</h2>
                <div class="steps-timeline">
                    <div class="timeline-line"></div>
                </div>
                <div class="steps-list">
                    <div class="step">
                        <div class="step-number">
                            <i data-lucide="search"></i>
                        </div>
                        <h3 class="step-title">Browse Products</h3>
                        <p class="step-text">Discover thousands of verified listings across multiple categories. Filter by product type, specifications, and supplier location to quickly find exactly what meets your business needs.</p>
                    </div>
                    <div class="step">
                        <div class="step-number">
                            <i data-lucide="mail"></i>
                        </div>
                        <h3 class="step-title">Send Enquiry</h3>
                        <p class="step-text">Select the product you're interested in and send a detailed enquiry directly to the vendor, outlining your requirements, quantity, and any customization preferences.</p>
                    </div>
                    <div class="step">
                        <div class="step-number">
                            <i data-lucide="list-checks"></i>
                        </div>
                        <h3 class="step-title">Get Offers</h3>
                        <p class="step-text">Receive personalized quotes and product details from multiple vendors. Compare specifications, pricing, and delivery terms to identify the most suitable supplier for your order.</p>
                    </div>
                    <div class="step">
                        <div class="step-number">
                            <i data-lucide="handshake"></i>
                        </div>
                        <h3 class="step-title">Finalize Deal</h3>
                        <p class="step-text">Negotiate terms directly with the vendor and arrange delivery. All payments and order confirmations are handled outside the platform for flexibility and control.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Buyer Protection Section -->
        <section class="content-section">
            <div class="content-image" style="background-image: url('https://via.placeholder.com/500x500');"></div>
            <div class="content-details">
                <h2 class="content-title">Buyer Protection & Dispute Assistance</h2>
                <div class="content-text">
                    <p>When you make a purchase through Deal Rockets, we understand the importance of trust and reliability in every transaction. If the products you receive are defective, incorrect, damaged, or fail to match the agreed specifications, our team immediately steps in to help you connect directly with the seller and resolve the issue as quickly as possible.</p>
                    <p>This resolution may include arranging a product replacement, initiating corrections to meet agreed standards, or facilitating a mutually agreed refund — all handled directly between you and the seller for maximum control and flexibility.</p>
                    <p>In cases where returns are required, we assist you in navigating the process, helping with clear communication, documentation, and coordination so that you avoid delays and confusion. Our goal is to ensure that any disputes are settled fairly, efficiently, and with your satisfaction as the priority.</p>
                </div>
                <a href="#" class="cta-button">Find trusted deals</a>
            </div>
        </section>

        <!-- Why Choose Section -->
        <section class="features-section">
            <h2 class="features-title">Why Choose Deal Rockets Trade Assist Program</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="shield-check"></i>
                    </div>
                    <h3 class="feature-title">Verified Trade Confidence</h3>
                    <p class="feature-text">Boost your credibility instantly with Deal Rockets' Verified Vendor status, assuring buyers of your authenticity, product quality, and commitment to professional business practices.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="users"></i>
                    </div>
                    <h3 class="feature-title">Higher Buyer Engagement</h3>
                    <p class="feature-text">Stand out in search results and attract more serious enquiries by showcasing your verified profile, detailed offerings, and trusted business history.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="globe"></i>
                    </div>
                    <h3 class="feature-title">Global Market Access</h3>
                    <p class="feature-text">Expand your reach with direct exposure to a worldwide network of active buyers, suppliers, and trading partners across multiple industries.</p>
                </div>
            </div>
        </section>

        <!-- Order Tracking Section -->
        <section class="content-section">
            <div class="content-details">
                <h2 class="content-title">Order Tracking & Updates</h2>
                <div class="content-text">
                    <p>From the moment your order is confirmed, Deal Rockets ensures you're never left in the dark. Our Order Tracking & Updates feature gives you full visibility into your procurement journey, starting from production progress to shipment milestones and final delivery.</p>
                    <p>You'll receive timely updates directly from the seller, including manufacturing timelines, dispatch details, tracking numbers, and estimated arrival dates. In addition, our team is available to help clarify any unexpected delays, changes in schedules, or adjustments to your order.</p>
                    <p>We make sure all communications remain transparent and accurate, eliminating uncertainty and keeping you in control of your order status at every step. Whether it's a bulk shipment across borders or a smaller, specialized delivery, we keep you informed so you can plan your business operations with confidence.</p>
                </div>
                <a href="#" class="cta-button">Track My Order</a>
            </div>
            <div class="content-image" style="background-image: url('https://via.placeholder.com/500x500');"></div>
        </section>

        <!-- Why Our Assistance Works Section -->
        <section class="features-section">
            <h2 class="features-title">Why Our Assistance Works for You</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="shield-check"></i>
                    </div>
                    <h3 class="feature-title">Verified Suppliers</h3>
                    <p class="feature-text">Work only with carefully vetted vendors to ensure product quality, reliability, and professionalism at every step of your buying journey.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="check-circle"></i>
                    </div>
                    <h3 class="feature-title">Quality Control</h3>
                    <p class="feature-text">Gain confidence in your purchase with sample checks, independent product inspections, and continuous production monitoring before final shipment.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="workflow"></i>
                    </div>
                    <h3 class="feature-title">Smooth Process</h3>
                    <p class="feature-text">We simplify the procurement process by coordinating supplier communication, negotiations, shipping arrangements, and documentation handling on your behalf.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="percent"></i>
                    </div>
                    <h3 class="feature-title">Better Deals</h3>
                    <p class="feature-text">Access competitive offers from multiple trusted suppliers, giving you the power to negotiate and secure the best value for your order.</p>
                </div>
            </div>
        </section>

        <!-- Negotiation Support Section -->
        <section class="content-section">
            <div class="content-image" style="background-image: url('https://via.placeholder.com/500x500');"></div>
            <div class="content-details">
                <h2 class="content-title">Negotiation Support</h2>
                <div class="content-text">
                    <p>Securing the best value for your procurement is not just about price — it's about getting the right terms, quality, and timelines that meet your exact needs. At Deal Rockets, our Negotiation Support service ensures you have the right tools and assistance to reach an agreement that works in your favor.</p>
                    <p>We facilitate direct, clear discussions between you and the seller, covering key details such as product specifications, quantities, delivery schedules, and final pricing. By helping both parties align on expectations and responsibilities early on, we reduce the risk of misunderstandings that could disrupt your order.</p>
                    <p>Our experienced team can also guide you through counter-offers, specification adjustments, and alternative solutions when challenges arise. The result is a smoother, faster negotiation process that protects your interests, builds strong supplier relationships, and ensures successful deal closures.</p>
                </div>
                <a href="#" class="cta-button">Start Negotiation</a>
            </div>
        </section>

        <!-- How to Join Section -->
        <section class="steps-section">
            <div class="steps-container">
                <h2 class="steps-title">How to Join Deal Rockets Trade Assist Program</h2>
                <div class="steps-timeline">
                    <div class="timeline-line"></div>
                </div>
                <div class="steps-list">
                    <div class="step">
                        <div class="step-number">
                            <span>1</span>
                        </div>
                        <h3 class="step-title">Create Your Free Account</h3>
                        <p class="step-text">Sign up on Deal Rockets and set up your business profile with all the essential details buyers need to know.</p>
                    </div>
                    <div class="step">
                        <div class="step-number">
                            <span>2</span>
                        </div>
                        <h3 class="step-title">Get Verified & Listed</h3>
                        <p class="step-text">Complete our quick verification process to become a trusted seller and have your products listed for global visibility.</p>
                    </div>
                    <div class="step">
                        <div class="step-number">
                            <span>3</span>
                        </div>
                        <h3 class="step-title">Start Receiving Enquiries</h3>
                        <p class="step-text">Connect with genuine buyers worldwide, negotiate deals, and grow your trade network — all in one secure platform.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Final CTA Section -->
        <div class="final-cta">
            <div class="final-cta-content">
                <div class="final-cta-text">
                    <h2 class="final-cta-title">Your Deals. Your Market. Instantly Global.</h2>
                    <p class="final-cta-description">Whether you're showcasing hot-selling products or niche specialties, Deal Rocket helps you reach the right buyers at the right time. Compare inquiries, respond directly, and close deals — all in one place. Your offers stay live for buyers around the globe to discover, 24/7.</p>
                    <p class="final-cta-note">At Deal Rockets, we connect suppliers with serious buyers worldwide — fast, simple, and hassle-free.</p>
                </div>
                <a href="#" class="cta-button">Create My First Offer</a>
            </div>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Tab functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-button');
            
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>
</html>