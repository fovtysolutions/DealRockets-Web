@extends('layouts.front-end.app')


@push('css_or_js')
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/ai/vendor-web.css') }}" />
@endpush

@section('content')
    <div class="main-container vender-about-us">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <img src="<?php echo asset('assets\front-end\img\image 203.png'); ?>" class="logo" alt="Logo" />
                <div class="company-info">
                    <span class="company-title">Shenzhen Kingstar Industrial Co., Ltd.</span>
                    <p class="member"><img src="<?php echo asset('assets\front-end\img\Diamond.png'); ?>" class="diamond"> Premium Member <span
                            class="member2024"> Since 2024</span> </p>
                </div>
            </div>

            <div class="header-right">
                <input class="search-input" placeholder="Search for products..." />
                <button class="search-btn">Search</button>
                <!-- <button class="search-icon"><i class="fas fa-search"></i></button> -->

            </div>
            <div class="search-box">
                <button class="btn-search" onclick="toggleSearch()"><i class="fas fa-search"></i></button>
                <input type="text" class="input-search" placeholder="Type to Search...">
            </div>
            <div class="search-overlay" onclick="toggleSearch()"></div>

        </header>
        <script>
            function toggleSearch() {
                const searchBox = document.querySelector('.search-box');
                searchBox.classList.toggle('active');
            }
        </script>

        <!-- Navigation -->
        <div style="overflow: scroll;">
            <nav class="navbar">
                <a href="#" class="nav-item nav-active">Home</a>
                <div class="nav-item dropdown">
                    Products
                    <span class="chevron">&#9660;</span>
                </div>
                <a href="#" class="nav-item">Company Profile</a>
                <a href="#" class="nav-item">Contact Us</a>
            </nav>
        </div>
        <div class="company-section">
            <aside class="company-sidebar">
                <ul>
                    <li>Company Overview</li>
                    <li>Production Capacity</li>
                    <li>Quality Control</li>
                    <li>R&D Capabilities</li>
                </ul>
            </aside>

            <main class="company-content">
                <div class="company-header">
                    <div class="company-intro">

                        <h3>Professional manufacturer of electronic products for 14 years</h3>
                        <p class="company-meta">OEM/ODM orders welcome | CE, RoHS, FCC, BQB-certified | 3,500sqm factory</p>
                        <small>Avg Response time: <strong>48–72 h</strong></small>
                        <div class="mt-4">
                            <h3>14-year Professional Manufacturer of Electronic Products</h3>
                            <p>Shenzhen Kingstar Co., Ltd is a 14-year professional manufacturer of electronic products such
                                as Bluetooth wireless speakers, Bluetooth wireless earphones, headphone headsets, power
                                banks, phone cases, massage guns, massagers, hand massagers, percussion massagers, muscle
                                massagers, muscle massage guns, handheld massagers, body massagers, electric massagers,
                                bracelets, fitness tracker, watches for women, smartwatches for Android, custom bracelets,
                                fitness tracker watches, wristbands, sports watches and more. We have advanced and
                                professional manufacturing equipment, and excellent research and development engineers. We
                                have a high-quality management and experienced manufacturing team.</p>
                        </div>


                    </div>
                    <div class="company-image">
                        <img src="<?php echo asset('assets\front-end\img\image 202.png'); ?>" alt="Company Interior" />
                    </div>
                </div>


                <section class="info-table">
                    <h5>Basic Information</h5>
                    <table>
                        <tr>
                            <td>Total Capitalization</td>
                            <td colspan="3">US$50,000 to 99,000</td>

                        </tr>
                        <tr>
                            <td>Year Established</td>
                            <td>2013</td>
                            <td>Total Employees</td>
                            <td>80 to 99</td>
                        </tr>
                        <tr>
                            <td> Company Certificate</td>
                            <td>NA</td>
                            <td>Product Certificate</td>
                            <td>ROHS, CE, FCC, PSE</td>
                        </tr>
                        <tr>
                            <td>Business Type</td>
                            <td colspan="3"> Buying Office, Exporter, Manufacturer, Online Seller, Retailer, Wholesaler
                            </td>

                        </tr>
                    </table>
                </section>

                <section class="info-table">
                    <h5>Trading Capabilities</h5>
                    <table>
                        <tr>
                            <td>Total Annual Sales</td>
                            <td>less than US$50,000</td>
                            <td>Export Percentage</td>
                            <td>100 percent</td>
                        </tr>
                        <tr>
                            <td>OEM Service</td>
                            <td>Yes</td>
                            <td>Small Orders Accepted</td>
                            <td>Yes</td>
                        </tr>
                    </table>
                </section>
                <section class="product-section">
                    <div class="section-header">
                        <h3>Company Show</h3>
                        <p>New&Hot Products <span class="span-items">| 4 Items</span></p>
                    </div>

                    <div class="product-grid">
                        <div class="product-card">
                            <p>Smartphone</p>
                            <img src="<?php echo asset('assets\front-end\img\mobile4.png'); ?>" alt="Smartphone" />
                        </div>
                        <div class="product-card">
                            <p>Laptop</p>
                            <img src="<?php echo asset('assets\front-end\img\mobile3.png'); ?>" alt="Laptop" />
                        </div>
                        <div class="product-card">
                            <p>Tablet</p>
                            <img src="<?php echo asset('assets\front-end\img\mobile2.png'); ?>" alt="Tablet" />
                        </div>
                        <div class="product-card">
                            <p>Smartwatch</p>
                            <img src="<?php echo asset('assets\front-end\img\moblie1.png'); ?>" alt="Smartwatch" />
                        </div>
                    </div>

                    <hr />

                    <div class="section-header">
                        <h3>Bulletin Board</h3>
                    </div>

                    <div class="product-grid">
                        <div class="product-card">
                            <p>Smartphone</p>
                            <img src="<?php echo asset('assets\front-end\img\mobile4.png'); ?>" alt="Smartphone" />
                        </div>
                        <div class="product-card">
                            <p>Laptop</p>
                            <img src="<?php echo asset('assets\front-end\img\mobile3.png'); ?>" alt="Laptop" />
                        </div>
                        <div class="product-card">
                            <p>Tablet</p>
                            <img src="<?php echo asset('assets\front-end\img\mobile2.png'); ?>" alt="Tablet" />
                        </div>
                        <div class="product-card">
                            <p>Smartwatch</p>
                            <img src="<?php echo asset('assets\front-end\img\moblie1.png'); ?>" alt="Smartwatch" />
                        </div>
                    </div>

                    <div class="section-header">
                        <h3>Office and Warehouse</h3>
                    </div>

                    <div class="product-grid">
                        <div class="product-card">
                            <p>Smartphone</p>
                            <img src="<?php echo asset('assets\front-end\img\mobile4.png'); ?>" alt="Smartphone" />
                        </div>
                        <div class="product-card">
                            <p>Laptop</p>
                            <img src="<?php echo asset('assets\front-end\img\mobile3.png'); ?>" alt="Laptop" />
                        </div>
                        <div class="product-card">
                            <p>Tablet</p>
                            <img src="<?php echo asset('assets\front-end\img\mobile2.png'); ?>" alt="Tablet" />
                        </div>
                        <div class="product-card">
                            <p>Smartwatch</p>
                            <img src="<?php echo asset('assets\front-end\img\moblie1.png'); ?>" alt="Smartwatch" />
                        </div>
                    </div>
                </section>

            </main>
        </div>


        <section class="inquiry-section"
            style="background: white; padding: 20px; margin: 1rem; border: 1px solid #ddd; border-radius: 8px;">
            <h5 style="background: #EBEBEB; padding: 10px; border-radius: 4px;">Send a direct inquiry to this supplier</h5>
            <form style="padding: 10px;">
                <div class="mb-3">
                    <label for="company" class="form-label">To</label>
                    <input type="text" class="form-control" id="company" value="Wenzhou Ivspeed Co.,Ltd" readonly>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail Address</label>
                    <input type="email" class="form-control" id="email"
                        placeholder="Please enter your business e-mail address">
                </div>

                <div class="mb-4">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" rows="5"
                        placeholder="Enter product details such as color, size, materials and other specific requirements."></textarea>
                </div>

                <div style="display: flex; justify-content: end;">
                    <button type="submit" class="btn btn-red inquire-btn">Send Inquiry Now</button>
                </div>
            </form>
        </section>

    </div>
@endsection

@push('script')
    <script src="{{ theme_asset(path: 'public/assets/front-end/js/product-details.js') }}"></script>
    <script type="text/javascript" async="async"
        src="https://platform-api.sharethis.com/js/sharethis.js#property=5f55f75bde227f0012147049&product=sticky-share-buttons">
    </script>
@endpush
