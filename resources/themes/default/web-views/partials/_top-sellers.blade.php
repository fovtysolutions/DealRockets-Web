    <div class="mainpagesection seller-card custom-dealrock-banner-small" style="background-color: var(--web-bg);">
        <div class="card border-0 h-100">
            <div style="display:block; background-color: var(--web-bg);">
                <div class="row d-flex justify-content-between" style="height: 40px;">
                    <div class="seller-list-title hide-768">
                        <h5 class="m-0 text-capitalize leadstitle2" style="color: black; text-transform:uppercase; font-size: 20px;position: absolute;/* bottom: 1px; */top: 6px;left: 44%;">
                            {{ translate('top_sellers')}}
                        </h5>
                    </div>
                    <div class="title-show-768">
                        <h5 class="m-0 text-capitalize" style="color: black;font-size: 20px;  text-transform:uppercase; position: absolute;/* bottom: 1px; */top: 6px;left: 17px;">
                            {{ translate('Recommended_Suppliers')}}
                        </h5>
                    </div>
                    <div class="seller-list-view-all hide-768">
                        <a class="text-capitalize top-movers-viewall"
                            href="{{ route('vendors', ['filter'=>'top-vendors']) }}">
                            {{ translate('view_all')}}
                            <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left mr-1 ml-n1 mt-1 float-left' : 'right ml-1 mr-n1'}}"></i>
                        </a>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="others-store-slider owl-theme owl-carousel">

                        @foreach ($topVendorsList as $vendorData)
                            <a stlye="text-decoration: none;" href="{{route('shopView',['id'=> $vendorData['id']])}}" class="others-store-card text-capitalize">
                                <div class="overflow-hidden other-store-banner">
                                    <img class="w-100 h-100 object-cover" alt=""
                                         src="{{ getStorageImages(path: $vendorData->banner_full_url, type: 'shop-banner') }}">
                                </div>
                                <div class="name-area">
                                    {{-- <div class="position-relative">
                                        <div class="overflow-hidden other-store-logo rounded-full">
                                            <img class="rounded-full" alt="{{ translate('store') }}"
                                                 src="{{ getStorageImages(path: $vendorData->image_full_url, type: 'shop') }}">
                                        </div>

                                        @if($vendorData->temporary_close)
                                            <span class="temporary-closed position-absolute text-center rounded-full p-2">
                                                <span class="custom-dealrock-text">{{translate('Temporary_OFF')}}</span>
                                            </span>
                                        @elseif($vendorData->vacation_status && ($current_date >= $vendorData->vacation_start_date) && ($current_date <= $vendorData->vacation_end_date))
                                            <span class="temporary-closed position-absolute text-center rounded-full p-2">
                                                <span class="custom-dealrock-text">{{translate('closed_now')}}</span>
                                            </span>
                                        @endif
                                    </div> --}}
                                    <div class="info pt-4">
                                        <div class="d-flex flex-column">
                                            <h5 class="custom-dealrock-text d-flex flex-column" style="color: black; font-weight: 700;">{{ $vendorData->name }}</h5>
                                            <span class="text-truncate" style="font-size:12px; color: #515050;">{{ $vendorData->subtitle }}<span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="fw-bold me-1 text-dark" style="font-size: 12px;
                                                background: #d7d1d1;
                                                padding: 4px;"><i class="tio-star text-star mx-1"></i>{{number_format($vendorData->average_rating,1)}}/5</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="info-area">
                                    <div class="info-item">
                                        <span>{{ translate('Store Views') }}</span>
                                        <h6 style="color: black;">
                                            {{$vendorData->store_views < 1000 ? $vendorData->store_views : number_format($vendorData->store_views/1000 , 1).'K'}}
                                        </h6>
                                    </div>
                                    <div class="info-item">
                                        <span>{{ translate('Total Products') }}</span>
                                        <h6 style="color: black;">
                                            {{$vendorData->products_count < 1000 ? $vendorData->products_count : number_format($vendorData->products_count/1000 , 1).'K'}}
                                        </h6>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
