@extends('layouts.front-end.app')
@section('title', translate('Favorites' . ' | ' . $web_config['name']->value))
@section('content')
    <section class="mainpagesection" style="margin-top: 20px; background-color: unset;">
        <h3 style="color: black;">My Favourites</h3>
        {{-- Tabs --}}
        <ul class="nav nav-tabs" id="favTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" style="color:black;" id="stocksell-tab" data-toggle="tab" href="#stocksell"
                    role="tab">Stock
                    Sell</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" style="color:black;" id="buyleads-tab" data-toggle="tab" href="#buyleads"
                    role="tab">Buy Leads</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" style="color:black;" id="saleoffer-tab" data-toggle="tab" href="#saleoffer"
                    role="tab">Sale
                    Offer</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" style="color:black;" id="products-tab" data-toggle="tab" href="#products"
                    role="tab">Products</a>
            </li>
        </ul>

        {{-- Tab Contents --}}
        <div class="tab-content mt-3" id="favTabsContent">
            {{-- Stock Sell Tab --}}
            <div class="tab-pane fade show active" id="stocksell" role="tabpanel">
                @include('web.partials.favourite', [
                    'items' => $favourites_array->where('type', 'stocksell')->values(),
                    'type' => 'stocksell',
                ])
            </div>

            {{-- Buy Leads Tab --}}
            <div class="tab-pane fade" id="buyleads" role="tabpanel">
                @include('web.partials.favourite', [
                    'items' => $favourites_array->where('type', 'buyleads')->values(),
                    'type' => 'buyleads',
                ])
            </div>

            {{-- Sale Offer Tab --}}
            <div class="tab-pane fade" id="saleoffer" role="tabpanel">
                @include('web.partials.favourite', [
                    'items' => $favourites_array->where('type', 'saleoffer')->values(),
                    'type' => 'saleoffer',
                ])
            </div>

            {{-- Product Tab --}}
            <div class="tab-pane fade" id="products" role="tabpanel">
                @include('web.partials.favourite', [
                    'items' => $favourites_array->where('type', 'product')->values(),
                    'type' => 'saleoffer',
                ])
            </div>
        </div>
    </section>
@endsection
