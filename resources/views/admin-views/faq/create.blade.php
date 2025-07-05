@extends('layouts.back-end.app-partialseller')

@section('title', translate('Create FAQ'))

@section('content')
    @php
        $vendorFeatures = [
            'analytics' => 'Analytics',
            'inbox' => 'Inbox',
            'notifications' => 'Notifications',
            'marketplace' => 'Marketplace',
            'profile' => 'My Profile',
            'advertise' => 'Advertise',
            'stocksell' => 'Stock Sell',
            'buyleads' => 'Buy Leads',
            'saleoffer' => 'Sale Offer',
            'dealassist' => 'Deal Assist',
            'postrfq' => 'RFQ',
            'industryjobs' => 'Industry Jobs',
            'tradeshow' => 'Tradeshow',
            'membership' => 'Membership',
            'clearingforwarding' => 'Clearing & Forwarding',
        ];
        $userFeatures = [
            'stocksell' => 'Stock Sell',
            'buyleads' => 'Buy Leads',
            'saleoffer' => 'Sale Offer',
            'dealassist' => 'Deal Assist',
            'postrfq' => 'RFQ',
            'industryjobs' => 'Industry Jobs',
            'tradeshow' => 'Tradeshow',
            'marketplace' => 'Marketplace',
        ];
    @endphp
    <div class="content container-fluid">
        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <h2 class="h1 mb-0 d-flex gap-2">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
                {{ translate('Add New FAQ') }}
            </h2>
        </div>

        <form class="product-form text-start" id="createfaq">
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="faq_type" class="title-color">Type</label>
                            <select class="form-control" name="type" id="faq_type" required>
                                <option value="" disabled selected>Select Type</option>
                                <option value="vendor">Vendor</option>
                                <option value="user">User</option>
                            </select>
                        </div>

                        <div class="col-md-12" id="feature_selector_wrapper" style="display: none;">
                            <label for="faq_feature" class="title-color">Feature</label>
                            <select class="form-control" name="feature" id="faq_feature" required>
                                <option value="" disabled selected>Select Feature</option>
                                {{-- Options will be injected via JS --}}
                            </select>
                        </div>

                        <div class="col-lg-12">
                            <label class="title-color">Question</label>
                            <input class="form-control" type="text" name="question" id="question" required>
                        </div>

                        <div class="col-lg-12">
                            <label class="title-color">Answer</label>
                            <input class="form-control" type="text" name="answer" id="answer" required>
                        </div>

                        <input type="hidden" name="seller" id="seller" value="{{ auth('admin')->user()->id }}">
                    </div>

                    <div class="row justify-content-end gap-3 mt-3 mx-1">
                        <button type="submit" class="btn btn--primary px-5">{{ translate('submit') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script>
        var createfaqform = document.getElementById('createfaq');

        createfaqform.addEventListener('submit', function(e) {
            e.preventDefault();

            var question = document.getElementById('question').value;
            var answer = document.getElementById('answer').value;
            var seller = document.getElementById('seller').value;
            var type = document.getElementById('faq_type').value;
            var sub_type = document.getElementById('faq_feature').value;

            $.ajax({
                url: '{{ route('admin.crudfaq') }}',
                method: 'POST',
                data: {
                    action: 'create',
                    question: question,
                    answer: answer,
                    seller: seller,
                    type: type,
                    sub_type: sub_type,
                    _token: '{{ csrf_token() }}',
                },
                success: function() {
                    toastr.success('FAQ Created Successfully');
                    window.location.href = '{{ route('admin.managefaq') }}';
                },
                error: function() {
                    toastr.error('FAQ Fail');
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
    <script>
        const vendorFeatures = @json($vendorFeatures);
        const userFeatures = @json($userFeatures);
        const typeSelector = document.getElementById('faq_type');
        const featureSelectorWrapper = document.getElementById('feature_selector_wrapper');
        const featureSelector = document.getElementById('faq_feature');

        typeSelector.addEventListener('change', function() {
            const selectedType = this.value;

            featureSelector.innerHTML = '<option value="" disabled selected>Select Feature</option>';
            let features = {};

            if (selectedType === 'vendor') {
                features = vendorFeatures;
            } else if (selectedType === 'user') {
                features = userFeatures;
            }

            // Populate the feature dropdown
            for (const [key, value] of Object.entries(features)) {
                const option = document.createElement('option');
                option.value = key;
                option.text = value;
                featureSelector.appendChild(option);
            }

            featureSelectorWrapper.style.display = 'block';
        });
    </script>
@endpush
