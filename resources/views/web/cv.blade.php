@extends('layouts.front-end.app')
@push('css_or_js')
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/ai/joblanding.css') }}" />
@endpush
@section('title', translate('Job Landing' . ' | ' . $web_config['name']->value))
@section('content')
    <section class="mainpagesection job-landing" style="margin-top: 20px;">
        <div>
            <!-- Hero Section -->
            <section class="hero-section">
                <div class="hero-content">
                    <div class="hero-left">
                        <div class="logo-container">
                            <img src="/img/a0b617ba94804b374f010991f905edd8.png" alt="DealRocket Logo" class="dealrocket-logo">
                            <span class="industry-jobs">INDUSTRY JOB'S</span>
                        </div>
                        <h1 class="hero-title">Find the Right Opportunity</h1>
                        <p class="hero-description">Advance your career or discover the ideal candidate.<br />Take the next
                            step toward success today!</p>
                        <div class="hero-buttons">
                            <a href="{{ route('talentfinder') }}" class="btn btn-outline">I'm hiring</a>
                            <a href="{{ route('jobseeker') }}" class="btn btn-primary">I'm looking for a job</a>
                        </div>
                    </div>
                    <div class="hero-right">
                        <!-- <img src="/img/image 165.png" alt="Business handshake" class="hero-image"> -->
                    </div>
                </div>
            </section>

            <!-- Job Categories Section -->
            <section class="job-categories">
                <h2 class="section-title1">Job <span class="highlight">Categories</span></h2>
                <div class="categories-grid">
                    <div class="category-card">
                        <div class="category-icon-container">
                            <img src="https://img.icons8.com/ios/50/BF9E66/wheat.png" alt="Agriculture icon"
                                class="category-icon">
                        </div>
                        <div class="category-info">
                            <h3 class="category-title">Agriculture</h3>
                            <p class="category-count">235 Jobs Available</p>
                        </div>
                    </div>
                    <div class="category-card">
                        <div class="category-icon-container">
                            <img src="https://img.icons8.com/ios/50/BF9E66/factory.png" alt="Manufacturing icon"
                                class="category-icon">
                        </div>
                        <div class="category-info">
                            <h3 class="category-title">Manufacturing</h3>
                            <p class="category-count">235 Jobs Available</p>
                        </div>
                    </div>
                    <div class="category-card">
                        <div class="category-icon-container">
                            <img src="https://img.icons8.com/ios/50/BF9E66/cottage.png" alt="Real Estate icon"
                                class="category-icon">
                        </div>
                        <div class="category-info">
                            <h3 class="category-title">Real Estate</h3>
                            <p class="category-count">235 Jobs Available</p>
                        </div>
                    </div>
                    <div class="category-card">
                        <div class="category-icon-container">
                            <img src="https://img.icons8.com/ios/50/BF9E66/test-tube.png" alt="Chemicals icon"
                                class="category-icon">
                        </div>
                        <div class="category-info">
                            <h3 class="category-title">Chemicals</h3>
                            <p class="category-count">235 Jobs Available</p>
                        </div>
                    </div>
                    <div class="category-card">
                        <div class="category-icon-container">
                            <img src="https://img.icons8.com/ios/50/BF9E66/t-shirt.png" alt="Apparel icon"
                                class="category-icon">
                        </div>
                        <div class="category-info">
                            <h3 class="category-title">Apparel</h3>
                            <p class="category-count">235 Jobs Available</p>
                        </div>
                    </div>
                    <div class="category-card">
                        <div class="category-icon-container">
                            <img src="https://img.icons8.com/ios/50/BF9E66/heart-health.png" alt="Health icon"
                                class="category-icon">
                        </div>
                        <div class="category-info">
                            <h3 class="category-title">Health</h3>
                            <p class="category-count">235 Jobs Available</p>
                        </div>
                    </div>
                    <div class="category-card">
                        <div class="category-icon-container">
                            <img src="https://img.icons8.com/ios/50/BF9E66/electrical.png" alt="Electrician icon"
                                class="category-icon">
                        </div>
                        <div class="category-info">
                            <h3 class="category-title">Electrician</h3>
                            <p class="category-count">235 Jobs Available</p>
                        </div>
                    </div>
                    <div class="category-card">
                        <div class="category-icon-container">
                            <img src="https://img.icons8.com/ios/50/BF9E66/car.png" alt="Automobiles icon"
                                class="category-icon">
                        </div>
                        <div class="category-info">
                            <h3 class="category-title">Automobiles</h3>
                            <p class="category-count">235 Jobs Available</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Available Jobs Section -->
            <section class="available-jobs">
                <h2 class="section-title">Available <span class="highlight1">Job's</span></h2>
                <div class="jobs-grid">
                    <div class="job-row">
                        <div class="job-card">
                            <div class="job-header">
                                <h3 class="job-title">Vice President Marketing</h3>
                                <span class="job-posted">9 hrs ago by <span
                                        class="highlight2">eFinancialCareers</span></span>
                            </div>
                            <div class="job-details-container">
                                <div class="job-details">
                                    <div class="job-detail">
                                        <img src="https://img.icons8.com/material-outlined/16/000000/us-dollar.png"
                                            alt="salary" class="job-icon">
                                        <span>10,000 to 15,000</span>
                                    </div>
                                    <div class="job-detail">
                                        <img src="https://img.icons8.com/material-outlined/16/000000/home-office.png"
                                            alt="work location" class="job-icon">
                                        <span>Work from home</span>
                                    </div>
                                </div>
                                <div class="job-details">
                                    <div class="job-detail">
                                        <img src="https://img.icons8.com/material-outlined/16/000000/marker.png"
                                            alt="city" class="job-icon">
                                        <span>London</span>
                                    </div>
                                    <div class="job-detail">
                                        <img src="https://img.icons8.com/material-outlined/16/000000/clock.png"
                                            alt="job type" class="job-icon">
                                        <span>Permanent, full-time</span>
                                    </div>
                                </div>
                            </div>
                            <p class="job-description">Eames is working with a cutting-edge insurance data and platform
                                provider on the appointment of an Operations Manager to join their growing UK and European
                                Operations team on a remote working basis.</p>
                            <button class="btn btn-outline-small">Apply Now</button>
                        </div>

                        <div class="job-card">
                            <div class="job-header">
                                <h3 class="job-title">Vice President Marketing</h3>
                                <span class="job-posted">9 hrs ago by <span
                                        class="highlight2">eFinancialCareers</span></span>
                            </div>
                            <div class="job-details-container">
                                <div class="job-details">
                                    <div class="job-detail">
                                        <img src="https://img.icons8.com/material-outlined/16/000000/us-dollar.png"
                                            alt="salary" class="job-icon">
                                        <span>10,000 to 15,000</span>
                                    </div>
                                    <div class="job-detail">
                                        <img src="https://img.icons8.com/material-outlined/16/000000/home-office.png"
                                            alt="work location" class="job-icon">
                                        <span>Work from home</span>
                                    </div>
                                </div>
                                <div class="job-details">
                                    <div class="job-detail">
                                        <img src="https://img.icons8.com/material-outlined/16/000000/marker.png"
                                            alt="city" class="job-icon">
                                        <span>London</span>
                                    </div>
                                    <div class="job-detail">
                                        <img src="https://img.icons8.com/material-outlined/16/000000/clock.png"
                                            alt="job type" class="job-icon">
                                        <span>Permanent, full-time</span>
                                    </div>
                                </div>
                            </div>
                            <p class="job-description">Eames is working with a cutting-edge insurance data and platform
                                provider on the appointment of an Operations Manager to join their growing UK and European
                                Operations team on a remote working basis.</p>
                            <button class="btn btn-outline-small">Apply Now</button>
                        </div>

                        <div class="job-card">
                            <div class="job-header">
                                <h3 class="job-title">Vice President Marketing</h3>
                                <span class="job-posted">9 hrs ago by <span
                                        class="highlight2">eFinancialCareers</span></span>
                            </div>
                            <div class="job-details-container">
                                <div class="job-details">
                                    <div class="job-detail">
                                        <img src="https://img.icons8.com/material-outlined/16/000000/us-dollar.png"
                                            alt="salary" class="job-icon">
                                        <span>10,000 to 15,000</span>
                                    </div>
                                    <div class="job-detail">
                                        <img src="https://img.icons8.com/material-outlined/16/000000/home-office.png"
                                            alt="work location" class="job-icon">
                                        <span>Work from home</span>
                                    </div>
                                </div>
                                <div class="job-details">
                                    <div class="job-detail">
                                        <img src="https://img.icons8.com/material-outlined/16/000000/marker.png"
                                            alt="city" class="job-icon">
                                        <span>London</span>
                                    </div>
                                    <div class="job-detail">
                                        <img src="https://img.icons8.com/material-outlined/16/000000/clock.png"
                                            alt="job type" class="job-icon">
                                        <span>Permanent, full-time</span>
                                    </div>
                                </div>
                            </div>
                            <p class="job-description">Eames is working with a cutting-edge insurance data and platform
                                provider on the appointment of an Operations Manager to join their growing UK and European
                                Operations team on a remote working basis.</p>
                            <button class="btn btn-outline-small">Apply Now</button>
                        </div>
                        <div class="job-card">
                            <div class="job-header">
                                <h3 class="job-title">Vice President Marketing</h3>
                                <span class="job-posted">9 hrs ago by <span
                                        class="highlight2">eFinancialCareers</span></span>
                            </div>
                            <div class="job-details-container">
                                <div class="job-details">
                                    <div class="job-detail">
                                        <img src="https://img.icons8.com/material-outlined/16/000000/us-dollar.png"
                                            alt="salary" class="job-icon">
                                        <span>10,000 to 15,000</span>
                                    </div>
                                    <div class="job-detail">
                                        <img src="https://img.icons8.com/material-outlined/16/000000/home-office.png"
                                            alt="work location" class="job-icon">
                                        <span>Work from home</span>
                                    </div>
                                </div>
                                <div class="job-details">
                                    <div class="job-detail">
                                        <img src="https://img.icons8.com/material-outlined/16/000000/marker.png"
                                            alt="city" class="job-icon">
                                        <span>London</span>
                                    </div>
                                    <div class="job-detail">
                                        <img src="https://img.icons8.com/material-outlined/16/000000/clock.png"
                                            alt="job type" class="job-icon">
                                        <span>Permanent, full-time</span>
                                    </div>
                                </div>
                            </div>
                            <p class="job-description">Eames is working with a cutting-edge insurance data and platform
                                provider on the appointment of an Operations Manager to join their growing UK and European
                                Operations team on a remote working basis.</p>
                            <button class="btn btn-outline-small">Apply Now</button>
                        </div>

                        <div class="job-card">
                            <div class="job-header">
                                <h3 class="job-title">Vice President Marketing</h3>
                                <span class="job-posted">9 hrs ago by <span
                                        class="highlight2">eFinancialCareers</span></span>
                            </div>
                            <div class="job-details-container">
                                <div class="job-details">
                                    <div class="job-detail">
                                        <img src="https://img.icons8.com/material-outlined/16/000000/us-dollar.png"
                                            alt="salary" class="job-icon">
                                        <span>10,000 to 15,000</span>
                                    </div>
                                    <div class="job-detail">
                                        <img src="https://img.icons8.com/material-outlined/16/000000/home-office.png"
                                            alt="work location" class="job-icon">
                                        <span>Work from home</span>
                                    </div>
                                </div>
                                <div class="job-details">
                                    <div class="job-detail">
                                        <img src="https://img.icons8.com/material-outlined/16/000000/marker.png"
                                            alt="city" class="job-icon">
                                        <span>London</span>
                                    </div>
                                    <div class="job-detail">
                                        <img src="https://img.icons8.com/material-outlined/16/000000/clock.png"
                                            alt="job type" class="job-icon">
                                        <span>Permanent, full-time</span>
                                    </div>
                                </div>
                            </div>
                            <p class="job-description">Eames is working with a cutting-edge insurance data and platform
                                provider on the appointment of an Operations Manager to join their growing UK and European
                                Operations team on a remote working basis.</p>
                            <button class="btn btn-outline-small">Apply Now</button>
                        </div>

                        <div class="job-card">
                            <div class="job-header">
                                <h3 class="job-title">Vice President Marketing</h3>
                                <span class="job-posted">9 hrs ago by <span
                                        class="highlight2">eFinancialCareers</span></span>
                            </div>
                            <div class="job-details-container">
                                <div class="job-details">
                                    <div class="job-detail">
                                        <img src="https://img.icons8.com/material-outlined/16/000000/us-dollar.png"
                                            alt="salary" class="job-icon">
                                        <span>10,000 to 15,000</span>
                                    </div>
                                    <div class="job-detail">
                                        <img src="https://img.icons8.com/material-outlined/16/000000/home-office.png"
                                            alt="work location" class="job-icon">
                                        <span>Work from home</span>
                                    </div>
                                </div>
                                <div class="job-details">
                                    <div class="job-detail">
                                        <img src="https://img.icons8.com/material-outlined/16/000000/marker.png"
                                            alt="city" class="job-icon">
                                        <span>London</span>
                                    </div>
                                    <div class="job-detail">
                                        <img src="https://img.icons8.com/material-outlined/16/000000/clock.png"
                                            alt="job type" class="job-icon">
                                        <span>Permanent, full-time</span>
                                    </div>
                                </div>
                            </div>
                            <p class="job-description">Eames is working with a cutting-edge insurance data and platform
                                provider on the appointment of an Operations Manager to join their growing UK and European
                                Operations team on a remote working basis.</p>
                            <button class="btn btn-outline-small">Apply Now</button>
                        </div>
                    </div>
                </div>
            </section>

            <div class="white-bg-container">
                <!-- Hiring Section -->
                <section class="hiring-section">
                    <div class="hiring-content">
                        <div class="hiring-left">
                            <span class="need-hire-badge">NEED TO HIRE?</span>
                            <h2 class="hiring-title">Looking to <span class="highlight">post</span> a job?</h2>
                            <p class="hiring-description">Find top professionals from around the world across all
                                industries and experience levels. Connect with the best talent and build your dream team
                                today!</p>
                            <div class="features">
                                <div class="feature">
                                    <span class="feature-dot"></span>
                                    <span>Fast Hiring</span>
                                </div>
                                <div class="feature">
                                    <span class="feature-dot"></span>
                                    <span>Verified Talent</span>
                                </div>
                                <div class="feature">
                                    <span class="feature-dot"></span>
                                    <span>All Job Categories</span>
                                </div>
                            </div>
                            <button class="btn-primary-large">Post Your Job</button>
                        </div>
                        <div class="hiring-right">
                            <img src="/img/image (2).png" alt="Hiring image" class="hiring-image">
                        </div> 

                    </div>
                </section>

                <!-- Company Logos Section -->
                <section class="company-logos-section">
                    <h2 class="section-title2">Companies with <span class="highlight">Open Positions</span></h2>
                    <div class="logos-container">
                        <img class="img1" src="/img/eca8b7cee29635d9d9b3a609ed1022d5.png" alt="Google logo"
                            class="logo">
                        <img class="img1" src="/img/eca8b7cee29635d9d9b3a609ed1022d5.png" alt="Amazon logo"
                            class="logo">
                        <img class="img2" src="/img/b7870e8893e06e9ef15ef9d30733da8e.png" alt="Microsoft logo"
                            class="logo">
                        <img class="img2" src="/img/b7870e8893e06e9ef15ef9d30733da8e.png" alt="IBM logo"
                            class="logo">
                        <img class="img3" src="/img/123b18b8e9fe24642bc287b91dde155e.png" alt="Netflix logo"
                            class="logo">
                        <img class="img3" src="/img/123b18b8e9fe24642bc287b91dde155e.png" alt="Netflix logo"
                            class="logo">
                    </div>
                </section>

                <!-- Consultants Section -->
                <section class="consultants-section">
                    <h2 class="section-title3">Consultants <span class="highlight"></span></h2>
                    <div class="consultants-logos">
                        <img class="img4" src="/img/68c1fed84f886a36ad57b2c180379875.png" alt="Deloitte logo"
                            class="consultant-logo">
                        <img class="img5" src="/img/ebcabfd37a862fe1f205012ce6d7f4e2.png" alt="McKinsey logo"
                            class="consultant-logo">
                        <img class="img4" src="/img/23cfc42261019bdbd9880f930298e82f.png" alt="IBM logo"
                            class="consultant-logo">
                        <img class="img4" src="/img/3f78b8725887b42a275ec411f59bdcab.png" alt="Accenture logo"
                            class="consultant-logo">
                        <img class="img4" src="/img/23cfc42261019bdbd9880f930298e82f.png" alt="IBM logo"
                            class="consultant-logo">
                        <img class="img5" src="/img/ebcabfd37a862fe1f205012ce6d7f4e2.png" alt="McKinsey logo"
                            class="consultant-logo">
                        <img class="img6" src="/img/68c1fed84f886a36ad57b2c180379875.png" alt="Deloitte logo"
                            class="consultant-logo">
                        <img class="img7" src="/img/ebcabfd37a862fe1f205012ce6d7f4e2.png" alt="McKinsey logo"
                            class="consultant-logo">
                        <img class="img8" src="/img/23cfc42261019bdbd9880f930298e82f.png" alt="IBM logo"
                            class="consultant-logo">
                    </div>
                </section>

                <!-- foo -->
                <div class="foo">
                    <div class="foo-links">
                        <a href="#" class="foo-link">Terms & Conditions</a>
                        <span class="foo-divider"></span>
                        <a href="#" class="foo-link">Privacy Policy</a>
                        <span class="foo-divider"></span>
                        <a href="#" class="foo-link">© 2025 Industry Jobs</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script src="{{ theme_asset(path: 'public/js/joblanding.js') }}"></script>
@endpush
