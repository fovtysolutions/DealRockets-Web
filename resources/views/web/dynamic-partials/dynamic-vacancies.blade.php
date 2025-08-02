@foreach ($jobseeker as $item)
    <div class="job-card" data-id="{{ $item->id }}" onclick="populateDetailedBox(this)">
        <div class="job-header pb-0">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div style="flex: 1;">
                    <h2>{{ $item->title ?? 'Untitled Position' }}</h2>
                    <p class="job-meta mb-0">
                        {{ optional($item->created_at)->diffForHumans() ?? 'Date not available' }} 
                        by <span style="color: var(--primary-color);"> {{ $item->company_name ?? 'Unknown Company' }} </span>
                    </p>
                </div>
                
                @php
                    $user = auth('customer')->user();
                    $isFavourite = $user
                        ? \App\Utils\HelperUtil::checkIfFavourite($item->id, $user->id, 'industryjob')
                        : false;
                @endphp

                @if ($user)
                    <div class="favourite-btn" onclick="makeFavourite(this); event.stopPropagation();"
                         data-id="{{ $item->id }}" data-userid="{{ $user->id }}"
                         data-type="industryjob" data-role="{{ auth()->user()->role ?? 'customer' }}"
                         style="cursor: pointer; display: flex; align-items: center; gap: 5px;">
                        <!-- <img class="heart favourite-img"
                             src="{{ $isFavourite ? theme_asset('public/img/Heart (2).png') : theme_asset('public/img/Heart (1).png') }}"
                             width="20" alt="Featured icon"> -->
                        <!-- <span class="favourite-text" style="font-size: 14px; color: #666;">
                            {{ $isFavourite ? 'Saved' : 'Save' }}
                        </span> -->
                    </div>
                @else
                    <div class="favourite-btn" onclick="sendtologin(); event.stopPropagation();"
                         style="cursor: pointer; display: flex; align-items: center; gap: 5px;">
                        <!-- <img class="heart favourite-img" 
                             src="{{ theme_asset('public/img/Heart (1).png') }}" width="20"
                             alt="Featured icon">
                        <span class="favourite-text" style="font-size: 14px; color: #666;">Save</span> -->
                    </div>
                @endif
            </div>
        </div>
        <div class="job-details">
            <div style="display: flex; justify-content: space-between;">
                <div class="job-info">
                    <div class="salary">
                        <i class="fa-sharp fa-solid fa-dollar-sign" style="font-size: 15px;"></i> 
                        {{ $item->salary_low ?? 'N/A' }} to {{ $item->salary_high ?? 'N/A' }}
                    </div>

                    <div class="type">
                        <i class="fa-sharp fa fa-house"></i> 
                        {{ $item->employment_space ?? 'Not specified' }}
                    </div>

                    <div class="location">
                        <i class="fa fa-map-marker"></i>
                        {{ optional(\App\Models\City::find($item->city))->name ?? 'Unknown Location' }}
                    </div>

                    <div class="commitment">
                        <i class="far fa-clock"></i> 
                        {{ $item->employment_type ?? 'Not specified' }}
                    </div>
                </div>
            </div>

            <div class="job-description">
                <p>{{ $item->description ?? 'No description provided.' }}</p>
            </div>
        </div>
    </div>
@endforeach
<script>
    function makeFavourite(element) {
        const listingId = element.getAttribute('data-id');
        const user_id = element.getAttribute('data-userid');
        const type = element.getAttribute('data-type');
        const role = element.getAttribute('data-role');
        const btn = element;
        const heartImg = btn.querySelector('.heart');
        const textSpan = btn.querySelector('.favourite-text');

        var data = {
            listing_id: listingId,
            user_id: user_id,
            type: type,
            role: role,
            _token: '{{ csrf_token() }}'
        };

        $.ajax({
            url: '{{ route('toggle-favourite') }}',
            method: 'POST',
            data: data,
            success: function(response) {
                if (response.status === 'added') {
                    toastr.success('Added to Favourites');
                    if (heartImg) heartImg.src = '{{ theme_asset('public/img/Heart (2).png') }}';
                    if (textSpan) textSpan.textContent = 'Saved';
                } else {
                    toastr.success('Removed from Favourites');
                    if (heartImg) heartImg.src = '{{ theme_asset('public/img/Heart (1).png') }}';
                    if (textSpan) textSpan.textContent = 'Save';
                }
            },
            error: function() {
                toastr.error('Something Went Wrong');
            }
        });
    }

    function sendtologin() {
        window.location.href = '/customer/auth/login';
    }
</script>
