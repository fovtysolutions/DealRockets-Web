@extends('layouts.back-end.app-partial')

@section('title', translate('Add_Vacancies'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ theme_asset('public/assets/custom-css/progress-form.css') }}">
    <style>
        /* Step section visibility control */
        .progress-form-main .step-section {
            display: none !important;
        }
        
        .progress-form-main .step-section.active-step {
            display: block !important;
        }
        
        /* Initial step visibility */
        .progress-form-main .step-section[data-step="1"]:not(.d-none) {
            display: block !important;
        }
        
        /* Progress indicator styling */
        .step.active .step-circle {
            background-color: #007bff;
            color: white;
        }
        
        /* Input error styling */
        .input-error {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        }
        
        /* Smooth transition for steps */
        .step-section {
            transition: all 0.3s ease-in-out;
        }
        
        /* Debug indicator for active step */
        .step-section.active-step {
            border-left: 4px solid #007bff;
            background-color: rgba(0, 123, 255, 0.02);
        }
        
        /* Ensure hidden steps are completely hidden */
        .step-section.d-none {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
        }
    </style>
@endpush

@section('content')
    <div class="content container-fluid">
        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <h2 class="h1 mb-0 d-flex gap-2">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
                {{ translate('Add New Vacancy') }}
            </h2>
        </div>

        <form class="vacancy-form text-start" action="{{ route('admin.jobvacancy.store') }}" method="POST"
            enctype="multipart/form-data" id="vacancy_form">
            @csrf
            <div class="card">
                <div class="card-body">
                    @include('admin-views.jobseekers.partials._vacancy_fields')
                </div>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script src="{{ theme_asset('public/js/progress-form.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/tags-input.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.js') }}"></script>
    <script>
        // Custom multi-step form handler
        $(document).ready(function() {
            // Initialize step visibility
            function initializeSteps() {
                $('.step-section').removeClass('active-step').addClass('d-none');
                $('.step-section[data-step="1"]').addClass('active-step').removeClass('d-none');
                $('.step').removeClass('active');
                $('.step:first').addClass('active');
                console.log('Steps initialized');
            }
            
            // Show specific step
            function showStep(stepNumber) {
                console.log('Showing step:', stepNumber);
                
                // Hide all steps with animation
                $('.step-section').removeClass('active-step').addClass('d-none');
                
                // Show current step
                const currentStep = $('.step-section[data-step="' + stepNumber + '"]');
                currentStep.addClass('active-step').removeClass('d-none');
                
                // Update progress indicators
                $('.step').removeClass('active');
                $('.step').each(function(index) {
                    if (index + 1 <= stepNumber) {
                        $(this).addClass('active');
                    }
                });
                
                // Scroll to top of form for better UX
                $('html, body').animate({
                    scrollTop: $('.progress-form-main').offset().top - 100
                }, 300);
            }
            
            // Validate current step
            function validateStep(stepElement) {
                let isValid = true;
                let firstInvalidInput = null;
                let invalidFields = [];
                const requiredInputs = stepElement.find('input[required], select[required], textarea[required]');
                
                requiredInputs.each(function() {
                    const input = $(this);
                    if (!input.val().trim()) {
                        isValid = false;
                        input.addClass('input-error');
                        const label = input.closest('.form-group').find('label').text() || input.attr('name');
                        
                        // Store first invalid input for focusing
                        if (!firstInvalidInput) {
                            firstInvalidInput = input;
                        }
                        
                        // Collect field names for summary message
                        invalidFields.push(label);
                    } else {
                        input.removeClass('input-error');
                    }
                });
                
                // Show single summary message instead of multiple individual messages
                if (!isValid) {
                    if (invalidFields.length === 1) {
                        toastr.error('Please fill in the "' + invalidFields[0] + '" field.');
                    } else {
                        toastr.error('Please fill in the following required fields: ' + invalidFields.join(', '));
                    }
                    
                    // Focus on first invalid input
                    if (firstInvalidInput) {
                        firstInvalidInput.focus();
                        $('html, body').animate({
                            scrollTop: firstInvalidInput.offset().top - 200
                        }, 300);
                    }
                }
                
                return isValid;
            }
            
            // Initialize on page load
            initializeSteps();
            
            // Next button click handler
            $(document).on('click', '.next-btn', function() {
                const currentStep = $(this).closest('.step-section');
                const nextStepNumber = parseInt($(this).data('next'));
                
                if (validateStep(currentStep)) {
                    showStep(nextStepNumber);
                }
                // Note: Error messages are already handled in validateStep function
            });
            
            // Previous button click handler
            $(document).on('click', '.prev-btn', function() {
                const prevStepNumber = parseInt($(this).data('prev'));
                showStep(prevStepNumber);
            });
            
            // Fallback for original function
            if (typeof initializeMultiStepForm === 'function') {
                // Override the original function behavior
                console.log('Original function found, but using custom implementation');
            }
        });

        $('body').ready(function() {
            $(document).on('change', '#country', function() {
                var country_id = $(this).val();
                var base_url = window.location.origin;
                $('#state').empty().append($('<option>', {
                    value: '',
                    text: 'Select State'
                }));
                $('#city').empty().append($('<option>', {
                    value: '',
                    text: 'Select City'
                }));
                $.ajax({
                    type: "GET",
                    url: base_url + "/get-state-by-id/" + country_id,
                    success: function(GetData) {
                        const data = JSON.parse(GetData);
                        $.each(data, function(i, obj) {
                            const fetchdata = `
                            <option value="${obj.id}"> ${obj.name} </option>
                            `;
                            $('#state').append(fetchdata);
                        });
                    }
                });
            });

            $(document).on('change', '#state', function() {
                console.log("F3");
                var new_state = $(this).val();
                var base_url = window.location.origin;
                $('#city').empty();
                $.ajax({
                    type: "GET",
                    url: base_url + "/get-city-by-id/" + new_state,
                    success: function(GetData) {
                        const data = JSON.parse(GetData);
                        $.each(data, function(i, obj) {
                            const fetchdata = `
                            <option value="${obj.id}"> ${obj.name} </option>
                            `;
                            $('#city').append(fetchdata);
                        });
                    }
                });
            });
        });
    </script>
@endpush
