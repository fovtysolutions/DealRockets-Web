<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/multitab1.css') }}" />
<div class="mainpagesection noboxshadow" style="border: 1px solid lightgrey;">
    <div class="tab-containeruno" id="tabs2">
        <div class="tabsuno">
            <div class="tab-linkssuno d-flex flex-row mb-3" style="justify-content: end; padding-bottom:40px;">
                <div class="leadstitle2 active" data-tab="tab-4" style="outline: none;position: absolute;left: 44%;top: 27px;text-transform: uppercase;">
                    Trade shows</div>
                <a href="{{ route('tradeshow') }}" class="top-movers-viewall" style="text-decoration: none;">View All <i style="color:#ED4553;" class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left mr-1 ml-n1 mt-1 float-left' : 'right ml-1 mr-n1'}}"></i></a>
            </div>

            <div class="tab-contentuno active" id="tab-4">
                @include('web-views.partials._tradeshow')
            </div>
        </div>
    </div>
</div>