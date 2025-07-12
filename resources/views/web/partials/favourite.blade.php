@foreach ($items as $fav)
    @php
        $listing = null;
        $link = '#';
        $image = '/images/placeholder.webp';
        $name = 'Unnamed Listing';

        switch ($fav->type) {
            case 'stocksell':
                $listing = \App\Models\StockSell::find($fav->listing_id);
                $link = '/stock-sale?specific_id=' . $fav->listing_id;
                $image = json_decode($listing->image,true)[0] ?? $image;
                $name = $listing->name ?? $name;
                break;

            case 'buyleads':
                $listing = \App\Models\Leads::find($fav->listing_id);
                $link = '/buy-leads?specific_id=' . $fav->listing_id;
                $image = json_decode($listing->images,true)[0] ?? $image;
                $name = $listing->name ?? $name;
                break;

            case 'saleoffer':
                $listing = \App\Models\Leads::find($fav->listing_id);
                $link = '/sell-offer?specific_id=' . $fav->listing_id;
                $image = json_decode($listing->images,true)[0] ?? $image;
                $name = $listing->name ?? $name;
                break;

            case 'product':
                $listing = \App\Models\Product::find($fav->listing_id);
                if ($listing && isset($listing->slug)) {
                    $link = '/product/' . $listing->slug;
                    $image = '/storage/' . $listing->thumbnail ?? $image;
                    $name = $listing->name ?? $name;
                }
                break;
        }
    @endphp

    <div class="col-md-3 mb-3">
        <div class="card" style="border: 1px solid lightgrey; border-radius:0px;">
            <a href="{{ $link }}">
                <img src="{{ $image }}" class="card-img-top" alt="Listing Image">
                <div class="card-body">
                    <h5 class="card-title">{{ $name }}</h5>
                </div>
            </a>
        </div>
    </div>
@endforeach
