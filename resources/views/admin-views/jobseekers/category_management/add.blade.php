@extends('layouts.back-end.app')

@section('title', translate('Job_Category_Add'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="content-wrapper">
        <section class="content-header mt-5">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ translate('Add New Job Category') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.jobvacancy.category.list') }}">{{ translate('Categories') }}</a></li>
                            <li class="breadcrumb-item active">{{ translate('Add Category') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ translate('Create Job Category') }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ route('admin.jobvacancy.category.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">{{ translate('Category Name') }}</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="{{ translate('Enter category name') }}" required>
                            </div>

                            <div class="form-group">
                                <label>{{ translate('Status') }}</label>
                                <select class="form-control" name="active" required>
                                    <option value="1">{{ translate('Active') }}</option>
                                    <option value="0">{{ translate('Inactive') }}</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">{{ translate('Save Category') }}</button>
                                <a href="{{ route('admin.jobvacancy.category.list') }}" class="btn btn-secondary">{{ translate('Back to List') }}</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </section>
    </div>
@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/tags-input.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/product-add-update.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/product-add-colors-img.js') }}"></script>
@endpush
