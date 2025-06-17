@extends('layouts.back-end.app-partialseller')

@section('title', translate('product_Preview'))

@section('content')
    <div class="content container-fluid text-start">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-10 mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{ asset('public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
                {{ translate('Product Details') }}
            </h2>
        </div>

        <div class="card card-top-bg-element">
            <div class="card-body row gy-4">
                {{-- Basic Info --}}
                <x-preview-field label="Product ID" :value="$product->id" />
                <x-preview-field label="Name" :value="$product->name" />
                <x-preview-field label="HTS Code" :value="$product->hts_code" />
                <x-preview-field label="Category" :value="\App\Models\Category::where('id', $product->category_id)->first()->name" />
                <x-preview-field label="Sub Category" :value="\App\Models\Category::where('id', $product->sub_category_id)->first()->name" />

                {{-- Images --}}
                <x-preview-field label="Thumbnail">
                    <img src="/storage/{{ $product->thumbnail }}" alt="Thumbnail" style="max-width: 200px;">
                </x-preview-field>

                <x-preview-field label="Extra Images">
                    @foreach (json_decode($product->extra_images, true) ?? [] as $img)
                        <img src="/storage/{{ $img }}" alt="Extra Image" style="max-width: 200px;"
                            class="me-2 mb-2">
                    @endforeach
                </x-preview-field>

                {{-- Product Specs --}}
                <x-preview-field label="Origin" :value="\App\Models\Country::where('id', $product->origin)->first()->name" />
                <x-preview-field label="Minimum Order Qty" :value="$product->minimum_order_qty" />
                <x-preview-field label="Unit" :value="$product->unit" />
                <x-preview-field label="Supply Capacity" :value="$product->supply_capacity" />
                <x-preview-field label="Unit Price" :value="$product->unit_price" />
                <x-preview-field label="Delivery Terms" :value="$product->delivery_terms" />
                <x-preview-field label="Delivery Mode" :value="$product->delivery_mode" />
                <x-preview-field label="Place of Loading" :value="$product->place_of_loading" />
                <x-preview-field label="Port of Loading" :value="$product->port_of_loading" />
                <x-preview-field label="Lead Time" :value="$product->lead_time" />
                <x-preview-field label="Lead Time Unit" :value="$product->lead_time_unit" />
                <x-preview-field label="Payment Terms" :value="$product->payment_terms" />
                <x-preview-field label="Packing Type" :value="$product->packing_type" />
                <x-preview-field label="Weight Per Unit" :value="$product->weight_per_unit" />
                <x-preview-field label="Dimensions Per Unit" :value="$product->dimensions_per_unit" />
                <x-preview-field label="Target Market" :value="implode(', ', json_decode($product->target_market, true) ?? [])" />
                <x-preview-field label="Brand" :value="$product->brand" />

                {{-- Descriptions --}}
                <x-preview-field label="Short Details">{!! $product->short_details !!}</x-preview-field>
                <x-preview-field label="Details">{!! $product->details !!}</x-preview-field>

                {{-- Dynamic Data --}}
                <x-preview-field label="Dynamic Data">
                    @php
                        $dynamicData = json_decode($product->dynamic_data, true);
                    @endphp

                    @if (is_array($dynamicData))
                        @foreach ($dynamicData as $section)
                            <div class="mb-2">
                                <strong>{{ $section['title'] ?? '' }}</strong>
                                @if (!empty($section['sub_heads']))
                                    <ul class="ms-3">
                                        @foreach ($section['sub_heads'] as $sub)
                                            <li>
                                                <strong>{{ $sub['sub_head'] ?? '' }}:</strong>
                                                {{ $sub['sub_head_data'] ?? '-' }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <em>No data available</em>
                    @endif
                </x-preview-field>

                <x-preview-field label="Dynamic Technical Data">
                    @php
                        $technicalData = json_decode($product->dynamic_data_technical, true);
                    @endphp

                    @if (is_array($technicalData))
                        @foreach ($technicalData as $section)
                            <div class="mb-2">
                                <strong>{{ $section['title'] ?? '' }}</strong>
                                @if (!empty($section['sub_heads']))
                                    <ul class="ms-3">
                                        @foreach ($section['sub_heads'] as $sub)
                                            <li>
                                                <strong>{{ $sub['sub_head'] ?? '' }}:</strong>
                                                {{ $sub['sub_head_data'] ?? '-' }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <em>No data available</em>
                    @endif
                </x-preview-field>

                {{-- Certificates --}}
                <x-preview-field label="Certificates">
                    @foreach (json_decode($product->certificates, true) ?? [] as $cert)
                        <a href="/storage/{{ $cert }}" target="_blank">View Certificate</a><br>
                    @endforeach
                </x-preview-field>

                {{-- Metadata --}}
                <x-preview-field label="Created At" :value="$product->created_at" />
                <x-preview-field label="Updated At" :value="$product->updated_at" />
                <x-preview-field label="Local Currency" :value="$product->local_currency" />
                <x-preview-field label="Supply Unit" :value="$product->supply_unit" />
            </div>
        </div>
    </div>
@endsection
