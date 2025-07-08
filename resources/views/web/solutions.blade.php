@extends('layouts.front-end.app')

@section('title', translate('Solutions' . ' | ' . $web_config['name']->value))

@push('css_or_js')
    <link rel="stylesheet" href="{{ asset('assets/custom-css/ai/solutions.css') }}">
    </link>
@endpush

@section('content')
    <section class="mainpagesection solutions" style="background-color: unset; margin-top: 22px;">
        <main class="main-content">
            <div class="card">
                <div class="card-title text-center position-relative text-white"
                    style="background-image: url('{{ asset('storage/' . $solution->banner) }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">

                    <!-- Subtle black overlay -->
                    <div class="position-absolute top-0 start-0 w-100 h-100"
                        style="background-color: rgba(0, 0, 0, 56%); z-index: 1;"></div>

                    <!-- Text content -->
                    <div class="position-relative"
                        style="z-index: 2;height: 100%;width: 61%;margin: 0 auto;align-content: center;">
                        <h1 class="page-title fw-bold mb-2 animate__animated animate__fadeInDown">
                            Explore our Solutions – <span class="text-light">{{ $solution->name }}</span>
                        </h1>
                        <p class="page-subtitle text-light fs-5 animate__animated animate__fadeInUp"
                            style="font-size: 16px;">
                            {{ $solution->banner_text }}
                        </p>
                    </div>
                </div>


                <div class="card-body" id="categoryGrid">
                    <h4
                        style="font-size: 20px; width:fit-content ;background: linear-gradient(90deg, #FE4E44 0%, #9F0900 100%);-webkit-background-clip: text;-webkit-text-fill-color: transparent;">
                        {{ $solution->name }}
                    </h4>
                    <div class="category-cards">
                        @foreach ($solution->categories as $key => $value)
                            <div class="category-card">
                                <div class="category-header">
                                    <h3 class="category-title">
                                        {{ \App\Models\Category::where('id', $value->name)->first()->name }}</h3>
                                </div>
                                <div class="category-items">
                                    @foreach ($value->subCategories as $key1 => $value1)
                                        <div class="category-item">
                                            <div class="item-left">
                                                <i class="fas fa-chevron-right item-icon"></i>
                                                <span
                                                    class="item-name">{{ \App\Models\Category::where('id', $value1->name)->first()->name }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </main>
    </section>
@endsection

@push('script')
    <script rel="stylesheet" href="{{ asset('js/solutions.js') }}"></script>
@endpush
