@extends('layouts.back-end.app-partial')

@section('title', translate('Solutions Settings'))

@push('css_or_js')
    <style>
        .table-row-custom {}
    </style>
@endpush

@section('content')
    <div class="content container-fluid">
        <div class="mb-4 pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/system-setting.png') }}" alt="">
                {{ translate('web_Homepage_Setting') }}
            </h2>
        </div>
        @include('admin-views.business-settings.theme-pages.theme-pages-selector')
        <div class="card">
            <div class="card-body">
                <div class="container">
                    <h3 class="mb-4">Edit Solution</h3>

                    <form action="{{ route('solutions.update', $solution->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Solution Fields --}}
                        <div class="mb-3">
                            <label for="solution_name" class="form-label">Solution Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="solution_name" id="solution_name" class="form-control"
                                value="{{ old('solution_name', $solution->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="solution_image" class="form-label">Solution Image</label>
                            <input type="file" name="solution_image" id="solution_image" class="form-control"
                                accept="image/*">
                            @if ($solution->image)
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $solution->image) }}"
                                        class="text-blue d-block w-100 text-start" target="_blank">View File</a>
                                </div>
                            @endif
                        </div>

                        {{-- Categories Table --}}
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle text-center">
                                <thead class="bg-light" style="z-index: 10; background-color: white;">
                                    <tr>
                                        <th>#</th>
                                        <th>Category Name</th>
                                        <th>Category Image</th>
                                        <th>Sub-Categories</th>
                                    </tr>
                                </thead>
                                <tbody id="category-container">
                                    @foreach ($solution->categories as $i => $category)
                                        <tr class="table-row-custom" id="category-row-{{ $i }}">
                                            <td>{{ $i + 1 }}</td>
                                            <td>
                                                <select name="categories[{{ $i }}][id]" class="form-control"
                                                    data-index="{{ $i }}" required>
                                                    <option value="">-- Select Category --</option>
                                                    @foreach ($categoryList as $catId => $catName)
                                                        <option value="{{ $catId }}"
                                                            {{ $category->name == $catId ? 'selected' : '' }}>
                                                            {{ $catName }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="file" name="categories[{{ $i }}][image]"
                                                    class="form-control" accept="image/*">
                                                @if ($category->image)
                                                    <a href="{{ asset('storage/' . $category->image) }}"
                                                        class="text-blue d-block w-100 text-start mt-2" target="_blank">View
                                                        File</a>
                                                @endif
                                            </td>
                                            <td>
                                                <table class="table table-sm table-bordered mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Sub-Category Name</th>
                                                            <th>Sub-Category Image</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="sub-category-container-{{ $i }}">
                                                        @foreach ($category->subCategories as $j => $sub)
                                                            <tr id="subcat-{{ $i }}-{{ $j }}">
                                                                <td>{{ $j + 1 }}</td>
                                                                <td>
                                                                    <select
                                                                        name="categories[{{ $i }}][sub_categories][{{ $j }}][id]"
                                                                        class="form-control" required>
                                                                        <option value="">-- Select Sub-Category --
                                                                        </option>
                                                                        @foreach ($subCategoryList[$category->name] ?? [] as $subId => $subName)
                                                                            <option value="{{ $subId }}"
                                                                                {{ $sub->name == $subId ? 'selected' : '' }}>
                                                                                {{ $subName }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="file"
                                                                        name="categories[{{ $i }}][sub_categories][{{ $j }}][image]"
                                                                        class="form-control" accept="image/*">
                                                                    @if ($sub->image)
                                                                        <a href="{{ asset('storage/' . $sub->image) }}"
                                                                            class="text-blue d-block w-100 text-start mt-2"
                                                                            target="_blank">View File</a>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="btn btn-danger"
                                                                        onclick="removeSubCategory({{ $i }}, {{ $j }})">&times;</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <button type="button" class="btn btn-outline-primary mt-1"
                                                    style="width: 100%;" onclick="addSubCategory({{ $i }})">+
                                                    Add Sub-Category</button>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger"
                                                    onclick="removeCategory({{ $i }})">&times;</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end mb-4">
                            <button type="button" class="btn btn-primary" onclick="addCategory()">+ Add Category</button>
                        </div>

                        {{-- Submit --}}
                        <div class="text-end">
                            <a href="{{ route('admin.webtheme.solutions') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">Update Solution</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        let categoryNameMap = @json($categoryList);
        let subCategoryNameMap = @json($subCategoryList);

        function getCategoryNameById(id) {
            return categoryNameMap[id] || 'Unknown';
        }

        function getSubCategoryNameById(id) {
            return subCategoryNameMap[id] || 'Unknown';
        }
    </script>
    <script>
        let categoryIndex = 0;

        function addCategory() {
            const categoryOptions = Object.entries(categoryNameMap)
                .map(([id, name]) => `<option value="${id}">${name}</option>`)
                .join('');

            const categoryRow = `
        <tr id="category-row-${categoryIndex}">
            <td>${categoryIndex + 1}</td>
            <td>
                <select name="categories[${categoryIndex}][id]" class="form-control" data-index="${categoryIndex}" required>
                    ${categoryOptions}
                </select>
            </td>
            <td>
                <input type="file" name="categories[${categoryIndex}][image]" class="form-control" accept="image/*" required>
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
                    <tbody id="sub-category-container-${categoryIndex}"></tbody>
                </table>
                <button type="button" class="btn btn-outline-primary mt-1" style="width: 100%;" onclick="addSubCategory(${categoryIndex})">+ Add Sub-Category</button>
            </td>
            <td>
                <button type="button" class="btn btn-danger" onclick="removeCategory(${categoryIndex})">&times;</button>
            </td>
        </tr>
    `;
            document.getElementById('category-container').insertAdjacentHTML('beforeend', categoryRow);
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
                        <input type="file" name="categories[${categoryIndex}][sub_categories][${subIndex}][image]" class="form-control" accept="image/*" required>
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
    </script>
@endsection
