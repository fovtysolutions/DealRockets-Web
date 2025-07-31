@extends('layouts.front-end.app')
@section('title')
    Info | {{ $web_config['name']->value }}
@endsection
@section('content')
    <style>
        /* Main container styling */
        .info-page-container {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 60px 0;
        }

        .page-header {
            text-align: center;
            margin-bottom: 60px;
            padding: 0 20px;
        }

        .page-title {
            font-size: 3.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .page-subtitle {
            font-size: 1.3rem;
            color: #7f8c8d;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Services List Container */
        .services-list {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 30px;
        }

        /* Individual Service Item */
        .service-item {
            background: #ffffff;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .service-item:hover {
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        /* Service Header (Always Visible) */
        .service-header {
            display: flex;
            align-items: center;
            padding: 30px 35px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .service-header:hover {
            background: rgba(254, 78, 68, 0.05);
        }

        .service-header.active {
            background: linear-gradient(to right, #FE4E44, #9F0900);
            color: white;
        }

        /* Service Icon */
        .service-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 25px;
            border: 3px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .service-header.active .service-icon {
            border-color: rgba(255, 255, 255, 1);
            transform: scale(1.1);
        }

        /* Service Title and Summary */
        .service-info {
            flex: 1;
        }

        .service-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
            transition: color 0.3s ease;
        }

        .service-header.active .service-title {
            color: white;
        }

        .service-summary {
            font-size: 0.9rem;
            color: #7f8c8d;
            line-height: 1.4;
            transition: color 0.3s ease;
        }

        .service-header.active .service-summary {
            color: rgba(255, 255, 255, 0.9);
        }

        /* Expand/Collapse Icon */
        .expand-icon {
            width: 24px;
            height: 24px;
            margin-left: 15px;
            transition: transform 0.3s ease;
            opacity: 0.7;
        }

        .service-header.active .expand-icon {
            transform: rotate(180deg);
            opacity: 1;
        }

        /* Expandable Content */
        .service-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease, padding 0.4s ease;
            background: #fafbfc;
        }

        .service-content.expanded {
            max-height: 600px;
            padding: 35px 40px;
        }

        .service-description {
            font-size: 1.05rem;
            color: #555;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .service-description a {
            color: #FE4E44;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .service-description a:hover {
            color: #9F0900;
            text-decoration: underline;
        }

        /* Features List */
        .service-features {
            margin-bottom: 50px;
        }

        .service-features h4 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 18px;
        }

        .features-list {
            list-style: none;
            padding: 0;
        }

        .features-list li {
            padding: 10px 0;
            padding-left: 30px;
            position: relative;
            color: #666;
            font-size: 1rem;
        }

        .features-list li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #FE4E44;
            font-weight: bold;
            font-size: 1.1rem;
        }

        /* Call to Action Button */
        .cta-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 25px;
            background: linear-gradient(to right, #FE4E44, #9F0900);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(254, 78, 68, 0.3);
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(254, 78, 68, 0.4);
            color: white;
            text-decoration: none;
        }

        .cta-button::after {
            content: '→';
            margin-left: 8px;
            transition: transform 0.3s ease;
        }

        .cta-button:hover::after {
            transform: translateX(3px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .page-title {
                font-size: 2.5rem;
            }
            
            .page-subtitle {
                font-size: 1.1rem;
            }
            
            .services-list {
                padding: 0 20px;
            }
            
            .service-header {
                padding: 25px 25px;
                flex-direction: column;
                text-align: center;
            }
            
            .service-icon {
                margin-right: 0;
                margin-bottom: 20px;
            }
            
            .service-content.expanded {
                padding: 25px;
            }
        }

        @media (max-width: 480px) {
            .page-title {
                font-size: 2rem;
            }
            
            .info-page-container {
                padding: 40px 0;
            }
            
            .page-header {
                margin-bottom: 40px;
            }
            
            .services-list {
                padding: 0 15px;
            }
            
            .service-header {
                padding: 20px;
            }
            
            .service-title {
                font-size: 1.2rem;
            }
            
            .service-summary {
                font-size: 0.85rem;
            }
        }

        /* Animation for items on load */
        .service-item {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.5s ease forwards;
        }

        .service-item:nth-child(1) { animation-delay: 0.1s; }
        .service-item:nth-child(2) { animation-delay: 0.2s; }
        .service-item:nth-child(3) { animation-delay: 0.3s; }
        .service-item:nth-child(4) { animation-delay: 0.4s; }
        .service-item:nth-child(5) { animation-delay: 0.5s; }
        .service-item:nth-child(6) { animation-delay: 0.6s; }
        .service-item:nth-child(7) { animation-delay: 0.7s; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Image error handling */
        .service-icon {
            background: url('/images/placeholderimage.webp') center/cover no-repeat;
        }
    </style>

    <section class="mainpagesection" style="margin-top:22px;">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Our Services</h1>
            <p class="page-subtitle">Discover comprehensive business solutions designed to accelerate your growth and connect you with opportunities worldwide</p>
        </div>

        @php
            $services = [
                [
                    'title' => 'Stock Sale',
                    'image' => '/images/info/stocksale.jpg',
                    'alt' => 'Stock Sale',
                    'summary' => 'Buy discounted stock in bulk with special business pricing',
                    'description' => 'Access exclusive wholesale opportunities with significant discounts on bulk purchases. Our stock sale platform connects you with verified suppliers offering genuine products at competitive prices.',
                    'features' => [
                        'Bulk purchase discounts up to 50%',
                        'Verified supplier network',
                        'Quality assurance guarantee',
                        'Flexible payment terms',
                        'Global shipping options'
                    ],
                    'route' => route('stocksale'),
                ],
                [
                    'title' => 'Buy Leads',
                    'image' => '/images/info/buyleads.png',
                    'alt' => 'Buy Leads',
                    'summary' => 'Access verified leads from real buyers worldwide',
                    'description' => 'Connect with genuine buyers actively seeking your products or services. Our advanced lead generation system ensures high-quality prospects that convert into real business opportunities.',
                    'features' => [
                        'Pre-verified buyer information',
                        'Real-time lead notifications',
                        'Industry-specific targeting',
                        'Contact details included',
                        '24/7 lead monitoring'
                    ],
                    'route' => route('buyer'),
                ],
                [
                    'title' => 'Sale Offer',
                    'image' => '/images/info/sellleads.jpg',
                    'alt' => 'Sale Offer',
                    'summary' => 'Find limited-time offers tailored for your business',
                    'description' => 'Discover exclusive deals and promotional offers designed specifically for your business needs. Save significantly on products and services from trusted suppliers.',
                    'features' => [
                        'Exclusive business discounts',
                        'Limited-time promotional offers',
                        'Customized deal recommendations',
                        'Bulk order incentives',
                        'Priority access to new offers'
                    ],
                    'route' => route('seller'),
                ],
                [
                    'title' => 'Industry Jobs',
                    'image' => '/images/info/industryjobs.jpg',
                    'alt' => 'Industry Jobs',
                    'summary' => 'Apply to top jobs in your industry across key sectors',
                    'description' => 'Find career opportunities that match your skills and experience. Our job platform connects professionals with leading companies across various industries.',
                    'features' => [
                        'Industry-specific job listings',
                        'Direct employer connections',
                        'Resume optimization tools',
                        'Interview preparation support',
                        'Career advancement guidance'
                    ],
                    'route' => route('sendcv'),
                ],
                [
                    'title' => 'Business Solutions',
                    'image' => '/images/info/dealassist.jpg',
                    'alt' => 'Business Solutions',
                    'summary' => 'Smart solutions for hypermarket, hospitality, and construction',
                    'description' => 'Get comprehensive business solutions tailored for <a href="solutions/web/1" target="_blank">hypermarket</a>, <a href="solutions/web/3" target="_blank">hospitality</a>, and <a href="solutions/web/2" target="_blank">construction</a> industries. Streamline your operations with our specialized tools and services.',
                    'features' => [
                        'Industry-specific software solutions',
                        'Process automation tools',
                        'Inventory management systems',
                        'Customer relationship management',
                        'Analytics and reporting dashboards'
                    ],
                    'link' => 'solutions/web/1',
                ],
                [
                    'title' => 'Deal Assist',
                    'image' => '/images/info/dealassist.jpg',
                    'alt' => 'Deal Assist',
                    'summary' => 'Expert help to close deals faster with confidence',
                    'description' => 'Get professional assistance in negotiating and closing business deals. Our experienced team provides guidance, documentation support, and strategic advice to ensure successful transactions.',
                    'features' => [
                        'Professional negotiation support',
                        'Contract review and assistance',
                        'Risk assessment and mitigation',
                        'Documentation preparation',
                        'Post-deal follow-up services'
                    ],
                    'route' => route('dealassist'),
                ],
                [
                    'title' => 'Tradeshows',
                    'image' => '/images/info/tradeshow.jpg',
                    'alt' => 'Tradeshows',
                    'summary' => 'Connect with industry leaders and expand market reach',
                    'description' => 'Participate in live trade shows and industry events to showcase your products, meet potential partners, and stay updated with market trends. Network with key industry players and decision-makers.',
                    'features' => [
                        'Access to premium trade events',
                        'Networking opportunities',
                        'Product showcase platforms',
                        'Industry trend insights',
                        'Partnership development support'
                    ],
                    'route' => route('tradeshow'),
                ],
            ];
        @endphp

        <!-- Services List -->
        <div class="services-list">
            @foreach ($services as $index => $service)
                <div class="service-item">
                    <div class="service-header" onclick="toggleService({{ $index }})">
                        <img src="{{ $service['image'] }}" alt="{{ $service['alt'] }}" class="service-icon" 
                             onerror="this.src='/public/images/placeholderimage.webp'">
                        <div class="service-info">
                            <h3 class="service-title">{{ $service['title'] }}</h3>
                            <p class="service-summary">{{ $service['summary'] }}</p>
                        </div>
                        <svg class="expand-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="service-content" id="content-{{ $index }}">
                        <div class="service-description">
                            {!! $service['description'] !!}
                        </div>
                        <div class="service-features">
                            <h4>Key Features:</h4>
                            <ul class="features-list">
                                @foreach ($service['features'] as $feature)
                                    <li>{{ $feature }}</li>
                                @endforeach
                            </ul>
                            <a href="{{ $service['route'] ?? $service['link'] ?? '#' }}" class="cta-button">
                                Get Started
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <script>
            function toggleService(index) {
                const header = document.querySelector(`.service-item:nth-child(${index + 1}) .service-header`);
                const content = document.getElementById(`content-${index}`);
                
                // Toggle active state
                header.classList.toggle('active');
                content.classList.toggle('expanded');
                
                // Close other expanded items (optional - for accordion behavior)
                // Uncomment the lines below if you want only one item expanded at a time
                /*
                document.querySelectorAll('.service-header').forEach((otherHeader, otherIndex) => {
                    if (otherIndex !== index) {
                        otherHeader.classList.remove('active');
                        document.getElementById(`content-${otherIndex}`).classList.remove('expanded');
                    }
                });
                */
            }
        </script>

    </section>
@endsection
