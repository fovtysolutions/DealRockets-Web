@extends('layouts.back-end.app-partial')

@section('title', translate('All Messages'))

@push('css_or_js')
    <link href="{{ dynamicAsset('public/assets/custom-css/gmail-ui/style.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset('public/assets/custom-css/admin-panel/chatbox.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="gmail-ui" style="padding-bottom: 30px;">

        <body class="h-screen flex flex-col md:pb-2 bg-[#f6f9ff] relative">
            <nav class="w-full py-2 flex px-4 text-gray-600 justify-between">
                <div class="flex items-center w-[70%] justify-between gap-3">
                    <div
                        class=" hidden group md:flex h-full items-center rounded-full p-1 bg-[#e5f1ff] gap-2 w-[80%] max-w-2xl hover:drop-shadow-md hover:bg-white">
                        <button class="grid place-content-center rounded-full hover:bg-gray-200 p-2"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                        <input class="h-full focus:outline-none bg-[#e5f1ff] py-2 w-full group-hover:bg-white"
                            type="text" name="search" id="search" placeholder="Search mail">
                    </div>
                </div>
            </nav>
            <div class="h-full w-full  grid grid-cols-10">
                <div class="self-start sticky top-0 col-span-2 h-full mr-2 hidden md:block">

                    <ul class="w-full text-sm my-3">
                        <li class="w-full">
                            <a class="{{ request('special') === 'all' ? 'bg-blue-200 font-semibold' : 'hover:bg-gray-200' }} w-full flex leading-none pl-6 py-2 gap-3 items-center rounded-e-full pr-2"
                                href="{{ route('admin.get-chat-lists', ['special' => 'all']) }}">
                                <i class="fa-solid fa-inbox"></i>
                                <p class="flex w-full justify-between">All
                                    <span id="allmessages">{{ $chatboxStatics['total_messages'] }}</span>
                                </p>
                            </a>
                        </li>

                        <li class="w-full">
                            <a class="{{ request('special') === 'read' ? 'bg-blue-200 font-semibold' : 'hover:bg-gray-200' }} w-full flex leading-none pl-6 py-2 gap-3 items-center rounded-e-full pr-2"
                                href="{{ route('admin.get-chat-lists', ['special' => 'read']) }}">
                                <i class="fa-regular fa-star"></i>
                                <p class="flex w-full justify-between">Read
                                    <span id="readmessages">{{ $chatboxStatics['read_messages'] }}</span>
                                </p>
                            </a>
                        </li>

                        <li class="w-full">
                            <a class="{{ request('special') === 'unread' ? 'bg-blue-200 font-semibold' : 'hover:bg-gray-200' }} w-full flex leading-none pl-6 py-2 gap-3 items-center rounded-e-full pr-2"
                                href="{{ route('admin.get-chat-lists', ['special' => 'unread']) }}">
                                <i class="fa-regular fa-clock"></i>
                                <p class="flex w-full justify-between">Unread
                                    <span id="unreadmessages">{{ $chatboxStatics['unread_messages'] }}</span>
                                </p>
                            </a>
                        </li>
                        {{-- <li class="w-full"><a
                                class="w-full flex leading-none hover:bg-gray-200 pl-6 py-2 gap-3 items-center rounded-e-full pr-2"
                                href="#"><i class="fa-solid fa-angle-down"></i>
                                <p class="flex w-full justify-between">More</p>
                            </a></li> --}}
                    </ul>
                </div>
                <div class="bg-white h-full col-span-10 md:col-span-8 rounded-2xl mx-2 flex flex-col">
                    <div id="messagebox">
                        @include('admin-views.betterchat.partials.messagebox', [
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
