@extends('layouts.back-end.app-partial')

@section('title', translate('Solutions Settings'))

@section('content')
    <div class="content container-fluid">
        <div class="mb-4 pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/system-setting.png') }}" alt="">
                {{ translate('web_Homepage_Setting') }}
            </h2>
        </div>
        @include('admin-views.business-settings.theme-pages.theme-pages-selector')

        <div class="container">

            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center text-white">
                    <h4 class="mb-0">Solutions</h4>
                    <button class="btn btn-light btn-sm" data-toggle="modal" data-target="#createSolutionModal">
                        + Add New Solution
                    </button>
                </div>
                <div class="card-body">
                    @if ($solutions->count())
                        <div class="table-responsive">
                            <table class="table table-bordered text-center align-middle">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Solution Name</th>
                                        <th>Image</th>
                                        <th>Categories</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($solutions as $index => $solution)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $solution->name }}</td>
                                            <td>
                                                @if ($solution->image)
                                                    <img src="{{ asset('storage/' . $solution->image) }}" alt="Solution Image"
                                                        width="60">
                                                @endif
                                            </td>
                                            <td>{{ $solution->categories->count() }} Categories</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-info">View</a>
                                                <!-- Add edit/delete if needed -->
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-muted">No solutions found.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Modal --}}
        <div class="modal fade" id="createSolutionModal" tabindex="-1" aria-labelledby="createSolutionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form action="{{ route('solutions.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createSolutionModalLabel">Add New Solution</h5><button type="button"
                                class="btn btn-sm btn-danger" data-bs-dismiss="modal">
                                &times;
                            </button>
                        </div>

                        <div class="modal-body">
                            {{-- Required Solution Fields --}}
                            <div class="mb-3">
                                <label for="solution_name">Solution Name <span class="text-danger">*</span></label>
                                <input type="text" name="solution_name" id="solution_name" class="form-control" required>
                            </div>

                            <div class="mb-4">
                                <label for="solution_image">Solution Image <span class="text-danger">*</span></label>
                                <input type="file" name="solution_image" id="solution_image" class="form-control"
                                    accept="image/*" required>
                            </div>

                            {{-- Categories Table --}}
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle text-center">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Category Name</th>
                                            <th>Category Image</th>
                                            <th>Sub-Categories</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 0; $i < 10; $i++)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>
                                                    <input type="text" name="categories[{{ $i }}][name]" class="form-control"
                                                        placeholder="Category Name">
                                                </td>
                                                <td>
                                                    <input type="file" name="categories[{{ $i }}][image]" class="form-control"
                                                        accept="image/*">
                                                </td>
                                                <td>
                                                    <table class="table table-sm table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Sub-Category Name</th>
                                                                <th>Sub-Category Image</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @for ($j = 0; $j < 5; $j++)
                                                                <tr>
                                                                    <td>{{ $j + 1 }}</td>
                                                                    <td>
                                                                        <input type="text"
                                                                            name="categories[{{ $i }}][sub_categories][{{ $j }}][name]"
                                                                            class="form-control" placeholder="Sub-Category Name">
                                                                    </td>
                                                                    <td>
                                                                        <input type="file"
                                                                            name="categories[{{ $i }}][sub_categories][{{ $j }}][image]"
                                                                            class="form-control" accept="image/*">
                                                                    </td>
                                                                </tr>
                                                            @endfor
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Save Solution</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#createSolutionForm').on('submit', function (e) {
            e.preventDefault();

            let form = this;
            let formData = new FormData(form);

            $.ajax({
                url: "{{ route('solutions.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    toastr.success(response.message);
                    $('#createSolutionModal').modal('hide');
                    form.reset();
                },
                error: function (xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let errors = xhr.responseJSON.errors;
                        let msg = '';
                        for (const key in errors) {
                            msg += errors[key] + '\n';
                        }
                        alert("Validation failed:\n" + msg);
                    } else {
                        alert("Something went wrong.");
                    }
                }
            });
        });
    </script>
@endsection