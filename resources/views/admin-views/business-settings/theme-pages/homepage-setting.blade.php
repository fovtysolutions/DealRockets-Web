@extends('layouts.back-end.app')

@section('title', translate('Website Setting'))

@section('content')
<div class="content container-fluid">
    <div class="mb-4 pb-2">
        <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
            <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/system-setting.png') }}" alt="">
            {{ translate('web_Homepage_Setting') }}
        </h2>
    </div>
    @include('admin-views.business-settings.theme-pages.theme-pages-selector')

    <form action="{{ route('admin.webtheme.genresectionsetting') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @foreach ($homepagesetting as $index => $genre)  <!-- Loop for each genre in data -->
            <div class="genre-section mb-4">
                <h3>Genre {{ $index + 1 }}</h3>
                
                <div class="row"> <!-- Start row for Category Title and Button Text -->
                    <!-- Category Title -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="genres[{{ $index }}][category_title]">Category Title</label>
                            <select name="genres[{{ $index }}][category_title]" class="form-control">
                                <option value="">Select a Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->name }}" 
                                        {{ old('genres['.$index.'][category_title]', $genre['category_title']) == $category->name ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>                        
                    </div>
    
                    <!-- Button Text -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="genres[{{ $index }}][button_text]">Button Text</label>
                            <input type="text" name="genres[{{ $index }}][button_text]" class="form-control" 
                                value="{{ old('genres['.$index.'][button_text]', $genre['button_text']) }}">
                        </div>
                    </div>
                </div> <!-- End row for Category Title and Button Text -->
    
                <!-- Background Image -->
                <div class="form-group">
                    <label for="genres[{{ $index }}][background_image]">Background Image</label>
                    <input type="file" name="genres[{{ $index }}][background_image]" class="form-control">
                    @if ($genre['background_image'])
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $genre['background_image']) }}" class="img-fluid" width="150">
                            <div>
                                <label for="genres[{{ $index }}][keep_background_image]">
                                    <input type="checkbox" name="genres[{{ $index }}][keep_background_image]" value="1" {{ old('genres['.$index.'][keep_background_image]', false) ? 'checked' : '' }}>
                                    Keep Existing Image
                                </label>
                            </div>
                        </div>
                        <!-- Hidden input to track the image deletion -->
                        <input type="hidden" name="delete_genres[{{ $index }}][background_image]" value="0">
                    @endif
                </div>
    
                <!-- Products Section (up to 8 products) -->
                <div class="products-section">
                    <h4>Products (up to 8)</h4>
    
                    @foreach ($genre['products'] as $productIndex => $product)
                        <div class="product-item mb-3">
                            <h5>Product {{ $productIndex + 1 }}</h5>
    
                            <div class="row"> <!-- Start row for Product Name and Image -->
                                <!-- Product Name -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="genres[{{ $index }}][products][{{ $productIndex }}][name]">Product Name</label>
                                        <input type="text" name="genres[{{ $index }}][products][{{ $productIndex }}][name]" class="form-control" 
                                            value="{{ old('genres['.$index.'][products]['.$productIndex.'][name]', $product['name']) }}">
                                    </div>
                                </div>
    
                                <!-- Product Image -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="genres[{{ $index }}][products][{{ $productIndex }}][image]">Product Image</label>
                                        <input type="file" name="genres[{{ $index }}][products][{{ $productIndex }}][image]" class="form-control">
                                        @if ($product['image'])
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $product['image']) }}" class="img-fluid" width="100">
                                                <div>
                                                    <label for="genres[{{ $index }}][products][{{ $productIndex }}][keep_image]">
                                                        <input type="checkbox" name="genres[{{ $index }}][products][{{ $productIndex }}][keep_image]" value="1" {{ old('genres['.$index.'][products]['.$productIndex.'][keep_image]', false) ? 'checked' : '' }}>
                                                        Keep Existing Image
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- Hidden input to track the product image deletion -->
                                            <input type="hidden" name="delete_genres[{{ $index }}][products][{{ $productIndex }}][image]" value="0">
                                        @endif
                                    </div>
                                </div>
                            </div> <!-- End row for Product Name and Image -->
                        </div>
                    @endforeach
                </div>
    
            </div>
        @endforeach
    
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
@endsection
