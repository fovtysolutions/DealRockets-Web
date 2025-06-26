@if ($favourites_array->isEmpty())
    <p>No favourites in this category.</p>
@else
    <div class="row">
        @foreach ($favourites_array as $fav)
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
    </div>
@endif
