@extends('layouts.back-end.app-partialseller')

@section('title', translate('FAQ'))

@push('css_or_js')
    <link rel="stylesheet" href="{{ asset('assets/custom-css/css-partials/faq.css') }}">
@endpush

@section('content')
    <div class="content container-fluid faqs">
        <div class="faq-container">
            <div class="faq-header">
                <h1>Frequently Asked Questions</h1>
                <p>Find answers to common questions about our services</p>

                <!-- Search Bar -->
                <div class="search-container">
                    <div class="search-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" id="searchInput" placeholder="Search questions...">
                        <button class="clear-search" title="Clear search">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>
                </div>

                {{-- <!-- Category Filter -->
                <div class="category-filter">
                    <button class="category-btn active" data-category="all">All</button>
                    <button class="category-btn" data-category="general">General</button>
                    <button class="category-btn" data-category="account">Account</button>
                    <button class="category-btn" data-category="billing">Billing</button>
                    <button class="category-btn" data-category="technical">Technical</button>
                </div> --}}
            </div>

            <div class="faq-content">
                @if (empty($faqs))
                    <h5> No FAQ's Added by Admin. Please Check Later. </h5>
                @endif
                <!-- General Questions -->
                <div class="faq-category" data-category="general">
                    <h2>General Questions</h2>
                    @foreach ($faqs as $item)
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>{{ $item->question }}</h3>
                                <span class="faq-icon"><i class="fa-solid fa-plus"></i></span>
                            </div>
                            <div class="faq-answer">
                                <p>{{ $item->answer }}</p>
                            </div>
                        </div>
                    @endforeach
                    {{-- <div class="faq-item">
                        <div class="faq-question">
                            <h3>What services do you offer?</h3>
                            <span class="faq-icon"><i class="fa-solid fa-plus"></i></span>
                        </div>
                        <div class="faq-answer">
                            <p>We offer a comprehensive range of services including web development, cloud solutions,
                                digital marketing, and technical support. Our team of experts is dedicated to providing
                                high-quality solutions tailored to your specific needs.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>How can I contact customer support?</h3>
                            <span class="faq-icon"><i class="fa-solid fa-plus"></i></span>
                        </div>
                        <div class="faq-answer">
                            <p>You can reach our customer support team through multiple channels: email at
                                support@example.com, phone at +1 (555) 123-4567, or through our live chat feature available
                                24/7 on our website.</p>
                        </div>
                    </div> --}}
                </div>

                <!-- Account Questions -->
                {{-- <div class="faq-category" data-category="account">
                    <h2>Account Management</h2>
                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>How do I create an account?</h3>
                            <span class="faq-icon"><i class="fa-solid fa-plus"></i></span>
                        </div>
                        <div class="faq-answer">
                            <p>Creating an account is simple! Click the "Sign Up" button in the top right corner, fill in
                                your details, verify your email address, and you're ready to go. The entire process takes
                                less than 2 minutes.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>How can I reset my password?</h3>
                            <span class="faq-icon"><i class="fa-solid fa-plus"></i></span>
                        </div>
                        <div class="faq-answer">
                            <p>To reset your password, click on the "Forgot Password" link on the login page. Enter your
                                email address, and we'll send you a password reset link. Follow the instructions in the
                                email to create a new password.</p>
                        </div>
                    </div>
                </div> --}}

                <!-- Billing Questions -->
                {{-- <div class="faq-category" data-category="billing">
                    <h2>Billing & Payments</h2>
                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>What payment methods do you accept?</h3>
                            <span class="faq-icon"><i class="fa-solid fa-plus"></i></span>
                        </div>
                        <div class="faq-answer">
                            <p>We accept all major credit cards (Visa, MasterCard, American Express), PayPal, and bank
                                transfers. For enterprise customers, we also offer custom payment terms and invoicing
                                options.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>How do I update my billing information?</h3>
                            <span class="faq-icon"><i class="fa-solid fa-plus"></i></span>
                        </div>
                        <div class="faq-answer">
                            <p>You can update your billing information by logging into your account, navigating to the
                                "Billing" section, and clicking on "Update Payment Method". Here you can add, remove, or
                                modify your payment details.</p>
                        </div>
                    </div>
                </div> --}}

                <!-- Technical Questions -->
                {{-- <div class="faq-category" data-category="technical">
                    <h2>Technical Support</h2>
                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>What are your system requirements?</h3>
                            <span class="faq-icon"><i class="fa-solid fa-plus"></i></span>
                        </div>
                        <div class="faq-answer">
                            <p>Our platform is designed to work on all modern browsers (Chrome, Firefox, Safari, Edge) and
                                devices. We recommend using the latest version of your preferred browser for the best
                                experience.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>How do I integrate your API?</h3>
                            <span class="faq-icon"><i class="fa-solid fa-plus"></i></span>
                        </div>
                        <div class="faq-answer">
                            <p>We provide comprehensive API documentation and SDKs for various programming languages. You
                                can find detailed integration guides, code examples, and API references in our Developer
                                Portal.</p>
                        </div>
                    </div>
                </div> --}}
            </div>

            {{-- <footer>
                <div class="footer-content">
                    Created by <a href="https://harmoncode.com" target="_blank">HarmonCode</a>
                </div>
            </footer> --}}
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('js/faqs.js') }}"></script>
@endpush
