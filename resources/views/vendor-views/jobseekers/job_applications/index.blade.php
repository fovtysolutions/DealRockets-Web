@extends('layouts.back-end.app-partialseller')

@section('title', translate('List_Jobs'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Filters and Actions -->
        <div class="card mt-4">
            <div class="card-body">
                <h3>Filter</h3>
                <div class="row mb-4 mt-4">
                    <div class="col-md-12 d-flex justify-content-between">
                        <!-- Filter Section -->
                        <div class="filter-section">
                            <form method="GET" action="{{ route('vendor.jobvacancy.job-applications') }}" class="d-flex" id="filterJobApplications-form">
                                <div class="form-group mx-2">
                                    <label for="search" class="form-label">Search</label>
                                    <input class="form-control" name="search" id="search" value="{{ request('search') }}" placeholder="Search by User Name or Job Title" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5 mb-5">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ translate('Job Applications List') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable"
                                class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100 text-start">
                                    <thead class="thead-light thead-50 text-capitalize">
                                        <tr>
                                            <th>ID</th>
                                            <th class="text-center">User Name</th>
                                            <th class="text-center">Job Title</th>
                                            <th class="text-center">Apply Via</th>
                                            <th class="text-center">Created At</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jobapplications as $application)
                                            <tr>
                                                <td>{{ $application->id }}</td>
                                                <td class="text-center">{{ $application->user->name ?? 'N/A' }}</td>
                                                <td class="text-center">{{ $application->job->title ?? 'N/A' }}</td>
                                                <td class="text-center">{{ ucfirst($application->apply_via) }}</td>
                                                <td class="text-center">{{ $application->created_at->format('Y-m-d H:i:s') }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-outline--primary btn-sm square-btn" data-toggle="modal"
                                                        data-target="#viewModal{{ $application->id }}">
                                                        <i class="fa fa-eye"></i> 
                                                    </button>
                                                </td>
                                            </tr>
                                            <!-- Modal -->
                                            <div class="modal fade" id="viewModal{{ $application->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="viewModalLabel{{ $application->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="viewModalLabel{{ $application->id }}">
                                                                Job Application Details</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>User Name:</strong> {{ $application->user->name ?? 'N/A' }}</p>
                                                            <p><strong>Email:</strong> {{ $application->user->email ?? 'N/A' }}</p>
                                                            <p><strong>Job Title:</strong> {{ $application->job->title ?? 'N/A' }}</p>
                                                            <p><strong>Apply Via:</strong> {{ ucfirst($application->apply_via) }}</p>
                                                            <p><strong>Created At:</strong> {{ $application->created_at->format('Y-m-d H:i:s') }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ $jobapplications->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/tags-input.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#filterJobApplications-form').on('submit', function (e) {
                e.preventDefault();
                var search = $('#search').val();
                var url = "{{ route('vendor.jobvacancy.job-applications') }}?search=" + search;
                window.location.href = url;
            });
            $('#search').on('keyup', function (e) {
                if (e.key === 'Enter') {
                    $('#filterJobApplications-form').submit();
                }
            });
            $('#search').on('change', function (e) {
                $('#filterJobApplications-form').submit();
            });
            $('#search').on('input', function (e) {
                if ($(this).val() === '') {
                    $('#filterJobApplications-form').submit();
                }
            });
        });
    </script>
@endpush