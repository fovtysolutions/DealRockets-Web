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
                        <input type="file" name="banner_{{$slug}}1">
                        <label>Preview</label>
                    </div>
                    <div class="col-lg-12 mb-4">
                        <label>Banner 2</label>
                        <input type="file" name="banner_{{$slug}}2">
                        <label>Preview</label>     
                    </div>
                    <div class="col-lg-12 mb-4">
                        <label>Banner 3</label>
                        <input type="file" name="banner_{{$slug}}3">
                        <label>Preview</label>     
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
