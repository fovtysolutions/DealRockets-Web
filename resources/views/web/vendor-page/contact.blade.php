@extends('layouts.front-end.app')


@push('css_or_js')
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/front-end/css/vendor-web.css') }}" />
@endpush

@section('content')

 <div class="main-container vender-contact">
    <!-- Header -->
    <header class="header">
      <div class="header-left">
        <img src="<?php echo asset('assets\front-end\img\image 203.png'); ?>" class="logo" alt="Logo" />
        <div class="company-info">
          <span class="company-title">Shenzhen Kingstar Industrial Co., Ltd.</span>
          <p class="member"><img src="<?php echo asset('assets\front-end\img\Diamond.png'); ?>" class="diamond"> Premium Member <span class="member2024"> Since
              2024</span> </p>
        </div>
      </div>

      <div class="header-right">
        <input class="search-input" placeholder="Search for products..." />
        <button class="search-btn">Search</button>
       

      </div>
      <div class="search-box">
        <button class="btn-search" onclick="toggleSearch()"><i class="fas fa-search"></i></button>
        <input type="text" class="input-search" placeholder="Type to Search...">
      </div>
      <div class="search-overlay" onclick="toggleSxzearch()"></div>

    </header>
    <script>
      function toggleSearch() {
      
        const searchBox = document.querySelector('.search-box');
        searchBox.classList.toggle('active');
          console.log('hello')
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
    <div class="contact-section">
      <div class="contact-left">
        <h3>Contact Details</h3>
        <p><strong>Address:</strong> <span class="contact-text margin-l"> 704, No. 818, Tianzhu Rd, Shanghai, China
            201805</span></p>
        <p><strong>Local Time:</strong><span class="contact-text">3:36PM Sat Mar 22</span> </p>
        <p><strong>Address:</strong><span class="contact-text margin-l"> Room 704, No. 818, Tianzhu Rd, Shanghai, China
            201805</span> </p>

        <div class="private-info-box">
          <p class="mb-0"><strong>Telephone:</strong></p>
          <p class="mb-0" style="justify-content: space-between;"><strong>Mobile Phone:</strong> <button
              class="sign-in-btn">Sign In for Details</button></p>
          <p class="mb-0"><strong>Fax:</strong></p>
        </div>

        <p><strong>Showroom:</strong> <span class="contact-text">704, No. 818, Tianzhu Rd, Shanghai, China 201805</span>
        </p>
      </div>

      <div class="contact-right">
        <h3>Contact Details</h3>
        <div class="contact-person">
          <div class=" text-end">
            <p class="name">Miss Linda Zhang</p>
            <p class="position">Sales Dept</p>
          </div>
          <div class="avatar-placeholder"></div>


        </div>
        <button class="contact-now-btn" data-bs-toggle="modal" data-bs-target="#contactModal">Contact Now</button>
      </div>



    </div>
    <section class="inquiry-section"
      style="background:  white;max-width:990px; padding: 20px; margin: 2rem  auto; border: 1px solid #ddd; border-radius: 8px;">
      <h5 style="background: #EBEBEB; padding: 10px; border-radius: 4px;">Send a direct inquiry to this supplier</h5>
      <form style="padding: 10px;">
        <div class="mb-3">
          <label for="company" class="form-label">To</label>
          <input type="text" class="form-control" id="company" value="Wenzhou Ivspeed Co.,Ltd" readonly>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">E-mail Address</label>
          <input type="email" class="form-control" id="email" placeholder="Please enter your business e-mail address">
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



    <!-- Modal -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
          <div class="modal-body p-4">
            <p class="text-danger text-center mb-1">Contact us</p>
            <h3 class="text-center">Get in touch</h3>
            <p class="text-center mb-4">We’d love to hear from you. Please fill out this form.</p>
            <form>
              <div class="row mb-3">
                <div class="col">
                  <input type="text" class="form-control contact-input" placeholder="First Name">
                </div>
                <div class="col">
                  <input type="text" class="form-control contact-input" placeholder="Last Name">
                </div>
              </div>
              <div class="mb-3">
                <input type="email" class="form-control contact-input" placeholder="Email">
              </div>
              <div class="mb-3">
                <input type="tel" class="form-control contact-input" placeholder="Phone Number">
              </div>
              <div class="mb-3">
                <textarea class="form-control contact-input" rows="4" placeholder="Message"></textarea>
              </div>
              <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input contact-input" id="agreePolicy">
                <label class="form-check-label " for="agreePolicy">
                  You agree to our friendly <a href="#" class="privacy">privacy policy</a>.
                </label>
              </div>
              <button type="submit" class="btn contact-now-btn w-100" style="width: 100% !important;">Send
                Message</button>
            </form>
          </div>
        </div>
      </div>
    </div>

@endsection

@push('script')
    <script src="{{ theme_asset(path: 'public/assets/front-end/js/product-details.js') }}"></script>
    <script type="text/javascript" async="async"
        src="https://platform-api.sharethis.com/js/sharethis.js#property=5f55f75bde227f0012147049&product=sticky-share-buttons"></script>
@endpush

