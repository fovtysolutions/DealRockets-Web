<div>
    <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
        <h2 class="h1 mb-0 d-flex gap-2">
            <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
            {{ translate('Sale Offer Banners') }}
        </h2>
    </div>

    <form class="product-form text-start" action="{{ route('vendor.bannerstore') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <input type="hidden" name="slug" value="{{ $slug }}">

                    @for ($i = 1; $i <= 3; $i++)
                        <div class="col-lg-12 mb-4">
                            <label style="color: var(--title-color);font-size: 14px;font-weight: 700;">Banner {{ $i }}</label><br>
                            <input type="file" class="form-control" name="banner_{{ $slug }}{{ $i }}"
                                accept="image/*"><br>

                            @if (!empty($banner_images) && isset($banner_images[$i - 1]['image_path']))
                                <label>Preview</label>
                                <img src="{{ theme_asset('/storage/' . $banner_images[$i - 1]['image_path']) }}"
                                    alt="banner_image{{ $i }}"
                                    style="height:300px; width:100%; object-fit:contain;">
                            @endif
                        </div>
                    @endfor
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
