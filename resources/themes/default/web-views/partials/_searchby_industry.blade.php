<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/leads.css') }}" />
<div class="mainpagesection d-flex shadow" style="border-radius: 0px;">
    <div class="filter-container">
        <h5 class="filter-header font-weight-bold mb-0" style="/* color: var(--web-text); */">
            Search by Industry
        </h5>
        <div class="filter-description">
            Choose a Industry to filter by. You can select multiple Industry, and they will appear as tags
            below.
        </div>
        <!-- Country Buttons -->
        <div class="country-buttons">
            @foreach ($industries as $key => $value)
                <div class="main-category">
                    <a class="country-button font-weight-bold" href="{{ route('buyer', ['industry' => $value]) }}" style="margin-bottom:10px;">
                        {{ $value['name'] }}
                    </a>
                    @if ($value->childes->count() > 0)
                        <div class="sub-category-list pl-0">
                            @foreach ($value->childes->take(5) as $sub_category)
                                <a class="sub-category-button font-weight-normal" style="margin-bottom: 10px;"
                                    href="{{ route('buyer', ['industry' => $sub_category['id']]) }}">
                                    {{ $sub_category['name'] }}
                                </a>
                                {{-- @if ($sub_category->childes->count() > 0)
                                    <div class="sub-sub-category-list">
                                        @foreach ($sub_category->childes->take(5) as $sub_sub_category)
                                            <a class="sub-sub-category-button font-weight-light"
                                                href="{{ route('buyer', ['industry' => $sub_sub_category['id']]) }}">
                                                {{ $sub_sub_category['name'] }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif --}}
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        <!-- Display selected tags -->
        <div class="selected-tags" id="selectedTags"></div>
    </div>
</div>
