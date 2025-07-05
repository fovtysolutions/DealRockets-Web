@extends('layouts.back-end.app-partialseller')

@section('title', translate('Manage FAQ'))

@section('content')
    @php
        $features = array_merge($vendorFeatures ?? [], $userFeatures ?? []);
    @endphp

    <div class="content container-fluid">
        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <h2 class="h1 mb-0 d-flex gap-2">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
                {{ translate('Manage FAQ') }}
            </h2>
        </div>

        <!-- Filters -->
        <form method="GET" action="{{ url()->current() }}" class="mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="type" class="form-label">Type</label>
                    <select name="type" id="type" class="form-control">
                        <option value="">All Types</option>
                        <option value="vendor" {{ request('type') === 'vendor' ? 'selected' : '' }}>Vendor</option>
                        <option value="user" {{ request('type') === 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="feature" class="form-label">Feature</label>
                    <select name="feature" id="feature" class="form-control">
                        <option value="">All Features</option>
                        @foreach ($features as $key => $label)
                            <option value="{{ $key }}" {{ request('feature') === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 d-flex gap-2">
                    <button type="submit" class="btn btn--primary px-4">
                        <i class="tio-filter"></i> Apply
                    </button>
                    <a href="{{ url()->current() }}" class="btn btn-outline-secondary px-4">
                        <i class="tio-clear"></i> Reset
                    </a>
                </div>
            </div>
        </form>

        <!-- Table -->
        <div class="row mt-20">
            <div class="col-md-12">
                <div class="card">
                    <div class="table-responsive">
                        <table id="datatable"
                            class="table table-hover table-borderless table-thead-bordered table-nowrap card-table w-100 text-start">
                            <thead class="thead-light text-capitalize">
                                <tr>
                                    <th>SL</th>
                                    <th>Question</th>
                                    <th>Answer</th>
                                    <th>Type</th>
                                    <th>Sub Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($faqs as $key => $faq)
                                    <tr>
                                        <td class="align-content-center">{{ $key + 1 }}</td>
                                        <td class="align-content-center">{{ $faq->question }}</td>
                                        <td class="align-content-center">{{ $faq->answer }}</td>
                                        <td class="align-content-center text-capitalize">{{ $faq->type }}</td>
                                        <td class="align-content-center">{{ $features[$faq->sub_type] ?? $faq->sub_type }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-outline--primary edit-faq"
                                                    data-id="{{ $faq->id }}" data-question="{{ $faq->question }}"
                                                    data-answer="{{ $faq->answer }}" data-type="{{ $faq->type }}"
                                                    data-feature="{{ $faq->sub_type }}">
                                                    <i class="tio-edit"></i> Edit FAQ
                                                </button>
                                                <button class="btn btn-outline-danger delete-faq"
                                                    data-id="{{ $faq->id }}">
                                                    <i class="tio-delete"></i> Delete FAQ
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @if ($faqs->isEmpty())
                                    <tr>
                                        <td colspan="4" class="text-center">No FAQs found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit FAQ Modal -->
    <div class="modal fade" id="editFaqModal" tabindex="-1" aria-labelledby="editFaqLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editfaqform">
                @csrf
                <input type="hidden" id="edit_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editFaqLabel">Edit FAQ</h5>
                        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal">X</button> --}}
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="faq_type" class="title-color">Type</label>
                            <select class="form-control" name="type" id="faq_type" required>
                                <option value="" disabled selected>Select Type</option>
                                <option value="vendor">Vendor</option>
                                <option value="user">User</option>
                            </select>
                        </div>

                        <div class="mb-3" id="feature_selector_wrapper">
                            <label for="faq_feature" class="title-color">Feature</label>
                            <select class="form-control" name="feature" id="faq_feature" required>
                                <option value="" disabled selected>Select Feature</option>
                                {{-- Options will be injected via JS --}}
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Question</label>
                            <input type="text" id="edit_question" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Answer</label>
                            <textarea id="edit_answer" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        const vendorFeatures = @json($vendorFeatures);
        const userFeatures = @json($userFeatures);

        $(document).on('click', '.edit-faq', function() {
            let id = $(this).data('id');
            let question = $(this).data('question');
            let answer = $(this).data('answer');
            let type = $(this).data('type');
            let feature = $(this).data('feature');

            // Prefill basic fields
            $('#edit_id').val(id);
            $('#edit_question').val(question);
            $('#edit_answer').val(answer);

            // Set type dropdown
            $('#faq_type').val(type);

            // Inject feature options based on type
            const featureSelect = $('#faq_feature');
            featureSelect.empty().append('<option value="" disabled>Select Feature</option>');

            let featureOptions = type === 'vendor' ? vendorFeatures : userFeatures;

            $.each(featureOptions, function(key, value) {
                featureSelect.append(`<option value="${key}">${value}</option>`);
            });

            // Show feature selector
            $('#feature_selector_wrapper').show();

            // Set the selected feature
            featureSelect.val(feature);

            // Finally show the modal
            $('#editFaqModal').modal('show');
        });

        // Handle Update Form Submit
        $('#editfaqform').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('admin.crudfaq') }}',
                method: 'POST',
                data: {
                    action: 'update',
                    id: $('#edit_id').val(),
                    question: $('#edit_question').val(),
                    answer: $('#edit_answer').val(),
                    type : $('#faq_type').val(),
                    sub_type : $('#faq_feature').val(),
                    seller: '{{ auth('seller')->id() }}',
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    toastr.success('FAQ updated successfully');
                    location.reload();
                },
                error: function(xhr) {
                    toastr.error('Update failed');
                    console.error(xhr.responseText);
                }
            });
        });

        // Delete FAQ
        $(document).on('click', '.delete-faq', function() {
            if (!confirm('Are you sure you want to delete this FAQ?')) return;
            let id = $(this).data('id');

            $.ajax({
                url: '{{ route('admin.crudfaq') }}',
                method: 'POST',
                data: {
                    action: 'delete',
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    toastr.success('FAQ deleted');
                    location.reload();
                },
                error: function(xhr) {
                    toastr.error('Delete failed');
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
@endpush
