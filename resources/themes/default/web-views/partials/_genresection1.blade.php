<?php
$colorat = App\Utils\ChatManager::getimagecolorat('storage/'.$homepagesetting[1]['background_image'], 15, 15);
$text_color = App\Utils\ChatManager::getTextColorBasedOnBackground($colorat);
$getcategoryid = App\Models\Category::where('name',$homepagesetting[1]['category_title'])->first()->id;
?>
<section>
    <div class="sourcenow-sec">
        <div class="sourcemaindiv d-flex">
            <!-- Left Banner Section -->
            <div class="sourcefirstdiv" style="background-image: url('{{ 'storage/'.$homepagesetting[1]['background_image']; }}');">
                <div class="cnt-1">
                    <div class="text-overlay">
                        <h4 class="title custom-dealrock-subhead" style="color:<?php echo $text_color ?> !important;">
                            {{$homepagesetting[1]['category_title']}}
                        </h4>
                        <a class="btn source-btn btn-sm"
                            href="{{ route('products', ['category_id' => $getcategoryid, 'data_from' => 'category', 'page' => 1]) }}">
                            {{$homepagesetting[1]['button_text']}}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Product Grid Section -->
            <div class="sourceseconddiv">
                <div class="prd-grid">
                    <?php
                    // Loop through the products array and display each product
                    for ($i = 0; $i < 8; $i++) {
                    ?>
                        <div class="prd-item">
                            <a style="all: unset; cursor: pointer;" href="{{ route('products', ['searchInput' => $homepagesetting[1]['products'][$i]['name'] ]) }}" class="text-decoration-none">
                                <div class="source-product-item">
                                    <div class="product-name text-left d-flex flex-column justify-content-center">
                                        <p class="custom-dealrock-text">{{ $homepagesetting[1]['products'][$i]['name'] }}</p>
                                    </div>
                                    {{-- <div class="redtriangle"> --}}
                                    <img src="storage/{{ $homepagesetting[1]['products'][$i]['image'] }}" alt="product" class="source-product-img align-self-end" />
                                </div>
                            </a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>