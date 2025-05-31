@extends('layouts.back-end.app-partialseller')

@section('title', translate('List_Vacancies'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Filters and Actions -->
        <div class="card mb-4">
            <div class="card-body">
                <h3>Filter</h3>
                <div class="row mb-4 mt-4">
                    <div class="col-md-12 d-flex justify-content-between">
                        <!-- Filter Section -->
                        <div class="filter-section">
                            <form method="GET" action="{{ route('admin.jobvacancy.list') }}" class="d-flex">
                                <!-- Category Filter -->
                                <div class="form-group mx-2">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-control" name="category" id="category">
                                        <option value="">All Categories</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->name }}"
                                                {{ request('category') == $category->name ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Status Filter -->
                                <div class="form-group mx-2">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="">All Statuses</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed
                                        </option>
                                    </select>
                                </div>

                                <!-- Employment Type Filter -->
                                <div class="form-group mx-2">
                                    <label for="employment_type" class="form-label">Employment Type</label>
                                    <select class="form-control" name="employment_type" id="employment_type">
                                        <option value="">All Types</option>
                                        <option value="full-time"
                                            {{ request('employment_type') == 'full-time' ? 'selected' : '' }}>
                                            Full-Time</option>
                                        <option value="part-time"
                                            {{ request('employment_type') == 'part-time' ? 'selected' : '' }}>
                                            Part-Time</option>
                                        <option value="contract"
                                            {{ request('employment_type') == 'contract' ? 'selected' : '' }}>
                                            Contract</option>
                                        <option value="freelance"
                                            {{ request('employment_type') == 'freelance' ? 'selected' : '' }}>
                                            Freelance</option>
                                    </select>
                                </div>

                                <!-- Submit Button -->
                                <div class="form-group mx-2 align-self-end">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </form>
                        </div>

                        <!-- Action Buttons -->
                        {{-- <div class="action-buttons">
                            <a href="{{ route('admin.jobvacancy.create') }}" class="btn btn-success"><i
                                    class="fa fa-plus"></i>
                                Create
                                Vacancy</a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Job Listings -->
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="datatable"
                                class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100 text-start">
                                <thead class="thead-light thead-50 text-capitalize">
                                    <tr>
                                        <th>
                                            #
                                        </th>
                                        <th class="text-capitalize">
                                            <a
                                                href="{{ route('admin.jobvacancy.list', ['sort_by' => 'title', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc', 'category' => request('category'), 'status' => request('status'), 'employment_type' => request('employment_type')]) }}">
                                                Job Title
                                            </a>
                                            @if (request('sort_by') == 'title')
                                                <span
                                                    class="badge badge-info">{{ request('sort_order') == 'asc' ? '▲' : '▼' }}</span>
                                            @endif
                                        </th>
                                        <th class="text-center text-capitalize">
                                            <a
                                                href="{{ route('admin.jobvacancy.list', ['sort_by' => 'company_name', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc', 'category' => request('category'), 'status' => request('status'), 'employment_type' => request('employment_type')]) }}">
                                                Company Name
                                            </a>
                                            @if (request('sort_by') == 'company_name')
                                                <span
                                                    class="badge badge-info">{{ request('sort_order') == 'asc' ? '▲' : '▼' }}</span>
                                            @endif
                                        </th>
                                        <th class="text-center text-capitalize">Status</th>
                                        <th class="text-center text-capitalize">Category</th>
                                        <th class="text-center text-capitalize">Employment Type</th>
                                        <th class="text-center text-capitalize">Approved</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vacancies as $vacancy)
                                        <tr>
                                            <td class="text-center">{{ $vacancy->id }}</td>
                                            <td class="text-center">{{ $vacancy->title }}</td>
                                            <td class="text-center">{{ $vacancy->company_name }}</td>
                                            <td class="text-center">{{ ucfirst($vacancy->status) }}</td>
                                            <td class="text-center">{{ \App\Models\JobCategory::where('id', $vacancy->category)->first()->name }}
                                            </td>
                                            <td class="text-center">{{ ucfirst($vacancy->employment_type) }}</td>
                                            <td class="text-center">
                                                @if ($vacancy->Approved == 1)
                                                    Approved
                                                @elseif($vacancy->Approved == 0)
                                                    Under Review
                                                @elseif($vacancy->Approved == 2)
                                                    Rejected
                                                @else
                                                    Not Available
                                                @endif
                                            </td>
                                            <td class="d-flex flex-row gap-2">
                                                <a href="{{ route('vendor.jobvacancy.show', ['id' => $vacancy->id]) }}"
                                                    class="btn btn-outline-info btn-sm square-btn"><i class="tio-invisible"></i></a>
                                                <a href="{{ route('vendor.jobvacancy.edit', ['id' => $vacancy->id]) }}"
                                                    class="btn btn-outline--primary btn-sm square-btn"><i class="tio-edit"></i></a>
                                                <form action="{{ route('vendor.jobvacancy.destroy', $vacancy->id) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm square-btn delete-data"
                                                        onclick="return confirm('Are you sure you want to delete this job vacancy?');">
                                                        <i class="tio-delete"></i>
                                                    </button>
                                                </form>
                                                {{-- <button type="button" class="btn btn-outline-info btn-sm square-btn" data-toggle="modal"
                                                    data-target="#approvalModal" data-id="{{ $vacancy->id }}"
                                                    data-current-status="{{ $vacancy->approved }}">
                                                    <i class="tio-refresh"></i>
                                                </button> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-end">
                            {{ $vacancies->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Approval Modal -->
    <div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approvalModalLabel">Change Job Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="approvalForm">
                        <div class="form-group">
                            <label for="approvalStatus">Select Status</label>
                            <select class="form-control" id="approvalStatus" name="approvalStatus">
                                <option value="1">Approve</option>
                                <option value="0">Under Review</option>
                                <option value="2">Reject</option>
                            </select>
                        </div>
                        <input type="hidden" id="vacancyId" name="vacancyId">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/tags-input.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/product-add-update.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/product-add-colors-img.js') }}"></script>
    <script>
        // Attach data to the modal when the "Change Status" button is clicked
        $('#approvalModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var vacancyId = button.data('id'); // Extract the vacancy ID
            var currentStatus = button.data('current-status'); // Extract the current status

            var modal = $(this);
            modal.find('#vacancyId').val(vacancyId); // Set vacancy ID in the hidden input
            modal.find('#approvalStatus').val(currentStatus); // Set the current status in the dropdown
        });

        // Handle form submission to update the status
        $('#approvalForm').on('submit', function(e) {
            e.preventDefault();

            var vacancyId = $('#vacancyId').val();
            var approvalStatus = $('#approvalStatus').val();

            $.ajax({
                url: '{{ route('vendor.jobvacancy.update-status') }}', // Define the appropriate route for updating status
                method: 'POST',
                data: {
                    vacancy_id: vacancyId,
                    approved: approvalStatus,
                    _token: '{{ csrf_token() }}', // Ensure CSRF token is included
                },
                success: function(response) {
                    // Close the modal
                    $('#approvalModal').modal('hide');

                    // Optionally, reload the page or update the status in the table row
                    location
                        .reload(); // Reload to reflect the changes (or you can modify the row directly with JS)
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
    </script>
@endpush
