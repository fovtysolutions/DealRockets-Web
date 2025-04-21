@extends('layouts.front-end.app')
@push('css_or_js')
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/ai/candidatejobs.css') }}" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush
@section('title', translate('Job Seeker' . ' | ' . $web_config['name']->value))
@section('content')
<section class="mainpagesection candidate-jobs" style="background-color: unset;">
    <div class="jobs " style="background: #f9f9f9;" >
        <div class="container  hide-header">
          <div class=" p-2 py-3 px-3 rounded  shadow1 d-flex align-items-center justify-content-between">
            
            <!-- Full version -->
    <div class="search-full  flex-grow-1 align-items-center">
      <div class="input-group rounded-pill border-gold overflow-hidden" style="max-width: 600px; height: 44px;">
        <input type="text" class="form-control border-0 ps-3" placeholder="Search for products..." />
        <button class="btn btn-gold px-4">Search</button>
      </div>
    </div>
    
    <!-- Compact version -->
    <div class="search-compact
    align-items-center" style="width: 50%;">
      <div class="d-flex align-items-center w-100 bg-white border px-3" style="height: 44px;">
        <img src="/img/Magnifiying Glass.png" alt="Search Icon" class="me-2" style="width: 20px;" />
        <input type="text" class="form-control border-0" placeholder="Search by Name" style="box-shadow: none;" />
      </div>
    </div>
            <!-- Filters Button -->
            <button class="btn btn-outline-light bg-white border ms-3 d-flex align-items-center " style="color: var(--text-medium);">
              Filters&nbsp;<i class="bi bi-filter align-items-center h-75" style="font-size:22px; position: relative; top: 4px;"></i>
            </button>
            
          </div>
        </div>
        
       
        <div class="container jobs">
          
          <div class="sidebar ">
            <div class="filter-section">
              <h3>Salary Range</h3>
              <div class="salary-slider">
                <div class="slider-track">
                  <div class="slider-fill"></div>
                  <div class="slider-thumb" id="min-thumb"></div>
                  <div class="slider-thumb" id="max-thumb"></div>
                </div>
                <div class="salary-values">
                  <div class="salary-min">$0 USD</div>
                  <div class="salary-max">$500 USD</div>
                </div>
              </div>
            </div>
      
            <div class="filter-section">
              <h3>Filter Currency</h3>
              <div class="search-box">
                <input type="text" placeholder="Search currency">
                <i class="fas fa-search"></i>
              </div>
              <div class="currency-options">
                <label class="currency-option">
                  <input type="checkbox" checked>
                  <span class="checkbox-custom checked"></span>
                  <span>INR</span>
                </label>
                <label class="currency-option">
                  <input type="checkbox">
                  <span class="checkbox-custom"></span>
                  <span>AUD</span>
                </label>
                <label class="currency-option">
                  <input type="checkbox">
                  <span class="checkbox-custom"></span>
                  <span>USD</span>
                </label>
                <label class="currency-option">
                  <input type="checkbox">
                  <span class="checkbox-custom"></span>
                  <span>EUR</span>
                </label>
                <label class="currency-option">
                  <input type="checkbox">
                  <span class="checkbox-custom"></span>
                  <span>CAD</span>
                </label>
              </div>
            </div>
      
            <div class="filter-section">
              <h3>Specialization</h3>
              <div class="filter-options">
                <label class="filter-option">
                  <input type="checkbox" checked>
                  <span class="checkbox-custom checked"></span>
                  <span>Agriculture <span class="count">(937)</span></span>
                </label>
                <label class="filter-option">
                  <input type="checkbox">
                  <span class="checkbox-custom"></span>
                  <span>Manufacturing <span class="count">(690)</span></span>
                </label>
                <label class="filter-option">
                  <input type="checkbox">
                  <span class="checkbox-custom"></span>
                  <span>Real Estate <span class="count">(606)</span></span>
                </label>
                <label class="filter-option">
                  <input type="checkbox">
                  <span class="checkbox-custom"></span>
                  <span>Chemicals <span class="count">(478)</span></span>
                </label>
                <label class="filter-option">
                  <input type="checkbox">
                  <span class="checkbox-custom"></span>
                  <span>Apparel <span class="count">(235)</span></span>
                </label>
                <label class="filter-option">
                  <input type="checkbox">
                  <span class="checkbox-custom"></span>
                  <span>Health <span class="count">(224)</span></span>
                </label>
                <label class="filter-option">
                  <input type="checkbox">
                  <span class="checkbox-custom"></span>
                  <span>Electrician <span class="count">(224)</span></span>
                </label>
                <label class="filter-option">
                  <input type="checkbox">
                  <span class="checkbox-custom"></span>
                  <span>Automobiles <span class="count">(224)</span></span>
                </label>
              </div>
            </div>
      
            <div class="filter-section">
              <h3>Job Type</h3>
              <div class="filter-options">
                <label class="filter-option">
                  <input type="checkbox" checked>
                  <span class="checkbox-custom checked"></span>
                  <span>Permanent <span class="count">(4512)</span></span>
                </label>
                <label class="filter-option">
                  <input type="checkbox">
                  <span class="checkbox-custom"></span>
                  <span>Temporary <span class="count">(45)</span></span>
                </label>
                <label class="filter-option">
                  <input type="checkbox">
                  <span class="checkbox-custom"></span>
                  <span>Contract <span class="count">(42)</span></span>
                </label>
                <label class="filter-option">
                  <input type="checkbox">
                  <span class="checkbox-custom"></span>
                  <span>Full-Time <span class="count">(4500)</span></span>
                </label>
                <label class="filter-option">
                  <input type="checkbox">
                  <span class="checkbox-custom"></span>
                  <span>Part-Time <span class="count">(500)</span></span>
                </label>
                <label class="filter-option">
                  <input type="checkbox">
                  <span class="checkbox-custom"></span>
                  <span>Work From Home <span class="count">(50)</span></span>
                </label>
              </div>
            </div>
      
            <div class="filter-section">
              <h3>Posted By</h3>
              <div class="filter-options">
                <label class="filter-option">
                  <input type="checkbox" checked>
                  <span class="checkbox-custom checked"></span>
                  <span>Agency <span class="count">(4432)</span></span>
                </label>
                <label class="filter-option">
                  <input type="checkbox">
                  <span class="checkbox-custom"></span>
                  <span>Employer <span class="count">(670)</span></span>
                </label>
                <label class="filter-option">
                  <input type="checkbox">
                  <span class="checkbox-custom"></span>
                  <span>Deal Rocket <span class="count">(50)</span></span>
                </label>
              </div>
            </div>
      
            <div class="filter-section">
              <h3>Experience Level</h3>
              <div class="filter-options">
                <label class="filter-option">
                  <input type="checkbox" checked>
                  <span class="checkbox-custom checked"></span>
                  <span>Graduate</span>
                </label>
              </div>
            </div>
          </div>
      
          <div class="job-listings">
            <div class="job-card">
              <div class="job-header">
                <h2>Vice President Marketing</h2>
                <p class="job-meta">9 hrs ago by eFinancialCareers</p>
              </div>
              <div class="job-details">
                <div class="" style="display: flex; justify-content: space-between;">
                  <div class="job-info">
                    <div class="salary"><i class="fa-sharp fa-solid fa-dollar-sign"></i> 10,000 to 15,000</div>
                    <div class="location"><i class="fas fa-map-marker-alt"></i> London</div>
                    <div class="type"><i class="fa-sharp fa-solid fa-house"></i> Work from home</div>
                    <div class="commitment"><i class="fas fa-clock"></i> Permanent, full-time</div>
                  </div>
                  <div>
                    <button class="apply-btn">Apply Now</button>
                  </div>
                  
                </div>
               
                <div class="job-description">
                  <p>Eames is working with a cutting-edge insurance data and platform provider on the appointment of an Operations Manag...</p>
                </div>
                
              </div>
            </div>
      
            <div class="job-card">
              <div class="job-header">
                <h2>Vice President Marketing</h2>
                <p class="job-meta">9 hrs ago by eFinancialCareers</p>
              </div>
              <div class="job-details">
                <div class="" style="display: flex; justify-content: space-between;">
                  <div class="job-info">
                    <div class="salary"><i class="fa-sharp fa-solid fa-dollar-sign"></i> 10,000 to 15,000</div>
                    <div class="location"><i class="fas fa-map-marker-alt"></i> London</div>
                    <div class="type"><i class="fa-sharp fa-solid fa-house"></i> Work from home</div>
                    <div class="commitment"><i class="fas fa-clock"></i> Permanent, full-time</div>
                  </div>
                  <div>
                    <button class="apply-btn">Apply Now</button>
                  </div>
                  
                </div>
               
                <div class="job-description">
                  <p>Eames is working with a cutting-edge insurance data and platform provider on the appointment of an Operations Manag...</p>
                </div>
                
              </div>
            </div>
      
            <div class="job-card">
              <div class="job-header">
                <h2>Vice President Marketing</h2>
                <p class="job-meta">9 hrs ago by eFinancialCareers</p>
              </div>
              <div class="job-details">
                <div class="" style="display: flex; justify-content: space-between;">
                  <div class="job-info">
                    <div class="salary"><i class="fa-sharp fa-solid fa-dollar-sign"></i> 10,000 to 15,000</div>
                    <div class="location"><i class="fas fa-map-marker-alt"></i> London</div>
                    <div class="type"><i class="fa-sharp fa-solid fa-house"></i> Work from home</div>
                    <div class="commitment"><i class="fas fa-clock"></i> Permanent, full-time</div>
                  </div>
                  <div>
                    <button class="apply-btn">Apply Now</button>
                  </div>
                  
                </div>
               
                <div class="job-description">
                  <p>Eames is working with a cutting-edge insurance data and platform provider on the appointment of an Operations Manag...</p>
                </div>
                
              </div>
            </div>
      
            <div class="job-card">
              <div class="job-header">
                <h2>Vice President Marketing</h2>
                <p class="job-meta">9 hrs ago by eFinancialCareers</p>
              </div>
              <div class="job-details">
                <div class="" style="display: flex; justify-content: space-between;">
                  <div class="job-info">
                    <div class="salary"><i class="fa-sharp fa-solid fa-dollar-sign"></i> 10,000 to 15,000</div>
                    <div class="location"><i class="fas fa-map-marker-alt"></i> London</div>
                    <div class="type"><i class="fa-sharp fa-solid fa-house"></i> Work from home</div>
                    <div class="commitment"><i class="fas fa-clock"></i> Permanent, full-time</div>
                  </div>
                  <div>
                    <button class="apply-btn">Apply Now</button>
                  </div>
                  
                </div>
               
                <div class="job-description">
                  <p>Eames is working with a cutting-edge insurance data and platform provider on the appointment of an Operations Manag...</p>
                </div>
                
              </div>
            </div>
      
            <div class="job-card">
              <div class="job-header">
                <h2>Vice President Marketing</h2>
                <p class="job-meta">9 hrs ago by eFinancialCareers</p>
              </div>
              <div class="job-details">
                <div class="" style="display: flex; justify-content: space-between;">
                  <div class="job-info">
                    <div class="salary"><i class="fa-sharp fa-solid fa-dollar-sign"></i> 10,000 to 15,000</div>
                    <div class="location"><i class="fas fa-map-marker-alt"></i> London</div>
                    <div class="type"><i class="fa-sharp fa-solid fa-house"></i> Work from home</div>
                    <div class="commitment"><i class="fas fa-clock"></i> Permanent, full-time</div>
                  </div>
                  <div>
                    <button class="apply-btn">Apply Now</button>
                  </div>
                  
                </div>
               
                <div class="job-description">
                  <p>Eames is working with a cutting-edge insurance data and platform provider on the appointment of an Operations Manag...</p>
                </div>
                
              </div>
            </div>
      
           
          </div>
      
          <div class="job-details-panel">
            <div class="job-header-panel">
              <div class="company-info">
                <img src="/img/image 154 (1).png" alt="Company Logo" class="company-logo">
                <div class="company-meta">
                  <h1>Vice President Marketing</h1>
                  <p>IndusHire Solutions - Amsterdam Area, Netherlands</p>
                  <p class="posted-time">Posted 2 weeks ago</p>
                </div>
              </div>
              <div class="action-icons">
                <button class="share-btn"><i class="fas fa-share-alt"></i></button>
                <button class="more-btn"><i class="fas fa-ellipsis-h"></i></button>
              </div>
            </div>
            
            <div class="action-buttons">
              <button class="apply-now-btn">Apply Now</button>
              <button class="save-btn">Save</button>
            </div>
            
            <hr>
            
            <div class="job-info-grid">
              <div class="job-info-left">
                <div class="info-item">
                  <i class="fa-sharp fa-solid fa-dollar-sign"></i>
                  <span>10,000 to 15,000 USD</span>
                </div>
                <div class="info-item">
                  <i class="fas fa-map-marker-alt"></i>
                  <span>London</span>
                </div>
                <div class="info-item">
                  <i class="fas fa-home"></i>
                  <span>Work from home</span>
                </div>
                <div class="info-item">
                  <i class="fa-sharp fa-solid fa-house"></i>
                  <span>Permanent, full-time</span>
                </div>
              </div>
              
              <div class="vertical-divider"></div>
              
              <div class="job-info-right">
                <h3>Company</h3>
                <p>11-50 employee</p>
                <p>Staffing and Recruiting</p>
              </div>
            </div>
            
            <hr>
            
            <div class="job-description-section">
              <h3>Job Description</h3>
              <div class="description-text">
                <p>Chad Harrison International is working with a leading global building materials group who is seeking a Vice President of Marketing to join their new headquarters in Amsterdam. The company is involved in the sales of building materials on both a B2B and B2C basis, they operate a network of more than 650 outlets under trusted local and regional Chad Harrison International is working with a leading global building materials group who is seeking a Vice President of Marketing to join their new headquarters in Amsterdam.</p>
                <p>The company is involved in the sales of building materials on both a B2B and B2C basis, they operate a network of more than 650 outlets under trusted local and regional Chad Harrison International is working with a leading global building materials group who is seeking a Vice President of Marketing to join their new headquarters in Amsterdam.</p>
                <p>The company is involved in the sales of building materials on both a B2B and B2C basis, they operate a network of more than 650 outlets under trusted local and regional.</p>
              </div>
              
              <h3>About Chad Harrison International</h3>
              <div class="description-text">
                <p>Chad Harrison International (CHI) is a globally recognized staffing and recruiting firm specializing in executive search and talent acquisition. With a presence in Amsterdam, London, and multiple international markets, we connect top-tier professionals with leading organizations across various industries.</p>
                <p>At CHI, we pride ourselves on delivering tailored recruitment solutions, ensuring businesses find the right leadership to drive success. Our team consists of experienced recruiters and industry specialists, leveraging deep market knowledge to identify and place high-caliber talent.</p>
                <p>At CHI, we pride ourselves on delivering tailored recruitment solutions, ensuring businesses find the right leadership to drive success. Our team consists of experienced recruiters and industry specialists, leveraging deep market knowledge to identify and place high-caliber talent.</p>
              </div>
            </div>
            
            <div class="contact-footer">
              <div class="contact-row">
                <div class="contact-item">
                  <i class="fas fa-envelope"></i>
                  <span>contact@indushire.com</span>
                </div>
                <div class="contact-item">
                  <i class="fas fa-globe"></i>
                  <span>www.indushire.com</span>
                </div>
              
              </div>
              <div class="contact-row">
                <div class="contact-item">
                  <i class="fas fa-phone"></i>
                  <span>+1 (555) 789-4560</span>
                </div>
                <div class="contact-item">
                  <i class="fas fa-map-marker-alt"></i>
                  <span>123 Industrial Avenue, New York, NY, USA</span>
                </div>
               
            </div>
            </div>
             
          </div>
          
        </div>
        <div class="pagination" style="width: s;">
          <div class="per-page">Job's Per Page: 7</div>
          <div class="page-controls">
            <button class="prev-btn"><i class="fas fa-chevron-left"></i></button>
            <button class="page-btn active">1</button>
            <button class="page-btn">2</button>
            <button class="page-btn">3</button>
            <button class="page-btn">4</button>
            <button class="page-btn">5</button>
            <span class="ellipsis">...</span>
            <button class="page-btn">276</button>
            <button class="next-btn"><i class="fas fa-chevron-right"></i></button>
          </div>
        </div>
      </div>
    
      
     <!-- Modal -->
    <div class="modal fade" id="jobDetailModal" tabindex="-1" aria-labelledby="jobDetailModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <!-- <h5 class="modal-title">Job Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
          </div>
          <div class="modal-body" id="modalJobDetails">
            <!-- Job detail content will be injected here -->
          </div>
        </div>
      </div>
    </div>
</section>
@endsection
@push('script')
<script src="{{ asset('public/js/candidatejobs.js') }}"></script>
@endpush
