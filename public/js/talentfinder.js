function filterdrop() {
  const section = document.getElementById('dropdown-panel');
  if (section.style.display === 'none' || section.style.display === '') {
    section.style.display = 'block';
  } else {
    section.style.display = 'none';
  }
}

document.addEventListener("DOMContentLoaded", function () {
    // Range Slider functionality
    const minInput = document.getElementById("min-salary");
    const maxInput = document.getElementById("max-salary");
    const sliderFill = document.querySelector(".slider-fill");
    const leftThumb = document.querySelector(".slider-thumb.left");
    const rightThumb = document.querySelector(".slider-thumb.right");

    // Update slider based on input values
    function updateSlider() {
        const min = parseInt(minInput.value) || 0;
        const max = parseInt(maxInput.value) || 500;

        const range = 500; // Max possible value
        const leftPos = (min / range) * 100;
        const rightPos = (max / range) * 100;

        sliderFill.style.left = leftPos + "%";
        sliderFill.style.width = rightPos - leftPos + "%";
    }

    minInput.addEventListener("input", updateSlider);
    maxInput.addEventListener("input", updateSlider);

    // Pagination functionality
    const pageNumbers = document.querySelectorAll(".page-number");
    const prevButton = document.querySelector(".prev-page");
    const nextButton = document.querySelector(".next-page");

    // Set active page
    pageNumbers.forEach((button) => {
        button.addEventListener("click", function () {
            pageNumbers.forEach((btn) => btn.classList.remove("active"));
            this.classList.add("active");
        });
    });

    // Previous page
    prevButton.addEventListener("click", function () {
        const activePage = document.querySelector(".page-number.active");
        const prevPage = activePage.previousElementSibling;

        if (prevPage && prevPage.classList.contains("page-number")) {
            activePage.classList.remove("active");
            prevPage.classList.add("active");
        }
    });

    // Next page
    nextButton.addEventListener("click", function () {
        const activePage = document.querySelector(".page-number.active");
        const nextPage = activePage.nextElementSibling;

        if (nextPage && nextPage.classList.contains("page-number")) {
            activePage.classList.remove("active");
            nextPage.classList.add("active");
        }
    });

    // Checkbox functionality
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');

    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", function () {
            // In a real application, this would filter the job listings
            console.log(
                `${this.id} is ${this.checked ? "checked" : "unchecked"}`
            );
        });
    });

    // Search box functionality
    const searchInputs = document.querySelectorAll(".search-box input");

    searchInputs.forEach((input) => {
        input.addEventListener("input", function () {
            // In a real application, this would filter based on search
            console.log(`Searching for: ${this.value}`);
        });
    });

    // Message button functionality
    const messageButtons = document.querySelectorAll(".message-btn");

    messageButtons.forEach((button) => {
        button.addEventListener("click", function () {
            // In a real application, this would open a message dialog
            const jobTitle = this.closest(".job-card").querySelector(
                ".job-title-location h3"
            ).textContent;
            alert(`You're about to message regarding the ${jobTitle} position`);
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    var firstcandidate = document.querySelector("input[id=talentid]");
    var talentid = firstcandidate ? firstcandidate.value : null;
    if (talentid) {
        fetchCandidateData(talentid);
    } else {
        console.log("Talent ID Not Found");
    }
});
document.getElementById("viewMoreBtn").addEventListener("click", function () {
    // Set the new HTML content for #dpcontainerbox
    const fullCategoryList = `
        @foreach ($categories as $c
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
  }
  
  body {
    background-color: #f7f7f7;
    color: #333;
  }
  
  .container {
    display: flex;
    padding: 45px 40px;
    gap: 20px;
    max-width: 1400px;
    margin: 0 auto;
  }
  
  /* Sidebar Styles */
  .sidebar {
    width: 280px;
    flex-shrink: 0;
    background: white;
    border-radius: 12px;
    box-shadow: 0px 0px 5px -1px rgba(0, 0, 0, 0.25);
    padding: 20px;
  }
  
  .filter-section {
    margin-bottom: 20px;
  }
  
  .filter-section h3 {
    font-size: 16px;
    color: #0D0D0F;
    margin-bottom: 10px;
    font-weight: 500;
  }
  
  .divider {
    height: 1px;
    background-color: #D5D5D5;
    margin: 20px 0;
  }
  
  /* Range Slider */
  .range-slider {
    margin-top: 20px;
  }
  
  .slider-track {
    height: 6px;
    background-color: #D5D5D5;
    border-radius: 3px;
    position: relative;
    margin-bottom: 25px;
  }
  
  .slider-fill {
    position: absolute;
    height: 100%;
    background-color: #BF9E66;
    border-radius: 3px;
    width: 100%;
  }
  
  .slider-thumb {
    width: 16px;
    height: 16px;
    background-color: #BF9E66;
    border-radius: 50%;
    border: 3px solid white;
    position: absolute;
    top: -5px;
  }
  
  .slider-thumb.left {
    left: -8px;
  }
  
  .slider-thumb.right {
    right: -8px;
  }
  
  .range-inputs {
    display: flex;
    justify-content: space-between;
    gap: 20px;
  }
  
  .range-input {
    display: flex;
    align-items: center;
    border: 1px solid #D5D5D5;
    border-radius: 13px;
    padding: 8px 10px;
    gap: 2px;
    width: 81px;
  }
  
  .range-input input {
    width: 100%;
    border: none;
    outline: none;
    background: transparent;
    font-size: 11px;
    color: #515050;
  }
  
  .range-input span {
    font-size: 11px;
    color: #515050;
  }
  
  /* Checkbox List */
  .checkbox-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
  }
  
  .checkbox-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    color: #515050;
  }
  
  .checkbox-item input[type="checkbox"] {
    width: 18px;
    height: 18px;
    border: 1px solid #D5D5D5;
    border-radius: 2px;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-color: white;
    cursor: pointer;
  }
  
  .checkbox-item input[type="checkbox"]:checked {
    background-image: url('https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/cc975798e7b27b9ff641002580e8bc05323b6643?placeholderIfAbsent=true');
    background-size: cover;
    border: none;
  }
  
  /* Search Box */
  .search-box {
    display: flex;
    align-items: center;
    border: 1px solid #D5D5D5;
    border-radius: 4px;
    padding: 8px 15px;
    margin-bottom: 12px;
  }
  
  .search-box input {
    flex: 1;
    border: none;
    outline: none;
    background: transparent;
    font-size: 14px;
    color: #515050;
  }
  
  .search-box button {
    background: none;
    border: none;
    cursor: pointer;
  }
  
  .search-box button img {
    width: 20px;
    height: 20px;
  }
  
  /* Main Content */
  .main-content {
    flex: 1;
  }
  
  .job-cards {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  
  /* Job Card */
  .job-card {
    background-color: white;
    border-radius: 12px;
    border: 1px solid #D5D5D5;
    padding: 16px 20px;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    flex-wrap: nowrap;
    align-items: stretch;
  }
  
  .job-header {
    margin-bottom: 10px;
  }
  
  .job-title-location h3 {
    font-size: 16px;
    font-weight: 600;
    color: #0D0D0F;
    margin-bottom: 6px;
  }
  
  .job-title-location p {
    font-size: 12px;
    color: #515050;
  }
  
  .job-details {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
    flex-wrap: nowrap;
    flex-direction: row;
    align-items: stretch;
  }
  
  .job-experience {
    width: 203px;
    display: flex;
    flex-direction: column;
    gap: 14px;
  }
  
  .experience-item h4 {
    font-size: 14px;
    font-weight: 600;
    color: #0D0D0F;
    margin-bottom: 10px;
  }
  
  .experience-item p {
    font-size: 12px;
    color: #515050;
  }
  
  .job-education-skills {
    display: flex;
    flex-direction: column;
    gap: 14px;
    width: 200px;
  }
  
  .education h4, .skills h4 {
    font-size: 14px;
    font-weight: 600;
    color: #0D0D0F;
    margin-bottom: 10px;
  }
  
  .education p {
    font-size: 12px;
    color: #515050;
  }
  
  .skill-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
  }
  
  .skill-tag {
    border: 1px solid #D5D5D5;
    padding: 4px 10px;
    font-size: 12px;
    color: #515050;
    background-color: white;
  }
  
  .job-meta {
    display: flex;
    flex-direction: column;
    gap: 14px;
    width: 132px;
  }
  
  .experience-total h4, .job-location h4 {
    font-size: 14px;
    font-weight: 600;
    color: #0D0D0F;
    margin-bottom: 10px;
  }
  
  .experience-total p, .job-location p {
    font-size: 12px;
    color: #515050;
  }
  
  .job-actions {
    display: flex;
    align-items: center;
    margin-left: 20px;
    position: relative;
  }
  
  .job-actions::before {
    content: '';
    position: absolute;
    left: -20px;
    top: 0;
    height: 100%;
    width: 1px;
    background-color: #D5D5D5;
  }
  
  .message-btn {
    background-color: #BF9E66;
    color: white;
    border: none;
    border-radius: 50px;
    padding: 8px 20px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    
  }
  
  /* Pagination */
  .pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: row;
    margin-top: 30px;
    gap: 20px;
    font-size: 16px;
    color: #515050;
  }
  
  .page-controls {
    display: flex;
    gap: 10px;
    align-items: center;
  }
  
  .prev-page, .next-page {
    width: 30px;
    height: 30px;
    background: none;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .prev-page img {
    transform: rotate(180deg);
  }
  
  .page-number {
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #D5D5D5;
    border-radius: 4px;
    background-color: white;
    cursor: pointer;
  }
  
  .page-number.active {
    border-color: #BF9E66;
    color: #BF9E66;
  }
  
  .page-dots {
    display: flex;
    align-items: center;
  }
  
  .total-items {
    border: 1px solid #D5D5D5;
    border-radius: 4px;
    padding: 5px 10px;
    background-color: white;
  }
  
  /* Responsive Design */
  @media (max-width: 1200px) {
    .container {
      padding: 30px 20px;
    }
    
    .job-details {
      gap: 20px;
    }
   
  }
  
  
  @media (max-width: 992px) {
    .container {
      flex-direction: column;
    }
    
    
    .sidebar {
      /* width: 100%;
      max-width: 600px;
      margin: 0 auto 20px; */
      display: none !important;
    }
    
    .job-card {
      padding: 15px;
    }
    
    .job-details {
      flex-direction: column;
      gap: 15px;
    }
    
    .job-actions::before {
      display: none;
    }
    
    .job-actions {
      margin-left: 0;
      margin-top: 15px;
    

    }
    
    .message-btn {
      width: 100%;
    }
    
    .job-experience, .job-education-skills, .job-meta {
      width: 100%;
    }
  }
  
  @media (max-width: 768px) {
    .pagination {
      flex-direction: column;
      align-items: center;
      gap: 20px;
    }
    
    .page-controls {
      flex-wrap: wrap;
      justify-content: center;
    }
    
    .prev-page, .next-page, .page-number {
      width: 28px;
      height: 28px;
    }
    .job-card{
      background-color: white;
    border-radius: 12px;
    border: 1px solid #D5D5D5;
    padding: 16px 20px;
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    align-items: stretch;
    }
    .job-details{
      display: flex;
      gap: 10px;
    justify-content: flex-end;
    flex-wrap: nowrap;
    flex-direction: row;
    align-items: stretch;
    
    }
  }
  
  @media (max-width: 576px) {
    .container {
      padding: 20px 10px;
    }
    
    .job-card {
      padding: 12px;
    }
    
    .page-controls {
      gap: 5px;
    }
    
    .skill-tags {
      flex-direction: column;
    }
    
    .skill-tag {
      display: inline-block;
    }
    .search-box-tab{
      border-radius: 12px;
    border: 1px solid #D5D5D5;
    }
    .job-experience{
      display: none !important;
    }
  
  }
  @media (min-width: 1024px) {
    .search-bar-wrapper-tab{
      display: none !important;
    }

  }
  .search-bar-wrapper-tab {
    display: flex;
    align-items: center;
    background: #f9f9f9;
    padding: 10px;
    border-radius: 12px;
    box-shadow: 0 1px 5px rgba(0, 0, 0, 0.05);
    gap: 60px;
    margin: auto;
    display: flex;
    width: 100%;
    border: 1px solid #D5D5D5;
  }
  
  .search-bar-tab {
    display: flex;
    flex: 1;
    border: 1px solid #d1b98b;
    border-radius: 50px;
    overflow: hidden;
   
  }
  
  .search-input-tab {
    flex: 1;
    border: none;
    padding: 10px 20px;
    outline: none;
    font-size: 14px;
    border-radius: 50px 0 0 50px;
  }
  
  .search-btn-tab {
    background-color: #c4a267;
    color: #fff;
    border: none;
    padding: 10px 25px;
    cursor: pointer;
    font-weight: bold;
    border-radius: 0 50px 50px 0;
  }
  
  /* tablet filter button */
  .filter-btn {
    padding: 10px 20px;
    background-color: #ffffff;
    border-radius: 10px;
    border: 1px solid #ccc;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 10px;
  }

  .dropdown-panel {
    display: none;
    margin-top: 10px;
    padding: 20px;
    border-radius: 30px;
    border: 1px solid #ccc;
    background: #ffffff;;
    max-width: 400px;
  }

  .filter-section {
    margin-bottom: 15px;
  }

  .filter-section h4 {
    margin-bottom: 5px;
    font-size: 16px;
    color: #333;
  }

  .filter-section select,
  .filter-section input[type="text"] {
    width: 100%;
    padding: 5px;
  }

  .filter-section .checkbox-group label {
    display: block;
  }


  @media (max-width: 425px) {
   .search-btn-tab{
    display: none !important;
   }
   .job-cards{
    display: none !important;
   }
  
  }
  @media (max-width: 430px) {
    .user-card-mobile {
      display: block;
      padding: 10px;
    }
  
    .card-mobile {
      border: 1px solid #ddd;
      border-radius: 12px;
      padding: 15px;
      background: #fff;
      margin-bottom: 16px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
  
    .card-header-mobile {
      display: flex;
      justify-content: space-between;
      align-items: start;
      margin-bottom: 10px;
      gap: 15px;
    }
  
    .title-mobile {
      font-size: 16px;
      font-weight: 600;
      margin: 0;
    }
  
    .location-mobile {
      font-size: 13px;
      color: #555;
      margin: 4px 0 0;
    }
  
    .skills-mobile {
      text-align:left;
      font-size: 12px;
    }
  
    .skill-badge {
      display: inline-block;
      font-size: 11px;
      padding: 4px 7px;
      margin: 2px 2px 0 0;
      background: #f5f5f5;
      border: 1px solid #ddd;
      border-radius: 4px;
    }
  
    .card-body-mobile p {
      font-size: 13px;
      margin: 8px 0;
    }
  
    .card-footer-mobile {
      text-align: right;
      margin-top: 10px;
    }
  
    .btn-mobile {
      background-color: #caa66d;
      color: white;
      border: none;
      padding: 6px 18px;
      border-radius: 20px;
      font-size: 13px;
    }
    .card-body-2{
      display: flex;
      
          flex-direction: row;
          flex-wrap: nowrap;
          justify-content: space-between;
    }
  }
  
  @media (min-width: 431px) {
    .user-card-mobile {
      display: none;
    }
  }
 ategory)
            <li>
                <a href="{{ route('talentfinder', ['categoryid' => $category->id]) }}">{{ $category->name }}</a>
            </li>
        @endforeach
    `;
    // Replace the current content with the full category list
    document.getElementById("dpcontainerbox").innerHTML = fullCategoryList;
});

function fetchCandidateData(talentid) {
    console.log("entereddata");
    var rightdetails = $(".jobbannerright").first(); // jQuery equivalent of getElementsByClassName
    var displayStyle = rightdetails.css("display"); // jQuery equivalent of window.getComputedStyle
    if (displayStyle === "block") {
        var baseUrl = window.location.origin;
        var dataUrl = baseUrl + "/get-talent-by-id/" + talentid;

        $.ajax({
            url: dataUrl,
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
            },
            success: function (data) {
                $("#candidate-name").text(
                    data.full_name || "Name not Provided"
                );
                $("#candidate-dob").text(
                    data.date_of_birth || "DOB not Provided"
                );
                $("#candidate-gender").text(data.gender || "not provided");
                $("#candidate-phone").text(data.phone || "not provided");
                $("#candidate-altphone").text(
                    data.alternate_phone || "not provided"
                );
                $("#candidate-email").text(data.email || "not provided");
                $("#candidate-altemail").text(
                    data.alternate_email || "not provided"
                );
                $("#candidate-address").text(data.address || "not provided");
                $("#candidate-city").text(data.city || "not provided");
                $("#candidate-state").text(data.state || "not provided");
                $("#candidate-country").text(data.country || "not provided");
                $("#candidate-postalcode").text(
                    data.postal_code || "not provided"
                );
                $("#candidate-nationality").text(
                    data.nationality || "not provided"
                );
                $("#candidate-maritalstatus").text(
                    data.marital_status || "not provided"
                );
                $("#candidate-profilephoto").text(
                    data.profile_photo || "not provided"
                );
                $("#candidate-higheducation").text(
                    data.highest_education || "not provided"
                );
                $("#candidate-fieldofstudy").text(
                    data.field_of_study || "not provided"
                );
                $("#candidate-universityname").text(
                    data.university_name || "not provided"
                );
                $("#candidate-graduationyear").text(
                    data.graduation_year || "not provided"
                );
                $("#candidate-additionalcourses").text(
                    data.additional_courses || "not provided"
                );
                $("#candidate-certifications").text(
                    data.certifications || "not provided"
                );
                $("#candidate-languages").text(
                    data.languages || "not provided"
                );
                $("#candidate-skills").text(data.skills || "not provided");
                $("#candidate-bio").text(data.bio || "not provided");
                $("#candidate-linkedin").text(
                    data.linkedin_profile || "not provided"
                );
                $("#candidate-resume").text(data.resume || "not provided");
                $("#candidate-yearsofexp").text(
                    data.years_of_experience || "not provided"
                );
                $("#candidate-currentpos").text(
                    data.current_position || "not provided"
                );
                $("#candidate-currentemployer").text(
                    data.current_employer || "not provided"
                );
                $("#candidate-workexperience").text(
                    data.work_experience || "not provided"
                );
                $("#candidate-desiredpos").text(
                    data.desired_position || "not provided"
                );
                $("#candidate-employmentype").text(
                    data.employment_type || "not provided"
                );
                $("#candidate-desiredsalary").text(
                    data.desired_salary || "not provided"
                );
                $("#candidate-relocation").text(
                    data.relocation || "not provided"
                );
                $("#candidate-industry").text(data.industry || "not provided");
                $("#candidate-preferredlocations").text(
                    data.preferred_locations || "not provided"
                );
                $("#candidate-opentoremote").text(
                    data.open_to_remote || "not provided"
                );
                $("#candidate-avaliableimme").text(
                    data.available_immediately || "not provided"
                );
                $("#candidate-avaliabledate").text(
                    data.availability_date || "not provided"
                );
                $("#candidate-refrences").text(
                    data.references || "not provided"
                );
                $("#candidate-hobbies").text(data.hobbies || "not provided");
                $("#candidate-hasdriverlicense").text(
                    data.has_drivers_license || "not provided"
                );
                $("#candidate-visastatus").text(
                    data.visa_status || "not provided"
                );
                $("#candidate-passportnumber").text(
                    data.passport_number || "not provided"
                );
                $("#candidate-criminalrecord").text(
                    data.has_criminal_record || "not provided"
                );
                $("#candidate-verified").text(
                    data.is_verified || "not provided"
                );
                $("#candidate-longgoal").text(
                    data.short_term_goal || "not provided"
                );
                $("#candidate-seekintern").text(
                    data.long_term_goal || "not provided"
                );
                $("#candidate-opentocontract").text(
                    data.seeking_internship || "not provided"
                );
                $("#candidate-githubprofile").text(
                    data.open_to_contract || "not provided"
                );
                $("#candidate-behanceprofile").text(
                    data.behance_profile || "not provided"
                );
                $("#candidate-twitterprofile").text(
                    data.twitter_profile || "not provided"
                );
                $("#candidate-personalwebsite").text(
                    data.personal_website || "not provided"
                );
                $("#candidate-portfolioitems").text(
                    data.portfolio_items || "not provided"
                );
                $("#candidate-videos").text(data.videos || "not provided");
            },
            error: function (error) {
                console.error("Error fetching Candidate Data:", error);
            },
        });
    } else {
        var baseUrl = window.location.origin;
        var dataUrl = baseUrl + "/get-talent-by-id/" + talentid;

        $.ajax({
            url: dataUrl,
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
            },
            success: function (data) {
                $("#candidate-namen").text(
                    data.full_name || "Name not Provided"
                );
                $("#candidate-dobn").text(
                    data.date_of_birth || "DOB not Provided"
                );
                $("#candidate-gendern").text(data.gender || "not provided");
                $("#candidate-phonen").text(data.phone || "not provided");
                $("#candidate-altphonen").text(
                    data.alternate_phone || "not provided"
                );
                $("#candidate-emailn").text(data.email || "not provided");
                $("#candidate-altemailn").text(
                    data.alternate_email || "not provided"
                );
                $("#candidate-addressn").text(data.address || "not provided");
                $("#candidate-cityn").text(data.city || "not provided");
                $("#candidate-staten").text(data.state || "not provided");
                $("#candidate-countryn").text(data.country || "not provided");
                $("#candidate-postalcoden").text(
                    data.postal_code || "not provided"
                );
                $("#candidate-nationalityn").text(
                    data.nationality || "not provided"
                );
                $("#candidate-maritalstatusn").text(
                    data.marital_status || "not provided"
                );
                $("#candidate-profilephoton").text(
                    data.profile_photo || "not provided"
                );
                $("#candidate-higheducationn").text(
                    data.highest_education || "not provided"
                );
                $("#candidate-fieldofstudyn").text(
                    data.field_of_study || "not provided"
                );
                $("#candidate-universitynamen").text(
                    data.university_name || "not provided"
                );
                $("#candidate-graduationyearn").text(
                    data.graduation_year || "not provided"
                );
                $("#candidate-additionalcoursesn").text(
                    data.additional_courses || "not provided"
                );
                $("#candidate-certificationsn").text(
                    data.certifications || "not provided"
                );
                $("#candidate-languagesn").text(
                    data.languages || "not provided"
                );
                $("#candidate-skillsn").text(data.skills || "not provided");
                $("#candidate-bion").text(data.bio || "not provided");
                $("#candidate-linkedinn").text(
                    data.linkedin_profile || "not provided"
                );
                $("#candidate-resumen").text(data.resume || "not provided");
                $("#candidate-yearsofexpn").text(
                    data.years_of_experience || "not provided"
                );
                $("#candidate-currentposn").text(
                    data.current_position || "not provided"
                );
                $("#candidate-currentemployern").text(
                    data.current_employer || "not provided"
                );
                $("#candidate-workexperiencen").text(
                    data.work_experience || "not provided"
                );
                $("#candidate-desiredposn").text(
                    data.desired_position || "not provided"
                );
                $("#candidate-employmentypen").text(
                    data.employment_type || "not provided"
                );
                $("#candidate-desiredsalaryn").text(
                    data.desired_salary || "not provided"
                );
                $("#candidate-relocationn").text(
                    data.relocation || "not provided"
                );
                $("#candidate-industryn").text(data.industry || "not provided");
                $("#candidate-preferredlocationsn").text(
                    data.preferred_locations || "not provided"
                );
                $("#candidate-opentoremoten").text(
                    data.open_to_remote || "not provided"
                );
                $("#candidate-avaliableimmen").text(
                    data.available_immediately || "not provided"
                );
                $("#candidate-avaliabledaten").text(
                    data.availability_date || "not provided"
                );
                $("#candidate-refrencesn").text(
                    data.references || "not provided"
                );
                $("#candidate-hobbiesn").text(data.hobbies || "not provided");
                $("#candidate-hasdriverlicensen").text(
                    data.has_drivers_license || "not provided"
                );
                $("#candidate-visastatusn").text(
                    data.visa_status || "not provided"
                );
                $("#candidate-passportnumbern").text(
                    data.passport_number || "not provided"
                );
                $("#candidate-criminalrecordn").text(
                    data.has_criminal_record || "not provided"
                );
                $("#candidate-verifiedn").text(
                    data.is_verified || "not provided"
                );
                $("#candidate-longgoaln").text(
                    data.short_term_goal || "not provided"
                );
                $("#candidate-seekinternn").text(
                    data.long_term_goal || "not provided"
                );
                $("#candidate-opentocontractn").text(
                    data.seeking_internship || "not provided"
                );
                $("#candidate-githubprofilen").text(
                    data.open_to_contract || "not provided"
                );
                $("#candidate-behanceprofilen").text(
                    data.behance_profile || "not provided"
                );
                $("#candidate-twitterprofilen").text(
                    data.twitter_profile || "not provided"
                );
                $("#candidate-personalwebsiten").text(
                    data.personal_website || "not provided"
                );
                $("#candidate-portfolioitemsn").text(
                    data.portfolio_items || "not provided"
                );
                $("#candidate-videosn").text(data.videos || "not provided");
            },
            error: function (error) {
                console.error("Error fetching Candidate Data:", error);
            },
        });
        $("#exampleModalLong").modal("show");
    }
}
function toggleDropdown(buttonId, menuClass) {
    const dropdownToggle = document.getElementById(buttonId);
    const dropdownMenu = document.getElementById(menuClass);

    // Toggle the dropdown visibility
    if (dropdownMenu.classList.contains("show")) {
        dropdownMenu.classList.remove("show"); // Hide dropdown
    } else {
        dropdownMenu.classList.add("show"); // Show dropdown
    }
}
