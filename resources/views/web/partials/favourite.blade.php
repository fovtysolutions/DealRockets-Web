@if ($items->isEmpty())
    <p>No favourites in this category.</p>
@else
    <div class="row">
        @if($items->count() > 0)
            @foreach ($items as $fav)
                @php
                    if ($type == 'stocksell') {
                        $data = \App\Models\StockSell::where('id', $fav->listing_id)->first();
                        if ($data) {
                            $decodedImage = json_decode($data->image);
                            $image = $decodedImage[0];
                            $name = $data->name;
                            $link = route('stocksale');
                        }
                    } elseif ($type == 'buyleads') {
                        $data = \App\Models\Leads::where('type', 'buyer')->where('id', $fav->listing_id)->first();
                        if ($data) {
                            $decodedImage = json_decode($data->images);
                            $image = $decodedImage[0];
                            $name = $data->name;
                            $link = route('buyer');
                        }
                    } elseif ($type == 'saleoffer') {
                        $data = \App\Models\Leads::where('type', 'seller')->where('id', $fav->listing_id)->first();
                        if ($data) {
                            $decodedImage = json_decode($data->images);
                            $image = $decodedImage[0];
                            $name = $data->name;
                            $link = route('seller');
                        }
                    } else {
                        return;
                    }
                @endphp
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm hover-shadow-lg border-0">
                        <a href="{{ $link }}">
                            <img src="{{ $image }}" class="card-img-top" alt="Listing Image">
                            <div class="card-body">
                                <h5 class="card-title">{{ $name }}</h5>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endif
