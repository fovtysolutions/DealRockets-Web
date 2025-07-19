@extends('layouts.front-end.app')
@section('title')
    Info | {{ $web_config['name']->value }}
@endsection
@section('content')
    <style>
        .card {
            width: 320px;
            border-radius: 0px;
            overflow: hidden;
            /* box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: #fff;
            display: flex;
            flex-direction: column;
        }

        .card:hover {
            /* transform: translateY(-1px); */
            /* box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2); */
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

    <section class="mainpagesection" style="background-color: unset; margin-top: 22px;">
        @php
            $cards = [
                [
                    'title' => 'Stock Sale',
                    'image' => '/images/info/stocksale.jpg',
                    'alt' => 'Stock Sale',
                    'description' => 'Buy discounted stock in bulk and save more with special business pricing deals.',
                    'route' => route('stocksale'),
                ],
                [
                    'title' => 'Buy Leads',
                    'image' => '/images/info/buyleads.png',
                    'alt' => 'Buy Leads',
                    'description' =>
                        'Access verified leads from real buyers and grow your business confidently every day.',
                        'route' => route('buyer'),
                ],
                [
                    'title' => 'Sale Offer',
                    'image' => '/images/info/sellleads.jpg',
                    'alt' => 'Sale Offer',
                    'description' =>
                        'Find limited-time offers tailored for your business and save big on top products.',
                        'route' => route('seller'),
                ],
                [
                    'title' => 'Industry Jobs',
                    'image' => '/images/info/industryjobs.jpg',
                    'alt' => 'Industry Jobs',
                    'description' =>
                        'Apply to top jobs in your industry and connect with employers across key sectors.',
                        'route' => route('sendcv'),
                ],
                [
                    'title' => 'Solutions',
                    'image' => '/images/info/dealassist.jpg',
                    'alt' => 'Deal Assist',
                    'description' =>'Get smart solutions for<a href="solutions/web/1 target="_blank" > hypermarket</a>, 
                    <a href="solutions/web/3 target="_blank"> hospitality</a>, and 
                    <a href="solutions/web/2 target="_blank"> construction</a> business operations today.',
                    'link' => 'solutions/web/1',
                ],
                [
                    'title' => 'Deal Assist',
                    'image' => '/images/info/dealassist.jpg',
                    'alt' => 'Deal Assist',
                    'description' => 'Receive expert help to close deals faster and manage trade with full confidence.',
                    'route' => route('dealassist'),
                ],
                [
                    'title' => 'Tradeshows',
                    'image' => '/images/info/tradeshow.jpg',
                    'alt' => 'Tradeshows',
                    'description' =>
                        'Attend live trade shows, connect with industry leaders, and expand your market reach.',
                        'route' => route('tradeshow'),
                ],
            ];
        @endphp

        <div class="card-section">
            @foreach ($cards as $card)
                <a href="{{ $card['route'] ?? $card['link'] ?? '#' }}" style="text-decoration: none; color: inherit;">
                    <div class="card">
                        <div class="card-content">
                            <div class="profile-img">
                                <img src="{{ $card['image'] }}" alt="{{ $card['alt'] }}">
                            </div>
                            <div class="card-body">
                                <h5>{{ $card['title'] }}</h5>
                              <p class=>{!! $card['description'] !!}</p>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

    </section>
@endsection
