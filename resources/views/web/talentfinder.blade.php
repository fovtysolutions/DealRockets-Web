@extends('layouts.front-end.app')
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/talentfinder.css')}}" />
@section('title')
Talent Finder | {{ $web_config['name']->value }}
@endsection
@section('content')
<?php
use App\Utils\CategoryManager;
$categories = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
use App\Utils\ChatManager;
$unread = ChatManager::unread_messages();
$userId = Auth('customer')->id();
use App\Models\User;
$user = User::where('id',$userId)->first();
if (isset($user)){
    $userid = auth('customer')->user()->id;
    $terms = App\Models\User::where('id',$userid)->first()->terms_accepted;
} else {
    $terms = 0;
}
?>
<div class="mainpagesection" style="background-color: unset;">
    <div class="jobbannermain">
        <div class="jobbannerleft">
            <div class="nav-item {{ !request()->is('/') ? 'dropdown' : '' }}" style="background-color: white;margin-left: 0px;">
                <a class="spanatag" href="javascript:" style="z-index: 0;">
                    <svg class="spanimage" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                        <rect x="5" y="6" width="20" height="2" fill="black" />
                        <rect x="5" y="13" width="20" height="2" fill="black" />
                        <rect x="5" y="20" width="20" height="2" fill="black" />
                    </svg>
                    <span class="spantitlenew">
                        {{ translate('categories') }}
                    </span>
                </a>
            </div>
            <ul class="navbar-nav" style="overflow-y:scroll; height: 90%;">
                <div class="megamenu">
                    <div class="megamenucontainer">
                        <div class="category-menu-wrapper">
                            <ul class="category-menu-items" id="dpcontainerbox">
                                @foreach ($categories->take(17) as $key => $category)
                                    <li>
                                        <a
                                            href="{{ route('talentfinder', ['categoryid' => $category->id]) }}">{{ $category->name }}</a>
                                    </li>
                                @endforeach
                                <li class="text-center" id="viewMoreBtn" style="background-color: white;">
                                    <a href="#" class="text-primary font-weight-bold justify-content-center mt-2">
                                        {{ translate('View_More') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </ul>
        </div>
        <div class="jobbannercenter">
            <ul class="navbar-nav hiddenonscreens">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="javascript:" id="dropdownMenuCat" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false"
                        onclick="toggleDropdown('dropdownMenuCat', 'dropdownmenu-cat')" style="position: absolute;">
                        <svg class="spanimage" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                            <rect x="5" y="6" width="20" height="2" fill="black" />
                            <rect x="5" y="13" width="20" height="2" fill="black" />
                            <rect x="5" y="20" width="20" height="2" fill="black" />
                        </svg>
                    </a>
                    <ul class="dropdown-menu" id="dropdownmenu-cat" aria-labelledby="dropdownMenuButton"
                        style="padding-top:50px;">
                        @foreach ($categories as $category)
                            <li>
                                <a
                                    href="{{ route('jobseeker', ['categoryid' => $category->id]) }}">{{ $category->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
            <div class="tilebox">
                @if ($talentfinder->isEmpty())
                    <p>No Profiles Found!</p>
                @else
                    @foreach ($talentfinder as $talent)
                        <input style="display: none;" value={{ $talent->id }} id="talentid" />
                        <div class="tile">
                            <div class="tile-content">
                                <!-- Profile Logo -->
                                <div class="icon">
                                    @if($talent->profile_photo)
                                        <img class="ico" src="/uploads/{{ $talent->profile_photo }}" />
                                    @else
                                        <img class="ico" src="/images/missing_image.jpg" />
                                    @endif
                                </div>
                                <!-- Profile Details Section -->
                                <div class="details">
                                    <div class="full_name">{{ $talent->full_name }}</div>
                                    <div class="industry">{{ $talent->industry }}</div>
                                    <div class="email">{{ $talent->email }}</div>
                                </div>
                            </div>
                            <div class="overlay">
                                <div class="overlay-content" onclick="fetchCandidateData('{{ $talent->id }}')">View Profile
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="jobbannerright" id="candidatedetails">
            <div class="container py-2 ml-0 mr-0" style="border-radius:0px;">
                <div class="card shadow-sm" style="border-radius:0px;">
                    {{-- <div class="card-header">
                        <h3>Candidate Details</h3>
                    </div> --}}
                    <div class="card-body">
                        <div class="container py-3">
                            <!-- Candidate Name and Profile Photo -->
                            <div class="row mb-4 text-center">
                                <div class="col">
                                    <h3 id="candidate-name" class="font-weight-bold">Loading...</h3>
                                    <img id="candidate-profilephoto" src="/images/missing_image.jpg" alt="Profile Photo"
                                        class="rounded-circle img-thumbnail mt-2" style="width: 120px; height: 120px;">
                                </div>
                            </div>

                            <!-- Personal Details -->
                            <div class="row mb-4 p-3" style="background-color: #f9f9f9;">
                                <div class="col-12">
                                    <h4 class="border-bottom pb-2">Personal Details</h4>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>Date of Birth:</strong> <span id="candidate-dob">Loading...</span></p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>Gender:</strong> <span id="candidate-gender">Loading...</span></p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>Postal Code:</strong> <span id="candidate-postalcode">Loading...</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Phone:</strong> <span id="candidate-phone">Loading...</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Alt. Phone:</strong> <span id="candidate-altphone">Loading...</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Email:</strong> <span id="candidate-email">Loading...</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Alt. Email:</strong> <span id="candidate-altemail">Loading...</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Nationality:</strong> <span id="candidate-nationality">Loading...</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Marital Status:</strong> <span
                                            id="candidate-maritalstatus">Loading...</span></p>
                                </div>
                            </div>

                            <!-- Address Details -->
                            <div class="row mb-4 p-3" style="background-color: #f9f9f9;">
                                <div class="col-12">
                                    <h4 class="border-bottom pb-2">Address</h4>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Address:</strong> <span id="candidate-address">Loading...</span></p>
                                </div>
                                <div class="col-md-3">
                                    <p><strong>City:</strong> <span id="candidate-city">Loading...</span></p>
                                </div>
                                <div class="col-md-3">
                                    <p><strong>State:</strong> <span id="candidate-state">Loading...</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Country:</strong> <span id="candidate-country">Loading...</span></p>
                                </div>
                            </div>

                            <!-- Education Details -->
                            <div class="row mb-4 p-3" style="background-color: #f9f9f9;">
                                <div class="col-12">
                                    <h4 class="border-bottom pb-2">Education</h4>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Highest Education:</strong> <span
                                            id="candidate-higheducation">Loading...</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Field of Study:</strong> <span
                                            id="candidate-fieldofstudy">Loading...</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>University:</strong> <span
                                            id="candidate-universityname">Loading...</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Graduation Year:</strong> <span
                                            id="candidate-graduationyear">Loading...</span></p>
                                </div>
                                <div class="col-md-12">
                                    <p><strong>Additional Courses:</strong> <span
                                            id="candidate-additionalcourses">Loading...</span></p>
                                </div>
                            </div>

                            <!-- Professional Details -->
                            <div class="row mb-4 p-3" style="background-color: #f9f9f9;">
                                <div class="col-12">
                                    <h4 class="border-bottom pb-2">Professional Details</h4>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Years of Experience:</strong> <span
                                            id="candidate-yearsofexp">Loading...</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Current Position:</strong> <span
                                            id="candidate-currentpos">Loading...</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Current Employer:</strong> <span
                                            id="candidate-currentemployer">Loading...</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Desired Position:</strong> <span
                                            id="candidate-desiredpos">Loading...</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Desired Salary:</strong> <span
                                            id="candidate-desiredsalary">Loading...</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Industry:</strong> <span id="candidate-industry">Loading...</span></p>
                                </div>
                                <div class="col-md-12">
                                    <p><strong>Work Experience:</strong> <span
                                            id="candidate-workexperience">Loading...</span></p>
                                </div>
                            </div>

                            <!-- Skills and Certifications -->
                            <div class="row mb-4 p-3" style="background-color: #f9f9f9;">
                                <div class="col-12">
                                    <h4 class="border-bottom pb-2">Skills & Certifications</h4>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Skills:</strong> <span id="candidate-skills">Loading...</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Certifications:</strong> <span
                                            id="candidate-certifications">Loading...</span></p>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="row mb-4 p-3" style="background-color: #f9f9f9;">
                                <div class="col-12">
                                    <h4 class="border-bottom pb-2">Additional Information</h4>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Languages:</strong> <span id="candidate-languages">Loading...</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Hobbies:</strong> <span id="candidate-hobbies">Loading...</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>LinkedIn:</strong> <span id="candidate-linkedin">Loading...</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>GitHub:</strong> <span id="candidate-githubprofile">Loading...</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Twitter:</strong> <span id="candidate-twitterprofile">Loading...</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Behance:</strong> <span id="candidate-behanceprofile">Loading...</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Right Section with Ads -->
    <div class="leadrightdivision">
        <div class="ad-section">
            <div class="vendor-ad">
                <div class="ad-content">
                    <!-- Replace with actual vendor ad content -->
                    <img src="/images/banner/D7z2EogpjPPb2nkuJ7hDWOR67xVhbqjybdOkdpLr.png" alt="Vendor Ad" class="ad-image">
                </div>
            </div>
            <div class="google-ad">
                <div class="ad-content">
                    <!-- Google Ad code goes here -->
                    <img src="/images/banner/wpnBmaWcxCSnIC0ATIVVbwIST2ybhqHbd1SQLVYa.png" alt="Google Ad" class="ad-image">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Candidate Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container py-3">
                    <!-- Candidate Name and Profile Photo -->
                    <div class="row mb-4 text-center">
                        <div class="col">
                            <h3 id="candidate-namen" class="font-weight-bold">Loading...</h3>
                            <img id="candidate-profilephoto" src="/images/missing_image.jpg" alt="Profile Photo"
                                class="rounded-circle img-thumbnail mt-2" style="width: 120px; height: 120px;">
                        </div>
                    </div>

                    <!-- Personal Details -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h4 class="border-bottom pb-2">Personal Details</h4>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Date of Birth:</strong> <span id="candidate-dobn">Loading...</span></p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Gender:</strong> <span id="candidate-gendern">Loading...</span></p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Postal Code:</strong> <span id="candidate-postalcoden">Loading...</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Phone:</strong> <span id="candidate-phonen">Loading...</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Alt. Phone:</strong> <span id="candidate-altphonen">Loading...</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Email:</strong> <span id="candidate-emailn">Loading...</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Alt. Email:</strong> <span id="candidate-altemailn">Loading...</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Nationality:</strong> <span id="candidate-nationalityn">Loading...</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Marital Status:</strong> <span id="candidate-maritalstatusn">Loading...</span></p>
                        </div>
                    </div>

                    <!-- Address Details -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h4 class="border-bottom pb-2">Address</h4>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Address:</strong> <span id="candidate-addressn">Loading...</span></p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>City:</strong> <span id="candidate-cityn">Loading...</span></p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>State:</strong> <span id="candidate-staten">Loading...</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Country:</strong> <span id="candidate-countryn">Loading...</span></p>
                        </div>
                    </div>

                    <!-- Education Details -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h4 class="border-bottom pb-2">Education</h4>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Highest Education:</strong> <span id="candidate-higheducationn">Loading...</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Field of Study:</strong> <span id="candidate-fieldofstudyn">Loading...</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>University:</strong> <span id="candidate-universitynamen">Loading...</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Graduation Year:</strong> <span id="candidate-graduationyearn">Loading...</span>
                            </p>
                        </div>
                        <div class="col-md-12">
                            <p><strong>Additional Courses:</strong> <span
                                    id="candidate-additionalcoursesn">Loading...</span></p>
                        </div>
                    </div>

                    <!-- Professional Details -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h4 class="border-bottom pb-2">Professional Details</h4>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Years of Experience:</strong> <span id="candidate-yearsofexpn">Loading...</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Current Position:</strong> <span id="candidate-currentposn">Loading...</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Current Employer:</strong> <span id="candidate-currentemployern">Loading...</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Desired Position:</strong> <span id="candidate-desiredposn">Loading...</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Desired Salary:</strong> <span id="candidate-desiredsalaryn">Loading...</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Industry:</strong> <span id="candidate-industryn">Loading...</span></p>
                        </div>
                        <div class="col-md-12">
                            <p><strong>Work Experience:</strong> <span id="candidate-workexperiencen">Loading...</span>
                            </p>
                        </div>
                    </div>

                    <!-- Skills and Certifications -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h4 class="border-bottom pb-2">Skills & Certifications</h4>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Skills:</strong> <span id="candidate-skillsn">Loading...</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Certifications:</strong> <span id="candidate-certificationsn">Loading...</span>
                            </p>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h4 class="border-bottom pb-2">Additional Information</h4>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Languages:</strong> <span id="candidate-languagesn">Loading...</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Hobbies:</strong> <span id="candidate-hobbiesn">Loading...</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>LinkedIn:</strong> <span id="candidate-linkedinn">Loading...</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>GitHub:</strong> <span id="candidate-githubprofilen">Loading...</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Twitter:</strong> <span id="candidate-twitterprofilen">Loading...</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Behance:</strong> <span id="candidate-behanceprofilen">Loading...</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>
@if($terms == 0)
    @include('web.partials.policyaccept')
@endif
<script>
    document.getElementById("viewMoreBtn").addEventListener("click", function () {
        // Set the new HTML content for #dpcontainerbox
        const fullCategoryList = `
            @foreach ($categories as $category)
                <li>
                    <a href="{{ route('talentfinder', ['categoryid' => $category->id]) }}">{{ $category->name }}</a>
                </li>
            @endforeach
        `;
        // Replace the current content with the full category list
        document.getElementById("dpcontainerbox").innerHTML = fullCategoryList;
    });
</script>
<script>
    function fetchCandidateData(talentid) {
        console.log('entereddata');
        var rightdetails = $('.jobbannerright').first(); // jQuery equivalent of getElementsByClassName
        var displayStyle = rightdetails.css('display'); // jQuery equivalent of window.getComputedStyle
        if (displayStyle === 'block') {
            var baseUrl = window.location.origin;
            var dataUrl = baseUrl + '/get-talent-by-id/' + talentid;

            $.ajax({
                url: dataUrl,
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (data) {
                    $('#candidate-name').text(data.full_name || 'Name not Provided');
                    $('#candidate-dob').text(data.date_of_birth || 'DOB not Provided');
                    $('#candidate-gender').text(data.gender || 'not provided');
                    $('#candidate-phone').text(data.phone || 'not provided');
                    $('#candidate-altphone').text(data.alternate_phone || 'not provided');
                    $('#candidate-email').text(data.email || 'not provided');
                    $('#candidate-altemail').text(data.alternate_email || 'not provided');
                    $('#candidate-address').text(data.address || 'not provided');
                    $('#candidate-city').text(data.city || 'not provided');
                    $('#candidate-state').text(data.state || 'not provided');
                    $('#candidate-country').text(data.country || 'not provided');
                    $('#candidate-postalcode').text(data.postal_code || 'not provided');
                    $('#candidate-nationality').text(data.nationality || 'not provided');
                    $('#candidate-maritalstatus').text(data.marital_status || 'not provided');
                    $('#candidate-profilephoto').text(data.profile_photo || 'not provided');
                    $('#candidate-higheducation').text(data.highest_education || 'not provided');
                    $('#candidate-fieldofstudy').text(data.field_of_study || 'not provided');
                    $('#candidate-universityname').text(data.university_name || 'not provided');
                    $('#candidate-graduationyear').text(data.graduation_year || 'not provided');
                    $('#candidate-additionalcourses').text(data.additional_courses || 'not provided');
                    $('#candidate-certifications').text(data.certifications || 'not provided');
                    $('#candidate-languages').text(data.languages || 'not provided');
                    $('#candidate-skills').text(data.skills || 'not provided');
                    $('#candidate-bio').text(data.bio || 'not provided');
                    $('#candidate-linkedin').text(data.linkedin_profile || 'not provided');
                    $('#candidate-resume').text(data.resume || 'not provided');
                    $('#candidate-yearsofexp').text(data.years_of_experience || 'not provided');
                    $('#candidate-currentpos').text(data.current_position || 'not provided');
                    $('#candidate-currentemployer').text(data.current_employer || 'not provided');
                    $('#candidate-workexperience').text(data.work_experience || 'not provided');
                    $('#candidate-desiredpos').text(data.desired_position || 'not provided');
                    $('#candidate-employmentype').text(data.employment_type || 'not provided');
                    $('#candidate-desiredsalary').text(data.desired_salary || 'not provided');
                    $('#candidate-relocation').text(data.relocation || 'not provided');
                    $('#candidate-industry').text(data.industry || 'not provided');
                    $('#candidate-preferredlocations').text(data.preferred_locations || 'not provided');
                    $('#candidate-opentoremote').text(data.open_to_remote || 'not provided');
                    $('#candidate-avaliableimme').text(data.available_immediately || 'not provided');
                    $('#candidate-avaliabledate').text(data.availability_date || 'not provided');
                    $('#candidate-refrences').text(data.references || 'not provided');
                    $('#candidate-hobbies').text(data.hobbies || 'not provided');
                    $('#candidate-hasdriverlicense').text(data.has_drivers_license || 'not provided');
                    $('#candidate-visastatus').text(data.visa_status || 'not provided');
                    $('#candidate-passportnumber').text(data.passport_number || 'not provided');
                    $('#candidate-criminalrecord').text(data.has_criminal_record || 'not provided');
                    $('#candidate-verified').text(data.is_verified || 'not provided');
                    $('#candidate-longgoal').text(data.short_term_goal || 'not provided');
                    $('#candidate-seekintern').text(data.long_term_goal || 'not provided');
                    $('#candidate-opentocontract').text(data.seeking_internship || 'not provided');
                    $('#candidate-githubprofile').text(data.open_to_contract || 'not provided');
                    $('#candidate-behanceprofile').text(data.behance_profile || 'not provided');
                    $('#candidate-twitterprofile').text(data.twitter_profile || 'not provided');
                    $('#candidate-personalwebsite').text(data.personal_website || 'not provided');
                    $('#candidate-portfolioitems').text(data.portfolio_items || 'not provided');
                    $('#candidate-videos').text(data.videos || 'not provided');
                },
                error: function (error) {
                    console.error('Error fetching Candidate Data:', error);
                }
            });
        } else {
            var baseUrl = window.location.origin;
            var dataUrl = baseUrl + '/get-talent-by-id/' + talentid;

            $.ajax({
                url: dataUrl,
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (data) {
                    $('#candidate-namen').text(data.full_name || 'Name not Provided');
                    $('#candidate-dobn').text(data.date_of_birth || 'DOB not Provided');
                    $('#candidate-gendern').text(data.gender || 'not provided');
                    $('#candidate-phonen').text(data.phone || 'not provided');
                    $('#candidate-altphonen').text(data.alternate_phone || 'not provided');
                    $('#candidate-emailn').text(data.email || 'not provided');
                    $('#candidate-altemailn').text(data.alternate_email || 'not provided');
                    $('#candidate-addressn').text(data.address || 'not provided');
                    $('#candidate-cityn').text(data.city || 'not provided');
                    $('#candidate-staten').text(data.state || 'not provided');
                    $('#candidate-countryn').text(data.country || 'not provided');
                    $('#candidate-postalcoden').text(data.postal_code || 'not provided');
                    $('#candidate-nationalityn').text(data.nationality || 'not provided');
                    $('#candidate-maritalstatusn').text(data.marital_status || 'not provided');
                    $('#candidate-profilephoton').text(data.profile_photo || 'not provided');
                    $('#candidate-higheducationn').text(data.highest_education || 'not provided');
                    $('#candidate-fieldofstudyn').text(data.field_of_study || 'not provided');
                    $('#candidate-universitynamen').text(data.university_name || 'not provided');
                    $('#candidate-graduationyearn').text(data.graduation_year || 'not provided');
                    $('#candidate-additionalcoursesn').text(data.additional_courses || 'not provided');
                    $('#candidate-certificationsn').text(data.certifications || 'not provided');
                    $('#candidate-languagesn').text(data.languages || 'not provided');
                    $('#candidate-skillsn').text(data.skills || 'not provided');
                    $('#candidate-bion').text(data.bio || 'not provided');
                    $('#candidate-linkedinn').text(data.linkedin_profile || 'not provided');
                    $('#candidate-resumen').text(data.resume || 'not provided');
                    $('#candidate-yearsofexpn').text(data.years_of_experience || 'not provided');
                    $('#candidate-currentposn').text(data.current_position || 'not provided');
                    $('#candidate-currentemployern').text(data.current_employer || 'not provided');
                    $('#candidate-workexperiencen').text(data.work_experience || 'not provided');
                    $('#candidate-desiredposn').text(data.desired_position || 'not provided');
                    $('#candidate-employmentypen').text(data.employment_type || 'not provided');
                    $('#candidate-desiredsalaryn').text(data.desired_salary || 'not provided');
                    $('#candidate-relocationn').text(data.relocation || 'not provided');
                    $('#candidate-industryn').text(data.industry || 'not provided');
                    $('#candidate-preferredlocationsn').text(data.preferred_locations || 'not provided');
                    $('#candidate-opentoremoten').text(data.open_to_remote || 'not provided');
                    $('#candidate-avaliableimmen').text(data.available_immediately || 'not provided');
                    $('#candidate-avaliabledaten').text(data.availability_date || 'not provided');
                    $('#candidate-refrencesn').text(data.references || 'not provided');
                    $('#candidate-hobbiesn').text(data.hobbies || 'not provided');
                    $('#candidate-hasdriverlicensen').text(data.has_drivers_license || 'not provided');
                    $('#candidate-visastatusn').text(data.visa_status || 'not provided');
                    $('#candidate-passportnumbern').text(data.passport_number || 'not provided');
                    $('#candidate-criminalrecordn').text(data.has_criminal_record || 'not provided');
                    $('#candidate-verifiedn').text(data.is_verified || 'not provided');
                    $('#candidate-longgoaln').text(data.short_term_goal || 'not provided');
                    $('#candidate-seekinternn').text(data.long_term_goal || 'not provided');
                    $('#candidate-opentocontractn').text(data.seeking_internship || 'not provided');
                    $('#candidate-githubprofilen').text(data.open_to_contract || 'not provided');
                    $('#candidate-behanceprofilen').text(data.behance_profile || 'not provided');
                    $('#candidate-twitterprofilen').text(data.twitter_profile || 'not provided');
                    $('#candidate-personalwebsiten').text(data.personal_website || 'not provided');
                    $('#candidate-portfolioitemsn').text(data.portfolio_items || 'not provided');
                    $('#candidate-videosn').text(data.videos || 'not provided');
                },
                error: function (error) {
                    console.error('Error fetching Candidate Data:', error);
                }
            });
            $("#exampleModalLong").modal("show");
        }
    }
</script>
<script>
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
</script>
<script>
    document.addEventListener('DOMContentLoaded',function(){
        var firstcandidate = document.querySelector('input[id=talentid]');
        var talentid =firstcandidate ? firstcandidate.value : null;
        if(talentid){
            fetchCandidateData(talentid);
        } else {
            console.log('Talent ID Not Found');
        }
    });
</script>
@endsection