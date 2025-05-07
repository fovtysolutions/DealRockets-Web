@extends('layouts.back-end.app-seller')

@section('title', translate('dashboard'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="row p-5">
        @foreach ($cardData as $card)
            <div class="col-sm-6 col-lg-3 mb-3">
                <a href="{{ $card['link'] }}" class="text-decoration-none w-100 h-100">
                    <div class="card h-100 d-flex flex-column justify-content-center text-center p-4">
                        <h4 class="mb-2">{{ $card['title'] }}</h4>
                        <h2 class="text-primary m-0">{{ $card['value'] }}</h2>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection

@push('script_2')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/apexcharts.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/vendor/dashboard.js') }}"></script>
@endpush
