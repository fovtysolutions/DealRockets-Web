@extends('layouts.front-end.app')

@section('title', 'AI Assistant | ' . $web_config['name']->value)

@push('css_or_js')
    <link rel="stylesheet" href="{{ asset('public/assets/front-end/css/chatbot.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="container mt-4 mb-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card chatbot-container">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex align-items-center">
                        <div class="chatbot-avatar me-3">
                            <i class="fas fa-robot"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">AI Shopping Assistant</h5>
                            <small>Here to help you find what you're looking for!</small>
                        </div>
                        <div class="ms-auto">
                            <button class="btn btn-sm btn-outline-light" id="clearChat">
                                <i class="fas fa-trash"></i> Clear
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <div id="chatMessages" class="chat-messages">
                        <!-- Welcome message -->
                        <div class="message bot-message">
                            <div class="message-content">
                                <div class="avatar">
                                    <i class="fas fa-robot"></i>
                                </div>
                                <div class="content">
                                    <div class="text">
                                        Hello! 👋 I'm your AI shopping assistant. I can help you:
                                        <ul class="mt-2 mb-2">
                                            <li>Find products and check availability</li>
                                            <li>Track your orders and delivery status</li>
                                            <li>Answer questions about our services</li>
                                            <li>Help you submit inquiries and forms</li>
                                            <li>Provide customer support</li>
                                        </ul>
                                        What can I help you with today?
                                    </div>
                                    <div class="suggestions mt-2">
                                        <button class="btn btn-sm btn-outline-primary suggestion-btn">Search products</button>
                                        <button class="btn btn-sm btn-outline-primary suggestion-btn">Check my orders</button>
                                        <button class="btn btn-sm btn-outline-primary suggestion-btn">Contact support</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <form id="chatForm" class="d-flex gap-2">
                        <div class="flex-grow-1">
                            <input type="text" 
                                   id="messageInput" 
                                   class="form-control" 
                                   placeholder="Type your message here..." 
                                   autocomplete="off">
                        </div>
                        <button type="submit" class="btn btn-primary" id="sendBtn">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="voiceBtn" title="Voice input">
                            <i class="fas fa-microphone"></i>
                        </button>
                    </form>
                    <div class="text-muted small mt-2 text-center">
                        Press Enter to send • <span id="typingIndicator" style="display: none;">AI is typing...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form Modal -->
<div class="modal fade" id="formModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Submit Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="dynamicForm">
                    <div id="formFields"></div>
                    <input type="hidden" id="formType" name="form_type">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitForm">Submit</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('public/assets/front-end/js/chatbot.js') }}"></script>
@endpush