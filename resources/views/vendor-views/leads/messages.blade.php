@extends('layouts.back-end.app-partialseller')

@section('title', translate('Leads_Messages'))

@push('css_or_js')
    <link href="{{ dynamicAsset('public/assets/custom-css/admin-panel/chatbox.css') }}" rel="stylesheet">   
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <!-- char-area -->
    <input type="hidden" name="sender_typemew" id="sender_typemew" value="customer">
    <input type="hidden" name="reciever_typemew" id="reciever_typemew" value="seller">
    <input type="hidden" name="typemew" id="typemew" value="leads">
    <section class="message-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="chat-area">
                        <!-- chatlist -->
                        <div class="chatlist">
                            <div class="modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="chat-header">
                                        <div class="msg-search">
                                            <input type="text" class="form-control" id="inlineFormInputGroup"
                                                placeholder="Search" aria-label="search" onkeyup="filterChats()">
                                        </div>

                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="Open-tab" href="#Open" role="tab"
                                                    aria-controls="Open" aria-selected="true">Open</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="Closed-tab" href="#Closed" role="tab"
                                                    aria-controls="Closed" aria-selected="false">Closed</a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="modal-body">
                                        <!-- chat-list -->
                                        <div class="chat-lists">
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="Open" role="tabpanel"
                                                    aria-labelledby="Open-tab">
                                                    <!-- chat-list for Open tab -->
                                                    <div class="chat-list">
                                                        @if (count($openchats) === 0)
                                                            <a href="#" class="d-flex align-items-center">
                                                                <div class="flex-grow-1 ms-3">
                                                                    <h3>No Opened Chats Found</h3>
                                                                </div>
                                                            </a>
                                                        @else
                                                            @foreach ($openchats as $chat)
                                                                <a href="#"
                                                                    class="d-flex align-items-center chat-item"
                                                                    onclick="LoadChats({{ $chat[0]['sender_id'] }}, 
                                                                        '{{ \App\Utils\ChatManager::fetchusername($chat[0]['sender_id']) }}',
                                                                        '{{ $chat[0]['sender_type'] }}',
                                                                        '{{ $chat['openstatus'] }}')"
                                                                    data-name="{{ \App\Utils\ChatManager::fetchusername($chat[0]['sender_id']) }}">
                                                                    <div class="flex-shrink-0">
                                                                        <img style="max-width:50px;" class="img-fluid"
                                                                            src="{{ \App\Utils\ChatManager::fetchimage($chat[0]['sender_id']) ?? '/images/missing_image.jpg' }}"
                                                                            alt="user img">
                                                                        @if ($chat['unread_messages'] > 0)
                                                                            <span
                                                                                class="active">{{ $chat['unread_messages'] }}</span>
                                                                        @endif
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-3">
                                                                        <h3>{{ \App\Utils\ChatManager::fetchusername($chat[0]['sender_id']) }}
                                                                        </h3>
                                                                    </div>
                                                                </a>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="Closed" role="tabpanel"
                                                    aria-labelledby="Closed-tab">
                                                    <!-- chat-list for Closed tab -->
                                                    <div class="chat-list">
                                                        @if (count($closechats) === 0)
                                                            <a href="#" class="d-flex align-items-center">
                                                                <div class="flex-grow-1 ms-3">
                                                                    <h3>No Closed Chats Found</h3>
                                                                </div>
                                                            </a>
                                                        @else
                                                            @foreach ($closechats as $chat)
                                                                <a href="#"
                                                                    class="d-flex align-items-center chat-item"
                                                                    onclick="LoadChats({{ $chat[0]['sender_id'] }}, 
                                                                '{{ \App\Utils\ChatManager::fetchusername($chat[0]['sender_id']) }}',
                                                                '{{ $chat[0]['sender_type'] }}',
                                                                '{{ $chat['openstatus'] }}')"
                                                                    data-name="{{ \App\Utils\ChatManager::fetchusername($chat[0]['sender_id']) }}">
                                                                    <div class="flex-shrink-0">
                                                                        <img style="max-width:50px;" class="img-fluid"
                                                                            src="{{ \App\Utils\ChatManager::fetchimage($chat[0]['sender_id']) ?? '/images/missing_image.jpg' }}"
                                                                            alt="user img">
                                                                        @if ($chat['unread_messages'] > 0)
                                                                            <span
                                                                                class="active">{{ $chat['unread_messages'] }}</span>
                                                                        @endif
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-3">
                                                                        <h3>{{ \App\Utils\ChatManager::fetchusername($chat[0]['sender_id']) }}
                                                                        </h3>
                                                                    </div>
                                                                </a>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- chat-list -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- chatlist -->
                        <!-- chatbox -->
                        <div class="chatbox">
                            <div class="modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="msg-head">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="d-flex align-items-center">
                                                    <span class="chat-icon"><img class="img-fluid"
                                                            src="https://mehedihtml.com/chatbox/assets/img/arroleftt.svg"
                                                            alt="image title"></span>
                                                    <div class="flex-shrink-0">
                                                        <img style="max-width:50px;" class="img-fluid"
                                                            src="/images/missing_image.jpg"
                                                            alt="user img">
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h3 id="username">Select a Chat from left sidebar</h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="flex-grow-1 ms-3">
                                                    <button onclick="SetOpenorClose()" id="toggle-chat"
                                                        class="btn btn--primary m-2">
                                                        Open a Chat
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <div class="msg-body">
                                            <ul id="chat-messages">
                                                <h5>Select a Chat from left sidebar</h5>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="send-box">
                                        <?php
                                        $userdata = \App\Utils\ChatManager::getRoleDetail();
                                        $user_id = $userdata['user_id'];
                                        $role = $userdata['role'];
                                        ?>
                                        <form id="sendchatmessage">
                                            @csrf
                                            <input type="hidden" name="typereq" id="typereq" value="leads">
                                            <input type="hidden" name="sender_id" id="sender_id"
                                                value="{{ $user_id }}">
                                            <input type="hidden" name="sender_type" id="sender_type"
                                                value="{{ $role }}">
                                            <input type="hidden" name="receiver_id" id="receiver_id" value="">
                                            <input type="hidden" name="receiver_type" id="receiver_type"
                                                value="">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="text" id="messagesend" class="form-control"
                                                aria-label="message…" placeholder="Write message…">
                                            <button id="send-message-btn" type="button"><i class="fa fa-paper-plane"
                                                    aria-hidden="true"></i> Send</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- chatbox -->
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" name="_token" value={{ csrf_token() }}>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src={{ dynamicAsset('public/assets/custom-js/sendmessage.js') }}></script>
@endsection
