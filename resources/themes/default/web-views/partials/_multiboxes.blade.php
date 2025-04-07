<section class="mainpagesection custom-dealrock-banner-large" style="margin-top: 22px;">
    <h3 class="custom-dealrock-head">Trade Solutions</h3>
    <div class="section-block solutions" faw-module="solution_booth">
        <div class="solution-list">
            @for ($key = 1; $key <= 3; $key++)
                <!-- Adjust this for the number of items in your data -->
                @if (isset($newbaublesdata['image_' . $key]))
                    <div class="solution-item">
                        <div class="item-inr">
                            <a href="{{ $newbaublesdata['link_' . $key] }}" class="solution-banner">
                                <div class="solution-bg">
                                    <div class="solution-bg-img">
                                        <img src="{{ 'storage/' . $newbaublesdata['image_' . $key] }}"
                                            alt="{{ $newbaublesdata['heading_' . $key] }}" loaded="true">
                                    </div>
                                    <div class="solution-mask"></div>
                                </div>
                                <div class="solution-link">
                                    <h3 class="banner-title"
                                        style="color: {{ $newbaublesdata['sub_text_color_' . $key] }}">
                                        {{ $newbaublesdata['heading_' . $key] }}
                                    </h3>
                                    <div class="banner-desc text-truncate"
                                        style="color: {{ $newbaublesdata['sub_text_color_' . $key] }}">
                                        {!! nl2br(e($newbaublesdata['sub_text_' . $key])) !!}
                                    </div>
                                    <div class="banner-arr"></div>
                                    <div class="hoverarrow"></div>
                                </div>
                            </a>

                            <!-- Loop to show 3 baubles -->
                            <div class="solution-baubles">
                                @for ($i = 1; $i <= 4; $i++)
                                    @if (isset($newbaublesdata['bauble_icon_' . $key . '_' . $i]) &&
                                            isset($newbaublesdata['bauble_text_' . $key . '_' . $i]))
                                        <a href="{{ $newbaublesdata['bauble_link_' . $key. '_' . $i] }}" href="" class="bauble-item">
                                            <img src="{{ 'storage/' . $newbaublesdata['bauble_icon_' . $key . '_' . $i] }}"
                                                alt="{{ $newbaublesdata['bauble_text_' . $key . '_' . $i] }}"
                                                loaded="true">
                                            <p class="text-truncate"
                                                style="color: {{ $newbaublesdata['bauble_text_color_' . $key] }}">
                                                {{ $newbaublesdata['bauble_text_' . $key . '_' . $i] }}</p>
                                        </a>
                                    @else
                                        <!-- If bauble icon or text is missing, skip rendering or show default -->
                                        <div class="bauble-item">
                                            <p>Information not available</p>
                                        </div>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                @else
                    <!-- If the main data (image, heading, subtext) is missing, you can skip the entire section or show a fallback -->
                    <div class="solution-item">
                        <p>Solution details are incomplete</p>
                    </div>
                @endif
            @endfor
        </div>
    </div>
</section>
