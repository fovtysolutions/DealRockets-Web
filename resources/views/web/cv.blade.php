@extends('layouts.front-end.app')
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/cv.css')}}" />
@section('title',translate('CV Submit'. ' | ' . $web_config['name']->value))
@section('content')
<?php
if (isset($user)){
    $userid = auth('customer')->user()->id;
    $terms = App\Models\User::where('id',$userid)->first()->terms_accepted;
} else {
    $terms = 0;
}
?>
<section class="mainpagesection">
    <div class="cv-submission-container" id="cv-submission">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left: Job Selection Box -->
                <div class="col-lg-6">
                    <div class="cv-box">
                        <h2 class="box-title">Find the Right Opportunity</h2>
                        <p class="box-subtitle">Take the next step in your career or find the perfect hire.</p>
    
                        <!-- Employer Button -->
                        <a href="{{ route('talentfinder') }}" class="btn custom-btn-big btn-employer">
                            <span class="text-white">I'm Hiring</span>
                        </a>
                        
                        <!-- Job Seeker Button -->
                        <a href="{{ route('jobseeker') }}" class="btn custom-btn-big btn-jobseeker">
                            <span class="text-white">I'm Looking for a Job</span>
                        </a>
    
                        <!-- Key Benefits -->
                        <div class="benefits">
                            <div class="benefit-item">
                                <i class="fas fa-user-check"></i>
                                <span>Trusted by thousands of professionals</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-briefcase"></i>
                                <span>Access top job listings & talent</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-bolt"></i>
                                <span>Fast & easy recruitment process</span>
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Right: Smaller GIF -->
                <div class="col-lg-6 text-center d-none d-lg-block">
                    <img src="/images/gif2-ezgif.com-crop.gif" 
                         alt="Job Search" class="job-gif">
                </div>
            </div>
        </div>
    </div>
@if($terms == 0)
    @include('web.partials.policyaccept')
@endif
</section>
<!-- Font Awesome for Icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<!-- Lottie Animation Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.7.6/lottie.min.js"></script>
<script>
    // Load Lottie Animation
    lottie.loadAnimation({
        container: document.getElementById("lottie-animation"),
        renderer: "svg",
        loop: true,
        autoplay: true,
        path: "https://assets10.lottiefiles.com/packages/lf20_jtbfg2nb.json" // Change to a different Lottie JSON if needed
    });
</script>
@endsection