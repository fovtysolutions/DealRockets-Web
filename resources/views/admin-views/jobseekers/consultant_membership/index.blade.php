@extends('layouts.back-end.app')

@section('title', translate('List_Vacancies'))

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
                <form method="GET" action="{{ route('admin.jobvacancy.list') }}" class="d-flex">
                    <div class="form-group mx-2">
                        <label for="category" class="form-label">Search Filter</label>
                        <input class="form-control" name="search" id="search" />
                    </div>
                    <div class="form-group mx-2 align-self-end">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-5">
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
                                            <a href="#" class="btn btn-info btn-sm">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
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
@endpush