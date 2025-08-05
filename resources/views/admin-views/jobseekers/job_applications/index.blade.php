@extends('layouts.back-end.app-partial')

@section('title', translate('List_Jobs'))

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
                {{ translate('Job Applications List') }}
                <span class="badge badge-soft-dark radius-50 fz-14 ml-1">{{ $jobapplications->total() ?? count($jobapplications) }}</span>
            </h2>
        </div> -->

        <div class="container-fluid p-0">
            <div class="mb-3">
                <div class="card-body p-0">
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-2 col-sm-4 col-6">
                                <label class="form-label mb-1 small">{{ translate('search') }}</label>
                                <input type="text" name="search" class="form-control form-control-sm" placeholder="{{ translate('search_by_user_name_or_job_title') }}" value="{{ request('search') }}">
                            </div>

                            <div>
                                <a href="{{ route('admin.jobvacancy.job-applications') }}"
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

        <div>
            <div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ translate('Job Applications List') }}</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User Name</th>
                                        <th>Job Title</th>
                                        <th>Apply Via</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jobapplications as $application)
                                        <tr>
                                            <td>{{ $application->id }}</td>
                                            <td>{{ $application->user->name ?? 'N/A' }}</td>
                                            <td>{{ $application->job->title ?? 'N/A' }}</td>
                                            <td>{{ ucfirst($application->apply_via) }}</td>
                                            <td>{{ $application->created_at->format('Y-m-d H:i:s') }}</td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#viewModal{{ $application->id }}">
                                                    <i class="fa fa-eye"></i> View
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
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/product-add-update.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/product-add-colors-img.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#filterJobApplications-form').on('submit', function (e) {
                e.preventDefault();
                var search = $('#search').val();
                var url = "{{ route('admin.jobvacancy.job-applications') }}?search=" + search;
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