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
                <div class="card-title text-center py-4">
                    <h1 class="page-title fw-bold mb-2 animate__animated animate__fadeInDown">
                        Explore our Solutions – <span class="text-dark">{{ $solution->name }}</span>
                    </h1>
                    <p class="page-subtitle text-muted fs-5 animate__animated animate__fadeInUp">
                        Discover tailored services designed for your needs
                    </p>
                </div>

                <div class="card-body" id="categoryGrid">
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
