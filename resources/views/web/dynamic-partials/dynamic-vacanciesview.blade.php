<div style="padding: 0 1rem">
<button type="button" class="close showbelow768" aria-label="Close" onclick="toggleDetailBox()">
    <span aria-hidden="true">&times;</span>
</button>

<div class="job-header-panel">
    <div class="company-info">
        <img src="{{ isset($firstdata->company_logo) && $firstdata->company_logo
    ? asset('storage/' . $firstdata->company_logo)
    : asset('/img/image 154 (1).png') }}" alt="Company Logo" onerror="this.onerror=null;this.src='/images/placeholderimage.webp';" class="company-logo">

        <div class="company-meta">
            <h1 class="text-black">{{ $firstdata->title ?? 'No Title Provided' }}</h1>
            <p>
                {{ $firstdata->company_name ?? 'Company name unavailable' }} -
                {{ $firstdata->company_address ?? 'Address unavailable' }}
            </p>
            <p class="posted-time">
                Posted {{ optional($firstdata->created_at)->diffForHumans() ?? 'Date not available' }}
            </p>
        </div>
    </div>

    <div class="action-icons">
        <button class="share-btn" onclick="copyLinkToClipboard()">
            <img src="/img/Share.png" alt="Share Icon" style="max-width:20px;">
        </button>
        {{-- <button class="more-btn"><i class="fas fa-ellipsis-h"></i></button> --}}
    </div>
</div>

<div class="action-buttons">
    <button class="apply-now-btn" data-toggle="modal" data-target="#modalJobApply">Apply Now</button>

    @php
        $user = auth('customer')->user();
        $isFavourite = false;
        if ($user && isset($firstdata->id)) {
            $isFavourite = \App\Utils\HelperUtil::checkIfFavourite($firstdata->id, $user->id, 'industryjob');
        }
    @endphp

    @if ($user)
        <button class="save-btn" onclick="makeFavourite(this)" data-id="{{ $firstdata->id ?? '' }}"
            data-userid="{{ $user->id ?? '' }}" data-type="industryjob" data-role="{{ $user->role ?? 'customer' }}">
            {{ $isFavourite ? 'Saved' : 'Save' }}
        </button>
    @else
        <button class="save-btn" onclick="sendtologin()">Save</button>
    @endif
</div>

<hr>

    <div class="job-info-grid">
        <div class="job-info-left">
            <div class="info-item">
                <div class="icon-container">
                    <i class="fa-sharp fa-solid fa-dollar-sign"></i>
                </div>
                <span>
                    {{ $firstdata->salary_low ?? 'N/A' }} to {{ $firstdata->salary_high ?? 'N/A' }}
                    {{ $firstdata->currency ?? '' }}
                </span>
            </div>
            <div class="info-item">
                <div class="icon-container">
                    <i class="fa fa-map-marker"></i>
                </div>
                <span>
                    {{ optional(\App\Models\City::find($firstdata->city))->name ?? 'Unknown Location' }}
                </span>
            </div>
            <div class="info-item">
                <div class="icon-container">
                    <i class="fa-sharp fa fa-house"></i>
                </div>
                <span>{{ $firstdata->employment_space ?? 'Not specified' }}</span>
            </div>
            <div class="info-item">
                <div class="icon-container">
                    <i class="far fa-clock"></i>
                </div>
                <span>{{ $firstdata->employment_type ?? 'Not specified' }}</span>
            </div>
        </div>

        <div class="vertical-divider"></div>

        <div class="job-info-right" >
            <h3 style="color: #151414;">Company</h3>
            <p>{{ $firstdata->company_employees ? $firstdata->company_employees . ' employee' : 'Employee count unavailable' }}</p>
            <p>{{ optional(\App\Models\Category::find($firstdata->category))->name ?? 'Category unavailable' }}</p>
        </div>
    </div>

<hr>

        <div class="job-description-section">
            <h3 style="color: #151414;">Job Description</h3>
            <div class="description-text">
                {{ $firstdata->description ?? 'No description provided.' }}
            </div>
        </div>
</div>
<div class="contact-footer">
    <div class="contact-row pr-0 " style="padding:0 1rem">
        <div class="contact-item my-1">
            <i class="fas fa-envelope"></i>
            <span class="text-black">{{ $firstdata->company_email ?? 'Email not available' }}</span>
        </div>
        <div class="contact-item my-1">
            <i class="fas fa-globe"></i>
            <span class="text-black">
                @if(!empty($firstdata->company_website))
                    <a href="{{ $firstdata->company_website }}" target="_blank" rel="noopener noreferrer">
                        {{ $firstdata->company_website }}
                    </a>
                @else
                    Website not available
                @endif
            </span>
        </div>
    </div>
    <div class="contact-row" style="padding:0 1.5rem">
        <div class="contact-item my-1">
            <i class="fas fa-phone"></i>
            <span class="text-black">{{ $firstdata->company_phone ?? 'Phone not available' }}</span>
        </div>
        <div class="contact-item my-1">
            <i class="fas fa-map-marker-alt"></i>
            <span class="text-black">{{ $firstdata->company_address ?? 'Address not available' }}</span>
        </div>
    </div>
</div>
<script>
    function copyLinkToClipboard() {
        const url = window.location.href;
        navigator.clipboard.writeText(url)
            .then(() => {
                // Optional: show success message
                toastr.success("Link copied to clipboard!");
            })
            .catch(err => {
                console.error('Failed to copy link:', err);
            });
    }
</script>