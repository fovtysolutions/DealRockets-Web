<section class="fade-in-on-scroll">
    <div class="trade-container">
        <!-- First Box -->
        <div class="firstbox">
            @if(!empty($tradeshowhomepage['tradeshowhomepage']['carousel1']))
                <img src="{{ asset('storage/' . $tradeshowhomepage['tradeshowhomepage']['carousel1']) }}" alt="first image">
            @endif
            @if(!empty($tradeshowhomepage['tradeshowhomepage']['title1']))
                <h5 style="color: {{ $tradeshowhomepage['tradeshowhomepage']['textcolor1'] ?? 'black' }}">
                    {{ $tradeshowhomepage['tradeshowhomepage']['title1'] }}
                </h5>
            @endif
        </div>

        <!-- Second Box -->
        <div class="secondbox">
            <!-- First Box -->
            <div class="secondtop">
                @if(!empty($tradeshows[0]['image']))
                    <img src="{{ asset('storage/' . json_decode($tradeshows[0]['image'])[0]) }}" alt="first image">
                @elseif(!empty($tradeshowhomepage['tradeshowhomepage']['carousel2']))
                    <img src="{{ asset('storage/' . $tradeshowhomepage['tradeshowhomepage']['carousel2']) }}" alt="first image">
                @endif
                <h5 class="text-truncate" style="color: {{ $tradeshowhomepage['tradeshowhomepage']['textcolor2'] ?? 'black' }}">
                    {{ $tradeshows[0]['name'] ?? $tradeshowhomepage['tradeshowhomepage']['title2'] ?? 'Default Title 2' }}
                </h5>
            </div>
        
            <!-- Second Box -->
            <div class="secondbottom">
                @if(!empty($tradeshows[1]['image']))
                    <img src="{{ asset('storage/' . json_decode($tradeshows[1]['image'])[0]) }}" alt="second image">
                @elseif(!empty($tradeshowhomepage['tradeshowhomepage']['carousel3']))
                    <img src="{{ asset('storage/' . $tradeshowhomepage['tradeshowhomepage']['carousel3']) }}" alt="second image">
                @endif
                <h5 class="text-truncate" style="color: {{ $tradeshowhomepage['tradeshowhomepage']['textcolor3'] ?? 'black' }}">
                    {{ $tradeshows[1]['name'] ?? $tradeshowhomepage['tradeshowhomepage']['title3'] ?? 'Default Title 3' }}
                </h5>
            </div>
        </div>        

        <!-- Third Box -->
        <div class="thirdbox">
            <div class="thirdtop">
                @if(!empty($tradeshowhomepage['tradeshowhomepage']['carousel4']))
                    <img class="base-image" src="{{ asset('storage/' . $tradeshowhomepage['tradeshowhomepage']['carousel4']) }}" alt="third top image">
                @endif
                @if(!empty($tradeshowhomepage['tradeshowhomepage']['newimage4']))
                    <img class="overlay-image" src="{{ asset('storage/' . $tradeshowhomepage['tradeshowhomepage']['newimage4']) }}" alt="third top overlay image">
                @endif
                @if(!empty($tradeshowhomepage['tradeshowhomepage']['title4']))
                    <h5 style="color: {{ $tradeshowhomepage['tradeshowhomepage']['textcolor4'] ?? 'black' }}">
                        {{ $tradeshowhomepage['tradeshowhomepage']['title4'] }}
                    </h5>
                @endif
            </div>
            <div class="thirdbottom">
                @if(!empty($tradeshowhomepage['tradeshowhomepage']['carousel5']))
                    <img class="base-image" src="{{ asset('storage/' . $tradeshowhomepage['tradeshowhomepage']['carousel5']) }}" alt="third bottom image">
                @endif
                @if(!empty($tradeshowhomepage['tradeshowhomepage']['newimage5']))
                    <img class="overlay-image" src="{{ asset('storage/' . $tradeshowhomepage['tradeshowhomepage']['newimage5']) }}" alt="third bottom overlay image">
                @endif
                @if(!empty($tradeshowhomepage['tradeshowhomepage']['title5']))
                    <h5 style="color: {{ $tradeshowhomepage['tradeshowhomepage']['textcolor5'] ?? 'black' }}">
                        {{ $tradeshowhomepage['tradeshowhomepage']['title5'] }}
                    </h5>
                @endif
            </div>
        </div>        
    </div>
</section>
