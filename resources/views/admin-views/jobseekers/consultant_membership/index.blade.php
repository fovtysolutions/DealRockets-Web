@extends('layouts.back-end.app-partial')

@section('title', translate('List_Job_Consultants'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Filters and Actions -->
        <div class="row mb-4 mt-4">
            <div class="col-md-12 d-flex justify-content-between">
                <!-- Filter Section -->
                <div class="filter-section">
                    <form method="GET" action="{{ route('admin.jobvacancy.list') }}" class="d-flex" id="filterConsultant-form">
                        <div class="form-group mx-2">
                            <label for="category" class="form-label">Search</label>
                            <input class="form-control" name="search" id="search" value="{{ request('search') }}" placeholder="Search by Name" />
                        </div>
                        {{-- <div class="form-group mx-2 align-self-end">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-5 mb-5">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ translate('Consultants List') }}</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Membership</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($consultants as $consultant)
                                        <tr>
                                            <td>{{ $consultant->f_name }} {{ $consultant->l_name }}</td>
                                            <td>{{ $consultant->email }}</td>
                                            <td>{{ $consultant->phone }}</td>
                                            <td>
                                                @if ($consultant->membership != 'none')
                                                    {{ $consultant->membership }}
                                                @else
                                                    No Membership
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#viewModal{{ $consultant->id }}">
                                                    <i class="fa fa-eye"></i> View
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="viewModal{{ $consultant->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="viewModalLabel{{ $consultant->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="viewModalLabel{{ $consultant->id }}">
                                                            Consultant Details</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Name:</strong> {{ $consultant->f_name }}
                                                            {{ $consultant->l_name }}</p>
                                                        <p><strong>Email:</strong> {{ $consultant->email }}</p>
                                                        <p><strong>Phone:</strong> {{ $consultant->phone }}</p>
                                                        <p><strong>Membership:</strong>
                                                            @if ($consultant->membership != 'none')
                                                                {{ $consultant->membership }}
                                                            @else
                                                                No Membership
                                                            @endif
                                                        </p>
                                                        <p><strong>Address:</strong> {{ $consultant->street_address }},
                                                            {{ $consultant->city }}, {{ $consultant->country }}</p>
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
                            {{ $consultants->links() }}
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
            $('#filterConsultant-form').on('submit', function (e) {
                e.preventDefault();
                var search = $('#search').val();
                var url = "{{ route('admin.jobvacancy.consultant-membership') }}?search=" + search;
                window.location.href = url;
            });
            $('#search').on('keyup', function (e) {
                if (e.key === 'Enter') {
                    $('#filterConsultant-form').submit();
                }
            });
            $('#search').on('change', function (e) {
                $('#filterConsultant-form').submit();
            });
            $('#search').on('input', function (e) {
                if ($(this).val() === '') {
                    $('#filterConsultant-form').submit();
                }
            });
        });
    </script>
@endpush