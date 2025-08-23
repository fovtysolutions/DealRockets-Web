@extends('layouts.back-end.app-partial')

@section('title', translate('Ads Manager'))

@section('content')
<div class="content container-fluid">
    <div class="mb-4 pb-2 d-flex align-items-center gap-2">
        <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
            <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/system-setting.png') }}" alt="">
            {{ translate('Ads Manager') }}
        </h2>
    </div>

    @include('admin-views.business-settings.theme-pages.theme-pages-selector')

    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ translate('Filter Ads') }}</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.webtheme.adsmanager') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">{{ translate('Vendor ID') }}</label>
                    <input type="number" name="vendor_id" class="form-control" value="{{ $filters['vendor_id'] ?? '' }}" placeholder="e.g. 26">
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ translate('From Date') }}</label>
                    <input type="date" name="date_from" class="form-control" value="{{ $filters['date_from'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ translate('To Date') }}</label>
                    <input type="date" name="date_to" class="form-control" value="{{ $filters['date_to'] ?? '' }}">
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn--primary">{{ translate('Apply') }}</button>
                    <a href="{{ route('admin.webtheme.adsmanager') }}" class="btn btn-secondary">{{ translate('Reset') }}</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ translate('Vendor Ads') }}</h5>
            <div class="text-muted small">
                {{ translate('Vendors Shown') }}: {{ $sellers->total() }}
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ translate('Vendor ID') }}</th>
                        <th>{{ translate('Vendor') }}</th>
                        <th>{{ translate('Page') }}</th>
                        <th>{{ translate('Banner') }}</th>
                        <th>{{ translate('Size') }}</th>
                        <th>{{ translate('Preview') }}</th>
                        <th>{{ translate('Status') }}</th>
                        <th>{{ translate('Updated At') }}</th>
                        <th class="text-end">{{ translate('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ads as $idx => $ad)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td>{{ $ad['seller_id'] }}</td>
                            <td>{{ $ad['seller_name'] ?: '—' }}</td>
                            <td><span class="badge bg-info">{{ ucfirst($ad['slug']) }}</span></td>
                            <td>{{ $ad['index'] }}</td>
                            <td>{{ $ad['size'] }}</td>
                            <td>
                                @if(!empty($ad['image_path']))
                                    <img src="{{ asset('storage/' . $ad['image_path']) }}" alt="ad" style="height:50px; width:auto; object-fit:contain;">
                                @else
                                    <span class="text-muted">{{ translate('No Image') }}</span>
                                @endif
                            </td>
                            <td>
                                @if(($ad['active'] ?? 1) == 1)
                                    <span class="badge bg-success">{{ translate('Active') }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ translate('Inactive') }}</span>
                                @endif
                            </td>
                            <td>{{ $ad['updated_at'] }}</td>
                            <td class="text-end">
                                <form method="POST" action="{{ route('admin.webtheme.adsmanager.toggle') }}" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="seller_id" value="{{ $ad['seller_id'] }}">
                                    <input type="hidden" name="slug" value="{{ $ad['slug'] }}">
                                    <input type="hidden" name="index" value="{{ $ad['index'] }}">
                                    <input type="hidden" name="status" value="{{ ($ad['active'] ?? 1) ? 0 : 1 }}">
                                    <button type="submit" class="btn btn-sm {{ ($ad['active'] ?? 1) ? 'btn-danger' : 'btn-success' }}">
                                        {{ ($ad['active'] ?? 1) ? translate('Deactivate') : translate('Activate') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">{{ translate('No ads found for the applied filters.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex justify-content-end">
            {{ $sellers->links() }}
        </div>
    </div>
</div>
@endsection