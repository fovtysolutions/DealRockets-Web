@extends('layouts.front-end.app')

@section('title', translate('My Messages'))

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
                                        type="text" name="search" id="search" placeholder="Search messages" style="margin-right: 10px;">
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
                                <i class="fa-regular fa-envelope"></i>
                                <p class="flex w-full justify-between">Unread
                                    <span id="unreadmessages">{{ $chatboxStatics['unread_messages'] }}</span>
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

                        <li class="w-full">
                            <a data-tab="products" class="custom-tab-button w-full flex leading-none hover:bg-gray-200 pl-5 py-2 gap-3 items-center rounded-e-full pr-2"
                                href="javascript:">
                                <i class="fa-solid fa-box"></i>
                                <p class="flex w-full justify-between">Products
                                    <span id="productsmessages">{{ collect($chatboxStatics['messages_by_type'])->where('type', 'products')->first()->total ?? 0 }}</span>
                                </p>
                            </a>
                        </li>

                        <li class="w-full">
                            <a data-tab="buyleads" class="custom-tab-button w-full flex leading-none hover:bg-gray-200 pl-5 py-2 gap-3 items-center rounded-e-full pr-2"
                                href="javascript:">
                                <i class="fa-solid fa-shopping-cart"></i>
                                <p class="flex w-full justify-between">Buy Leads
                                    <span id="buyleadsmessages">{{ collect($chatboxStatics['messages_by_type'])->where('type', 'buyleads')->first()->total ?? 0 }}</span>
                                </p>
                            </a>
                        </li>

                        <li class="w-full">
                            <a data-tab="sellleads" class="custom-tab-button w-full flex leading-none hover:bg-gray-200 pl-5 py-2 gap-3 items-center rounded-e-full pr-2"
                                href="javascript:">
                                <i class="fa-solid fa-tags"></i>
                                <p class="flex w-full justify-between">Sell Leads
                                    <span id="sellleadsmessages">{{ collect($chatboxStatics['messages_by_type'])->where('type', 'sellleads')->first()->total ?? 0 }}</span>
                                </p>
                            </a>
                        </li>

                        <li class="w-full">
                            <a data-tab="stocksell" class="custom-tab-button w-full flex leading-none hover:bg-gray-200 pl-5 py-2 gap-3 items-center rounded-e-full pr-2"
                                href="javascript:">
                                <i class="fa-solid fa-warehouse"></i>
                                <p class="flex w-full justify-between">Stock Sell
                                    <span id="stocksellmessages">{{ collect($chatboxStatics['messages_by_type'])->where('type', 'stocksell')->first()->total ?? 0 }}</span>
                                </p>
                            </a>
                        </li>

                    </ul>
                </div>

                <div class="col-span-8 h-full flex flex-col">
                    <div class="flex-1 overflow-y-auto p-4" id="message-list">
                        <!-- Messages will be loaded here -->
                        <div class="text-center text-gray-500 mt-10">
                            <i class="fa-solid fa-inbox text-4xl mb-4"></i>
                            <p>Select a conversation to view messages</p>
                        </div>
                    </div>

                    <!-- Chat interface will be loaded here when a conversation is selected -->
                    <div id="chat-interface" style="display: none;">
                        <div class="border-t p-4">
                            <div class="flex gap-2">
                                <input type="text" id="message-input" class="flex-1 border rounded-lg px-3 py-2" placeholder="Type your message...">
                                <button id="send-message" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                                    <i class="fa-solid fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
    </div>

    <script>
        $(document).ready(function() {
            let currentTab = 'all';
            let currentChatId = null;
            let currentUserId = null;
            let currentUserType = null;
            let currentType = null;
            let currentListingId = null;

            // Load initial messages
            loadMessages(currentTab);

            // Tab switching
            $('.custom-tab-button').click(function() {
                $('.custom-tab-button').removeClass('bg-blue-100');
                $(this).addClass('bg-blue-100');
                currentTab = $(this).data('tab');
                loadMessages(currentTab);
            });

            // Search functionality
            $('#search').on('input', function() {
                const searchTerm = $(this).val();
                loadMessages(currentTab, searchTerm);
            });

            function loadMessages(tab, search = '') {
                $.ajax({
                    url: '{{ route("get-chat-lists") }}',
                    method: 'GET',
                    data: {
                        special: tab,
                        search: search
                    },
                    success: function(response) {
                        displayMessages(response[tab] || []);
                    },
                    error: function(xhr) {
                        console.error('Error loading messages:', xhr);
                    }
                });
            }

            function displayMessages(messages) {
                const messageList = $('#message-list');
                messageList.empty();

                if (messages.length === 0) {
                    messageList.html(`
                        <div class="text-center text-gray-500 mt-10">
                            <i class="fa-solid fa-inbox text-4xl mb-4"></i>
                            <p>No messages found</p>
                        </div>
                    `);
                    return;
                }

                messages.forEach(function(message) {
                    const messageHtml = `
                        <div class="message-item border-b p-4 hover:bg-gray-50 cursor-pointer" 
                             data-chat-id="${message.chat_id}"
                             data-user-id="${message.sender_type === 'customer' ? message.receiver_id : message.sender_id}"
                             data-user-type="${message.sender_type === 'customer' ? message.receiver_type : message.sender_type}"
                             data-type="${message.type}"
                             data-listing-id="${message.chat_id}">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-semibold">${getSenderName(message)}</span>
                                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">${message.type}</span>
                                        ${message.is_read == 0 ? '<span class="w-2 h-2 bg-blue-500 rounded-full"></span>' : ''}
                                    </div>
                                    <p class="text-gray-700 text-sm mb-1">${message.message.substring(0, 100)}${message.message.length > 100 ? '...' : ''}</p>
                                    <p class="text-xs text-gray-500">${formatDate(message.sent_at)}</p>
                                </div>
                            </div>
                        </div>
                    `;
                    messageList.append(messageHtml);
                });

                // Add click handlers for message items
                $('.message-item').click(function() {
                    const chatId = $(this).data('chat-id');
                    const userId = $(this).data('user-id');
                    const userType = $(this).data('user-type');
                    const type = $(this).data('type');
                    const listingId = $(this).data('listing-id');
                    
                    loadChat(userId, userType, type, listingId);
                });
            }

            function getSenderName(message) {
                if (message.sender_type === 'admin') {
                    return 'Admin';
                } else if (message.sender_type === 'customer') {
                    return 'You';
                } else {
                    return message.sender_type.charAt(0).toUpperCase() + message.sender_type.slice(1);
                }
            }

            function formatDate(dateString) {
                const date = new Date(dateString);
                return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            }

            function loadChat(userId, userType, type, listingId) {
                currentUserId = userId;
                currentUserType = userType;
                currentType = type;
                currentListingId = listingId;

                $.ajax({
                    url: `/chat-by-listing/${userId}/${userType}/${type}/${listingId}`,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        displayChat(response);
                        $('#chat-interface').show();
                    },
                    error: function(xhr) {
                        console.error('Error loading chat:', xhr);
                    }
                });
            }

            function displayChat(messages) {
                const messageList = $('#message-list');
                messageList.empty();

                if (messages.length === 0) {
                    messageList.html('<div class="text-center text-gray-500 mt-10"><p>No messages in this conversation</p></div>');
                    return;
                }

                messages.forEach(function(message) {
                    const isOwn = message.is_self;
                    const messageHtml = `
                        <div class="mb-4 ${isOwn ? 'text-right' : 'text-left'}">
                            <div class="inline-block max-w-xs lg:max-w-md px-4 py-2 rounded-lg ${isOwn ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800'}">
                                <p class="text-sm">${message.message}</p>
                                <p class="text-xs mt-1 ${isOwn ? 'text-blue-100' : 'text-gray-500'}">${formatDate(message.sent_at)}</p>
                            </div>
                        </div>
                    `;
                    messageList.append(messageHtml);
                });

                // Scroll to bottom
                messageList.scrollTop(messageList[0].scrollHeight);
            }

            // Send message functionality
            $('#send-message').click(function() {
                sendMessage();
            });

            $('#message-input').keypress(function(e) {
                if (e.which == 13) {
                    sendMessage();
                }
            });

            function sendMessage() {
                const message = $('#message-input').val().trim();
                if (!message || !currentUserId) return;

                $.ajax({
                    url: '{{ route("send-reply-message") }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        sender_id: {{ auth('customer')->id() ?? 0 }},
                        sender_type: 'customer',
                        receiver_id: currentUserId,
                        receiver_type: currentUserType,
                        message: message,
                        listing_id: currentListingId,
                        type: currentType
                    },
                    success: function(response) {
                        $('#message-input').val('');
                        // Reload the chat to show the new message
                        loadChat(currentUserId, currentUserType, currentType, currentListingId);
                    },
                    error: function(xhr) {
                        console.error('Error sending message:', xhr);
                        alert('Failed to send message. Please try again.');
                    }
                });
            }
        });
    </script>
@endsection