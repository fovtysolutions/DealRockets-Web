@extends('layouts.back-end.app-partial')

@section('title', translate('Job_Category_list'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')

    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ translate('Job Categories List') }}</h3>
                        <a href="{{ route('admin.jobvacancy.category.create') }}" class="btn btn-primary btn-sm float-right">
                            {{ translate('Add Category') }}
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ translate('Category Name') }}</th>
                                    <th>{{ translate('Status') }}</th>
                                    <th>{{ translate('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            @if($category->active == 1)
                                                <span class="badge badge-success">{{ translate('Active') }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ translate('Inactive') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#viewCategoryModal" data-category="{{ json_encode($category) }}">
                                                {{ translate('View') }}
                                            </button>
                                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editCategoryModal" data-category="{{ json_encode($category) }}">
                                                {{ translate('Edit') }}
                                            </button>
                                            <form action="{{ route('admin.jobvacancy.category.destroy', $category->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                    {{ translate('Delete') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View Category Modal -->
    <div class="modal fade" id="viewCategoryModal" tabindex="-1" role="dialog" aria-labelledby="viewCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewCategoryModalLabel">{{ translate('View Category') }}</h5>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
                </div>
                <div class="modal-body">
                    <p><strong>{{ translate('Category Name') }}:</strong> <span id="viewCategoryName"></span></p>
                    <p><strong>{{ translate('Status') }}:</strong> <span id="viewCategoryStatus"></span></p>
                    <p><strong>{{ translate('Created At') }}:</strong> <span id="viewCategoryCreatedAt"></span></p>
                    <p><strong>{{ translate('Updated At') }}:</strong> <span id="viewCategoryUpdatedAt"></span></p>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ translate('Close') }}</button>
                </div> -->
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">{{ translate('Edit Category') }}</h5>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
                </div>
                <form action="{{ route('admin.jobvacancy.category.update', ':id') }}" method="POST" id="editCategoryForm">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="category_name">{{ translate('Category Name') }}</label>
                            <input type="text" name="name" id="editCategoryName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>{{ translate('Status') }}</label>
                            <select name="active" id="editCategoryStatus" class="form-control" required>
                                <option value="1">{{ translate('Active') }}</option>
                                <option value="0">{{ translate('Inactive') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ translate('Close') }}</button> -->
                        <button type="submit" class="btn btn-primary">{{ translate('Save Changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        // Populate view modal with category data
        $('#viewCategoryModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var category = button.data('category');
            $('#viewCategoryName').text(category.name);
            $('#viewCategoryStatus').text(category.active == 1 ? '{{ translate('Active') }}' : '{{ translate('Inactive') }}');
            $('#viewCategoryCreatedAt').text(category.created_at);
            $('#viewCategoryUpdatedAt').text(category.updated_at);
        });

        // Populate edit modal with category data
        $('#editCategoryModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var category = button.data('category');
            var actionUrl = $('#editCategoryForm').attr('action').replace(':id', category.id);
            $('#editCategoryForm').attr('action', actionUrl);
            $('#editCategoryName').val(category.name);
            $('#editCategoryStatus').val(category.active);
        });
    </script>
@endpush
