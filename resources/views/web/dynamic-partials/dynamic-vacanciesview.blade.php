<button type="button" class="close showbelow768" aria-label="Close" onclick="toggleDetailBox()">
    <span aria-hidden="true">&times;</span>
</button>
<div class="job-header-panel">
    <div class="company-info">
        <img src="{{ isset($firstdata->company_logo) ? 'storage/' . $firstdata->company_logo : '/img/image 154 (1).png' }}"
            alt="Company Logo" class="company-logo">
        <div class="company-meta">
            <h1>{{ $firstdata->title }}</h1>
            <p>{{ $firstdata->company_name }} - {{ $firstdata->company_address }}</p>
            <p class="posted-time">Posted {{ $firstdata->created_at->diffForHumans() }}</p>
        </div>
    </div>
    <div class="action-icons">
        <button class="share-btn" onclick="copyLinkToClipboard()"><i class="fas fa-share-alt"></i></button>
        {{-- <button class="more-btn"><i class="fas fa-ellipsis-h"></i></button> --}}
    </div>
</div>

<div class="action-buttons">
    <button class="apply-now-btn" data-toggle="modal" data-target="#modalJobApply">Apply Now</button>
    @php
        $user = auth('customer')->user();
        if ($user) {
            $isFavourite = \App\Utils\HelperUtil::checkIfFavourite($firstdata->id, $user->id);
        } else {
            $isFavourite = false;
        }
    @endphp
    @if (auth('customer')->user())
        <button class="save-btn" onclick="makeFavourite(this)" data-id="{{ $firstdata->id }}"
            data-userid="{{ $user->id }}" data-type="industryjob"
            data-role="{{ auth()->user()->role ?? 'customer' }}">{{ $isFavourite ? 'Saved' : 'Save' }}</button>
    @else
        <button class="save-btn" onclick="sendtologin()">Save</button>
    @endif
</div>

<hr>

<div class="job-info-grid">
    <div class="job-info-left">
        <div class="info-item">
            <i class="fa-sharp fa-solid fa-dollar-sign"></i>
            <span>{{ $firstdata->salary_low }} to {{ $firstdata->salary_high }} {{ $firstdata->currency }}</span>
        </div>
        <div class="info-item">
            <i class="fas fa-map-marker-alt"></i>
            <span>{{ \App\Models\City::where('id', $firstdata->city)->first()->name }}</span>
        </div>
        <div class="info-item">
            <i class="fas fa-home"></i>
            <span>{{ $firstdata->employment_space }}</span>
        </div>
        <div class="info-item">
            <i class="fa-sharp fa-solid fa-house"></i>
            <span>{{ $firstdata->employment_type }}</span>
        </div>
    </div>

    <div class="vertical-divider"></div>

    <div class="job-info-right">
        <h3>Company</h3>
        <p>{{ $firstdata->company_employees }} employee</p>
        <p>{{ \App\Models\Category::find($firstdata->category)->name }}</p>
    </div>
</div>

<hr>

<div class="job-description-section">
    <h3>Job Description</h3>
    <div class="description-text">
        {{ $firstdata->description }}
    </div>
</div>

<div class="contact-footer">
    <div class="contact-row">
        <div class="contact-item">
            <i class="fas fa-envelope"></i>
            <span>{{ $firstdata->company_email }}</span>
        </div>
        <div class="contact-item">
            <i class="fas fa-globe"></i>
            <span>
                <a href="{{ $firstdata->company_website }}">
                    Click here to go to Website
                </a>
            </span>
        </div>

    </div>
    <div class="contact-row">
        <div class="contact-item">
            <i class="fas fa-phone"></i>
            <span>{{ $firstdata->company_phone }}</span>
        </div>
        <div class="contact-item">
            <i class="fas fa-map-marker-alt"></i>
            <span>{{ $firstdata->company_address }}</span>
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
