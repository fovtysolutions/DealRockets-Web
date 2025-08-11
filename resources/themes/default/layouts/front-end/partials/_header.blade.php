@php($announcement = getWebConfig(name: 'announcement'))
<link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/custom-css/ai/header.css') }}" />
{{-- Start Content --}}
@if (isset($announcement) && $announcement['status'] == 1)
    <div class="text-center position-relative px-4 py-1" id="announcement"
        style="background-color: {{ $announcement['color'] }}; color: {{ $announcement['text_color'] }};">
        <span>{{ $announcement['announcement'] }} </span>
        <span class="__close-announcement web-announcement-slideUp">X</span>
    </div>
@endif
<?php
$unread = App\Utils\ChatManager::unread_messages();
$userId = Auth::guard('customer')->user() ? Auth::guard('customer')->id() : 0;
$role = App\Models\User::where('id', $userId)->first();
$is_jobadder = $role['typerole'] === 'findtalent' ? true : false;
        $role = \App\Utils\HelperUtil::getLoggedInRole();

?>
<p style="height: 124px; visiblity: none;">
    Hidden height From Top
</p>
<div class="element-mobile header-wrapper navbar-sticky navbar-floating navbar-dark">
    <div class="navbar-wrapper">
        <div class="navbar-2">
            <div class="group-14">
                <div class="overlap-group-3">
                    <div class="contentgroup deltwelve">
                        <div class="group-15">
                            <div class="group-2">
                                <a class="text-wrapper" href="{{ route('categories') }}">All Categories</a>
                                <img class="options-lines" src="/img/options-lines-1.png" />
                            </div>
                        </div>
                        <div class="navbar-3">
                            <a class="nav-tile deleight" href="{{ route('home') }}" data-menu="/" data-home="true">
                                <img class="badge img-default" src="/img/home.svg" />
                                <img class="badge img-hover" src="/img/home-hover.svg" />
                                <span class="nav-label">Home</span>
                            </a>
                            <a class="nav-tile delseven" href="{{ route('stocksale') }}" data-menu="/stock-sale">
                                <img class="badge img-default" src="/img/stocksale.svg" />
                                <img class="badge img-hover" src="/img/stocksale-hover.svg" />
                                <span class="nav-label">Stock Sale</span>
                            </a>
                            <a class="nav-tile delsix" href="{{ route('buyer') }}" data-menu="/buy-leads">
                                <img class="badge img-default" src="/img/lead.svg" style="padding-left: 12px;" />
                                <img class="badge img-hover" src="/img/lead-hover.svg" style="padding-left: 12px;" />
                                <span class="nav-label">Buy Leads</span>
                            </a>
                            <a class="nav-tile deleight" href="/products?searchInput=" data-menu="/" data-home="true">
                                <img class="badge img-default" src="/img/shop.svg" />
                                <img class="badge img-hover" src="/img/shop.svg" />
                                <span class="nav-label">Marketplace</span>
                            </a>
                            <a class="nav-tile delfive" href="{{ route('seller') }}" data-menu="/sell-offer">
                                <img class="badge img-default" src="/img/saleoffer.svg" />
                                <img class="badge img-hover" src="/img/saleoffer-hover.svg" />
                                <span class="nav-label">Sell Offer</span>
                            </a>
                            <a class="nav-tile delfour" href="{{ route('dealassist') }}" data-menu="/deal-assist">
                                <img class="badge img-default" src="/img/dealassist.svg" />
                                <img class="badge img-hover" src="/img/dealassist-hover.svg" />
                                <span class="nav-label">Deal Assist</span>
                            </a>
                            <a class="nav-tile delone" href="{{ route('sendcv') }}" data-menu="/industry-jobs">
                                <img class="badge img-default" src="/img/industryjobs.svg" />
                                <img class="badge img-hover" src="/img/industryjobs-hover.svg" />
                                <span class="nav-label">Industry Jobs</span>
                            </a>
                            {{-- <div class="frame-2 deltwo">
                                <a class="nav-tile" href="{{ route('tradeshow') }}" data-menu="/tradeshow">
                                    <img class="badge img-default" src="/img/trade-shows.png" />
                                    <img class="badge img-hover" src="/img/trade-shows-hover.png" />
                                    <span class="nav-label">Trade Shows</span>
                                </a>
                            </div> --}}
                            {{-- <div class="frame-2 delthree">
                                <a class="nav-tile" href="{{ route('vendor.auth.registration.index') }}"
                                    data-menu="/vendorzone">
                                    <img class="badge img-default" src="/img/supplier-zone.png" />
                                    <img class="badge img-hover" src="/img/supplier-zone-hover.png" />
                                    <span class="nav-label">Supplier Zone</span>
                                </a>
                            </div> --}}
                        </div>
                        <div class="frame-6 delnine">
                            <a href="{{ route('webinfo') }}">
                                <div class="nav-tile">
                                    <img class="badge img-default" src="/img/badge-1.png" />
                                    <img class="badge img-hover" src="/img/badge (2).png" />
                                    <div class="text-wrapper-4">Features</div>
                                </div>
                            </a>
                            <div class="group-12">
                                <a href="{{ route('chat', ['type' => 'vendor']) }}" class="nav-tile">
                                    <img class="badge img-default" src="/img/chatting-1.png" />
                                    <img class="badge img-hover" src="/img/chatting (2).png" />
                                    <div class="text-wrapper-10">Message</div>
                                    @if (auth('customer')->check() && isset($unread))
                                        <span class="unread-badge">{{ $unread }}</span>
                                    @endif
                                </a>
                            </div>
                            <div class="group-3">
                                <a href="{{ route('helpTopic') }}" target="_blank" class="nav-tile">
                                    <div class="frame-4">
                                        <div class="text-wrapper-5">Help</div>
                                        {{-- <img class="img" src="/img/arrow-down-sign-to-navigate-4.png" /> --}}
                                    </div>
                                    <div class="icon-hover group-help">
                                        <img class="badge img-default" src="/img/question-1.png" />
                                        <img class="badge img-hover" src="/img/help-web-button.png" />
                                    </div>
                                </a>
                            </div>

                            @include('themes.default.layouts.front-end.partials._libre-translate-button')
                                    <div class="dropdown-header">
                                        <div class="search-container">
                                            <i class="fas fa-search"></i>
                                            <input type="text" id="languageSearch" placeholder="Search languages..." />
                                        </div>
                                        <div class="translate-info">
                                            <i class="fas fa-globe"></i>
                                            <span>Powered by LibreTranslate</span>
                                        </div>
                                    </div>
                                    
                                    <div class="language-sections">
                                        <!-- Popular Languages -->
                                        <div class="language-section">
                                            <h6 class="section-title">
                                                <i class="fas fa-star"></i> Popular Languages
                                            </h6>
                                            <div class="language-grid popular-languages">
                                                <div class="language-item" data-code="en" data-name="English">
                                                    <span class="flag">🇺🇸</span>
                                                    <span class="name">English</span>
                                                </div>
                                                <div class="language-item" data-code="es" data-name="Spanish">
                                                    <span class="flag">🇪🇸</span>
                                                    <span class="name">Spanish</span>
                                                </div>
                                                <div class="language-item" data-code="fr" data-name="French">
                                                    <span class="flag">🇫🇷</span>
                                                    <span class="name">French</span>
                                                </div>
                                                <div class="language-item" data-code="de" data-name="German">
                                                    <span class="flag">🇩🇪</span>
                                                    <span class="name">German</span>
                                                </div>
                                                <div class="language-item" data-code="zh" data-name="Chinese">
                                                    <span class="flag">🇨🇳</span>
                                                    <span class="name">Chinese</span>
                                                </div>
                                                <div class="language-item" data-code="ja" data-name="Japanese">
                                                    <span class="flag">🇯🇵</span>
                                                    <span class="name">Japanese</span>
                                                </div>
                                                <div class="language-item" data-code="ko" data-name="Korean">
                                                    <span class="flag">🇰🇷</span>
                                                    <span class="name">Korean</span>
                                                </div>
                                                <div class="language-item" data-code="ar" data-name="Arabic">
                                                    <span class="flag">🇸🇦</span>
                                                    <span class="name">Arabic</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- All Languages -->
                                        <div class="language-section">
                                            <h6 class="section-title">
                                                <i class="fas fa-globe-americas"></i> All Languages
                                            </h6>
                                            <div class="language-list" id="allLanguagesList">
                                                <!-- A-C -->
                                                <div class="language-item" data-code="af" data-name="Afrikaans">
                                                    <span class="flag">🇿🇦</span>
                                                    <span class="name">Afrikaans</span>
                                                </div>
                                                <div class="language-item" data-code="sq" data-name="Albanian">
                                                    <span class="flag">🇦🇱</span>
                                                    <span class="name">Albanian</span>
                                                </div>
                                                <div class="language-item" data-code="am" data-name="Amharic">
                                                    <span class="flag">🇪🇹</span>
                                                    <span class="name">Amharic</span>
                                                </div>
                                                <div class="language-item" data-code="ar" data-name="Arabic">
                                                    <span class="flag">🇸🇦</span>
                                                    <span class="name">Arabic</span>
                                                </div>
                                                <div class="language-item" data-code="hy" data-name="Armenian">
                                                    <span class="flag">🇦🇲</span>
                                                    <span class="name">Armenian</span>
                                                </div>
                                                <div class="language-item" data-code="az" data-name="Azerbaijani">
                                                    <span class="flag">🇦🇿</span>
                                                    <span class="name">Azerbaijani</span>
                                                </div>
                                                <div class="language-item" data-code="eu" data-name="Basque">
                                                    <span class="flag">🇪🇸</span>
                                                    <span class="name">Basque</span>
                                                </div>
                                                <div class="language-item" data-code="be" data-name="Belarusian">
                                                    <span class="flag">🇧🇾</span>
                                                    <span class="name">Belarusian</span>
                                                </div>
                                                <div class="language-item" data-code="bn" data-name="Bengali">
                                                    <span class="flag">🇧🇩</span>
                                                    <span class="name">Bengali</span>
                                                </div>
                                                <div class="language-item" data-code="bs" data-name="Bosnian">
                                                    <span class="flag">🇧🇦</span>
                                                    <span class="name">Bosnian</span>
                                                </div>
                                                <div class="language-item" data-code="bg" data-name="Bulgarian">
                                                    <span class="flag">🇧🇬</span>
                                                    <span class="name">Bulgarian</span>
                                                </div>
                                                <div class="language-item" data-code="ca" data-name="Catalan">
                                                    <span class="flag">🇪🇸</span>
                                                    <span class="name">Catalan</span>
                                                </div>
                                                <div class="language-item" data-code="ceb" data-name="Cebuano">
                                                    <span class="flag">🇵🇭</span>
                                                    <span class="name">Cebuano</span>
                                                </div>
                                                <div class="language-item" data-code="zh" data-name="Chinese">
                                                    <span class="flag">🇨🇳</span>
                                                    <span class="name">Chinese</span>
                                                </div>
                                                <div class="language-item" data-code="co" data-name="Corsican">
                                                    <span class="flag">🇫🇷</span>
                                                    <span class="name">Corsican</span>
                                                </div>
                                                <div class="language-item" data-code="hr" data-name="Croatian">
                                                    <span class="flag">🇭🇷</span>
                                                    <span class="name">Croatian</span>
                                                </div>
                                                <div class="language-item" data-code="cs" data-name="Czech">
                                                    <span class="flag">🇨🇿</span>
                                                    <span class="name">Czech</span>
                                                </div>
                                                
                                                <!-- D-H -->
                                                <div class="language-item" data-code="da" data-name="Danish">
                                                    <span class="flag">🇩🇰</span>
                                                    <span class="name">Danish</span>
                                                </div>
                                                <div class="language-item" data-code="nl" data-name="Dutch">
                                                    <span class="flag">🇳🇱</span>
                                                    <span class="name">Dutch</span>
                                                </div>
                                                <div class="language-item" data-code="en" data-name="English">
                                                    <span class="flag">🇺🇸</span>
                                                    <span class="name">English</span>
                                                </div>
                                                <div class="language-item" data-code="eo" data-name="Esperanto">
                                                    <span class="flag">🌍</span>
                                                    <span class="name">Esperanto</span>
                                                </div>
                                                <div class="language-item" data-code="et" data-name="Estonian">
                                                    <span class="flag">🇪🇪</span>
                                                    <span class="name">Estonian</span>
                                                </div>
                                                <div class="language-item" data-code="fi" data-name="Finnish">
                                                    <span class="flag">🇫🇮</span>
                                                    <span class="name">Finnish</span>
                                                </div>
                                                <div class="language-item" data-code="fr" data-name="French">
                                                    <span class="flag">🇫🇷</span>
                                                    <span class="name">French</span>
                                                </div>
                                                <div class="language-item" data-code="fy" data-name="Frisian">
                                                    <span class="flag">🇳🇱</span>
                                                    <span class="name">Frisian</span>
                                                </div>
                                                <div class="language-item" data-code="gl" data-name="Galician">
                                                    <span class="flag">🇪🇸</span>
                                                    <span class="name">Galician</span>
                                                </div>
                                                <div class="language-item" data-code="ka" data-name="Georgian">
                                                    <span class="flag">🇬🇪</span>
                                                    <span class="name">Georgian</span>
                                                </div>
                                                <div class="language-item" data-code="de" data-name="German">
                                                    <span class="flag">🇩🇪</span>
                                                    <span class="name">German</span>
                                                </div>
                                                <div class="language-item" data-code="el" data-name="Greek">
                                                    <span class="flag">🇬🇷</span>
                                                    <span class="name">Greek</span>
                                                </div>
                                                <div class="language-item" data-code="gu" data-name="Gujarati">
                                                    <span class="flag">🇮🇳</span>
                                                    <span class="name">Gujarati</span>
                                                </div>
                                                <div class="language-item" data-code="ht" data-name="Haitian Creole">
                                                    <span class="flag">🇭🇹</span>
                                                    <span class="name">Haitian Creole</span>
                                                </div>
                                                <div class="language-item" data-code="ha" data-name="Hausa">
                                                    <span class="flag">🇳🇬</span>
                                                    <span class="name">Hausa</span>
                                                </div>
                                                <div class="language-item" data-code="haw" data-name="Hawaiian">
                                                    <span class="flag">🇺🇸</span>
                                                    <span class="name">Hawaiian</span>
                                                </div>
                                                <div class="language-item" data-code="he" data-name="Hebrew">
                                                    <span class="flag">🇮🇱</span>
                                                    <span class="name">Hebrew</span>
                                                </div>
                                                <div class="language-item" data-code="hi" data-name="Hindi">
                                                    <span class="flag">🇮🇳</span>
                                                    <span class="name">Hindi</span>
                                                </div>
                                                <div class="language-item" data-code="hmn" data-name="Hmong">
                                                    <span class="flag">🇱🇦</span>
                                                    <span class="name">Hmong</span>
                                                </div>
                                                <div class="language-item" data-code="hu" data-name="Hungarian">
                                                    <span class="flag">🇭🇺</span>
                                                    <span class="name">Hungarian</span>
                                                </div>
                                                
                                                <!-- I-M -->
                                                <div class="language-item" data-code="is" data-name="Icelandic">
                                                    <span class="flag">🇮🇸</span>
                                                    <span class="name">Icelandic</span>
                                                </div>
                                                <div class="language-item" data-code="ig" data-name="Igbo">
                                                    <span class="flag">🇳🇬</span>
                                                    <span class="name">Igbo</span>
                                                </div>
                                                <div class="language-item" data-code="id" data-name="Indonesian">
                                                    <span class="flag">🇮🇩</span>
                                                    <span class="name">Indonesian</span>
                                                </div>
                                                <div class="language-item" data-code="ga" data-name="Irish">
                                                    <span class="flag">🇮🇪</span>
                                                    <span class="name">Irish</span>
                                                </div>
                                                <div class="language-item" data-code="it" data-name="Italian">
                                                    <span class="flag">🇮🇹</span>
                                                    <span class="name">Italian</span>
                                                </div>
                                                <div class="language-item" data-code="ja" data-name="Japanese">
                                                    <span class="flag">🇯🇵</span>
                                                    <span class="name">Japanese</span>
                                                </div>
                                                <div class="language-item" data-code="jv" data-name="Javanese">
                                                    <span class="flag">🇮🇩</span>
                                                    <span class="name">Javanese</span>
                                                </div>
                                                <div class="language-item" data-code="kn" data-name="Kannada">
                                                    <span class="flag">🇮🇳</span>
                                                    <span class="name">Kannada</span>
                                                </div>
                                                <div class="language-item" data-code="kk" data-name="Kazakh">
                                                    <span class="flag">🇰🇿</span>
                                                    <span class="name">Kazakh</span>
                                                </div>
                                                <div class="language-item" data-code="km" data-name="Khmer">
                                                    <span class="flag">🇰🇭</span>
                                                    <span class="name">Khmer</span>
                                                </div>
                                                <div class="language-item" data-code="rw" data-name="Kinyarwanda">
                                                    <span class="flag">🇷🇼</span>
                                                    <span class="name">Kinyarwanda</span>
                                                </div>
                                                <div class="language-item" data-code="ko" data-name="Korean">
                                                    <span class="flag">🇰🇷</span>
                                                    <span class="name">Korean</span>
                                                </div>
                                                <div class="language-item" data-code="ku" data-name="Kurdish">
                                                    <span class="flag">🇮🇶</span>
                                                    <span class="name">Kurdish</span>
                                                </div>
                                                <div class="language-item" data-code="ky" data-name="Kyrgyz">
                                                    <span class="flag">🇰🇬</span>
                                                    <span class="name">Kyrgyz</span>
                                                </div>
                                                <div class="language-item" data-code="lo" data-name="Lao">
                                                    <span class="flag">🇱🇦</span>
                                                    <span class="name">Lao</span>
                                                </div>
                                                <div class="language-item" data-code="la" data-name="Latin">
                                                    <span class="flag">🇻🇦</span>
                                                    <span class="name">Latin</span>
                                                </div>
                                                <div class="language-item" data-code="lv" data-name="Latvian">
                                                    <span class="flag">🇱🇻</span>
                                                    <span class="name">Latvian</span>
                                                </div>
                                                <div class="language-item" data-code="lt" data-name="Lithuanian">
                                                    <span class="flag">🇱🇹</span>
                                                    <span class="name">Lithuanian</span>
                                                </div>
                                                <div class="language-item" data-code="lb" data-name="Luxembourgish">
                                                    <span class="flag">🇱🇺</span>
                                                    <span class="name">Luxembourgish</span>
                                                </div>
                                                <div class="language-item" data-code="mk" data-name="Macedonian">
                                                    <span class="flag">🇲🇰</span>
                                                    <span class="name">Macedonian</span>
                                                </div>
                                                <div class="language-item" data-code="mg" data-name="Malagasy">
                                                    <span class="flag">🇲🇬</span>
                                                    <span class="name">Malagasy</span>
                                                </div>
                                                <div class="language-item" data-code="ms" data-name="Malay">
                                                    <span class="flag">🇲🇾</span>
                                                    <span class="name">Malay</span>
                                                </div>
                                                <div class="language-item" data-code="ml" data-name="Malayalam">
                                                    <span class="flag">🇮🇳</span>
                                                    <span class="name">Malayalam</span>
                                                </div>
                                                <div class="language-item" data-code="mt" data-name="Maltese">
                                                    <span class="flag">🇲🇹</span>
                                                    <span class="name">Maltese</span>
                                                </div>
                                                <div class="language-item" data-code="mi" data-name="Maori">
                                                    <span class="flag">🇳🇿</span>
                                                    <span class="name">Maori</span>
                                                </div>
                                                <div class="language-item" data-code="mr" data-name="Marathi">
                                                    <span class="flag">🇮🇳</span>
                                                    <span class="name">Marathi</span>
                                                </div>
                                                <div class="language-item" data-code="mn" data-name="Mongolian">
                                                    <span class="flag">🇲🇳</span>
                                                    <span class="name">Mongolian</span>
                                                </div>
                                                <div class="language-item" data-code="my" data-name="Myanmar">
                                                    <span class="flag">🇲🇲</span>
                                                    <span class="name">Myanmar</span>
                                                </div>
                                                
                                                <!-- N-S -->
                                                <div class="language-item" data-code="ne" data-name="Nepali">
                                                    <span class="flag">🇳🇵</span>
                                                    <span class="name">Nepali</span>
                                                </div>
                                                <div class="language-item" data-code="no" data-name="Norwegian">
                                                    <span class="flag">🇳🇴</span>
                                                    <span class="name">Norwegian</span>
                                                </div>
                                                <div class="language-item" data-code="ny" data-name="Nyanja">
                                                    <span class="flag">🇲🇼</span>
                                                    <span class="name">Nyanja</span>
                                                </div>
                                                <div class="language-item" data-code="or" data-name="Odia">
                                                    <span class="flag">🇮🇳</span>
                                                    <span class="name">Odia</span>
                                                </div>
                                                <div class="language-item" data-code="ps" data-name="Pashto">
                                                    <span class="flag">🇦🇫</span>
                                                    <span class="name">Pashto</span>
                                                </div>
                                                <div class="language-item" data-code="fa" data-name="Persian">
                                                    <span class="flag">🇮🇷</span>
                                                    <span class="name">Persian</span>
                                                </div>
                                                <div class="language-item" data-code="pl" data-name="Polish">
                                                    <span class="flag">🇵🇱</span>
                                                    <span class="name">Polish</span>
                                                </div>
                                                <div class="language-item" data-code="pt" data-name="Portuguese">
                                                    <span class="flag">🇵🇹</span>
                                                    <span class="name">Portuguese</span>
                                                </div>
                                                <div class="language-item" data-code="pa" data-name="Punjabi">
                                                    <span class="flag">🇮🇳</span>
                                                    <span class="name">Punjabi</span>
                                                </div>
                                                <div class="language-item" data-code="ro" data-name="Romanian">
                                                    <span class="flag">🇷🇴</span>
                                                    <span class="name">Romanian</span>
                                                </div>
                                                <div class="language-item" data-code="ru" data-name="Russian">
                                                    <span class="flag">🇷🇺</span>
                                                    <span class="name">Russian</span>
                                                </div>
                                                <div class="language-item" data-code="sm" data-name="Samoan">
                                                    <span class="flag">🇼🇸</span>
                                                    <span class="name">Samoan</span>
                                                </div>
                                                <div class="language-item" data-code="gd" data-name="Scots Gaelic">
                                                    <span class="flag">🏴󠁧󠁢󠁳󠁣󠁴󠁿</span>
                                                    <span class="name">Scots Gaelic</span>
                                                </div>
                                                <div class="language-item" data-code="sr" data-name="Serbian">
                                                    <span class="flag">🇷🇸</span>
                                                    <span class="name">Serbian</span>
                                                </div>
                                                <div class="language-item" data-code="st" data-name="Sesotho">
                                                    <span class="flag">🇱🇸</span>
                                                    <span class="name">Sesotho</span>
                                                </div>
                                                <div class="language-item" data-code="sn" data-name="Shona">
                                                    <span class="flag">🇿🇼</span>
                                                    <span class="name">Shona</span>
                                                </div>
                                                <div class="language-item" data-code="sd" data-name="Sindhi">
                                                    <span class="flag">🇵🇰</span>
                                                    <span class="name">Sindhi</span>
                                                </div>
                                                <div class="language-item" data-code="si" data-name="Sinhala">
                                                    <span class="flag">🇱🇰</span>
                                                    <span class="name">Sinhala</span>
                                                </div>
                                                <div class="language-item" data-code="sk" data-name="Slovak">
                                                    <span class="flag">🇸🇰</span>
                                                    <span class="name">Slovak</span>
                                                </div>
                                                <div class="language-item" data-code="sl" data-name="Slovenian">
                                                    <span class="flag">🇸🇮</span>
                                                    <span class="name">Slovenian</span>
                                                </div>
                                                <div class="language-item" data-code="so" data-name="Somali">
                                                    <span class="flag">🇸🇴</span>
                                                    <span class="name">Somali</span>
                                                </div>
                                                <div class="language-item" data-code="es" data-name="Spanish">
                                                    <span class="flag">🇪🇸</span>
                                                    <span class="name">Spanish</span>
                                                </div>
                                                <div class="language-item" data-code="su" data-name="Sundanese">
                                                    <span class="flag">🇮🇩</span>
                                                    <span class="name">Sundanese</span>
                                                </div>
                                                <div class="language-item" data-code="sw" data-name="Swahili">
                                                    <span class="flag">🇰🇪</span>
                                                    <span class="name">Swahili</span>
                                                </div>
                                                <div class="language-item" data-code="sv" data-name="Swedish">
                                                    <span class="flag">🇸🇪</span>
                                                    <span class="name">Swedish</span>
                                                </div>
                                                
                                                <!-- T-Z -->
                                                <div class="language-item" data-code="tl" data-name="Tagalog">
                                                    <span class="flag">🇵🇭</span>
                                                    <span class="name">Tagalog</span>
                                                </div>
                                                <div class="language-item" data-code="tg" data-name="Tajik">
                                                    <span class="flag">🇹🇯</span>
                                                    <span class="name">Tajik</span>
                                                </div>
                                                <div class="language-item" data-code="ta" data-name="Tamil">
                                                    <span class="flag">🇮🇳</span>
                                                    <span class="name">Tamil</span>
                                                </div>
                                                <div class="language-item" data-code="tt" data-name="Tatar">
                                                    <span class="flag">🇷🇺</span>
                                                    <span class="name">Tatar</span>
                                                </div>
                                                <div class="language-item" data-code="te" data-name="Telugu">
                                                    <span class="flag">🇮🇳</span>
                                                    <span class="name">Telugu</span>
                                                </div>
                                                <div class="language-item" data-code="th" data-name="Thai">
                                                    <span class="flag">🇹🇭</span>
                                                    <span class="name">Thai</span>
                                                </div>
                                                <div class="language-item" data-code="tr" data-name="Turkish">
                                                    <span class="flag">🇹🇷</span>
                                                    <span class="name">Turkish</span>
                                                </div>
                                                <div class="language-item" data-code="tk" data-name="Turkmen">
                                                    <span class="flag">🇹🇲</span>
                                                    <span class="name">Turkmen</span>
                                                </div>
                                                <div class="language-item" data-code="uk" data-name="Ukrainian">
                                                    <span class="flag">🇺🇦</span>
                                                    <span class="name">Ukrainian</span>
                                                </div>
                                                <div class="language-item" data-code="ur" data-name="Urdu">
                                                    <span class="flag">🇵🇰</span>
                                                    <span class="name">Urdu</span>
                                                </div>
                                                <div class="language-item" data-code="ug" data-name="Uyghur">
                                                    <span class="flag">🇨🇳</span>
                                                    <span class="name">Uyghur</span>
                                                </div>
                                                <div class="language-item" data-code="uz" data-name="Uzbek">
                                                    <span class="flag">🇺🇿</span>
                                                    <span class="name">Uzbek</span>
                                                </div>
                                                <div class="language-item" data-code="vi" data-name="Vietnamese">
                                                    <span class="flag">🇻🇳</span>
                                                    <span class="name">Vietnamese</span>
                                                </div>
                                                <div class="language-item" data-code="cy" data-name="Welsh">
                                                    <span class="flag">🏴󠁧󠁢󠁷󠁬󠁳󠁿</span>
                                                    <span class="name">Welsh</span>
                                                </div>
                                                <div class="language-item" data-code="xh" data-name="Xhosa">
                                                    <span class="flag">🇿🇦</span>
                                                    <span class="name">Xhosa</span>
                                                </div>
                                                <div class="language-item" data-code="yi" data-name="Yiddish">
                                                    <span class="flag">🇮🇱</span>
                                                    <span class="name">Yiddish</span>
                                                </div>
                                                <div class="language-item" data-code="yo" data-name="Yoruba">
                                                    <span class="flag">🇳🇬</span>
                                                    <span class="name">Yoruba</span>
                                                </div>
                                                <div class="language-item" data-code="zu" data-name="Zulu">
                                                    <span class="flag">🇿🇦</span>
                                                    <span class="name">Zulu</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hidden Google Translate Element (Fallback) -->
                                <div id="google_translate_element" style="display: none;"></div>

                                <!-- LibreTranslate CSS Styles -->
                                <style>
                                    .libre-translate-dropdown {
                                        position: absolute;
                                        top: 100%;
                                        right: 0;
                                        background: white;
                                        border-radius: 15px;
                                        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
                                        width: 400px;
                                        max-height: 500px;
                                        overflow: hidden;
                                        z-index: 1000;
                                        display: none;
                                        border: 1px solid #e9ecef;
                                    }

                                    .libre-translate-dropdown.show {
                                        display: block;
                                        animation: slideDown 0.3s ease-out;
                                    }

                                    @keyframes slideDown {
                                        from {
                                            opacity: 0;
                                            transform: translateY(-10px);
                                        }
                                        to {
                                            opacity: 1;
                                            transform: translateY(0);
                                        }
                                    }

                                    .dropdown-header {
                                        background: linear-gradient(135deg, #007bff, #0056b3);
                                        color: white;
                                        padding: 20px;
                                        border-radius: 15px 15px 0 0;
                                    }

                                    .search-container {
                                        position: relative;
                                        margin-bottom: 15px;
                                    }

                                    .search-container i {
                                        position: absolute;
                                        left: 15px;
                                        top: 50%;
                                        transform: translateY(-50%);
                                        color: #6c757d;
                                    }

                                    .search-container input {
                                        width: 100%;
                                        padding: 12px 15px 12px 45px;
                                        border: none;
                                        border-radius: 25px;
                                        background: rgba(255,255,255,0.9);
                                        font-size: 14px;
                                        outline: none;
                                    }

                                    .search-container input::placeholder {
                                        color: #6c757d;
                                    }

                                    .translate-info {
                                        display: flex;
                                        align-items: center;
                                        gap: 8px;
                                        font-size: 12px;
                                        opacity: 0.9;
                                    }

                                    .language-sections {
                                        max-height: 350px;
                                        overflow-y: auto;
                                        padding: 0;
                                    }

                                    .language-sections::-webkit-scrollbar {
                                        width: 6px;
                                    }

                                    .language-sections::-webkit-scrollbar-track {
                                        background: #f1f1f1;
                                    }

                                    .language-sections::-webkit-scrollbar-thumb {
                                        background: #007bff;
                                        border-radius: 3px;
                                    }

                                    .language-section {
                                        padding: 20px;
                                        border-bottom: 1px solid #f8f9fa;
                                    }

                                    .language-section:last-child {
                                        border-bottom: none;
                                    }

                                    .section-title {
                                        display: flex;
                                        align-items: center;
                                        gap: 8px;
                                        margin: 0 0 15px 0;
                                        font-size: 14px;
                                        font-weight: 600;
                                        color: #495057;
                                    }

                                    .section-title i {
                                        color: #007bff;
                                    }

                                    .language-grid {
                                        display: grid;
                                        grid-template-columns: repeat(2, 1fr);
                                        gap: 8px;
                                    }

                                    .language-list {
                                        display: flex;
                                        flex-direction: column;
                                        gap: 2px;
                                    }

                                    .language-item {
                                        display: flex;
                                        align-items: center;
                                        gap: 12px;
                                        padding: 10px 15px;
                                        border-radius: 8px;
                                        cursor: pointer;
                                        transition: all 0.2s ease;
                                        background: transparent;
                                    }

                                    .language-item:hover {
                                        background: #f8f9fa;
                                        transform: translateX(5px);
                                    }

                                    .language-item.selected {
                                        background: #e3f2fd;
                                        color: #007bff;
                                        font-weight: 500;
                                    }

                                    .language-item .flag {
                                        font-size: 18px;
                                        width: 24px;
                                        text-align: center;
                                    }

                                    .language-item .name {
                                        font-size: 14px;
                                        flex: 1;
                                    }

                                    .popular-languages .language-item {
                                        background: rgba(0,123,255,0.05);
                                        border: 1px solid rgba(0,123,255,0.1);
                                    }

                                    .popular-languages .language-item:hover {
                                        background: rgba(0,123,255,0.1);
                                        border-color: rgba(0,123,255,0.2);
                                    }

                                    /* Translation Status */
                                    .translation-status {
                                        position: fixed;
                                        top: 20px;
                                        right: 20px;
                                        background: #007bff;
                                        color: white;
                                        padding: 15px 20px;
                                        border-radius: 10px;
                                        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
                                        z-index: 10000;
                                        display: none;
                                        align-items: center;
                                        gap: 10px;
                                    }

                                    .translation-status.show {
                                        display: flex;
                                        animation: slideInRight 0.3s ease-out;
                                    }

                                    @keyframes slideInRight {
                                        from {
                                            opacity: 0;
                                            transform: translateX(100px);
                                        }
                                        to {
                                            opacity: 1;
                                            transform: translateX(0);
                                        }
                                    }

                                    .translation-status.success {
                                        background: #28a745;
                                    }

                                    .translation-status.error {
                                        background: #dc3545;
                                    }

                                    /* Mobile Responsive */
                                    @media (max-width: 768px) {
                                        .libre-translate-dropdown {
                                            width: 320px;
                                            right: -50px;
                                        }

                                        .language-grid {
                                            grid-template-columns: 1fr;
                                        }

                                        .dropdown-header {
                                            padding: 15px;
                                        }

                                        .language-section {
                                            padding: 15px;
                                        }
                                    }

                                    /* Hide original language dropdown when LibreTranslate is active */
                                    .group-4.libre-active #languageDropdown-class {
                                        display: none !important;
                                    }

                                    /* Hide Google Translate widget */
                                    #google_translate_element {
                                        display: none !important;
                                    }

                                    /* Hide Google Translate banner */
                                    .goog-te-banner-frame {
                                        display: none !important;
                                    }

                                    body {
                                        top: 0 !important;
                                    }

                                    /* Custom loading animation */
                                    .translation-loading {
                                        display: inline-block;
                                        width: 20px;
                                        height: 20px;
                                        border: 3px solid rgba(255,255,255,.3);
                                        border-radius: 50%;
                                        border-top-color: #fff;
                                        animation: spin 1s ease-in-out infinite;
                                    }

                                    @keyframes spin {
                                        to { transform: rotate(360deg); }
                                    }
                                </style>

                                <!-- LibreTranslate JavaScript -->
                                <script>
                                    class LibreTranslateManager {
                                        constructor() {
                                            this.currentLanguage = 'en';
                                            this.originalContent = new Map();
                                            this.isTranslating = false;
                                            this.apiUrl = '{{ route("translate.text") }}'; // Laravel backend
                                            this.batchApiUrl = '{{ route("translate.batch") }}'; // Laravel batch endpoint
                                            this.init();
                                        }

                                        init() {
                                            this.bindEvents();
                                            this.storeOriginalContent();
                                        }

                                        bindEvents() {
                                            // Toggle dropdown
                                            document.getElementById('libreTranslateBtn').addEventListener('click', (e) => {
                                                e.stopPropagation();
                                                this.toggleDropdown();
                                            });

                                            // Language search
                                            document.getElementById('languageSearch').addEventListener('input', (e) => {
                                                this.filterLanguages(e.target.value);
                                            });

                                            // Language selection
                                            document.querySelectorAll('.language-item').forEach(item => {
                                                item.addEventListener('click', (e) => {
                                                    const code = e.currentTarget.dataset.code;
                                                    const name = e.currentTarget.dataset.name;
                                                    this.selectLanguage(code, name);
                                                });
                                            });

                                            // Close dropdown when clicking outside
                                            document.addEventListener('click', (e) => {
                                                if (!e.target.closest('.group-4')) {
                                                    this.closeDropdown();
                                                }
                                            });

                                            // Keyboard shortcuts
                                            document.addEventListener('keydown', (e) => {
                                                if (e.ctrlKey && e.shiftKey && e.key === 'T') {
                                                    e.preventDefault();
                                                    this.toggleDropdown();
                                                }
                                                if (e.key === 'Escape') {
                                                    this.closeDropdown();
                                                }
                                            });
                                        }

                                        toggleDropdown() {
                                            const dropdown = document.getElementById('libreTranslateDropdown');
                                            dropdown.classList.toggle('show');
                                            
                                            if (dropdown.classList.contains('show')) {
                                                document.getElementById('languageSearch').focus();
                                            }
                                        }

                                        closeDropdown() {
                                            document.getElementById('libreTranslateDropdown').classList.remove('show');
                                        }

                                        filterLanguages(searchTerm) {
                                            const items = document.querySelectorAll('.language-item');
                                            const term = searchTerm.toLowerCase();

                                            items.forEach(item => {
                                                const name = item.dataset.name.toLowerCase();
                                                const code = item.dataset.code.toLowerCase();
                                                
                                                if (name.includes(term) || code.includes(term)) {
                                                    item.style.display = 'flex';
                                                } else {
                                                    item.style.display = 'none';
                                                }
                                            });
                                        }

                                        async selectLanguage(code, name) {
                                            if (this.isTranslating) return;

                                            this.closeDropdown();
                                            
                                            // Update UI
                                            document.getElementById('currentLangText').textContent = name;
                                            document.querySelectorAll('.language-item').forEach(item => {
                                                item.classList.remove('selected');
                                            });
                                            document.querySelector(`[data-code="${code}"]`).classList.add('selected');

                                            // If English is selected, restore original content
                                            if (code === 'en') {
                                                this.restoreOriginalContent();
                                                this.currentLanguage = 'en';
                                                return;
                                            }

                                            // Translate page content with fallback
                                            await this.translatePageWithFallback(code, name);
                                        }

                                        storeOriginalContent() {
                                            // Store original text content for restoration
                                            const elementsToTranslate = document.querySelectorAll(
                                                'h1, h2, h3, h4, h5, h6, p, span:not(.flag), a, button, label, .nav-label, .text-wrapper, .detail-title, .detail-description'
                                            );

                                            elementsToTranslate.forEach((element, index) => {
                                                if (element.textContent.trim() && !element.closest('.libre-translate-dropdown')) {
                                                    this.originalContent.set(`element_${index}`, {
                                                        element: element,
                                                        text: element.textContent.trim()
                                                    });
                                                }
                                            });
                                        }

                                        async translatePage(targetLang, langName) {
                                            this.isTranslating = true;
                                            this.showStatus('Translating page...', 'info');

                                            try {
                                                const textsToTranslate = Array.from(this.originalContent.values())
                                                    .map(item => item.text)
                                                    .filter(text => text.length > 0 && text.length < 1000); // Increased limit

                                                // Use batch translation endpoint
                                                const response = await fetch(this.batchApiUrl, {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                    },
                                                    body: JSON.stringify({
                                                        texts: textsToTranslate,
                                                        source: 'en',
                                                        target: targetLang
                                                    })
                                                });

                                                if (!response.ok) {
                                                    throw new Error(`HTTP error! status: ${response.status}`);
                                                }

                                                const data = await response.json();
                                                
                                                if (data.success && data.translations) {
                                                    // Apply translations
                                                    let textIndex = 0;
                                                    this.originalContent.forEach((item, key) => {
                                                        if (textIndex < data.translations.length && data.translations[textIndex]) {
                                                            item.element.textContent = data.translations[textIndex];
                                                            textIndex++;
                                                        }
                                                    });

                                                    this.currentLanguage = targetLang;
                                                    this.showStatus(`Page translated to ${langName}`, 'success');
                                                } else {
                                                    throw new Error('Translation response invalid');
                                                }

                                            } catch (error) {
                                                console.error('Translation error:', error);
                                                this.showStatus('Translation failed. Please try again.', 'error');
                                            } finally {
                                                this.isTranslating = false;
                                            }
                                        }

                                        async translateText(text, sourceLang, targetLang) {
                                            try {
                                                const response = await fetch(this.apiUrl, {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                    },
                                                    body: JSON.stringify({
                                                        text: text,
                                                        source: sourceLang,
                                                        target: targetLang
                                                    })
                                                });

                                                if (!response.ok) {
                                                    throw new Error(`HTTP error! status: ${response.status}`);
                                                }

                                                const data = await response.json();
                                                return data.success ? data.translatedText : text;
                                            } catch (error) {
                                                console.error('Translation API error:', error);
                                                return text; // Return original text on error
                                            }
                                        }

                                        restoreOriginalContent() {
                                            this.originalContent.forEach(item => {
                                                item.element.textContent = item.text;
                                            });
                                            this.showStatus('Page restored to English', 'success');
                                        }

                                        showStatus(message, type = 'info') {
                                            // Remove existing status
                                            const existingStatus = document.querySelector('.translation-status');
                                            if (existingStatus) {
                                                existingStatus.remove();
                                            }

                                            // Create new status
                                            const status = document.createElement('div');
                                            status.className = `translation-status ${type} show`;
                                            status.innerHTML = `
                                                <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : 'spinner fa-spin'}"></i>
                                                <span>${message}</span>
                                            `;

                                            document.body.appendChild(status);

                                            // Auto remove after 3 seconds
                                            setTimeout(() => {
                                                status.classList.remove('show');
                                                setTimeout(() => status.remove(), 300);
                                            }, 3000);
                                        }

                                        // Fallback: Client-side translation using Google Translate
                                        initGoogleTranslateFallback() {
                                            if (!window.google || !window.google.translate) {
                                                // Load Google Translate script
                                                const script = document.createElement('script');
                                                script.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
                                                document.head.appendChild(script);
                                                
                                                // Initialize Google Translate
                                                window.googleTranslateElementInit = () => {
                                                    new google.translate.TranslateElement({
                                                        pageLanguage: 'en',
                                                        includedLanguages: 'af,sq,am,ar,hy,az,eu,be,bn,bs,bg,ca,ceb,zh,co,hr,cs,da,nl,en,eo,et,fi,fr,fy,gl,ka,de,el,gu,ht,ha,haw,he,hi,hmn,hu,is,ig,id,ga,it,ja,jv,kn,kk,km,rw,ko,ku,ky,lo,la,lv,lt,lb,mk,mg,ms,ml,mt,mi,mr,mn,my,ne,no,ny,or,ps,fa,pl,pt,pa,ro,ru,sm,gd,sr,st,sn,sd,si,sk,sl,so,es,su,sw,sv,tl,tg,ta,tt,te,th,tr,tk,uk,ur,ug,uz,vi,cy,xh,yi,yo,zu',
                                                        layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                                                        autoDisplay: false
                                                    }, 'google_translate_element');
                                                };
                                            }
                                        }

                                        // Enhanced translation with fallback
                                        async translatePageWithFallback(targetLang, langName) {
                                            try {
                                                // Try our Laravel backend first
                                                await this.translatePage(targetLang, langName);
                                            } catch (error) {
                                                console.warn('Backend translation failed, trying client-side fallback');
                                                this.showStatus('Trying alternative translation method...', 'info');
                                                
                                                // Fallback to Google Translate Widget
                                                this.initGoogleTranslateFallback();
                                                
                                                // Wait for Google Translate to load
                                                setTimeout(() => {
                                                    if (window.google && window.google.translate) {
                                                        // Trigger Google Translate
                                                        const selectElement = document.querySelector('.goog-te-combo');
                                                        if (selectElement) {
                                                            selectElement.value = targetLang;
                                                            selectElement.dispatchEvent(new Event('change'));
                                                            this.showStatus(`Page translated to ${langName} (via Google)`, 'success');
                                                        }
                                                    } else {
                                                        this.showStatus('Translation service unavailable', 'error');
                                                    }
                                                }, 2000);
                                            }
                                        }
                                    }

                                    // Initialize LibreTranslate when DOM is ready
                                    document.addEventListener('DOMContentLoaded', function() {
                                        window.libreTranslate = new LibreTranslateManager();
                                    });
                                </script>
                            </div>
                            @if (!auth('customer')->check() && !auth('seller')->check() && !auth('admin')->check())
                                {{-- Guest User: Show Sign In/Join --}}
                                {{-- <a href="{{ route('customer.auth.login') }}">
                                    <div class="group-5 group-user">
                                        <div class="text-wrapper-6">Sign in / Join</div>
                                        <img class="user img-default" src="/img/user-1.png" />
                                        <img class="user img-hover" src="/img/user (2).png" />
                                    </div>
                                </a> --}}
                            @else
                                <div class="dropdown m-0">
                                    <a class="navbar-tool navbaricons m-0" type="button" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <div class="navbar-tool-icon-box bg-secondary">
                                            <img class="img-profile rounded-circle __inline-14" alt=""
                                                src="{{ getStorageImages(path: auth()->user()->image_full_url ?? '', type: 'avatar') }}">
                                        </div>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}"
                                        aria-labelledby="dropdownMenuButton" style="border-radius: 10px; overflow: hidden;">

                                        @if (auth('customer')->check())
                                            <a class="dropdown-item custom-dealrock-text"
                                                href="{{ route('account-oder') }}">{{ translate('my_Order') }}</a>
                                            <a class="dropdown-item custom-dealrock-text"
                                                href="{{ route('user-account') }}">{{ translate('my_Profile') }}</a>
                                            @if ($is_jobadder === true)
                                                <a class="dropdown-item custom-dealrock-text"
                                                    href="{{ route('job-panel') }}">{{ translate('job_Panel') }}</a>
                                            @endif
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item custom-dealrock-text"
                                                href="{{ route('customer.auth.logout') }}">{{ translate('logout') }}</a>
                                        @elseif (auth('seller')->check())
                                            <a class="dropdown-item custom-dealrock-text"
                                                href="{{ route('vendor.dashboard.index') }}">{{ translate('manage_Dashboard') }}</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item custom-dealrock-text"
                                                href="{{ route('vendor.auth.logout') }}">{{ translate('logout') }}</a>
                                        @elseif (auth('admin')->check())
                                            <a class="dropdown-item custom-dealrock-text"
                                                href="{{ route('admin.dashboard.index') }}">{{ translate('manage_Dashboard') }}</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item custom-dealrock-text"
                                                href="{{ route('admin.logout') }}">{{ translate('logout') }}</a>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
   
            <div class="group-16">
                <div class="contentgroup">
                    <img class="rectangle-stroke-2" src="/img/rectangle-20-stroke-1.svg" />
                    <div class="group-17">
                        <a href="{{ url('/') }}">
                            <img class="logo-3" src="{{ getStorageImages(path: $web_config['web_logo'], type: 'logo') }}" />
                        </a>
                        <div class="group-18">
                            <div class="group-19">
                                <div class="overlap-group-4">
                                    <div class="input-group-overlay search-form-mobile text-align-direction ml-1 mr-2"
                                        id="searchformclose">
                                        <div class="section">
                                            <div class="wrapper">
                                                @if (str_contains(url()->current(), '/job-seeker'))
                                                    <form action="{{ route('jobseeker') }}" type="submit"
                                                        class="wrapperform mb-0">
                                                    @elseif(str_contains(url()->current(), '/talent-finder'))
                                                        <form action="{{ route('talentfinder') }}" type="submit"
                                                            class="wrapperform mb-0">
                                                        @else
                                                            <form id="prosup" action="{{ route('products') }}"
                                                                type="submit" class="wrapperform mb-0">
                                                @endif
                                                <div class="search_box">
                                                    @if (str_contains(url()->current(), '/job-seeker'))
                                                        <div class="w-30 mr-m-1 position-relative my-auto"
                                                            style="cursor: pointer;width: 105px;padding-left: 15px;">
                                                            <span class="custom-dealrock-text">Search Profile</span>
                                                        </div>
                                                    @elseif(str_contains(url()->current(), '/talent-finder'))
                                                        <div class="w-30 mr-m-1 position-relative my-auto"
                                                            style="cursor: pointer;width: 140px;padding-left: 15px;">
                                                            <span class="custom-dealrock-text">Search Candidates</span>
                                                        </div>
                                                    @else
                                                        <div class="dropdown" id="productDropdown">
                                                            <div class="d-flex h-100 flex-row align-items-center">
                                                                <span class="default_option">Products</span>
                                                                <span class="d-flex align-items-center"
                                                                    style="width: 20px; height: 100%;">
                                                                    <?xml version="1.0" ?><svg height="48"
                                                                        viewBox="0 0 48 48" width="48"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M14.83 16.42l9.17 9.17 9.17-9.17 2.83 2.83-12 12-12-12z" />
                                                                        <path d="M0-.75h48v48h-48z" fill="none" />
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                            <ul id="dropdownOptions">
                                                                <li id="productssearch" data-value="products"
                                                                    data-route="{{ route('products') }}"
                                                                    data-suggest="products" data-type="products"
                                                                    data-placeholder="Search for products..."
                                                                    class="custom-dealrock-text">
                                                                    Products
                                                                </li>
                                                                <li id="leadsbuy" data-value="buyleads"
                                                                    data-route="{{ route('buyer') }}"
                                                                    data-suggest="buyer" data-type="buyer"
                                                                    data-placeholder="Search for buy leads..."
                                                                    class="custom-dealrock-text">
                                                                    Buy Leads
                                                                </li>
                                                                <li id="leadssell" data-value="sellleads"
                                                                    data-route="{{ route('seller') }}"
                                                                    data-suggest="seller" data-type="seller"
                                                                    data-placeholder="Search for sell leads..."
                                                                    class="custom-dealrock-text">
                                                                    Sell offer
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @endif
                                                    <div class="search_field">
                                                        @if (str_contains(url()->current(), '/job-seeker'))
                                                            <input class="custom-dealrock-text" type="text"
                                                                id="searchInput" class="input" name="vacancy"
                                                                style="width: inherit;height: 100%;border: 0;outline: 0;"
                                                                value="{{ request('vacancy') }}"
                                                                placeholder="{{ translate('Search for job profiles') }}...">
                                                        @elseif(str_contains(url()->current(), '/talent-finder'))
                                                            <input class="custom-dealrock-text" type="text"
                                                                id="searchInput" class="input" name="talentfinder"
                                                                style="width: inherit;height: 100%;border: 0;outline: 0;"
                                                                value="{{ request('talentfinder') }}"
                                                                placeholder="{{ translate('Search for Candidates') }}...">
                                                        @else
                                                            <input class="custom-dealrock-text" type="text"
                                                                id="searchInput" name="searchInput" class="input"
                                                                data-suggest="products"
                                                                style="width: inherit;height: 100%;border: 0;outline: 0;"
                                                                data-type="products" value="{{ request('name') }}"
                                                                placeholder="{{ translate('Search for products') }}...">
                                                        @endif

                                                        <div class="d-flex position-absolute searchbutton justify-content-center"
                                                            onclick="document.getElementsByClassName('wrapperform')[0].submit()"
                                                            style="width: 177px;">
                                                            {{-- <span>Search</span> --}}
                                                            <img src="/images/magnify_icon.png" alt="magnify"
                                                                style="height: 16px; width: 16px;"><span
                                                                class="ml-1" style="font-size: 18px;">Search<span>
                                                        </div>
                                                        <ul id="suggestions" class="dropdown-menu suggestion-dropdown"
                                                            style="display: none;"></ul>
                                                    </div>
                                                </div>
                                                </form>
                                                <div class="closebutton" id="closebutton">
                                                    <strong> X</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="frame-11">
                                <a href="{{ route('quotationweb') }}">
                                    <div class="group-9">
                                        <img class="chat img-default" src="/img/chat-1.png" />
                                        <img class="chat img-hover" src="/img/chat (2).png" />
                                        <div class="text-wrapper-9">RFQ</div>
                                    </div>
                                </a>
                                <div class="group-10 position-relative">
                                    <a href="{{ route('vendor.auth.login') }}" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <img class="parcel img-default" src="/img/parcel-1.png" />
                                        <img class="parcel img-hover" src="/img/parcel (2).png" />
                                        <div class="text-wrapper-10">Supplier</div>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}"
                                        aria-labelledby="dropdownMenuButton"
                                        style="border-radius: 10px; min-width: 300px; padding: 20px;">

                                        <div class="detailsboxtop">
                                            <h5 class="custom-dealrock-head mb-3 text-center">Why Join as a Supplier
                                            </h5>
                                            <ul class="feature-list list-unstyled">
                                                <li class="d-flex mb-3">
                                                    <div class="leftclass pr-2">
                                                        <i class="fa fa-tachometer-alt fa-lg text-primary"></i>
                                                    </div>
                                                    <div class="rightclass">
                                                         <a href="{{ route('vendor.dashboard.index') }}" class="text-decoration-none">
                                                            <strong class="custom-dealrock-subhead">Manage Dashboard</strong>
                                                        </a><br>
                                                        <span class="custom-dealrock-subtext">Access all tools to
                                                            control your products, leads, and offers.</span>
                                                    </div>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <div class="leftclass pr-2">
                                                        <i class="fa fa-crown fa-lg text-warning"></i>
                                                    </div>
                                                    <div class="rightclass">
                                                        <a href="/vendor/subcard/membership" class="text-decoration-none">
                                                             <strong class="custom-dealrock-subhead">Flexible
                                                            Memberships</strong></a><br>
                                                        
                                                       
                                                        <span class="custom-dealrock-subtext">Choose a plan that fits
                                                            your scale and goals.</span>
                                                    </div>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <div class="leftclass pr-2">
                                                        <i class="fa fa-briefcase fa-lg text-success"></i>
                                                    </div>
                                                    <div class="rightclass">
                                                           <a href="/buy-leads" class="text-decoration-none"></a>
                                                        <strong class="custom-dealrock-subhead">Verified Business
                                                            Leads</strong> </a><br>
                                                          
                                                        <span class="custom-dealrock-subtext">Engage with buyers
                                                            actively looking for suppliers like you.</span>
                                                    </div>
                                                </li>
                                            </ul>

                                            <div class="text-center mt-4">
                                                @if (auth('seller')->check())
                                                    <a href="{{ route('vendor.dashboard.index') }}"
                                                        class="btn btn-primary btn-sm mb-2 w-100 gradient-button">Dashboard</a>
                                                @elseif (auth('web')->check() || auth('customer')->check() || auth('admin')->check())
                                                     @if ($role === 'Supplier')
                                                        <a href="javascript:void(0)" class="btn btn-primary btn-sm mb-2 w-100 gradient-button">
                                                            Login by Supplier
                                                        </a>
                                                    @elseif ($role === 'Buyer')
                                                        <a href="javascript:void(0)" class="btn btn-primary btn-sm mb-2 w-100 gradient-button">
                                                            Login by Buyer
                                                        </a>
                                                    @elseif ($role === 'Hire')
                                                        <a href="javascript:void(0)" class="btn btn-primary btn-sm mb-2 w-100 gradient-button">
                                                            Login by Hire
                                                        </a>
                                                    @elseif ($role === 'Admin')
                                                        <a href="javascript:void(0)" class="btn btn-primary btn-sm mb-2 w-100 gradient-button">
                                                            Login by Admin
                                                        </a>
                                                    @elseif ($role === 'Web')
                                                        <a href="javascript:void(0)" class="btn btn-primary btn-sm mb-2 w-100 gradient-button">
                                                            Already Logged In
                                                        </a>
                                                    @endif                                                
                                                @else
                                                    <a href="{{ route('vendor.auth.login') }}"
                                                        class="btn btn-primary btn-sm mb-2 w-100 gradient-button">Sign In</a>
                                                    <a href="{{ route('vendor.auth.registration.index') }}"
                                                        class="btn btn-primary btn-sm w-100 gradient-button">Sign Up</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="group-11 position-relative">
                                    <a href="{{ route('customer.auth.login') }}" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <img class="customer img-default" src="/img/customer-1.png" />
                                        <img class="customer img-hover" src="/img/customer (2).png" />
                                        <div class="text-wrapper-10">Buyer</div>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}"
                                        aria-labelledby="dropdownMenuButton"
                                        style="border-radius: 10px; min-width: 300px; padding: 20px;">

                                        <div class="detailsboxtop">
                                            <h5 class="custom-dealrock-head mb-3 text-center">Register as a Buyer</h5>
                                            <ul class="feature-list list-unstyled">
                                                <li class="d-flex mb-3">
                                                    <div class="leftclass pr-2">
                                                        <i class="fa fa-search fa-lg text-primary"></i>
                                                    </div>
                                                    <div class="rightclass">
                                                           <a href="/products?searchInput=" class="text-decoration-none">
                                                        <strong class="custom-dealrock-subhead">Product
                                                            Discovery</strong></a><br>
                                                            
                                                        <span class="custom-dealrock-subtext">Browse thousands of
                                                            products and categories.</span>
                                                    </div>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <div class="leftclass pr-2">
                                                        <i class="fa fa-heart fa-lg text-danger"></i>
                                                    </div>
                                                    <div class="rightclass">
                                                           <a href="/customer/auth/login" class="text-decoration-none">
                                                             <strong class="custom-dealrock-subhead">Wishlist &
                                                              Save</strong>
                                                            </a><br>
                                                        <span class="custom-dealrock-subtext">Shortlist your favorite
                                                            products for later.</span>
                                                    </div>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <div class="leftclass pr-2">
                                                        <i class="fa fa-paper-plane fa-lg text-success"></i>
                                                    </div>
                                                    <div class="rightclass">
                                                           <a href="/customer/auth/login" class="text-decoration-none">
                                                        <strong class="custom-dealrock-subhead">Send
                                                            Inquiries</strong></a><br>
                                                        <span class="custom-dealrock-subtext">Reach out to suppliers
                                                            directly with your needs.</span>
                                                    </div>
                                                </li>
                                            </ul>

                                            <div class="text-center mt-4">
                                                @if (auth('customer')->check() && auth('customer')->user()->typerole == 'jobseeker')
                                                    <a href="{{ route('account-oder') }}"
                                                        class="btn btn-primary btn-sm mb-2 w-100 gradient-button">My Orders</a>
                                                    <a href="{{ route('user-account') }}"
                                                        class="btn btn-primary btn-sm mb-2 w-100 gradient-button">My Profile</a>
                                                    <a href="{{ route('customer.auth.logout') }}"
                                                        class="btn btn-primary btn-sm w-100 gradient-button">Logout</a>
                                                @elseif (auth('web')->check() || auth('seller')->check() || auth('admin')->check())
                                                                                                @if ($role === 'Supplier')
                                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm mb-2 w-100 gradient-button">
                                                        Login by Supplier
                                                    </a>
                                                @elseif ($role === 'Buyer')
                                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm mb-2 w-100 gradient-button">
                                                        Login by Buyer
                                                    </a>
                                                @elseif ($role === 'Hire')
                                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm mb-2 w-100 gradient-button">
                                                        Login by Hire
                                                    </a>
                                                @elseif ($role === 'Admin')
                                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm mb-2 w-100 gradient-button">
                                                        Login by Admin
                                                    </a>
                                                @elseif ($role === 'Web')
                                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm mb-2 w-100 gradient-button">
                                                        Already Logged In
                                                    </a>
                                                @endif                                               
                                                @else
                                                    <a href="{{ route('customer.auth.login') }}"
                                                        class="btn btn-primary btn-sm mb-2 w-100 gradient-button">Sign In</a>
                                                    <a href="{{ route('customer.auth.sign-up') }}"
                                                        class="btn btn-primary btn-sm w-100 gradient-button">Sign Up</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="group-11 position-relative" style="width: 23px;height: 100%;">
                                    <a href="javascript:" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <img class="user img-default" src="/img/user-1.png" style="left: 2px;" />
                                        <img class="user img-hover" src="/img/user (2).png" style="left: 2px;" />
                                        <div class="text-wrapper-10">Hire</div>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}"
                                        aria-labelledby="dropdownMenuButton"
                                        style="border-radius: 10px; min-width: 300px; padding: 20px;">

                                        <div class="detailsboxtop">
                                            <h5 class="custom-dealrock-head mb-3 text-center">Hire Talented
                                                Professionals</h5>
                                            <ul class="feature-list list-unstyled">
                                                <li class="d-flex mb-3">
                                                    <div class="leftclass pr-2">
                                                        <i class="fa fa-users fa-lg text-info"></i>
                                                    </div>
                                                    <div class="rightclass">
                                                           <a href="/industry-jobs/talent-finder" class="text-decoration-none">
                                                        <strong class="custom-dealrock-subhead">Browse
                                                            Talent</strong></a><br>
                                                        <span class="custom-dealrock-subtext">Discover skilled
                                                            freelancers and professionals.</span>
                                                    </div>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <div class="leftclass pr-2">
                                                        <i class="fa fa-briefcase fa-lg text-warning"></i>
                                                    </div>
                                                    <div class="rightclass">
                                                           <a href="#" class="text-decoration-none">
                                                        <strong class="custom-dealrock-subhead">Post Jobs</strong></a><br>
                                                        <span class="custom-dealrock-subtext">List your hiring needs to
                                                            attract top candidates.</span>
                                                    </div>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <div class="leftclass pr-2">
                                                        <i class="fa fa-comments fa-lg text-success"></i>
                                                    </div>
                                                    <div class="rightclass">
                                                        <a href="/industry-jobs/talent-finder" class="text-decoration-none">
                                                        <strong class="custom-dealrock-subhead">Connect &
                                                            Hire</strong></a><br>
                                                        <span class="custom-dealrock-subtext">Chat, evaluate, and make
                                                            hiring decisions easily.</span>
                                                    </div>
                                                </li>
                                                <li class="d-flex mb-3">
                                                    <div class="leftclass pr-2">
                                                        <i class="fa fa-user fa-lg text-danger"></i>
                                                    </div>
                                                    <div class="rightclass">
                                                        <a href="/customer/auth/jobseeker-sign-in" class="text-decoration-none">
                                                        <strong class="custom-dealrock-subhead">Job Seeker</strong></a><br>
                                                        <span class="custom-dealrock-subtext">Sign In as Job Seeker.</span>
                                                    </div>
                                                </li>
                                            </ul>

                                            <div class="text-center mt-4">
                                                @if (auth('customer')->check() && auth('customer')->user()->typerole == 'findtalent')
                                                    <a href="{{ route('account-oder') }}"
                                                        class="btn btn-primary btn-sm mb-2 w-100 gradient-button">My Orders</a>
                                                    <a href="{{ route('user-account') }}"
                                                        class="btn btn-primary btn-sm mb-2 w-100 gradient-button">My Profile</a>
                                                    <a href="{{ route('customer.auth.logout') }}"
                                                        class="btn btn-primary btn-sm w-100 gradient-button">Logout</a>
                                                @elseif (auth('web')->check() || auth('seller')->check() || auth('admin')->check())
                                                    @if ($role === 'Supplier')
                                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm mb-2 w-100 gradient-button">
                                                        Login by Supplier
                                                    </a>
                                                @elseif ($role === 'Buyer')
                                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm mb-2 w-100 gradient-button">
                                                        Login by Buyer
                                                    </a>
                                                @elseif ($role === 'Hire')
                                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm mb-2 w-100 gradient-button">
                                                        Login by Hire
                                                    </a>
                                                @elseif ($role === 'Admin')
                                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm mb-2 w-100 gradient-button">
                                                        Login by Admin
                                                    </a>
                                                @elseif ($role === 'Web')
                                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm mb-2 w-100 gradient-button">
                                                        Already Logged In
                                                    </a>
                                                @endif                                                
                                                @else
                                                    <a href="{{ route('customer.auth.hire-sign-in') }}"
                                                        class="btn btn-primary btn-sm mb-2 w-100 gradient-button">Sign In</a>
                                                    <a href="{{ route('customer.auth.hire-sign-up') }}"
                                                        class="btn btn-primary btn-sm w-100 gradient-button">Sign Up</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="group-13">
                                    <div id="google-translate-dropdown"
                                        style="display: none;position: absolute;top: -17px;right: 0;z-index: 10000000;background: white;border: 1px solid black;padding: 15px;">
                                    </div>
                                    <a href="{{ route('gotoshortlist') }}">
                                        <img class="heart img-default" src="/img/heart-1.png" />
                                        <img class="heart img-hover" src="/img/heart (2).png" />
                                        <div class="text-wrapper-11">Shortlist</div>
                                    </a>
                                </div>
                            </div>
                            <div class="hamburger" onclick="toggleDropdown()"><img src="/img/menu.png"
                                    alt="menu" style="height: 16px; width: 16px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="dropdown-nav" id="dropdownNav">
    <a class="flexboxlogocross" href="{{ url('/') }}">
        <img class="logo-3" src="/img/logo-2.png" />
    </a>
    <button class="drawer-close" onclick="toggleDropdown()">✕</button>
    <a href="{{ route('stocksale') }}">Stock Sale</a>
    <a href="{{ route('buyer') }}">Buy Leads</a>
    <a href="{{ route('seller') }}">Sell Offer</a>
    <a href="{{ route('dealassist') }}">Deal Assist</a>
    <a href="{{ route('sendcv') }}">Industry Jobs</a>
    <a href="{{ route('tradeshow') }}">Trade Shows</a>
    <a href="{{ route('vendor.auth.registration.index') }}">Supplier Zone</a>
</div>
@push('script')
    <script defer src="{{ theme_asset('public/js/header.js') }}"></script>
    <script defer>
        "use strict";
        $(".category-menu").find(".mega_menu").parents("li")
            .addClass("has-sub-item").find("> a")
            .append("<i class='czi-arrow-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}'></i>");

        function toggleDropdown() {
            document.getElementById("dropdownNav").classList.toggle("show");
        }
    </script>
@endpush
