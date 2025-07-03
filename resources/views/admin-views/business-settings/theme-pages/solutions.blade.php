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
                                                    <img src="{{ asset('storage/' . $solution->image) }}"
                                                        alt="Solution Image" width="60">
                                                @endif
                                            </td>
                                            <td>{{ $solution->categories->count() }} Categories</td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm"
                                                    onclick='showSolutionModal(@json($solution->load('categories.subCategories')))'>
                                                    View
                                                </button>
                                                <!-- Edit Button -->
                                                <a href="{{ route('solutions.edit', ['id' => $solution->id]) }}"
                                                    class="btn btn-warning btn-sm">
                                                    Edit
                                                </a>

                                                <!-- Delete Button -->
                                                <form action="{{ route('solutions.destroy', $solution->id) }}"
                                                    method="POST" style="display: inline-block;"
                                                    onsubmit="return confirm('Are you sure you want to delete this solution?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        Delete
                                                    </button>
                                                </form>
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
                            <h5 class="modal-title" id="createSolutionModalLabel">Add New Solution</h5><button
                                type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">
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

                            <div class="mb-4">
                                <label for="solution_image">Solution Banner <span class="text-danger">*</span></label>
                                <input type="file" name="solution_banner" id="solution_banner" class="form-control"
                                    accept="image/*" required>
                            </div>

                            <div class="mb-3">
                                <label for="solution_banner">Solution Banner Text <span class="text-danger">*</span></label>
                                <textarea name="solution_banner_text" id="solution_banner_text" class="form-control" required></textarea>
                            </div>

                            {{-- Categories Table --}}
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle text-center">
                                    <thead style="background-color: white; z-index: 2;">
                                        <tr>
                                            <th>#</th>
                                            <th>Category Name</th>
                                            <th>Category Image</th>
                                            <th>Sub-Categories</th>
                                        </tr>
                                    </thead>
                                    <tbody id="category-container">
                                        <!-- JS will append category rows here -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end mb-3">
                                <button type="button" class="btn btn-primary" onclick="addCategory()">+ Add
                                    Category</button>
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
        <div class="modal fade" id="viewSolutionModal" tabindex="-1" aria-labelledby="viewSolutionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">View Solution</h5>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        {{-- Solution Name --}}
                        <div class="mb-3">
                            <label class="fw-bold">Solution Name:</label>
                            <p class="form-control-plaintext mb-0" id="view_solution_name"></p>
                        </div>

                        {{-- Solution Image --}}
                        <div class="mb-4">
                            <label class="fw-bold">Solution Image:</label><br>
                            <a id="view_solution_image_link" href="" target="_blank">
                                <img id="view_solution_image" src="" alt="Solution Image"
                                    class="img-fluid rounded shadow" style="max-height: 200px;">
                            </a>
                        </div>

                        {{-- Categories --}}
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle text-center">
                                <thead class="bg-light" style="background-color: white; z-index: 2;">
                                    <tr>
                                        <th>#</th>
                                        <th>Category Name</th>
                                        <th>Category Image</th>
                                        <th>Sub-Categories</th>
                                    </tr>
                                </thead>
                                <tbody id="view_category_container">
                                    <!-- JS will inject category rows here -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let categoryNameMap = @json($categories);
        console.log(categoryNameMap);

        function getCategoryNameById(id) {
            return categoryNameMap[id] || 'Unknown';
        }

        function showSolutionModal(solution) {
            // Fill name & image
            document.getElementById('view_solution_name').textContent = solution.name;
            document.getElementById('view_solution_image_link').href = '/storage/' + solution.image;
            document.getElementById('view_solution_image').src = '/storage/' + solution.image;

            // Clear old categories
            const container = document.getElementById('view_category_container');
            container.innerHTML = '';

            solution.categories.forEach((category, index) => {
                const subRows = category.sub_categories?.map((sub, subIndex) => {
                    return `
                <tr>
                    <td>${subIndex + 1}</td>
                    <td>${getCategoryNameById(sub.name) ?? '-'}</td>
                    <td>${sub.image ? `<a href="/storage/${sub.image}" target="_blank"><img src="/storage/${sub.image}" alt="Cat" style="height:50px;"></a>` : '-'}</td>
                </tr>`;
                }).join('') || '<tr><td colspan="3">No sub-categories</td></tr>';

                const row = `
            <tr>
                <td>${index + 1}</td>
                <td>${getCategoryNameById(category.name) ?? '-'}</td>
                <td>${category.image ? `<a href="/storage/${category.image}" target="_blank"><img src="/storage/${category.image}" alt="Cat" style="height:50px;"></a>` : '-'}</td>
                <td>
                    <table class="table table-sm table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Sub-Category Name</th>
                                <th>Sub-Category Image</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${subRows}
                        </tbody>
                    </table>
                </td>
            </tr>`;
                container.insertAdjacentHTML('beforeend', row);
            });

            new bootstrap.Modal(document.getElementById('viewSolutionModal')).show();
        }
    </script>
    <script>
        let categoryIndex = 0;

        function addCategory() {
            const categoryRow = `
        <tr id="category-row-${categoryIndex}">
            <td>${categoryIndex + 1}</td>
            <td>
                <select name="categories[${categoryIndex}][id]" class="form-control category-select" data-index="${categoryIndex}" required>
                    <option value="">-- Select Category --</option>
                    <!-- Options will be populated dynamically or server-rendered -->
                </select>
            </td>
            <td>
                <input type="file" name="categories[${categoryIndex}][image]" class="form-control" accept="image/*">
            </td>
            <td>
                <table class="table table-sm table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Sub-Category Name</th>
                            <th>Sub-Category Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="sub-category-container-${categoryIndex}">
                        <!-- AJAX will insert sub-categories -->
                    </tbody>
                </table>
                <button type="button" class="btn btn-outline-primary mt-1" style="width: 100%;" onclick="addSubCategory(${categoryIndex})">+ Add Sub-Category</button>
            </td>
            <td>
                <button type="button" class="btn btn-danger" onclick="removeCategory(${categoryIndex})">&times;</button>
            </td>
        </tr>
    `;
            document.getElementById('category-container').insertAdjacentHTML('beforeend', categoryRow);
            loadCategoryOptions(categoryIndex); // dynamically populate the dropdown
            categoryIndex++;
        }


        function removeCategory(index) {
            const row = document.getElementById(`category-row-${index}`);
            if (row) row.remove();
        }

        function addSubCategory(categoryIndex) {
            const select = document.querySelector(`select[data-index="${categoryIndex}"]`);
            const selectedCategoryId = select.value;

            if (!selectedCategoryId) {
                alert("Please select a category first.");
                return;
            }

            fetch(`/get-subcategories-by-categories/${selectedCategoryId}`)
                .then(response => response.json())
                .then(subcategories => {
                    const container = document.getElementById(`sub-category-container-${categoryIndex}`);
                    const subIndex = container.children.length;

                    const options = subcategories.map(sub =>
                        `<option value="${sub.id}">${sub.name}</option>`
                    ).join('');

                    const row = `
                <tr id="subcat-${categoryIndex}-${subIndex}">
                    <td>${subIndex + 1}</td>
                    <td>
                        <select name="categories[${categoryIndex}][sub_categories][${subIndex}][id]" class="form-control" required>
                            <option value="">-- Select Sub-Category --</option>
                            ${options}
                        </select>
                    </td>
                    <td>
                        <input type="file" name="categories[${categoryIndex}][sub_categories][${subIndex}][image]" class="form-control" accept="image/*">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger" onclick="removeSubCategory(${categoryIndex}, ${subIndex})">&times;</button>
                    </td>
                </tr>
            `;

                    container.insertAdjacentHTML('beforeend', row);
                });
        }


        function removeSubCategory(categoryIndex, subIndex) {
            const row = document.getElementById(`subcat-${categoryIndex}-${subIndex}`);
            if (row) row.remove();
        }

        function loadCategoryOptions(index) {
            fetch('/get-categories') // replace with your route
                .then(response => response.json())
                .then(data => {
                    const select = document.querySelector(`select[data-index="${index}"]`);
                    data.forEach(cat => {
                        const option = document.createElement('option');
                        option.value = cat.id;
                        option.text = cat.name;
                        select.appendChild(option);
                    });
                });
        }
    </script>
    <script>
        $('#createSolutionForm').on('submit', function(e) {
            e.preventDefault();

            let form = this;
            let formData = new FormData(form);

            $.ajax({
                url: "{{ route('solutions.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    toastr.success(response.message);
                    $('#createSolutionModal').modal('hide');
                    form.reset();
                },
                error: function(xhr) {
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
