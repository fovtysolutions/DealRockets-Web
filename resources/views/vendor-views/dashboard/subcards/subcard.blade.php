@extends('layouts.back-end.app-seller')

@section('title', translate('dashboard'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <span class="row pt-5 pl-5"><a href="{{ route('vendor.dashboard.index') }}" style="color: black; padding-right:3px;"> Home
        </a> / {{ $title }}</span>

    <div class="p-5">
        <ul class="nav nav-tabs" id="tabMenu" role="tablist">
            @foreach ($cardData as $index => $card)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $index }}-tab"
                        data-toggle="tab" data-target="#tab-{{ $index }}" type="button" role="tab"
                        aria-controls="tab-{{ $index }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                        data-url="{{ $card['ajax_route'] ?? '' }}">
                        {{ $card['title'] }}
                    </button>
                </li>
            @endforeach
        </ul>

        <div class="tab-content pt-4" id="tabContent" style="min-height: 600px;">
            @foreach ($cardData as $index => $card)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="tab-{{ $index }}"
                    role="tabpanel" aria-labelledby="tab-{{ $index }}-tab" style="height: 600px;">
                    @if (!empty($card['ajax_route']))
                        <div class="ajax-content" data-loaded="false" data-url="{{ $card['ajax_route'] }}"
                            style="height: 100%; overflow: auto;">
                            <div class="text-center pt-5">Loading content will appear here...</div>
                        </div>
                    @else
                        <div class="iframe-placeholder" data-loaded="false" data-src="{{ $card['link'] }}"
                            style="width: 100%; height: 100%;">
                            <div class="text-center pt-5">Loading iframe...</div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('script_2')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/apexcharts.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/vendor/dashboard.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tabMenu = document.getElementById('tabMenu');

            tabMenu.querySelectorAll('button').forEach(function(btn) {
                btn.addEventListener('shown.bs.tab', function(event) {
                    var targetId = event.target.getAttribute('data-target');
                    var tabPane = document.querySelector(targetId);

                    // AJAX content handler
                    var ajaxContent = tabPane.querySelector('.ajax-content');
                    if (ajaxContent && ajaxContent.getAttribute('data-loaded') === 'false') {
                        var url = event.target.getAttribute('data-url');
                        if (url && url.length > 0) {
                            // Optional: show global loading indicator
                            fetch(url)
                                .then(response => {
                                    if (!response.ok) throw new Error(
                                        'Network response was not ok');
                                    return response.text();
                                })
                                .then(html => {
                                    ajaxContent.innerHTML = html;
                                    ajaxContent.setAttribute('data-loaded', 'true');
                                })
                                .catch(error => {
                                    ajaxContent.innerHTML =
                                        `<div class="text-danger p-3">Failed to load content: ${error.message}</div>`;
                                });
                        }
                    }

                    // Iframe content handler
                    var iframePlaceholder = tabPane.querySelector('.iframe-placeholder');
                    if (iframePlaceholder && iframePlaceholder.getAttribute('data-loaded') ===
                        'false') {
                        var iframeSrc = iframePlaceholder.getAttribute('data-src');
                        if (iframeSrc && iframeSrc.length > 0) {
                            iframePlaceholder.innerHTML =
                                `<iframe src="${iframeSrc}" style="width: 100%; height: 100%; border: none;" loading="lazy"></iframe>`;
                            iframePlaceholder.setAttribute('data-loaded', 'true');
                        }
                    }
                });
            });

            // Trigger first tab manually
            var firstTabBtn = tabMenu.querySelector('button.nav-link.active');
            if (firstTabBtn) {
                firstTabBtn.dispatchEvent(new Event('shown.bs.tab'));
            }
        });
    </script>
@endpush
