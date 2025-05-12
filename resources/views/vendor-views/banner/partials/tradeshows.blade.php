<div class="content container-fluid">
    <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
        <h2 class="h1 mb-0 d-flex gap-2">
            <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
            {{ translate('Add Banners') }}
        </h2>
    </div>

    <form class="product-form text-start" action="{{ route('vendor.bannerstore') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <input type="hidden" name="slug" value="{{ $slug }}">
                    <div class="col-lg-12 mb-4">
                        <label>Banner 1</label>
                        <input type="file" name="banner_{{$slug}}1" accept="image/*"><br>
                        @if(!empty($banner_images))
                            <label>Preview</label>
                            <img src="{{ theme_asset('/storage/' . $banner_images[0]['image_path']) }}" alt="banner_image1" style="height:300px; width: 100%;">
                        @endif
                    </div>
                    <div class="col-lg-12 mb-4">
                        <label>Banner 2</label>
                        <input type="file" name="banner_{{$slug}}2" accept="image/*"><br>
                        @if(!empty($banner_images))
                            <label>Preview</label>
                            <img src="{{ theme_asset('/storage/' . $banner_images[1]['image_path']) }}" alt="banner_image2" style="height:300px; width: 100%;">
                        @endif
                    </div>
                    <div class="col-lg-12 mb-4">
                        <label>Banner 3</label>
                        <input type="file" name="banner_{{$slug}}3" accept="image/*"><br>
                        @if(!empty($banner_images))
                            <label>Preview</label>
                            <img src="{{ theme_asset('/storage/' . $banner_images[2]['image_path']) }}" alt="banner_image3" style="height:300px; width: 100%;">
                        @endif     
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-end gap-3 mt-3 mx-1">
            <button type="reset" class="btn btn-secondary px-5">{{ translate('reset') }}</button>
            <button type="submit" class="btn btn--primary px-5">
                {{ translate('submit') }}
            </button>
        </div>
    </form>
</div>
