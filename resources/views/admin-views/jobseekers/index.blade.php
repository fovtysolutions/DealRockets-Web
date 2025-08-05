@extends('layouts.back-end.app-partial')

@section('title', translate('List_Vacancies'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex gap-2">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
                {{ translate('Job_Vacancies_List') }}
                <span class="badge badge-soft-dark radius-50 fz-14 ml-1">{{ $vacancies->total() }}</span>
            </h2>
        </div> -->

        <div class="container-fluid p-0">
            <div class="mb-3">
                <div class="card-body p-0">
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-2 col-sm-4 col-6">
                                <label class="form-label mb-1 small">{{ translate('category') }}</label>
                                <select name="category" class="form-control form-control-sm">
                                    <option value="">{{ translate('all_categories') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->name }}"
                                            {{ request('category') == $category->name ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2 col-sm-4 col-6">
                                <label class="form-label mb-1 small">{{ translate('status') }}</label>
                                <select name="status" class="form-control form-control-sm">
                                    <option value="">{{ translate('all_status') }}</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                                        {{ translate('active') }}
                                    </option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                        {{ translate('inactive') }}
                                    </option>
                                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>
                                        {{ translate('closed') }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-2 col-sm-4 col-6">
                                <label class="form-label mb-1 small">{{ translate('employment_type') }}</label>
                                <select name="employment_type" class="form-control form-control-sm">
                                    <option value="">{{ translate('all_types') }}</option>
                                    <option value="full-time" {{ request('employment_type') == 'full-time' ? 'selected' : '' }}>
                                        {{ translate('full_time') }}
                                    </option>
                                    <option value="part-time" {{ request('employment_type') == 'part-time' ? 'selected' : '' }}>
                                        {{ translate('part_time') }}
                                    </option>
                                    <option value="contract" {{ request('employment_type') == 'contract' ? 'selected' : '' }}>
                                        {{ translate('contract') }}
                                    </option>
                                    <option value="freelance" {{ request('employment_type') == 'freelance' ? 'selected' : '' }}>
                                        {{ translate('freelance') }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-2 col-sm-4 col-6">
                                <label class="form-label mb-1 small">{{ translate('approval_status') }}</label>
                                <select name="approved" class="form-control form-control-sm">
                                    <option value="">{{ translate('all_approval_status') }}</option>
                                    <option value="1" {{ request('approved') == '1' ? 'selected' : '' }}>
                                        {{ translate('approved') }}
                                    </option>
                                    <option value="0" {{ request('approved') == '0' ? 'selected' : '' }}>
                                        {{ translate('under_review') }}
                                    </option>
                                    <option value="2" {{ request('approved') == '2' ? 'selected' : '' }}>
                                        {{ translate('rejected') }}
                                    </option>
                                </select>
                            </div>

                            <div>
                                <a href="{{ route('admin.jobvacancy.list') }}"
                                    class="btn btn--primary w-100" style="height:35px; padding:5px 10px 5px 10px;">
                                    {{ translate('reset') }}
                                </a>
                            </div>
                            <div>
                                <button type="submit" class="btn btn--primary w-100" style="height:35px; padding:5px 10px 5px 10px;">
                                    {{ translate('show_data') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row mt-20">
            <div class="col-md-12">
                <div class="card">
                    <div class="px-3 py-4">
                        <div class="row align-items-center">
                            <div class="col-lg-4">
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group input-group-custom input-group-merge">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="searchValue" class="form-control"
                                            placeholder="{{ translate('search_by_Job_Title') }}"
                                            aria-label="Search jobs" value="{{ request('searchValue') }}">
                                        <input type="hidden" value="{{ request('status') }}" name="status">
                                        <input type="hidden" value="{{ request('category') }}" name="category">
                                        <input type="hidden" value="{{ request('employment_type') }}" name="employment_type">
                                        <input type="hidden" value="{{ request('approved') }}" name="approved">
                                        <button type="submit" class="btn btn--primary">{{ translate('search') }}</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-8 mt-3 mt-lg-0 d-flex flex-wrap gap-3 justify-content-lg-end">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-outline--primary" data-toggle="dropdown">
                                        <i class="tio-download-to"></i>
                                        {{ translate('export') }}
                                        <i class="tio-chevron-down"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <img width="14" src="{{ dynamicAsset(path: 'public/assets/back-end/img/excel.png') }}" alt="">
                                                {{ translate('excel') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <a href="{{ route('admin.jobvacancy.create') }}" class="btn btn--primary">
                                    <i class="tio-add"></i>
                                    <span class="text">{{ translate('add_new_vacancy') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="box-view p-3">

                        <div class="table-responsive">
                            <table id="datatable"
                                style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                class="table table-hover table-borderless table-thead-bordered table-align-middle card-table w-100">
                                <thead class="thead-light thead-50 text-capitalize table-nowrap">
                                    <tr>
                                        <th>
                                            <a
                                                href="{{ route('admin.jobvacancy.list', ['sort_by' => 'title', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc', 'category' => request('category'), 'status' => request('status'), 'employment_type' => request('employment_type')]) }}">
                                                Job Title
                                            </a>
                                            @if (request('sort_by') == 'title')
                                                <span
                                                    class="badge badge-info">{{ request('sort_order') == 'asc' ? '▲' : '▼' }}</span>
                                            @endif
                                        </th>
                                        <th>
                                            <a
                                                href="{{ route('admin.jobvacancy.list', ['sort_by' => 'company_name', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc', 'category' => request('category'), 'status' => request('status'), 'employment_type' => request('employment_type')]) }}">
                                                Company Name
                                            </a>
                                            @if (request('sort_by') == 'company_name')
                                                <span
                                                    class="badge badge-info">{{ request('sort_order') == 'asc' ? '▲' : '▼' }}</span>
                                            @endif
                                        </th>
                                        <th>Status</th>
                                        <th>Category</th>
                                        <th>Employment Type</th>
                                        <th>Approved</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vacancies as $vacancy)
                                        <tr>
                                            <td>{{ $vacancy->title }}</td>
                                            <td>{{ $vacancy->company_name }}</td>
                                            <td>{{ ucfirst($vacancy->status) }}</td>
                                            <td>{{ \App\Models\JobCategory::where('id', $vacancy->category)->first()->name }}
                                            </td>
                                            <td>{{ ucfirst($vacancy->employment_type) }}</td>
                                            <td>
                                                @if($vacancy->Approved == 1)
                                                    Approved
                                                @elseif($vacancy->Approved == 0)
                                                    Under Review
                                                @elseif($vacancy->Approved == 2)
                                                    Rejected
                                                @else
                                                    Not Available
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="" role="group" style="display: flex;gap: 10px;align-items: center;">
                                                    <a href="{{ route('admin.jobvacancy.show', ['id' => $vacancy->id]) }}"
                                                        class="btn btn-outline-info" title="View"><i class="tio-invisible"></i>View</a>
                                                    <a href="{{ route('admin.jobvacancy.edit', ['id' => $vacancy->id]) }}"
                                                        class="btn btn-outline-primary" title="Edit"><i class="tio-edit"></i>Edit</a>
                                                    <form action="{{ route('admin.jobvacancy.destroy', $vacancy->id) }}"
                                                        method="POST" onsubmit="return confirm('Are you sure you want to delete this job vacancy?');" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" title="Delete">Delete
                                                            <i class="tio-delete"></i>
                                                        </button>
                                                    </form>
                                                    <button type="button" class="btn btn-outline-success" data-toggle="modal"
                                                        data-target="#approvalModal" data-id="{{ $vacancy->id }}"
                                                        data-current-status="{{ $vacancy->approved }}" title="Change Status">
                                                        <i class="tio-checkmark-circle-outlined"></i>Status
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="table-responsive mt-4">
                        <div class="px-4 d-flex justify-content-lg-end">
                            {{ $vacancies->links() }}
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
            $('#approvalModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var vacancyId = button.data('id'); // Extract the vacancy ID
                var currentStatus = button.data('current-status'); // Extract the current status

                var modal = $(this);
                modal.find('#vacancyId').val(vacancyId); // Set vacancy ID in the hidden input
                modal.find('#approvalStatus').val(currentStatus); // Set the current status in the dropdown
            });

            // Handle form submission to update the status
            $('#approvalForm').on('submit', function (e) {
                e.preventDefault();

                var vacancyId = $('#vacancyId').val();
                var approvalStatus = $('#approvalStatus').val();

                $.ajax({
                    url: '{{ route("admin.jobvacancy.update-status") }}', // Define the appropriate route for updating status
                    method: 'POST',
                    data: {
                        vacancy_id: vacancyId,
                        approved: approvalStatus,
                        _token: '{{ csrf_token() }}', // Ensure CSRF token is included
                    },
                    success: function (response) {
                        // Close the modal
                        $('#approvalModal').modal('hide');

                        // Optionally, reload the page or update the status in the table row
                        location.reload(); // Reload to reflect the changes (or you can modify the row directly with JS)
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            });
        </script>
    @endpush