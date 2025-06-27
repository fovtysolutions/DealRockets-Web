@php
    $isEdit = isset($stocksell);
@endphp
<div class="progress-form-main">
    <div class="progress-container">
        <div class="step active">
            <div class="step-circle">1</div>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">2</div>
        </div>
    </div>
    <div class="form-header">
        <h1>{{ $isEdit ? 'Edit Stock Sale' : 'Add Stock Sale' }}</h1>
        <p>Fill in the required details to {{ $isEdit ? 'Update' : 'Add' }} Stock Sale</p>
    </div>
    <div class="step-section" data-step="1">
        <div class="form-row">
            <div class="form-group">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $isEdit ? $stocksell->name : '') }}" placeholder="Enter name" required>
            </div>

            <div class="form-group">
                <label for="product_id" class="form-label">Product</label>
                <select id="product" name="product_id" class="form-control" required>
                    <option value="">Select a product</option>
                    @foreach ($items as $key => $value)
                        <option value="{{ $key }}"
                            {{ old('product_id', $isEdit ? $stocksell->product_id : '') == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-single">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control" placeholder="Enter description" rows="1">{{ old('description', $isEdit ? $stocksell->description : '') }}</textarea>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="industry" class="form-label">Category</label>
                <select name="industry" id="industry" class="form-control">
                    <option value="" selected>Select an Industry</option>
                    @foreach ($industry as $ind)
                        <option value="{{ $ind->id }}"
                            {{ old('industry', $isEdit ? $stocksell->industry : '') == $ind->id ? 'selected' : '' }}>
                            {{ $ind->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="sub_category_id" class="title-color">{{ translate('sub_Category') }}</label>
                <select class="form-control action-get-request-onchange" name="sub_category_id" id="sub-category-select"
                    data-url-prefix="{{ route('vendor.products.get-categories') . '?parent_id=' }}"
                    data-element-id="sub-sub-category-select" data-element-type="select">
                    <option value="" disabled {{ !$isEdit ? 'selected' : '' }}>
                        {{ translate('select_Sub_Category') }}
                    </option>
                    @if ($isEdit)
                        <option value="{{ $stocksell->sub_category_id }}" selected>
                            {{ optional($stocksell->subcategory)->name }}
                        </option>
                    @endif
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="product_type" class="form-label">Product Type</label>
                <input type="text" name="product_type" id="product_type" class="form-control"
                    value="{{ old('product_type', $isEdit ? $stocksell->product_type : '') }}"
                    placeholder="Enter Product Type">
            </div>

            <div class="form-group">
                <label for="stock_type" class="form-label">Stock Type</label>
                <select name="stock_type" id="stock_type" class="form-control">
                    <option value="">Select a Category</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('stock_type', $isEdit ? $stocksell->stock_type : '') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="badge" class="form-label">Badge</label>
                <input type="text" name="badge" id="badge" class="form-control"
                    value="{{ old('badge', $isEdit ? $stocksell->badge : '') }}" placeholder="Enter Badge">
            </div>

            <div class="form-group">
                <label for="hs_code" class="form-label">HS Code</label>
                <input type="text" name="hs_code" id="hs_code" class="form-control"
                    value="{{ old('hs_code', $isEdit ? $stocksell->hs_code : '') }}" placeholder="Enter HS Code"
                    required>
            </div>
        </div>
        <button type="button" class="next-btn" data-next="2">Next</button>
    </div>
    <div class="step-section" data-step="2">
        <div class="form-row">
            <div class="form-group">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control"
                    placeholder="Enter quantity" required>
            </div>
            <div class="form-group">
                <label for="unit" class="form-label">Unit</label>
                <input type="text" name="unit" id="unit" class="form-control" placeholder="Enter Unit">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="upper_limit" class="form-label">Upper Limit</label>
                <input type="text" name="upper_limit" id="upper_limit" class="form-control"
                    placeholder="Enter Upper Limit">
            </div>
            <div class="form-group">
                <label for="lower_limit" class="form-label">Lower Limit</label>
                <input type="text" name="lower_limit" id="lower_limit" class="form-control"
                    placeholder="Enter Lower Limit">
            </div>
        </div>
    </div>
</div>
