<div class="vender-contact">
    <div class="contact-section">
        <div class="contact-left">
            <h3>Contact Details</h3>
            <p>
                <strong>Address:</strong>
                <span class="contact-text margin-l">
                    {{ $shopInfoArray['company_profiles']->address ?? 'N/A' }}
                </span>
            </p>
            <p>
                <strong>Local Time:</strong>
                <span class="contact-text">
                    {{ $shopInfoArray['company_profiles']->local_time ?? 'N/A' }}
                </span>
            </p>
            @if (auth()->check())
                <div class="private-info-box">
                    <p class="mb-0">
                        <strong>Telephone:</strong>
                        <span class="contact-text margin-l">
                            {{ $shopInfoArray['company_profiles']->telephone ?? 'N/A' }}
                        </span>
                    </p>
                    <p class="mb-0" style="justify-content: space-between;">
                        <strong>Mobile Phone:</strong>
                        <span class="contact-text margin-l">
                            {{ $shopInfoArray['company_profiles']->mobile ?? 'N/A' }}
                        </span>
                    </p>
                    <p class="mb-0">
                        <strong>Fax:</strong>
                        <span class="contact-text margin-l">
                            {{ $shopInfoArray['company_profiles']->fax ?? 'N/A' }}
                        </span>
                    </p>
                </div>
            @else
                <p>
                    <button class="sign-in-btn">Sign In for Details</button>
                </p>
            @endif
            <p>
                <strong>Showroom:</strong>
                <span class="contact-text">
                    {{ $shopInfoArray['company_profiles']->showroom ?? 'N/A' }}
                </span>
            </p>
            <p>
                <strong>Website:</strong>
                <span class="contact-text">
                    @if (!empty($shopInfoArray['company_profiles']->website))
                        <a href="{{ $shopInfoArray['company_profiles']->website }}" target="_blank">
                            {{ $shopInfoArray['company_profiles']->website }}
                        </a>
                    @else
                        N/A
                    @endif
                </span>
            </p>
        </div>
        <div class="contact-right">
            <h3>Contact Person</h3>
            <div class="contact-person">
                <div class="text-end">
                    <p class="name">
                        {{ $shopInfoArray['company_profiles']->contact_name ?? 'N/A' }}
                    </p>
                    <p class="position">
                        {{ $shopInfoArray['company_profiles']->contact_dept ?? 'N/A' }}
                    </p>
                </div>
                <div class="avatar-placeholder"></div>
            </div>
            <p>
                <strong>Email:</strong>
                @if (auth()->check())
                    <span class="contact-text">
                        {{ $shopInfoArray['company_profiles']->email ?? 'N/A' }}
                    </span>
                @else
                    <button class="sign-in-btn">Sign In for Details</button>
                @endif
            </p>
            <button class="contact-now-btn" data-bs-toggle="modal" data-bs-target="#contactModal">
                Contact Now
            </button>
        </div>
    </div>
</div>
