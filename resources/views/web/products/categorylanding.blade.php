@extends('layouts.front-end.app')
@push('css_or_js')
    <link rel="stylesheet" href="{{ asset('assets/custom-css/ai/marketplace-sub.css') }}">
@endpush
@section('title')
    Category Landing Page | {{ $web_config['name']->value }}
@endsection
@section('content')
    <section class="mainpagesection marketplace-sub" style="background: unset; margin-top:20px;">
        <div class="market-price-container" style="background-color: #f7f7f7;">
            <!-- <div class="container bg-white form-con my-4 d-flex" > -->
            <div class="category-section bg-white">
                <div class="category-sidebar">
                    <h3 class="protection-head"><strong>{{ $categories->name }}</strong> </h3>
                    <ul class="ul-desktop">
                        @foreach($categories->childes as $subcategory)
                            <li>
                                <h6><span>{{ $subcategory->name }}</span><i class="bi bi-chevron-right"></i></h6>
                                <div class="d-flex">
                                    @foreach($subcategory->childes as $subsubcategory)
                                        <a href="{{ route('products', ['category_id' => $subsubcategory->id, 'data_from' => 'category', 'page' => 1]) }}">
                                            <p>{{ $subsubcategory->name }}&nbsp;/&nbsp;</p>
                                        </a>
                                    @endforeach
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <p class="gap-1 bg-white a-phone">
                        <a class="Security-btn" data-bs-toggle="collapse" href="#collapseHome" role="button"
                            aria-expanded="false" aria-controls="collapseHome">
                            Home Security
                        </a>
                        <a class="Security-btn" data-bs-toggle="collapse" href="#collapseWorkplace" role="button"
                            aria-expanded="false" aria-controls="collapseWorkplace">
                            Workplace Safety
                        </a>
                        <a class="Security-btn" data-bs-toggle="collapse" href="#collapsePersonal" role="button"
                            aria-expanded="false" aria-controls="collapsePersonal">
                            Personal Safety
                        </a>
                    </p>

                    <div id="accordionExample">
                        <div class="collapse" id="collapseHome" data-bs-parent="#accordionExample">
                            <div class="card card-body">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="cctv">
                                    <label class="form-check-label" for="cctv">CCTV Cameras</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="alarm">
                                    <label class="form-check-label" for="alarm">Alarm Systems</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="lock">
                                    <label class="form-check-label" for="lock">Smart Locks</label>
                                </div>
                            </div>
                        </div>

                        <div class="collapse" id="collapseWorkplace" data-bs-parent="#accordionExample">
                            <div class="card card-body">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="extinguisher">
                                    <label class="form-check-label" for="extinguisher">Fire Extinguishers</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="firstaid">
                                    <label class="form-check-label" for="firstaid">First Aid Kits</label>
                                </div>
                            </div>
                        </div>

                        <div class="collapse" id="collapsePersonal" data-bs-parent="#accordionExample">
                            <div class="card card-body">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="spray">
                                    <label class="form-check-label" for="spray">Pepper Spray</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="alarmPersonal">
                                    <label class="form-check-label" for="alarmPersonal">Personal Alarms</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="category-grid">
                    @foreach($randomSubsubcategories as $product) 
                        <a class="category-card" href="{{ route('products', ['category_id' => $product->id, 'data_from' => 'category', 'page' => 1]) }}">
                            <p>{{ $product->name }}</p>
                            <img src="{{ $product->category_image ? asset('storage/'.$product->category_image) : '/images/placeholderimage.webp' }}" alt="{{ $product->name }}" />
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @include('web-views.partials._order-now')
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $(".hoveronshow").hover(function() {
                // Hide all dropdowns first
                $(".subcategory-dropdown").hide();

                // Show only the hovered subcategory's dropdown
                $(this).find(".subcategory-dropdown").show();
            }, function() {
                // Hide dropdown when not hovering
                $(this).find(".subcategory-dropdown").hide();
            });
        });
    </script>
@endpush
