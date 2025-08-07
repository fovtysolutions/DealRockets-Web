@extends('layouts.front-end.app')

@section('title', 'AI Chatbot Assistant')

@push('css_or_js')
<style>
    .chatbot-container {
        max-width: 800px;
        margin: 0 auto;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .chatbot-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        text-align: center;
    }
    
    .chat-messages {
        height: 500px;
        overflow-y: auto;
        padding: 20px;
        background: #f8f9fa;
    }
    
    .message {
        margin-bottom: 15px;
        display: flex;
        align-items: flex-start;
    }
    
    .message.user {
        justify-content: flex-end;
    }
    
    .message.bot {
        justify-content: flex-start;
    }
    
    .message-content {
        max-width: 70%;
        padding: 12px 16px;
        border-radius: 18px;
        word-wrap: break-word;
    }
    
    .message.user .message-content {
        background: #007bff;
        color: white;
        border-bottom-right-radius: 4px;
    }
    
    .message.bot .message-content {
        background: white;
        color: #333;
        border: 1px solid #e9ecef;
        border-bottom-left-radius: 4px;
    }
    
    .chat-input-container {
        padding: 20px;
        background: white;
        border-top: 1px solid #e9ecef;
    }
    
    .chat-input {
        display: flex;
        gap: 10px;
    }
    
    .chat-input input {
        flex: 1;
        padding: 12px 16px;
        border: 1px solid #ddd;
        border-radius: 25px;
        outline: none;
        font-size: 14px;
    }
    
    .chat-input button {
        padding: 12px 20px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        font-size: 14px;
        transition: background 0.3s;
    }
    
    .chat-input button:hover {
        background: #0056b3;
    }
    
    .suggestions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
    }
    
    .suggestion-btn {
        padding: 6px 12px;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 15px;
        cursor: pointer;
        font-size: 12px;
        transition: all 0.3s;
    }
    
    .suggestion-btn:hover {
        background: #007bff;
        color: white;
        border-color: #007bff;
    }
    
    .typing-indicator {
        display: none;
        padding: 10px;
        font-style: italic;
        color: #666;
    }
    
    .product-list, .job-list, .lead-list {
        display: grid;
        gap: 10px;
        margin-top: 10px;
    }
    
    .product-item, .job-item, .lead-item {
        background: #f8f9fa;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }
    
    .form-container {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-top: 10px;
    }
    
    .form-field {
        margin-bottom: 15px;
    }
    
    .form-field label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }
    
    .form-field input, .form-field textarea, .form-field select {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }
    
    .form-submit-btn {
        background: #28a745;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }
    
    .form-submit-btn:hover {
        background: #218838;
    }
</style>
@endpush

@section('content')
<div class="container-fluid rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
    <div class="row">
        <div class="col-md-12">
            <div class="chatbot-container mt-4 mb-4">
                <!-- Chatbot Header -->
                <div class="chatbot-header">
                    <h3><i class="fas fa-robot"></i> AI Marketplace Assistant</h3>
                    <p class="mb-0">Ask me anything about products, jobs, leads, or get help with your account!</p>
                </div>
                
                <!-- Chat Messages Area -->
                <div class="chat-messages" id="chatMessages">
                    <div class="message bot">
                        <div class="message-content">
                            <strong>🤖 Assistant:</strong> Hello! I'm your AI marketplace assistant. I can help you with:
                            <div class="suggestions mt-2">
                                <span class="suggestion-btn" onclick="sendMessage('Search products')">🔍 Search Products</span>
                                <span class="suggestion-btn" onclick="sendMessage('Post buy requirement')">📩 Post Buy Lead</span>
                                <span class="suggestion-btn" onclick="sendMessage('Find jobs')">💼 Find Jobs</span>
                                <span class="suggestion-btn" onclick="sendMessage('My orders')">📦 My Orders</span>
                                <span class="suggestion-btn" onclick="sendMessage('Help')">🆘 Help & Support</span>
                                <span class="suggestion-btn" onclick="sendMessage('Switch language')">🌐 Language</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Typing Indicator -->
                <div class="typing-indicator" id="typingIndicator">
                    Assistant is typing...
                </div>
                
                <!-- Chat Input -->
                <div class="chat-input-container">
                    <div class="chat-input">
                        <input type="text" id="messageInput" placeholder="Type your message here..." onkeypress="handleKeyPress(event)">
                        <button onclick="sendMessage()" id="sendButton">
                            <i class="fas fa-paper-plane"></i> Send
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
let sessionId = null;
let currentLanguage = 'en';

// Initialize session
document.addEventListener('DOMContentLoaded', function() {
    sessionId = generateSessionId();
    loadConversationHistory();
});

function generateSessionId() {
    return 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
}

function handleKeyPress(event) {
    if (event.key === 'Enter') {
        sendMessage();
    }
}

function sendMessage(predefinedMessage = null) {
    const messageInput = document.getElementById('messageInput');
    const message = predefinedMessage || messageInput.value.trim();
    
    if (!message) return;
    
    // Clear input if not predefined message
    if (!predefinedMessage) {
        messageInput.value = '';
    }
    
    // Add user message to chat
    addMessageToChat('user', message);
    
    // Show typing indicator
    showTypingIndicator();
    
    // Send message to backend
    fetch('{{ route("chatbot.message") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            message: message,
            session_id: sessionId,
            language: currentLanguage
        })
    })
    .then(response => response.json())
    .then(data => {
        hideTypingIndicator();
        
        if (data.success) {
            sessionId = data.session_id;
            handleBotResponse(data.response);
        } else {
            addMessageToChat('bot', 'Sorry, I encountered an error. Please try again.');
        }
    })
    .catch(error => {
        hideTypingIndicator();
        console.error('Error:', error);
        addMessageToChat('bot', 'Sorry, something went wrong. Please try again.');
    });
}

function addMessageToChat(sender, message, metadata = null) {
    const chatMessages = document.getElementById('chatMessages');
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${sender}`;
    
    let content = `<div class="message-content">`;
    
    if (sender === 'bot') {
        content += `<strong>🤖 Assistant:</strong> ${message}`;
    } else {
        content += message;
    }
    
    // Handle metadata for special message types
    if (metadata) {
        content += handleMetadata(metadata);
    }
    
    content += `</div>`;
    messageDiv.innerHTML = content;
    
    chatMessages.appendChild(messageDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

function handleBotResponse(response) {
    addMessageToChat('bot', response.message, response.metadata);
}

function handleMetadata(metadata) {
    let content = '';
    
    // Handle suggestions
    if (metadata.suggestions) {
        content += '<div class="suggestions mt-2">';
        metadata.suggestions.forEach(suggestion => {
            content += `<span class="suggestion-btn" onclick="sendMessage('${suggestion}')">${suggestion}</span>`;
        });
        content += '</div>';
    }
    
    // Handle product list
    if (metadata.products) {
        content += '<div class="product-list mt-2">';
        metadata.products.forEach(product => {
            content += `
                <div class="product-item">
                    <strong>${product.name}</strong><br>
                    <small>Price: $${product.price} | Shop: ${product.shop}</small><br>
                    <a href="${product.url}" target="_blank" class="btn btn-sm btn-primary mt-1">View Product</a>
                </div>
            `;
        });
        content += '</div>';
    }
    
    // Handle job list
    if (metadata.jobs) {
        content += '<div class="job-list mt-2">';
        metadata.jobs.forEach(job => {
            content += `
                <div class="job-item">
                    <strong>${job.title}</strong><br>
                    <small>Company: ${job.company} | Location: ${job.location}</small><br>
                    <small>Type: ${job.type} | Salary: ${job.salary}</small>
                </div>
            `;
        });
        content += '</div>';
    }
    
    // Handle forms
    if (metadata.form_type) {
        content += generateForm(metadata);
    }
    
    // Handle language list
    if (metadata.languages) {
        content += '<div class="suggestions mt-2">';
        metadata.languages.forEach(lang => {
            content += `<span class="suggestion-btn" onclick="switchLanguage('${lang.code}')">${lang.flag} ${lang.name}</span>`;
        });
        content += '</div>';
    }
    
    return content;
}

function generateForm(metadata) {
    let formHtml = `<div class="form-container">`;
    formHtml += `<form onsubmit="submitForm(event, '${metadata.form_type}')">`;
    
    metadata.fields.forEach(field => {
        formHtml += `<div class="form-field">`;
        formHtml += `<label>${field.label}${field.required ? ' *' : ''}</label>`;
        
        if (field.type === 'textarea') {
            formHtml += `<textarea name="${field.name}" ${field.required ? 'required' : ''}></textarea>`;
        } else if (field.type === 'select') {
            formHtml += `<select name="${field.name}" ${field.required ? 'required' : ''}>`;
            formHtml += `<option value="">Select ${field.label}</option>`;
            if (field.options) {
                if (Array.isArray(field.options)) {
                    field.options.forEach(option => {
                        formHtml += `<option value="${option}">${option}</option>`;
                    });
                } else {
                    Object.entries(field.options).forEach(([key, value]) => {
                        formHtml += `<option value="${key}">${value}</option>`;
                    });
                }
            }
            formHtml += `</select>`;
        } else {
            formHtml += `<input type="${field.type}" name="${field.name}" ${field.required ? 'required' : ''}>`;
        }
        
        formHtml += `</div>`;
    });
    
    formHtml += `<button type="submit" class="form-submit-btn">Submit</button>`;
    formHtml += `</form></div>`;
    
    return formHtml;
}

function submitForm(event, formType) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const formObject = {};
    
    for (let [key, value] of formData.entries()) {
        formObject[key] = value;
    }
    
    fetch('{{ route("chatbot.submit-form") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            form_type: formType,
            form_data: formObject,
            session_id: sessionId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            addMessageToChat('bot', data.message);
            event.target.style.display = 'none'; // Hide form after submission
        } else {
            addMessageToChat('bot', 'Sorry, there was an error submitting the form.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        addMessageToChat('bot', 'Sorry, something went wrong with the form submission.');
    });
}

function switchLanguage(languageCode) {
    currentLanguage = languageCode;
    
    fetch('{{ route("chatbot.language.switch") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            language_code: languageCode
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            addMessageToChat('bot', `Language switched to ${data.language.name} successfully!`);
        } else {
            addMessageToChat('bot', 'Sorry, could not switch language.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        addMessageToChat('bot', 'Sorry, something went wrong.');
    });
}

function showTypingIndicator() {
    document.getElementById('typingIndicator').style.display = 'block';
    document.getElementById('chatMessages').scrollTop = document.getElementById('chatMessages').scrollHeight;
}

function hideTypingIndicator() {
    document.getElementById('typingIndicator').style.display = 'none';
}

function loadConversationHistory() {
    if (!sessionId) return;
    
    fetch(`{{ route("chatbot.history") }}?session_id=${sessionId}`)
    .then(response => response.json())
    .then(data => {
        if (data.success && data.conversations.length > 0) {
            data.conversations.forEach(conversation => {
                const sender = conversation.is_bot ? 'bot' : 'user';
                const metadata = conversation.metadata ? JSON.parse(conversation.metadata) : null;
                addMessageToChat(sender, conversation.message, metadata);
            });
        }
    })
    .catch(error => {
        console.error('Error loading history:', error);
    });
}
</script>
@endpush