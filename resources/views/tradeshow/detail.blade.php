@extends('layouts.front-end.app')
@section('title', translate('Trade Shows' . ' | ' . $web_config['name']->value))
@push('css_or_js')
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/ai/tradeshow-detail.css') }}" />
@endpush
@section('content')
<div class="trade-show-container mainpagesection">
    <main class="main-content">
      <header class="trade-show-header">
        <nav>
          <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/4050b66dcd7b723b70f446dccf2f40e76922fee3?placeholderIfAbsent=true" alt="Back arrow" class="back-arrow">
          <a href="{{ route('tradeshow') }}" class="back-link">Back to Events</a>
        </nav>
        @php
            $images = json_decode($tradeshow->image, true) ?? []; // Decode the image array
        @endphp

        @if (!empty($images) && isset($images[0]))
            <!-- Display the first image as the banner -->
            <img src="{{ asset('storage/' . $images[0]) }}" alt="Trade show banner" class="banner-image">
        @else
            <!-- Fallback if no images are available -->
            <img src="https://placehold.co/1200x400" alt="Default banner" class="banner-image">
        @endif
        </header>

      <div class="content-container">
        <div class="left-column">
          <section class="trade-show-content">
            <h1>{{ $tradeshow->name }}</h1>
            <p class="description">
              {{ $tradeshow->description }}            
            </p>

            <div class="divider"></div>

            <div class="schedule-header">
              <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/9336faac55345c273173b63c64764d0a87c42886?placeholderIfAbsent=true" alt="Schedule icon" class="schedule-icon">
              <h2>Event schedule</h2>
            </div>

            @if($tradeshow->timeline)
                <ul class="schedule-list">
                  @foreach(json_decode($tradeshow->timeline, true) as $event)
                      <li>{{ $event }}</li>
                  @endforeach
                </ul>
            @endif
            

            <div class="thick-divider"></div>

            <h2 class="gallery-title">Trade Show Images</h2>
            
            <div class="gallery-container">
                @php
                    $images = json_decode($tradeshow->image, true) ?? [];
                @endphp

                @if (count($images) > 1)
                    @foreach (array_slice($images, 1) as $image)
                        <div class="gallery-image">
                            <img src="{{ asset('storage/' . $image) }}" alt="Trade show image" style="width: 100%; height: auto;">
                        </div>
                    @endforeach
                @else
                    <p>No additional images available.</p>
                @endif
            </div>
          </section>
        </div>
        
        <div class="right-column">
          <aside class="trade-show-sidebar">
            <div class="sidebar-inner">
              <div class="date-section">
                <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/471546a607a9e78c3a12acb8ce95def0ddfdadbd?placeholderIfAbsent=true" alt="Calendar icon" class="date-icon">
                <div class="date-info">
                  <span class="label">Event Date</span>
                  <span class="value">{{ \Carbon\Carbon::parse($tradeshow->start_date)->format('j') }} - 
                    {{ \Carbon\Carbon::parse($tradeshow->end_date)->format('j F Y') }}</span>
                </div>
              </div>

              <div class="description-section">
                <p class="sidebar-description truncated" id="sidebarDescription">
                  {{ $tradeshow->description }}
                </p>
                <button class="see-more-btn" id="seeMoreBtn">See more</button>
              </div>

              <div class="location-section">
                <div class="info-row">
                  <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/fdd60901150e07cfd5d86a6807e1fd955bcca0ab?placeholderIfAbsent=true" alt="Location icon" class="info-icon">
                  <span>{{ \App\Utils\ChatManager::getCityName($tradeshow->city) }},{{ \App\Utils\ChatManager::getCountryDetails($tradeshow->country)['countryName'] }}</span>
                </div>

                <div class="info-row">
                  <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/bf1f1004b2baa9620a28435a57609d3f55e14345?placeholderIfAbsent=true" alt="Website icon" class="info-icon">
                  <a href="{{ $tradeshow->website }}" class="website-link">Visit the Official Website</a>
                </div>

                <div class="organizer-info">
                  <span class="organizer-label">Organizer:</span>
                  <span class="organizer-value">{{ $tradeshow->company_name }}</span>
                </div>
              </div>

              <button class="register-btn">Register to Event</button>
            </div>
          </aside>
        </div>
      </div>
    </main>

    <section class="latest-shows">
      <h2 class="latest-shows-title">Latest Show's</h2>
      
      <div class="card-container">
        @foreach($related as $tradeshow)
        <article class="trade-show-card">
          <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/1c4e82e1cfb765c8fff00a5114fdc640509b3ed4?placeholderIfAbsent=true" alt="Show image" class="card-image">
          <div class="card-content">
            <h3 class="card-title">{{ $tradeshow->name }}</h3>
            <p class="card-description">{{ $tradeshow->description }}</p>
            <div class="card-details">
              <span class="detail-label">Duration:</span>
              <span class="detail-value">{{ \Carbon\Carbon::parse($tradeshow->start_date)->format('j') }} - 
                {{ \Carbon\Carbon::parse($tradeshow->end_date)->format('j F Y') }}</span>
            </div>
            <div class="location-details">
              <span class="location-label">Location: </span>
              <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/c33069995588343bedd979e123bc9d023df1ee62?placeholderIfAbsent=true" alt="Location icon" class="location-icon">
              <span class="location-value">{{ \App\Utils\ChatManager::getCityName($tradeshow->city) }},{{ \App\Utils\ChatManager::getCountryDetails($tradeshow->country)['countryName'] }}</span>
            </div>
            <a href="{{ route('tradeshow.view',['name'=>$tradeshow->name,'id'=>$tradeshow->id]) }}" class="view-details-btn">View Details</a>
          </div>
        </article>
        @endforeach
      </div>
    </section>
  </div>
@endsection
@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Handle the "See more" button for the sidebar description
    const sidebarDescription = document.getElementById('sidebarDescription');
    const seeMoreBtn = document.getElementById('seeMoreBtn');

    if (sidebarDescription && seeMoreBtn) {
        seeMoreBtn.addEventListener('click', function() {
        if (sidebarDescription.classList.contains('truncated')) {
            // Show full description
            sidebarDescription.classList.remove('truncated');
            seeMoreBtn.textContent = 'See less';
        } else {
            // Truncate description
            sidebarDescription.classList.add('truncated');
            seeMoreBtn.textContent = 'See more';
        }
        });
    }

    // Add click handler for Register button
    const registerBtn = document.querySelector('.register-btn');
    if (registerBtn) {
        registerBtn.addEventListener('click', function() {
        alert('Registration form will open here');
        });
    }

    // Add click handler for View Details buttons
    const viewDetailsBtns = document.querySelectorAll('.view-details-btn');
    viewDetailsBtns.forEach(button => {
        button.addEventListener('click', function() {
        const cardTitle = this.closest('.trade-show-card').querySelector('.card-title').textContent;
        alert(`Viewing details for: ${cardTitle}`);
        });
    });

    // Make the page responsive
    function handleResponsiveLayout() {
        const windowWidth = window.innerWidth;
        const cards = document.querySelectorAll('.trade-show-card');
        
        if (windowWidth < 768) {
        cards.forEach(card => {
            card.style.width = '100%';
        });
        } else {
        cards.forEach(card => {
            card.style.width = 'calc(25% - 1rem)';
        });
        }
    }

    // Run once on load
    handleResponsiveLayout();

    // Update on window resize
    window.addEventListener('resize', handleResponsiveLayout);
    });
</script>
@endpush
