@if($items->isEmpty())
    <p>No favourites in this category.</p>
@else
    <div class="row">
        @foreach($items as $fav)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Listing ID: {{ $fav->listing_id }}</h5>
                        <p>Type: {{ $fav->type }}</p>
                        {{-- Optional link or detail --}}
                        {{-- <a href="#" class="btn btn-primary">View</a> --}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
