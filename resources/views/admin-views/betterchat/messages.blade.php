@extends('layouts.back-end.app-partialseller')

@section('title', translate('All Messages'))

@push('css_or_js')
    <link href="{{ dynamicAsset('public/assets/custom-css/gmail-ui/style.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset('public/assets/custom-css/admin-panel/chatbox.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
@endpush

@section('content')
    <div class="gmail-ui" style="padding-bottom: 30px;">

        <body class="h-screen flex flex-col md:pb-2 bg-[#f6f9ff] relative">
            <div class="h-full w-full  grid grid-cols-10">
                <div class="self-start sticky top-0 col-span-2 h-full hidden md:block" style="border-right: 1px solid lightgrey;">

                    <ul class="w-full text-sm my-3">
                        <li class="w-full" style="padding-bottom: 10px;">
                            <div class="items-center w-[100%] justify-between gap-3">
                                <div
                                    class=" hidden group md:flex h-full items-center rounded-full p-1 bg-[#e5f1ff] gap-2 w-[100%] max-w-2xl hover:drop-shadow-md hover:bg-white">
                                    <button class="grid place-content-center rounded-full hover:bg-gray-200 p-2"><i
                                            class="fa-solid fa-magnifying-glass"></i></button>
                                    <input class="h-full focus:outline-none bg-[#e5f1ff] py-2 w-full group-hover:bg-white"
                                        type="text" name="search" id="search" placeholder="Search mail" style="margin-right: 10px;">
                                </div>
                            </div>
                        </li>
                        <li class="w-full">
                            <a data-tab="all" class="custom-tab-button w-full flex leading-none hover:bg-gray-200 pl-5 py-2 gap-3 items-center rounded-e-full pr-2"
                                href="javascript:">
                                <i class="fa-solid fa-inbox"></i>
                                <p class="flex w-full justify-between">All
                                    <span id="allmessages">{{ $chatboxStatics['total_messages'] }}</span>
                                </p>
                            </a>
                        </li>

                        <li class="w-full">
                            <a data-tab="read" class="custom-tab-button w-full flex leading-none hover:bg-gray-200 pl-5 py-2 gap-3 items-center rounded-e-full pr-2"
                                href="javascript:">
                                <i class="fa-regular fa-star"></i>
                                <p class="flex w-full justify-between">Read
                                    <span id="readmessages">{{ $chatboxStatics['read_messages'] }}</span>
                                </p>
                            </a>
                        </li>

                        <li class="w-full">
                            <a data-tab="unread" class="custom-tab-button w-full flex leading-none hover:bg-gray-200 pl-5 py-2 gap-3 items-center rounded-e-full pr-2"
                                href="javascript:">
                                <i class="fa-regular fa-clock"></i>
                                <p class="flex w-full justify-between">Unread
                                    <span id="unreadmessages">{{ $chatboxStatics['unread_messages'] }}</span>
                                </p>
                            </a>
                        </li>
                        <li class="w-full">
                            <a data-tab="rfq" class="custom-tab-button w-full flex leading-none hover:bg-gray-200 pl-5 py-2 gap-3 items-center rounded-e-full pr-2"
                                href="javascript:">
                                <p class="flex w-full justify-between">RFQ - Buy Leads</p>
                            </a>
                        </li>
                        <li class="w-full">
                            <a data-tab="sell" class="custom-tab-button w-full flex leading-none hover:bg-gray-200 pl-5 py-2 gap-3 items-center rounded-e-full pr-2"
                                href="javascript:">
                                <p class="flex w-full justify-between">Sell Offer</p>
                            </a>
                        </li>
                        <li class="w-full">
                            <a data-tab="stock" class="custom-tab-button w-full flex leading-none hover:bg-gray-200 pl-5 py-2 gap-3 items-center rounded-e-full pr-2"
                                href="javascript:">
                                <p class="flex w-full justify-between">Stock Sale</p>
                            </a>
                        </li>
                        <li class="w-full">
                            <a data-tab="market" class="custom-tab-button w-full flex leading-none hover:bg-gray-200 pl-5 py-2 gap-3 items-center rounded-e-full pr-2"
                                href="javascript:">
                                <p class="flex w-full justify-between">Marketplace</p>
                            </a>
                        </li>
                        <li class="w-full">
                            <a data-tab="jobs" class="custom-tab-button w-full flex leading-none hover:bg-gray-200 pl-5 py-2 gap-3 items-center rounded-e-full pr-2"
                                href="javascript:">
                                <i class="fa-solid fa-briefcase"></i>
                                <p class="flex w-full justify-between">Jobs
                                    <span id="jobmessages">{{ $chatboxStatics['job_notifications'] ?? 0 }}</span>
                                </p>
                            </a>
                        </li>
                        <li class="w-full">
                            <a data-tab="dealassist" class="custom-tab-button w-full flex leading-none hover:bg-gray-200 pl-5 py-2 gap-3 items-center rounded-e-full pr-2"
                                href="javascript:">
                                <i class="fa-solid fa-handshake"></i>
                                <p class="flex w-full justify-between">Deal Assist
                                    <span id="dealassistmessages">{{ collect($chatboxStatics['messages_by_type'])->where('type', 'dealassist')->first()->total ?? 0 }}</span>
                                </p>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="bg-white h-full col-span-10 md:col-span-8 rounded-2xl mr-2 flex flex-col">
                    <div id="messagebox">
                        @include('vendor-views.betterchat.partials.messagebox', [
                            'chatData' => $intialMessages,
                        ])
                    </div>
                </div>
            </div>
        </body>
    </div>
    <script>
        document.getElementById('search').addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                const value = e.target.value;
                window.location.href = `?search=${encodeURIComponent(value)}`;
            }
        });
    </script>
@endsection
