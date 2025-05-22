@extends('layouts.back-end.app')

@section('title', translate('Leads_Messages'))

@push('css_or_js')
    <link href="{{ dynamicAsset('public/assets/custom-css/gmail-ui/style.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="gmail-ui">

        <body class="h-screen flex flex-col md:pb-2 bg-[#f6f9ff] relative">
            <nav class="w-full py-2 flex px-4 text-gray-600 justify-between">
                <div class="flex items-center w-[70%] justify-between gap-3">
                    <div class="flex gap-1 items-center">
                        <button class="h-10 w-10 grid place-content-center rounded-full hover:bg-gray-200"><i
                                class="fa-solid fa-bars text-lg"></i></button>
                        <div>
                            <img class="h-9" src="./assets/gmail-logo.png" alt="">
                        </div>
                    </div>
                    <div
                        class=" hidden group md:flex h-full items-center rounded-full p-1 bg-[#e5f1ff] gap-2 w-[80%] max-w-2xl hover:drop-shadow-md hover:bg-white">
                        <button class="grid place-content-center rounded-full hover:bg-gray-200 p-2"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                        <input class="h-full focus:outline-none bg-[#e5f1ff] py-2 w-full group-hover:bg-white"
                            type="text" name="saerch" id="saerch" placeholder="Search mail">
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="avatar border avatar-circle">
                        <img class="avatar-img"
                            src="{{ getStorageImages(path: auth('admin')->user()->image_full_url, type: 'backend-profile') }}"
                            alt="{{ translate('image_description') }}">
                        <span class="d-none avatar-status avatar-sm-status avatar-status-success"></span>
                    </div>
                </div>
            </nav>
            <div class="h-full w-full  grid grid-cols-10">
                <div class="self-start sticky top-0 col-span-2 h-full mr-2 hidden md:block">
                    <ul class="w-full text-sm my-3">
                        <li class="w-full"><a
                                class=" font-semibold w-full flex leading-none bg-blue-200 pl-6 py-2 gap-3 items-center rounded-e-full pr-2"
                                href="#"><i class="fa-solid fa-inbox"></i>
                                <p class="flex w-full justify-between">All <span id="allmessages"></span></p>
                            </a></li>
                        <li class="w-full"><a
                                class="w-full flex leading-none hover:bg-gray-200 pl-6 py-2 gap-3 items-center rounded-e-full pr-2"
                                href="#"><i class="fa-regular fa-star"></i>
                                <p class="flex w-full justify-between">Read <span id="readmessages"></span></p>
                            </a></li>
                        <li class="w-full"><a
                                class="w-full flex leading-none hover:bg-gray-200 pl-6 py-2 gap-3 items-center rounded-e-full pr-2"
                                href="#"><i class="fa-regular fa-clock"></i>
                                <p class="flex w-full justify-between">Unread <span id="unreadmessages"></span></p>
                            </a></li>
                        {{-- <li class="w-full"><a
                                class="w-full flex leading-none hover:bg-gray-200 pl-6 py-2 gap-3 items-center rounded-e-full pr-2"
                                href="#"><i class="fa-solid fa-angle-down"></i>
                                <p class="flex w-full justify-between">More</p>
                            </a></li> --}}
                    </ul>
                </div>
                <div class="bg-white h-full col-span-10 md:col-span-8 rounded-2xl mx-2 flex flex-col">
                    <div class="bg-white w-full sticky top-0 flex py-2 px-4 text-gray-600 text-[0.7rem] justify-between">
                        <div class="flex gap-1">
                            <div class="flex gap-1">
                                <input class="py-auto px-2" type="checkbox" name="select" id="select">
                                <button
                                    class="grid place-content-center rounded-full hover:bg-gray-200  text-gray-700 px-1 h-full"><i
                                        class="fa-solid fa-caret-down"></i></button>
                            </div>
                            <button class="grid place-content-center rounded-full hover:bg-gray-200 p-3"><i
                                    class="fa-solid fa-rotate-right"></i></button>
                        </div>
                        <div class="flex gap-1">
                            <div class="flex items-center h-full rounded-md px-2 cursor-pointer hover:bg-gray-200">
                                <p>1-50 of 4,814</p>
                            </div>
                            <button class="grid place-content-center rounded-full hover:bg-gray-200 p-3"><i
                                    class="fa-solid fa-chevron-left"></i></button>
                            <button class="grid place-content-center rounded-full hover:bg-gray-200 p-3"><i
                                    class="fa-solid fa-chevron-right"></i></button>
                        </div>
                    </div>
                    <div class="scrolable-width overflow-y-scroll overflow-x-hidden">
                        <div
                            class="hidden md:flex h-12 text-sm font-medium leading-none text-gray-600 border-b border-gray-200">
                            <button data-tab="rfq"
                                class="tab-button active-tab flex h-full w-52 items-center px-4 gap-4 text-blue-600 border-b-[3px] border-blue-600">
                                <i class="fa-solid fa-inbox"></i>
                                <p>RFQ</p>
                            </button>
                            <button data-tab="sell"
                                class="tab-button flex h-full w-52 items-center px-4 gap-4 hover:bg-gray-200">
                                <i class="fa-solid fa-receipt"></i>
                                <p>Sell Offer</p>
                            </button>
                            <button data-tab="stock"
                                class="tab-button flex h-full w-52 items-center px-4 gap-4 hover:bg-gray-200">
                                <i class="fa-solid fa-receipt"></i>
                                <p>Stock Sale</p>
                            </button>
                            <button data-tab="market"
                                class="tab-button flex h-full w-52 items-center px-4 gap-4 hover:bg-gray-200">
                                <i class="fa-solid fa-receipt"></i>
                                <p>Marketplace</p>
                            </button>
                        </div>
                        <div class="tab-content-wrapper flex flex-col h-full">
                            <div id="tab-rfq" class="tab-content">
                                @include('admin-views.partials.rfqentries')
                            </div>
                            <div id="tab-sell" class="tab-content hidden">
                                @include('admin-views.partials.saleofferentries')
                            </div>
                            <div id="tab-stock" class="tab-content hidden">
                                @include('admin-views.partials.stocksaleentries')
                            </div>
                            <div id="tab-market" class="tab-content hidden">
                                @include('admin-views.partials.marketplaceentries')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('get-statics') }}",
                method: "GET",
                success: function(response) {
                    var data = response;
                    $('#allmessages').text(data.total_messages);
                    $("#readmessages").text(data.read_messages);
                    $('#unreadmessages').text(data.unread_messages);
                },
                error: function(xhr) {
                    console.error("Error fetching statistics:", xhr.responseText);
                },
                complete: function() {
                    toastr.info('Data Successfully Loaded');
                },
            });

            $.ajax({
                url: "{{ route('get-chat-lists') }}",
                method: "GET",
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr) {
                    console.error("Error fetching statistics:", xhr.responseText);
                },
                complete: function() {
                    toastr.info('Data Successfully Loaded');
                },
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const buttons = document.querySelectorAll(".tab-button");
            const contents = document.querySelectorAll(".tab-content");

            buttons.forEach(button => {
                button.addEventListener("click", function() {
                    buttons.forEach(btn => btn.classList.remove("text-blue-600", "border-b-[3px]",
                        "border-blue-600", "active-tab"));

                    contents.forEach(tab => tab.classList.add("hidden"));

                    this.classList.add("text-blue-600", "border-b-[3px]", "border-blue-600",
                        "active-tab");

                    const tabId = this.getAttribute("data-tab");

                    document.getElementById("tab-" + tabId).classList.remove("hidden");
                });
            });
        });
    </script>
@endpush
