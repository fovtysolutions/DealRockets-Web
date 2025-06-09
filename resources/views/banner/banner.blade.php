@extends('layouts.back-end.app-seller')

@section('title', translate('Vendor Banner Setup'))

@section('content')
    <div class="content container-fluid">
        <h1>{{ ucfirst(str_replace('-', ' ', $slug)) }} Banner Setup</h1>

        @if ($slug == 'marketplace')
            @include('vendor-views.banner.partials.marketplace')
        @elseif ($slug == 'buyleads')
            @include('vendor-views.banner.partials.buyleads')
        @elseif ($slug == 'selloffer')
            @include('vendor-views.banner.partials.selloffer')
        @elseif ($slug == 'tradeshows')
            @include('vendor-views.banner.partials.tradeshows')
        @endif
    </div>
@endsection
