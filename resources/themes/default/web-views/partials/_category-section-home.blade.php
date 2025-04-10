@if ($categories->count() > 0 )
<style>
    a:hover .wrgewrgwr{
        color: var(--web-hover) !important;
    }
</style>
    <section class="pb-4 rtl">
        <div class="container" style="padding: 0;">
            <div>
                <div class="card __shadow h-100 max-md-shadow-0" style="box-shadow: none;">
                    <div class="card-body" style="padding: 20px 10px 0px 0px;">
                        <div class="d-flex justify-content-between">
                            <div class="categories-title m-0 w-100" style="text-align: center;">
                                <h5 class="top-movers-title">TOP MOVERS</h5>
                            </div>                            
                            <div class="top-movers-container">
                                <a class="text-capitalize top-movers-viewall"
                                   href="{{route('categories')}}">{{ translate('view_all')}}
                                    <i style="color:#ED4553;" class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left mr-1 ml-n1 mt-1 float-left' : 'right ml-1 mr-n1'}}"></i>
                                </a>
                            </div>
                        </div>
                        {{-- <div class="d-none d-md-block">
                            <div class="row mt-3">
                                @foreach($categories as $key => $category)
                                    @if ($key<10)
                                        <div class="text-center __m-5px __cate-item">
                                            <a href="{{route('products',['category_id'=> $category['id'],'data_from'=>'category','page'=>1])}}">
                                                <div class="__img">
                                                    <img alt="{{ $category->name }}"
                                                         src="{{ getStorageImages(path:$category->icon_full_url, type: 'category') }}">
                                                </div>
                                                <p class="text-center fs-13 mt-2" style="color: var(--web-text);">{{Str::limit($category->name, 12)}}</p>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div> --}}
                        <div class="d-md-block" style="padding-left:10px;">
                            <div class="owl-theme owl-carousel categories--slider mt-3">
                                @foreach($categories as $key => $category)
                                    @if ($key<10)
                                        <div class="text-center m-0 __cate-item w-100">
                                            <a href="{{route('products',['category_id'=> $category['id'],'data_from'=>'category','page'=>1])}}" style="text-decoration: none;">
                                                <div class="__img h-auto" style="width:142px;">
                                                    <img alt="{{ $category->name }}"
                                                         src="{{ getStorageImages(path: $category->icon_full_url, type: 'category') }}">
                                                </div>
                                                <p style="color:black; padding-top:22px;" class="wrgewrgwr">{{Str::limit($category->name, 12)}}</p>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
