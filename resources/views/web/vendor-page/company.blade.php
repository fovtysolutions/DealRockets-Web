@extends('layouts.front-end.app')


@push('css_or_js')

    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/ai/css/vendor-web.css') }}" />
@endpush

@section('content')

  <div class="main-container vender-company">
    <!-- Header -->
    <header class="header">
      <div class="header-left">

  
        <img src="<?php echo asset('assets\front-end\img\image 203.png'); ?>" class="logo" alt="Logo" />
        <div class="company-info">
          <span class="company-title">Shenzhen Kingstar Industrial Co., Ltd.</span>
          <p class="member"><img src="<?php echo asset('assets\front-end\img\Diamond.png'); ?>" class="diamond">   Premium Member <span class="member2024"> Since 2024</span> </p>
        </div>
      </div>
      <style>
       
   .vender-company .search-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    backdrop-filter: blur(1px); /* background blur */
    background: rgba(0, 0, 0, 0.3); /* optional dark overlay */
    z-index: 99;
    display: none;
  }

  .vender-company .search-box {
    position: relative;
    top: -5px;
    right: 20px;
    z-index: 100 !important;
  }

  .vender-company .input-search {
    
    z-index: 100;
    height: 50px;
    width: 50px;
    border: none;
    padding: 10px;
    font-size: 18px;
    letter-spacing: 2px;
    outline: none;
    border-radius: 25px;
    transition: all 0.5s ease-in-out;
    background: linear-gradient( to right , #FE4E44, #9F0900) ;
    padding-right: 40px;
    color: #fff;
  }

  .vender-company .input-search::placeholder {
    color: rgba(255, 255, 255, 0.5);
    font-size: 18px;
    letter-spacing: 2px;
  }

  .vender-company .btn-search {
    width: 50px;
    height: 50px;
    border: none;
    font-size: 20px;
    cursor: pointer;
    border-radius: 50%;
    position: absolute;
    right: 0;
    top: 0;
    color: #ffffff;
    background-color: transparent;
  }

  .vender-company .search-box.active .input-search {
    width: 300px;
    border-radius: 0;
    background-color: gray;
    /* color: black; */
    border: 1px solid rgba(100, 99, 99, 0.5);
    z-index: 100;
    border-radius: 41px;
  }

  .vender-company .search-box.active ~ .search-overlay {
    display: block;
  }
  
      </style>
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
    
    <!-- Banner -->
    <div class="banner">
      <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/1d933221293723129bf9432a3971faa04e4ac422?placeholderIfAbsent=true" alt="Banner" />
    </div>
    <!-- About & Certificates section -->
    <section class="section top-section">
      <div class="contant-section">
          <div class="top-section-left">
            <div class="company-history" >
              <h2>Professional manufacturer of electronic products for 14 years</h2>
              <div class="subline">OEM/ODM orders welcome | CE-, RoHS-, FCC- and BQB-certified | 3,500sqm factory</div>
              <div class="response-time">
                <span>Avg Response time:</span> <strong>48–72 h</strong>
              </div>
            </div>
            <div class="about">
              <h3>14-year Professional Manufacturer of Electronic Products</h3>
              <p>
                Shenzhen Kingstar Co., Ltd is a 14-year professional manufacturer of electronic products such as Bluetooth wireless speakers, Bluetooth wireless earphones, headphone headsets, power banks, phone cases, massage guns, massagers, hand massagers, percussion massagers, muscle massagers, muscle massage guns, handheld massagers, body massagers, electric massagers, bracelets, fitness tracker, watches for women, smartwatches for Android, custom bracelets, fitness tracker watches, wristbands, sports watches and more. We have advanced and professional manufacturing equipment, and excellent research and development engineers. We have a high-quality management and experienced manufacturing team.
              </p>
            </div>


          
          </div>
          <div class="top-section-right">

            <button class="inquire-btn"  data-bs-toggle="modal" data-bs-target="#inquireModel">
              <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/9881a67e7313be73b75bd5f735007e08ab4512c3?placeholderIfAbsent=true" alt="Email icon" width="18" />
              Inquire Now
            </button>
            <div class="certificates">
              <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/2b3067defc84e0e2a91721ce36774ca662fb26c4?placeholderIfAbsent=true" alt="Cert" />
              <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/2b3067defc84e0e2a91721ce36774ca662fb26c4?placeholderIfAbsent=true" alt="Cert" />
              <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/3dd098410cfa0d2566ccd447c4216ecd69fca3e2?placeholderIfAbsent=true" alt="Cert" />
              <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/16eb31ee8fd09c8c288752fc285fad97232cc570?placeholderIfAbsent=true" alt="Cert" />
            </div>
          </div>
    </div>
    <div class="gallery">
      <div ><img src="<?php echo asset('assets\front-end\img\image 220.png'); ?>" class="side-image"/></div>
      <div class="small-images images-for-mobile-1">
     
        <img src="<?php echo asset('assets\front-end\img\image 219.png'); ?>" class="small-image" />
        <img src="<?php echo asset('assets\front-end\img\image 216.png'); ?>"  class="small-image" />
       
      </div>
      <div class="small-images images-for-mobile-2">
        <img src="<?php echo asset('assets\front-end\img\image 218.png'); ?>" class="small-image" />
        <img src="<?php echo asset('assets\front-end\img\image 219.png'); ?>"class="small-image"  />
     </div>
    </div>
    </section>
   
    <!-- New Products Section -->
    <div class="related-products" >
      <h4 class="letest-pro-h">Letest Product</h4>
      <div class="new-products-container">
          <div class="new-products-banner">
              <img src="<?php echo asset('assets\front-end\img\image 72.png'); ?>" alt="New products background" class="banner-bg">
              <div class="banner-content">
                  <div class="banner-title">Ready to order</div>
                  <div class="view-more-container">
                      <div class="view-more">View More</div>
                  </div>
              </div>
          </div>
          
          <div class="product-grid">
              <div class="product-card">
                  <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/cb7b1be753ae81f132745df01ab5fb7ec2cdf023" alt="Wax Beads" class="product-img">
                  <div class="product-title">Wholesale Hard Wax Beads 400g Painess Bikini leg Hair Removal Bulk Depilatory Wax Beans</div>
                  <div class="product-price">US$ 2.30 / Piece</div>
                  <div class="product-moq">400 Piece (MOQ)</div>
                  <button class="start-order-btn">Start order</button>
              </div>
              <div class="product-card">
                  <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/cb7b1be753ae81f132745df01ab5fb7ec2cdf023" alt="Wax Beads" class="product-img">
                  <div class="product-title">Wholesale Hard Wax Beads 400g Painess Bikini leg Hair Removal Bulk Depilatory Wax Beans</div>
                  <div class="product-price">US$ 2.30 / Piece</div>
                  <div class="product-moq">400 Piece (MOQ)</div>
                  <button class="start-order-btn">Start order</button>
              </div>
              <div class="product-card">
                  <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/cb7b1be753ae81f132745df01ab5fb7ec2cdf023" alt="Wax Beads" class="product-img">
                  <div class="product-title">Wholesale Hard Wax Beads 400g Painess Bikini leg Hair Removal Bulk Depilatory Wax Beans</div>
                  <div class="product-price">US$ 2.30 / Piece</div>
                  <div class="product-moq">400 Piece (MOQ)</div>
                  <button class="start-order-btn">Start order</button>
              </div>
              <div class="product-card">
                  <img src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/cb7b1be753ae81f132745df01ab5fb7ec2cdf023" alt="Wax Beads" class="product-img">
                  <div class="product-title">Wholesale Hard Wax Beads 400g Painess Bikini leg Hair Removal Bulk Depilatory Wax Beans</div>
                  <div class="product-price">US$ 2.30 / Piece</div>
                  <div class="product-moq">400 Piece (MOQ)</div>
                  <button class="start-order-btn">Start order</button>
              </div>
              
          </div>
      </div>
  </div>
  <div class="main-content ">
    <h4 class="top-product-h">Top Products</h4>
    <div class="top-product-grid" id="productGrid">
      <div class="top-product-card">
        <div class="heart-icon-div">
   
           <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#4d4c4c" stroke-width="2" viewBox="0 0 24 24">
                 <path d="M12 21C12 21 4 13.9 4 8.5C4 5.4 6.4 3 9.5 3C11.1 3 12.6 3.9 13.3 5.2C14 3.9 15.5 3 17.1 3C20.2 3 22.6 5.4 22.6 8.5C22.6 13.9 15 21 15 21H12Z"/>
             </svg>
        </div>
     <img src="<?php echo asset('assets\front-end\img\image 99.png'); ?>" alt="${product.title}" class="product-image">
     <div class="product-info">
     <div class="d-flex justify-content-between">
      <p class="new">New</p>
  
             <div class="rating">
                 <span style="font-size: 12px;"><i class="bi bi-star-fill start-rating text-warning"></i> </i> 4.5/9</span>
             </div>
  
      </span>
     </div>
         <h3 class="top-product-title">Wholesale Auto tracking CCT V cameras Full Hd Video Life 3mp Baby Monitor Recorder Smart Home Security Camera</h3>
         <div class="top-product-price">US$ 2.30 / Piece</div>
         <div class="top-product-moq">400 Piece (MOQ)</div>
         <div class="top-product-seller">Market Union Co.Ltd</div>
         <div class="top-product-exhibition">Exhibited at 2 GS shows</div>
         <div class="top-product-diamond">
         <img scr="<?php echo asset('assets\front-end\img\Diamond.png'); ?>" alt="dimaond" class="dimond-img"> 
         </div>
        <div>
        
         <button class="top-start-order-btn">Start order</button>
        </div>
        
     </div>
      </div>

      <div class="top-product-card">
        <div class="heart-icon-div">
   
           <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#4d4c4c" stroke-width="2" viewBox="0 0 24 24">
                 <path d="M12 21C12 21 4 13.9 4 8.5C4 5.4 6.4 3 9.5 3C11.1 3 12.6 3.9 13.3 5.2C14 3.9 15.5 3 17.1 3C20.2 3 22.6 5.4 22.6 8.5C22.6 13.9 15 21 15 21H12Z"/>
             </svg>
        </div>
     <img src="<?php echo asset('assets\front-end\img\image 99.png'); ?>" alt="${product.title}" class="product-image">
     <div class="product-info">
     <div class="d-flex justify-content-between">
      <p class="new">New</p>
  
             <div class="rating">
                 <span style="font-size: 12px;"><i class="bi bi-star-fill start-rating text-warning"></i> </i> 4.5/9</span>
             </div>
  
      </span>
     </div>
         <h3 class="top-product-title">Wholesale Auto tracking CCT V cameras Full Hd Video Life 3mp Baby Monitor Recorder Smart Home Security Camera</h3>
         <div class="top-product-price">US$ 2.30 / Piece</div>
         <div class="top-product-moq">400 Piece (MOQ)</div>
         <div class="top-product-seller">Market Union Co.Ltd</div>
         <div class="top-product-exhibition">Exhibited at 2 GS shows</div>
         <div class="top-product-diamond">
         <img scr="<?php echo asset('assets\front-end\img\Diamond.png'); ?>" alt="dimaond" class="dimond-img"> 
         </div>
        <div>
        
         <button class="top-start-order-btn">Start order</button>
        </div>
        
     </div>
      </div>
      <div class="top-product-card">
        <div class="heart-icon-div">
   
           <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#4d4c4c" stroke-width="2" viewBox="0 0 24 24">
                 <path d="M12 21C12 21 4 13.9 4 8.5C4 5.4 6.4 3 9.5 3C11.1 3 12.6 3.9 13.3 5.2C14 3.9 15.5 3 17.1 3C20.2 3 22.6 5.4 22.6 8.5C22.6 13.9 15 21 15 21H12Z"/>
             </svg>
        </div>
     <img src="<?php echo asset('assets\front-end\img\image 99.png'); ?>" alt="${product.title}" class="product-image">
     <div class="product-info">
     <div class="d-flex justify-content-between">
      <p class="new">New</p>
  
             <div class="rating">
                 <span style="font-size: 12px;"><i class="bi bi-star-fill start-rating text-warning"></i> </i> 4.5/9</span>
             </div>
  
      </span>
     </div>
         <h3 class="top-product-title">Wholesale Auto tracking CCT V cameras Full Hd Video Life 3mp Baby Monitor Recorder Smart Home Security Camera</h3>
         <div class="top-product-price">US$ 2.30 / Piece</div>
         <div class="top-product-moq">400 Piece (MOQ)</div>
         <div class="top-product-seller">Market Union Co.Ltd</div>
         <div class="top-product-exhibition">Exhibited at 2 GS shows</div>
         <div class="top-product-diamond">
         <img scr="<?php echo asset('assets\front-end\img\Diamond.png'); ?>" alt="dimaond" class="dimond-img"> 
         </div>
        <div>
        
         <button class="top-start-order-btn">Start order</button>
        </div>
        
     </div>
      </div>
      <div class="top-product-card">
        <div class="heart-icon-div">
   
           <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#4d4c4c" stroke-width="2" viewBox="0 0 24 24">
                 <path d="M12 21C12 21 4 13.9 4 8.5C4 5.4 6.4 3 9.5 3C11.1 3 12.6 3.9 13.3 5.2C14 3.9 15.5 3 17.1 3C20.2 3 22.6 5.4 22.6 8.5C22.6 13.9 15 21 15 21H12Z"/>
             </svg>
        </div>
     <img src="<?php echo asset('assets\front-end\img\image 99.png'); ?>" alt="${product.title}" class="product-image">
     <div class="product-info">
     <div class="d-flex justify-content-between">
      <p class="new">New</p>
  
             <div class="rating">
                 <span style="font-size: 12px;"><i class="bi bi-star-fill start-rating text-warning"></i> </i> 4.5/9</span>
             </div>
  
      </span>
     </div>
         <h3 class="top-product-title">Wholesale Auto tracking CCT V cameras Full Hd Video Life 3mp Baby Monitor Recorder Smart Home Security Camera</h3>
         <div class="top-product-price">US$ 2.30 / Piece</div>
         <div class="top-product-moq">400 Piece (MOQ)</div>
         <div class="top-product-seller">Market Union Co.Ltd</div>
         <div class="top-product-exhibition">Exhibited at 2 GS shows</div>
         <div class="top-product-diamond">
         <img scr="<?php echo asset('assets\front-end\img\Diamond.png'); ?>" alt="dimaond" class="dimond-img"> 
         </div>
        <div>
        
         <button class="top-start-order-btn">Start order</button>
        </div>
        
     </div>
      </div>
      <div class="top-product-card">
        <div class="heart-icon-div">
   
           <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#4d4c4c" stroke-width="2" viewBox="0 0 24 24">
                 <path d="M12 21C12 21 4 13.9 4 8.5C4 5.4 6.4 3 9.5 3C11.1 3 12.6 3.9 13.3 5.2C14 3.9 15.5 3 17.1 3C20.2 3 22.6 5.4 22.6 8.5C22.6 13.9 15 21 15 21H12Z"/>
             </svg>
        </div>
     <img src="<?php echo asset('assets\front-end\img\image 99.png'); ?>" alt="${product.title}" class="product-image">
     <div class="product-info">
     <div class="d-flex justify-content-between">
      <p class="new">New</p>
  
             <div class="rating">
                 <span style="font-size: 12px;"><i class="bi bi-star-fill start-rating text-warning"></i> </i> 4.5/9</span>
             </div>
  
      </span>
     </div>
         <h3 class="top-product-title">Wholesale Auto tracking CCT V cameras Full Hd Video Life 3mp Baby Monitor Recorder Smart Home Security Camera</h3>
         <div class="top-product-price">US$ 2.30 / Piece</div>
         <div class="top-product-moq">400 Piece (MOQ)</div>
         <div class="top-product-seller">Market Union Co.Ltd</div>
         <div class="top-product-exhibition">Exhibited at 2 GS shows</div>
         <div class="top-product-diamond">
         <img scr="<?php echo asset('assets\front-end\img\Diamond.png'); ?>" alt="dimaond" class="dimond-img"> 
         </div>
        <div>
        
         <button class="top-start-order-btn">Start order</button>
        </div>
        
     </div>
      </div>
    </div>

</div>
</div>


 <!-- Modal -->
 <div class="modal fade vender-company" id="inquireModel" tabindex="-1" aria-labelledby="inquireModelLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background: #EBEBEB;">
        <h5 class="modal-title" id="inquireModelLabel">Send a direct inquiry to this supplier</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
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
            <textarea class="form-control" id="message" rows="5" placeholder="Enter product details such as color, size, materials and other specific requirements."></textarea>
          </div>

          <div style="display: flex; justify-content: end;">
            <button type="submit" class="btn btn-red inquire-btn" st>Send Inquiry Now</button>
          </div>
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
