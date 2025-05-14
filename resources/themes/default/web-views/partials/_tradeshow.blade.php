<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/tradeshow-home.css') }}" />
<main class="main-container tradeshow-home">
    <section class="content-section">
      <div class="content-layout">
        <div class="content-grid">
          <!-- Main content area with trade show cards -->
          <div class="main-content">
            <div class="trade-shows-grid beforeshow768">
              @foreach($tradeshows->take(4) as $tradeshow)
                <div class="trade-show-card">
                  <div class="card-container">
                    @php
                      $imageData = json_decode($tradeshow->image, true);
                      $image = !empty($imageData[0]) ? $imageData[0] : null;
                    @endphp
                    @if(isset($image))
                      <div class="image-wrapper shimmer">
                        <img
                          data-src="{{ asset('storage/' . $image) }}"
                          class="card-image lazyload"
                          alt="Trade Show"
                        />
                      </div>
                    @else
                      <img
                        src="{{ asset('images/placeholderimage.webp') }}"
                        class="card-image"
                        alt="Trade Show"
                      />
                    @endif
                    <div class="card-content">
                      <div class="card-title">{{ $tradeshow->name ?? '' }}</div>
                      <div class="card-description">{{ $tradeshow->description ?? ''}}</div>
                      <div class="card-details">
                        <div class="detail-label">Duration:</div>
                        <div class="detail-value">{{ \Carbon\Carbon::parse($tradeshow->start_date)->format('j') }} - 
                          {{ \Carbon\Carbon::parse($tradeshow->end_date)->format('j F Y') }}
                        </div>
                      </div>
                      <div class="card-location">
                        <div class="location-label">Location: </div>
                        <div class="location-value">
                          @php
                            $countryDetails = \App\Utils\ChatManager::getCountryDetails($tradeshow->country);
                          @endphp
                          <img
                            src="/flags/{{ strtolower($countryDetails['countryISO2']) }}.svg"
                            class="location-icon"
                            alt="China flag"
                          />
                          <div class="location-text">{{ $tradeshow->address ?? ''}}</div>
                        </div>
                      </div>
                      <a href="{{ route('tradeshow.view',['name'=>$tradeshow->name,'id'=>$tradeshow->id]) }}" class="card-button">View Details</a>
                    </div>
                  </div>
                </div>
              @endforeach          
            </div>
            <div class="trade-shows-grid onlyshow768">
              @foreach($tradeshows->take(2) as $tradeshow)
                <div class="trade-show-card">
                  <div class="card-container">
                    @php
                      $imageData = json_decode($tradeshow->image, true);
                      $image = !empty($imageData[0]) ? $imageData[0] : null;
                    @endphp
                    @if(isset($image))
                      <img
                        src="{{ asset('storage/' . $image) }}"
                        class="card-image"
                        alt="Trade Show"
                      />
                    @else
                      <img
                        src="{{ asset('images/placeholderimage.webp') }}"
                        class="card-image"
                        alt="Trade Show"
                      />
                    @endif
                    <div class="card-content">
                      <div class="card-title">{{ $tradeshow->name ?? '' }}</div>
                      <div class="card-description">{{ $tradeshow->description ?? ''}}</div>
                      <div class="card-details">
                        <div class="detail-label">Duration:</div>
                        <div class="detail-value">{{ \Carbon\Carbon::parse($tradeshow->start_date)->format('j') }} - 
                          {{ \Carbon\Carbon::parse($tradeshow->end_date)->format('j F Y') }}
                        </div>
                      </div>
                      <div class="card-location">
                        <div class="location-label">Location: </div>
                        <div class="location-value">
                          @php
                            $countryDetails = \App\Utils\ChatManager::getCountryDetails($tradeshow->country);
                          @endphp
                          <img
                            src="/flags/{{ strtolower($countryDetails['countryISO2']) }}.svg"
                            class="location-icon"
                            alt="China flag"
                          />
                          <div class="location-text">{{ $tradeshow->address ?? ''}}</div>
                        </div>
                      </div>
                      <a href="{{ route('tradeshow.view',['name'=>$tradeshow->name,'id'=>$tradeshow->id]) }}" class="card-button">View Details</a>
                    </div>
                  </div>
                </div>
              @endforeach          
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>