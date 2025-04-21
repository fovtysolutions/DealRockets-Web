@extends('layouts.front-end.app')
@push('css_or_js')
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/ai/talentfinder.css')}}" />
@endpush
@section('title')
Talent Finder | {{ $web_config['name']->value }}
@endsection
@section('content')
<section class="mainpagesection talent-finder" style="background-color: unset;">
    <div class="container">
        <!-- Left Sidebar -->
        <div class="sidebar">
        
          <!-- Salary Range Filter -->
          <div class="filter-section">
            <h3>Salary Range</h3>
            <div class="range-slider">
              <div class="slider-track">
                <div class="slider-fill"></div>
                <div class="slider-thumb left"></div>
                <div class="slider-thumb right"></div>
              </div>
              <div class="range-inputs">
                <div class="range-input">
                  <input type="text" value="0" id="min-salary">
                  <span>USD</span>
                </div>
                <div class="range-input">
                  <input type="text" value="500" id="max-salary">
                  <span>USD</span>
                </div>
              </div>
            </div>
          </div>
          
          <div class="divider"></div>
          
          <!-- Currency Filter -->
          <div class="filter-section">
            <h3>Filter Currency</h3>
            <div class="search-box">
              <input type="text" placeholder="Search Currency...">
              <button><img src="/img/Magnifiying Glass.png" alt="Search"></button>
            </div>
            <div class="checkbox-list">
              <div class="checkbox-item">
                <input type="checkbox" id="inr" checked>
                <label for="inr">INR</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="aud">
                <label for="aud">AUD</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="usd">
                <label for="usd">USD</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="eur">
                <label for="eur">EUR</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="cad">
                <label for="cad">CAD</label>
              </div>
            </div>
          </div>
          
          <div class="divider"></div>
          
          <!-- Keywords Filter -->
          <div class="filter-section">
            <h3>Keywords</h3>
            <div class="search-box">
              <input type="text" placeholder="Search keywords...">
              <button><img src="/img/Magnifiying Glass.png" alt="Search"></button>
            </div>
            <div class="checkbox-list">
              <div class="checkbox-item">
                <input type="checkbox" id="digital-marketing" checked>
                <label for="digital-marketing">Digital Marketing</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="cybersecurity">
                <label for="cybersecurity">Cybersecurity</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="ai-development">
                <label for="ai-development">AI Development</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="ai-engineer">
                <label for="ai-engineer">AI Engineer</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="investment-analyst">
                <label for="investment-analyst">Investment Analyst</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="medical-consultant">
                <label for="medical-consultant">Medical Consultant</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="radiologist">
                <label for="radiologist">Radiologist</label>
              </div>
            </div>
          </div>
          
          <div class="divider"></div>
          
          <!-- Job Type Filter -->
          <div class="filter-section">
            <h3>Job Type</h3>
            <div class="checkbox-list">
              <div class="checkbox-item">
                <input type="checkbox" id="full-time" checked>
                <label for="full-time">Full-Time</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="part-time">
                <label for="part-time">Part-Time</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="weekly">
                <label for="weekly">Weekly</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="hourly">
                <label for="hourly">Hourly</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="contract">
                <label for="contract">Contract</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="freelancing">
                <label for="freelancing">Freelancing</label>
              </div>
            </div>
          </div>
          
          <div class="divider"></div>
          
          <!-- Location Filter -->
          <div class="filter-section">
            <h3>Location</h3>
            <div class="search-box">
              <input type="text" placeholder="Search location...">
              <button><img src="/img/Magnifiying Glass.png" alt="Search"></button>
            </div>
            <div class="checkbox-list">
              <div class="checkbox-item">
                <input type="checkbox" id="al-barsha" checked>
                <label for="al-barsha">Al Barsha</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="business-bay">
                <label for="business-bay">Business Bay</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="downtown-dubai">
                <label for="downtown-dubai">Downtown Dubai</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="dubai-marina">
                <label for="dubai-marina">Dubai Marina</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="dubai-industrial-city">
                <label for="dubai-industrial-city">Dubai Industrial City</label>
              </div>
            </div>
          </div>
          
          <div class="divider"></div>
          
          <!-- Job Title Filter -->
          <div class="filter-section">
            <h3>Job Title</h3>
            <div class="search-box">
              <input type="text" placeholder="Search job title...">
              <button><img src="/img/Magnifiying Glass.png" alt="Search"></button>
            </div>
            <div class="checkbox-list">
              <div class="checkbox-item">
                <input type="checkbox" id="sales-manager" checked>
                <label for="sales-manager">Sales Manager</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="healthcare-administrator">
                <label for="healthcare-administrator">Healthcare Administrator</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="property-consultant">
                <label for="property-consultant">Property Consultant</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="ecommerce-specialist">
                <label for="ecommerce-specialist">E-commerce Specialist</label>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="shipping-manager">
                <label for="shipping-manager">Shipping Manager</label>
              </div>
            </div>
          </div>
        </div>
          <!-- button for screen less than 1024 -->
          <div class="search-bar-wrapper-tab">
            <div class="search-bar-tab">
              <input type="text" class="search-input-tab" placeholder="Search by names...">
              <button class="search-btn-tab">Search</button>
            </div>
            <button class="filter-btn" onclick="filterdrop()">Filters &#x2630;</button>
          </div>
          
        <!-- Main Content -->
        <div class="main-content">
          <!-- Job Cards -->
          <div class="job-cards">
            <!-- Job Card 1 -->
            <div class="job-card">
              <div class="job-header">
                <div class="job-title-location">
                  <h3>Sales Manager</h3>
                  <p>Dubai, UAE</p>
                </div>
              </div>
              
              <div class="job-details">
                <div class="job-experience">
                  <div class="experience-item">
                    <h4>Sales Manager</h4>
                    <p>Emirates Trading LLC - Present</p>
                  </div>
                  <div class="experience-item">
                    <h4>Sales Executive</h4>
                    <p>Gulf Info, 2019 - 2021</p>
                  </div>
                  <div class="experience-item">
                    <h4>Sales Executive</h4>
                    <p>Al Noor Trading, 2017 - 2019</p>
                  </div>
                </div>
                
                <div class="job-education-skills">
                  <div class="education">
                    <h4>Education</h4>
                    <p>BBA, American University in Dubai</p>
                  </div>
                  <div class="skills">
                    <h4>Skills</h4>
                    <div class="skill-tags">
                      <span class="skill-tag">CRM Software</span>
                      <span class="skill-tag">B2B</span>
                      <span class="skill-tag">Pricing</span>
                      <span class="skill-tag">CRM Software</span>
                      <span class="skill-tag">B2B</span>
                    </div>
                  </div>
                </div>
                
                <div class="job-meta">
                  <div class="experience-total">
                    <h4>Total Experience</h4>
                    <p>4+ Years</p>
                  </div>
                  <div class="job-location">
                    <h4>Current Job Location</h4>
                    <p>India</p>
                  </div>
                </div>
                
                <div class="job-actions col-auto align-self-center p-4">
                  <button class="message-btn">Message</button>
                </div>
              </div>
            </div>
            
            <!-- Job Card 2 -->
            <div class="job-card">
              <div class="job-header">
                <div class="job-title-location">
                  <h3>Marketing Executive</h3>
                  <p>Dubai, UAE</p>
                </div>
               
              </div>
              <div class="job-details">
                <div class="job-experience">
                  <div class="experience-item">
                    <h4>Sales Manager</h4>
                    <p>Al Futtaim Group (2020 - Present)</p>
                  </div>
                  <div class="experience-item">
                    <h4>Digital Marketing</h4>
                    <p>Media Hub (2018-2020)</p>
                  </div>
                  <div class="experience-item">
                    <h4>Marketing Coordinator</h4>
                    <p>Bright Advertising (2016-2018)</p>
                  </div>
                </div>
                
                <div class="job-education-skills">
                  <div class="education">
                    <h4>Education</h4>
                    <p>MBA, University of Dubai</p>
                  </div>
                  <div class="skills">
                    <h4>Skills</h4>
                    <div class="skill-tags">
                      <span class="skill-tag">SEO</span>
                      <span class="skill-tag">Google Ads</span>
                      <span class="skill-tag">Branding</span>
                    </div>
                  </div>
                </div>
                
                <div class="job-meta">
                  <div class="experience-total">
                    <h4>Total Experience</h4>
                    <p>8+ Years</p>
                  </div>
                  <div class="job-location">
                    <h4>Current Job Location</h4>
                    <p>India</p>
                  </div>
                </div>
                
                <div class="job-actions col-auto align-self-center p-4">
                  <button class="message-btn">Message</button>
                </div>
              </div>
              
        
            </div>
            
            <!-- Job Card 3 -->
            <div class="job-card">
              <div class="job-header">
                <div class="job-title-location">
                  <h3>Business Development Manager</h3>
                  <p>Dubai, UAE</p>
                </div>
              </div>
              
              <div class="job-details">
                <div class="job-experience">
                  <div class="experience-item">
                    <h4>Sales Manager</h4>
                    <p>Gulf Enterprises (2019-Present)</p>
                  </div>
                  <div class="experience-item">
                    <h4>BD Executive</h4>
                    <p>Horizon Industries (2017-2019)</p>
                  </div>
                  <div class="experience-item">
                    <h4>Sales Consultant</h4>
                    <p>Prime Solutions (2015-2017)</p>
                  </div>
                </div>
                
                <div class="job-education-skills">
                  <div class="education">
                    <h4>Education</h4>
                    <p>B.Com, University of Sharjah</p>
                  </div>
                  <div class="skills">
                    <h4>Skills</h4>
                    <div class="skill-tags">
                      <span class="skill-tag">Lead Gen</span>
                      <span class="skill-tag">B2B</span>
                      <span class="skill-tag">Market Research</span>
                      <span class="skill-tag">CRM Software</span>
                      <span class="skill-tag">B2B</span>
                    </div>
                  </div>
                </div>
                
                <div class="job-meta">
                  <div class="experience-total">
                    <h4>Total Experience</h4>
                    <p>9+ Years</p>
                  </div>
                  <div class="job-location">
                    <h4>Current Job Location</h4>
                    <p>Egyptian</p>
                  </div>
                </div>
                
                <div class="job-actions col-auto align-self-center p-4">
                  <button class="message-btn">Message</button>
                </div>
              </div>
            </div>
            
            <!-- Additional Job Cards would be here -->
            <div class="job-card">
              <div class="job-header">
                <div class="job-title-location">
                  <h3>Account Manager</h3>
                  <p>Sharjah, UAE</p>
                </div>
              </div>
              
              <div class="job-details">
                <div class="job-experience">
                  <div class="experience-item">
                    <h4>Account Manager</h4>
                    <p>Tech Solutions ME (2021-Present)</p>
                  </div>
                  <div class="experience-item">
                    <h4>Sales Associate</h4>
                    <p>IT World (2018-2021)</p>
                  </div>
                  <div class="experience-item">
                    <h4>Customer Support</h4>
                    <p>Gulf Tech (2016-2018)</p>
                  </div>
                </div>
                
                <div class="job-education-skills">
                  <div class="education">
                    <h4>Education</h4>
                    <p>MBA, Middlesex University Dubai</p>
                  </div>
                  <div class="skills">
                    <h4>Skills</h4>
                    <div class="skill-tags">
                      <span class="skill-tag">CRM</span>
                      <span class="skill-tag">B2 Client Relations</span>
                      <span class="skill-tag">Pricing</span>
                      <span class="skill-tag">Financial Planning</span>
                      <span class="skill-tag">B2B</span>
                    </div>
                  </div>
                </div>
                
                <div class="job-meta">
                  <div class="experience-total">
                    <h4>Total Experience</h4>
                    <p>7+ Years</p>
                  </div>
                  <div class="job-location">
                    <h4>Current Job Location</h4>
                    <p>Filipino</p>
                  </div>
                </div>
                
                <div class="job-actions col-auto align-self-center p-4">
                  <button class="message-btn">Message</button>
                </div>
              </div>
            </div>
            <!-- Additional job card from figma -->
            <div class="job-card">
              <div class="job-header">
                <div class="job-title-location">
                  <h3>Account Manager</h3>
                  <p>Sharjah, UAE</p>
                </div>
              </div>
              
              <div class="job-details">
                <div class="job-experience">
                  <div class="experience-item">
                    <h4>Account Manager</h4>
                    <p>Tech Solutions ME (2021-Present)</p>
                  </div>
                  <div class="experience-item">
                    <h4>Sales Associate</h4>
                    <p>IT World (2018-2021)</p>
                  </div>
                  <div class="experience-item">
                    <h4>Customer Support</h4>
                    <p>Gulf Tech (2016-2018)</p>
                  </div>
                </div>
                
                <div class="job-education-skills">
                  <div class="education">
                    <h4>Education</h4>
                    <p>MBA, Middlesex University Dubai</p>
                  </div>
                  <div class="skills">
                    <h4>Skills</h4>
                    <div class="skill-tags">
                      <span class="skill-tag">CRM</span>
                      <span class="skill-tag">B2 Client Relations</span>
                      <span class="skill-tag">Pricing</span>
                      <span class="skill-tag">Financial Planning</span>
                      <span class="skill-tag">B2B</span>
                    </div>
                  </div>
                </div>
                
                <div class="job-meta">
                  <div class="experience-total">
                    <h4>Total Experience</h4>
                    <p>7+ Years</p>
                  </div>
                  <div class="job-location">
                    <h4>Current Job Location</h4>
                    <p>Filipino</p>
                  </div>
                </div>
                
                <div class="job-actions col-auto align-self-center p-4">
                  <button class="message-btn">Message</button>
                </div>
              </div>
            </div>
            <div class="job-card">
              <div class="job-header">
                <div class="job-title-location">
                  <h3>Account Manager</h3>
                  <p>Sharjah, UAE</p>
                </div>
              </div>
              
              <div class="job-details">
                <div class="job-experience">
                  <div class="experience-item">
                    <h4>Account Manager</h4>
                    <p>Tech Solutions ME (2021-Present)</p>
                  </div>
                  <div class="experience-item">
                    <h4>Sales Associate</h4>
                    <p>IT World (2018-2021)</p>
                  </div>
                  <div class="experience-item">
                    <h4>Customer Support</h4>
                    <p>Gulf Tech (2016-2018)</p>
                  </div>
                </div>
                
                <div class="job-education-skills">
                  <div class="education">
                    <h4>Education</h4>
                    <p>MBA, Middlesex University Dubai</p>
                  </div>
                  <div class="skills">
                    <h4>Skills</h4>
                    <div class="skill-tags">
                      <span class="skill-tag">CRM</span>
                      <span class="skill-tag">B2 Client Relations</span>
                      <span class="skill-tag">Pricing</span>
                      <span class="skill-tag">Financial Planning</span>
                      <span class="skill-tag">B2B</span>
                    </div>
                  </div>
                </div>
                
                <div class="job-meta">
                  <div class="experience-total">
                    <h4>Total Experience</h4>
                    <p>7+ Years</p>
                  </div>
                  <div class="job-location">
                    <h4>Current Job Location</h4>
                    <p>Filipino</p>
                  </div>
                </div>
                
                <div class="job-actions col-auto align-self-center p-4">
                  <button class="message-btn">Message</button>
                </div>
              </div>
            </div>
            <div class="job-card">
              <div class="job-header">
                <div class="job-title-location">
                  <h3>Marketing Executive</h3>
                  <p>Dubai, UAE</p>
                </div>
              </div>
              
              <div class="job-details">
                <div class="job-experience">
                  <div class="experience-item">
                    <h4>Sales Manager</h4>
                    <p>Al Futtaim Group (2020 - Present)</p>
                  </div>
                  <div class="experience-item">
                    <h4>Digital Marketing</h4>
                    <p>Media Hub (2018-2020)</p>
                  </div>
                  <div class="experience-item">
                    <h4>Marketing Coordinator</h4>
                    <p>Bright Advertising (2016-2018)</p>
                  </div>
                </div>
                
                <div class="job-education-skills">
                  <div class="education">
                    <h4>Education</h4>
                    <p>MBA, University of Dubai</p>
                  </div>
                  <div class="skills">
                    <h4>Skills</h4>
                    <div class="skill-tags">
                      <span class="skill-tag">SEO</span>
                      <span class="skill-tag">Google Ads</span>
                      <span class="skill-tag">Branding</span>
                    </div>
                  </div>
                </div>
                
                <div class="job-meta">
                  <div class="experience-total">
                    <h4>Total Experience</h4>
                    <p>8+ Years</p>
                  </div>
                  <div class="job-location">
                    <h4>Current Job Location</h4>
                    <p>India</p>
                  </div>
                </div>
                
                <div class="job-actions col-auto align-self-center p-4">
                  <button class="message-btn">Message</button>
                </div>
              </div>
            </div>
          </div>
          <!-- job cards for mobile view -->
          <div class="user-card-mobile">
            <div class="card-mobile">
              <div class="card-header-mobile">
                <div>
                  <h6 class="title-mobile">Sales Manager</h6>
                  <p class="location-mobile">Dubai, UAE</p>
                </div>
                <div class="skills-mobile">
                  <h3><strong>Skills</strong></h3><br>
                  <span class="skill-badge">CRM Software</span>
                  <span class="skill-badge">B2B</span>
                  <span class="skill-badge">Pricing</span><br>
                  <span class="skill-badge">CRM Software</span>
                  <span class="skill-badge">B2B</span>
                </div>
              </div>
          <div class="card-body-2">
              <div class="card-body-mobile">
                
                <h5><strong>Total Experience</strong></h5> 
                <p>4+ Years</p>
               
              </div>
              <div class="card-body-mobile">
                <h5> <strong>Current Job Location </strong></h5> 
                <p>India</p>
              </div>   
              
          </div>
              <div class="card-body-mobile">
            <h5><strong>Education</strong></h5> 
            <p>BBA, American University in Dubai</p>
               
              </div>
              <div class="card-footer-mobile">
                <button class="btn-mobile">Message</button>
              </div>
            </div>
          </div>
          
          <div class="user-card-mobile">
            <div class="card-mobile">
              <div class="card-header-mobile">
                <div>
                  <h6 class="title-mobile">Marketing Executive</h6>
                  <p class="location-mobile">Dubai, UAE</p>
                </div>
                <div class="skills-mobile">
                  <h3><strong>Skills</strong></h3><br>
                  <span class="skill-badge">SEO</span>
                  <span class="skill-badge">Google Ads</span>
                  <span class="skill-badge">Branding</span><br>
                
                </div>
              </div>
          <div class="card-body-2">
              <div class="card-body-mobile">
                
                <h5><strong>Total Experience</strong></h5> 
                <p>8+ Years</p>
               
              </div>
              <div class="card-body-mobile">
                <h5> <strong>Current Job Location </strong></h5> 
                <p>India</p>
              </div>   
              
          </div>
              <div class="card-body-mobile">
            <h5><strong>Education</strong></h5> 
            <p>MBA University of Dubai</p>
               
              </div>
              <div class="card-footer-mobile">
                <button class="btn-mobile">Message</button>
              </div>
            </div>
          </div>
          <div class="user-card-mobile">
            <div class="card-mobile">
              <div class="card-header-mobile">
                <div>
                  <h6 class="title-mobile">Business Development Manager</h6>
                  <p class="location-mobile">Dubai, UAE</p>
                </div>
                <div class="skills-mobile">
                  <h3><strong>Skills</strong></h3><br>
                  <span class="skill-badge">Lead Gen</span>
                  <span class="skill-badge">B2B</span>
                  <span class="skill-badge">Market Research</span><br>
                  <span class="skill-badge">CRM Software</span>
                  <span class="skill-badge">B2B</span>
                </div>
              </div>
          <div class="card-body-2">
              <div class="card-body-mobile">
                
                <h5><strong>Total Experience</strong></h5> 
                <p>9+ Years</p>
               
              </div>
              <div class="card-body-mobile">
                <h5> <strong>Current Job Location </strong></h5> 
                <p>Egyptian</p>
              </div>   
              
          </div>
              <div class="card-body-mobile">
            <h5><strong>Education</strong></h5> 
            <p>B.Com, University of Sharjah</p>
               
              </div>
              <div class="card-footer-mobile">
                <button class="btn-mobile">Message</button>
              </div>
            </div>
          </div>
          <div class="user-card-mobile">
            <div class="card-mobile">
              <div class="card-header-mobile">
                <div>
                  <h6 class="title-mobile">Account Manager</h6>
                  <p class="location-mobile">Sharjah, UAE</p>
                </div>
                <div class="skills-mobile">
                  <h3><strong>Skills</strong></h3><br>
                  <span class="skill-badge">CRM </span>
                  <span class="skill-badge">B2 Client Relations</span>
                  <span class="skill-badge">Pricing</span><br>
                  <span class="skill-badge">CRM Software</span>
                  <span class="skill-badge">B2B</span>
                </div>
              </div>
          <div class="card-body-2">
              <div class="card-body-mobile">
                
                <h5><strong>Total Experience</strong></h5> 
                <p>7+ Years</p>
               
              </div>
              <div class="card-body-mobile">
                <h5> <strong>Current Job Location </strong></h5> 
                <p>Filipino</p>
              </div>   
              
          </div>
              <div class="card-body-mobile">
            <h5><strong>Education</strong></h5> 
            <p>MBA, Middlesex University Dubai</p>
               
              </div>
              <div class="card-footer-mobile">
                <button class="btn-mobile">Message</button>
              </div>
            </div>
          </div>
          <!-- Pagination -->
          <div class="pagination">
            <div class="per-page">Job's Per Page: 7</div>
            <div class="page-controls">
              <button class="prev-page">
                <img
                    src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/a709056010543323f81b868dae7add3f426c9f74?placeholderIfAbsent=true"
                    alt="Previous"
                />
              </button>
              <button class="page-number active">1</button>
              <button class="page-number">2</button>
              <button class="page-number">3</button>
              <button class="page-number">4</button>
              <button class="page-number">5</button>
              <div class="page-dots">...</div>
              <div class="total-items">276</div>
              <button class="next-page">
                <img
                    src="https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/2acf36908afa50c91c57d10e3f0023c880bdaf97?placeholderIfAbsent=true"
                    alt="Next"
                />             
            </button>
            </div>
          </div>
        </div>
      </div>
</section>
@endsection
@push('script')
<script src="{{ theme_asset(path: 'public/js/talentfinder.js')}}"></script>
@endpush