@extends('layouts.front-end.app')
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/agrotradex.css')}}" />
@section('title',translate('Agro Tradex'. ' | ' . $web_config['name']->value))
@section('content')
<section class="mainpagesection" style="background-image: url('/images/agrotradex.jpg');
                background-size: cover;">

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 class="banner-heading">Welcome to Agro Tradex</h1>
                    <p class="banner-paragraph">Your trusted marketplace for agricultural trading solutions.</p>
                    <a href="#services" class="btn explore-btn">Explore Services</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="features-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="feature-box">
                        <h3>Quality Products</h3>
                        <p>We ensure high-quality agricultural products for our clients.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <h3>Reliable Suppliers</h3>
                        <p>Partnering with verified suppliers for trust and transparency.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <h3>Competitive Pricing</h3>
                        <p>Get the best rates in the market with us.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <div id="services" class="services-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="banner-heading">Our Services</h2>
                    <p class="banner-paragraph">Explore our range of services designed to support agricultural trade.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="service-box">
                        <h4>Product Listing</h4>
                        <p>List your agricultural products and reach buyers globally.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-box">
                        <h4>Supplier Matching</h4>
                        <p>We match you with suppliers who meet your specific requirements.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-box">
                        <h4>Quotation Requests</h4>
                        <p>Submit requests and receive competitive quotes from suppliers.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="cta-section text-center">
        <h2 class="banner-heading">Start Trading with Agro Tradex Today!</h2>
        <a href="/products?category_id=9&data_from=category&page=1" class="btn get-started-btn">Get Started >></a>
    </div>
</section>
@endsection