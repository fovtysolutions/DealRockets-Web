@extends('layouts.front-end.app')
@section('title')
Info | {{ $web_config['name']->value }}
@endsection
@section('content')
<style>
    .card {
        width: 320px; /* Fixed card width */
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background-color: #fff;
        display: flex;
        flex-direction: column;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .card-body {
        padding: 20px;
        flex-grow: 1;
    }

    .card-body h5 {
        font-size: 20px;
        margin-bottom: 10px;
        color: #333;
    }

    .card-body p {
        font-size: 14px;
        color: #777;
        margin-bottom: 20px;
    }

    /* Image styles */
    .profile-img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        margin: 20px auto;
        border: 4px solid #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .profile-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Text and image layout */
    .card-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .card-content .profile-img {
        margin-bottom: 15px;
    }

    /* Box layout for sections */
    .card-section {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        justify-content: center;
    }
</style>

<section class="mainpagesection" style="background-color: unset;">
    <div class="card-section">
        <!-- Stock Sale Box -->
        <div class="card">
            <div class="card-content">
                <div class="profile-img">
                    <img src="/images/info/stocksale.jpg" alt="Stock Sale">
                </div>
                <div class="card-body">
                    <h5>Stock Sale</h5>
                    <p>Find discounted stock available for resale at great prices.</p>
                </div>
            </div>
        </div>

        <!-- Buy Leads Box -->
        <div class="card">
            <div class="card-content">
                <div class="profile-img">
                    <img src="/images/info/buyleads.png" alt="Buy Leads">
                </div>
                <div class="card-body">
                    <h5>Buy Leads</h5>
                    <p>Purchase high-quality leads to grow your customer base.</p>
                </div>
            </div>
        </div>

        <!-- Sale Offer Box -->
        <div class="card">
            <div class="card-content">
                <div class="profile-img">
                    <img src="/images/info/sellleads.jpg" alt="Sale Offer">
                </div>
                <div class="card-body">
                    <h5>Sale Offer</h5>
                    <p>Explore limited-time sale offers and special deals.</p>
                </div>
            </div>
        </div>

        <!-- Industry Jobs Box -->
        <div class="card">
            <div class="card-content">
                <div class="profile-img">
                    <img src="/images/info/industryjobs.jpg" alt="Industry Jobs">
                </div>
                <div class="card-body">
                    <h5>Industry Jobs</h5>
                    <p>Find job opportunities in various industries.</p>
                </div>
            </div>
        </div>

        <!-- Deal Assist Box -->
        <div class="card">
            <div class="card-content">
                <div class="profile-img">
                    <img src="/images/info/dealassist.jpg" alt="Deal Assist">
                </div>
                <div class="card-body">
                    <h5>Deal Assist</h5>
                    <p>Get expert assistance to close deals successfully.</p>
                </div>
            </div>
        </div>

        <!-- Tradeshows Box -->
        <div class="card">
            <div class="card-content">
                <div class="profile-img">
                    <img src="/images/info/tradeshow.jpg" alt="Tradeshows">
                </div>
                <div class="card-body">
                    <h5>Tradeshows</h5>
                    <p>Attend tradeshows to discover new opportunities.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
