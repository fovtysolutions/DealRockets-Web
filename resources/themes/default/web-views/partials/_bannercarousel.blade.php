@if(empty($carouselimages))
{{-- No Carousel Images --}}
@else
<div class="bgimages">
    <div id="carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach ($carouselimages as $key => $value)
                <div class="carousel-item  {{ $key == 0 ? 'active' : '' }}">
                    <div class="image-container">
                        <img class="d-block w-100 carousel-image" src="/storage/{{ $value['img_path'] }}" alt="Slide {{ $key + 1 }}">
                      </div>
                    </div>
            @endforeach
        </div>
        @if(count($carouselimages) != 1)
            <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                <span style="font-size: 32px; color: black;"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i></span>
            </a>
            <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                <span style="font-size: 32px; color: black;"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></span>        
            </a>
        @else
            {{-- Show Nothing --}}
        @endif
    </div>
</div>
<script defer>
    $(document).ready(function () {
        // Initialize carousel with auto-slide if needed
        $('#carousel').carousel({
            interval: 5000, // Slide every 3 seconds (optional)
            ride: 'carousel' // Start carousel on page load
        });
    });
</script>
@endif