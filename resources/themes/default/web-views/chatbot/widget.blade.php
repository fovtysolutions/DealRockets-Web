<!-- Chatbot Widget -->
<div id="chatbotWidget" class="chatbot-widget" style="position: fixed !important; bottom: 30px !important; right: 55px !important; z-index: 999999 !important; display: block !important;">
    <!-- Floating Chat Button -->
    <div id="chatToggle" class="chat-toggle" title="Open AI Assistant">
        <i class="fas fa-comments"></i>
        <span class="notification-badge" id="chatBadge" style="display: none;">1</span>
    </div>

    <!-- Chat Window -->
    <div id="chatWindow" class="chat-window" style="display: none;">
        <div class="chat-header">
            <div class="d-flex align-items-center w-100" style="justify-content: space-between;"">
                <div class="d-flex align-items-center">
                    <div class="chat-avatar me-2">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0">AI Assistant</h6>
                        <small class="text-white">Online</small>
                    </div>
                </div>
                <div class="chat-actions">
                    <button class="btn btn-sm btn-outline-light me-1" id="minimizeChat" title="Minimize">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-light" id="closeChat" title="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="chat-body" id="widgetChatMessages">
            <!-- Welcome Message -->
            <div class="chat-message bot-message">
                <div class="message-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="message-bubble">
                    <div class="message-text">
                        Hi! 👋 I'm your AI shopping assistant. How can I help you today?
                    </div>
                    <div class="message-time">{{ now()->format('H:i') }}</div>
                    <div class="quick-suggestions mt-2">
                        <button class="suggestion-chip" data-message="Search products">🔍 Search products</button>
                        <button class="suggestion-chip" data-message="Post buy requirement">📩 Buy leads</button>
                        <button class="suggestion-chip" data-message="Find jobs">💼 Jobs</button>
                        <button class="suggestion-chip" data-message="Negotiate deals">⚙️ Deals</button>
                        <button class="suggestion-chip" data-message="Membership plans">🧾 Membership</button>
                        <button class="suggestion-chip" data-message="Check my orders">📦 Orders</button>
                        <button class="suggestion-chip" data-message="Help">🆘 Help</button>
                        <button class="suggestion-chip" data-message="Switch language">🌐 Language</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="chat-footer">
            <div class="typing-indicator" id="widgetTypingIndicator" style="display: none;">
                <div class="typing-dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <span class="typing-text">AI is typing...</span>
            </div>
            <form id="widgetChatForm" class="chat-input-form">
                <div class="input-group gap-3">
                    <input type="text" 
                           id="widgetMessageInput" 
                           class="form-control" 
                           placeholder="Type a message..." 
                           autocomplete="off"
                           style="border-radius:25px;background-color:white;color:black;">
                    <button type="submit" class="btn btn-primary" id="widgetSendBtn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
            <div class="text-center mt-1">
                <small class="text-muted">Powered by DealRockets
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Widget Form Modal -->
<div class="modal fade" id="widgetFormModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Complete Information</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="widgetDynamicForm">
                    <div id="widgetFormFields"></div>
                    <input type="hidden" id="widgetFormType" name="form_type">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-sm" id="widgetSubmitForm">Submit</button>
            </div>
        </div>
    </div>
</div>

@push('css_or_js')
<link rel="stylesheet" href="{{ asset('public/assets/front-end/css/chatbot-widget.css') }}">
@endpush

@push('script')
<script>
// Initialize chatbot widget
document.addEventListener('DOMContentLoaded', function() {
    const chatToggle = document.getElementById('chatToggle');
    const chatWindow = document.getElementById('chatWindow');
    const closeChat = document.getElementById('closeChat');
    const minimizeChat = document.getElementById('minimizeChat');
    const widgetChatForm = document.getElementById('widgetChatForm');
    const widgetMessageInput = document.getElementById('widgetMessageInput');
    const widgetChatMessages = document.getElementById('widgetChatMessages');
    const widgetTypingIndicator = document.getElementById('widgetTypingIndicator');

    let sessionId = localStorage.getItem('chatbot_session_id') || generateSessionId();
    let isMinimized = localStorage.getItem('chat_minimized') === 'true';

    // Generate session ID
    function generateSessionId() {
        const id = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            const r = Math.random() * 16 | 0;
            const v = c == 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
        localStorage.setItem('chatbot_session_id', id);
        return id;
    }

    // Toggle chat window
    chatToggle.addEventListener('click', function() {
        const isVisible = chatWindow.style.display !== 'none';
        chatWindow.style.display = isVisible ? 'none' : 'block';
        
        if (!isVisible) {
            chatWindow.classList.add('chat-window-open');
            widgetMessageInput.focus();
            hideNotificationBadge();
        } else {
            chatWindow.classList.remove('chat-window-open');
        }
    });

    // Close chat
    closeChat.addEventListener('click', function() {
        chatWindow.style.display = 'none';
        chatWindow.classList.remove('chat-window-open');
    });

    // Minimize chat
    minimizeChat.addEventListener('click', function() {
        chatWindow.style.display = 'none';
        isMinimized = true;
        localStorage.setItem('chat_minimized', 'true');
    });

    // Handle form submission
    widgetChatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const message = widgetMessageInput.value.trim();
        if (message) {
            sendMessage(message);
            widgetMessageInput.value = '';
        }
    });

    // Handle suggestion clicks
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('suggestion-chip')) {
            const message = e.target.getAttribute('data-message');
            sendMessage(message);
        }
    });

    // Send message function
    function sendMessage(message) {
        addUserMessage(message);
        showTypingIndicator();

        fetch('{{ route("chatbot.message") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                message: message,
                session_id: sessionId
            })
        })
        .then(response => response.json())
        .then(data => {
            hideTypingIndicator();
            if (data.success) {
                sessionId = data.session_id;
                addBotMessage(data.response);
            } else {
                addBotMessage({
                    message: 'Sorry, I encountered an error. Please try again.',
                    type: 'text'
                });
            }
        })
        .catch(error => {
            hideTypingIndicator();
            console.error('Error:', error);
            addBotMessage({
                message: 'Connection error. Please check your internet and try again.',
                type: 'text'
            });
        });
    }

    // Add user message to chat
    function addUserMessage(message) {
        const messageEl = document.createElement('div');
        messageEl.className = 'chat-message user-message';
        messageEl.innerHTML = `
            <div class="message-bubble user-bubble">
                <div class="message-text">${escapeHtml(message)}</div>
                <div class="message-time">${getCurrentTime()}</div>
            </div>
        `;
        widgetChatMessages.appendChild(messageEl);
        scrollToBottom();
    }

    // Add bot message to chat
    function addBotMessage(response) {
        const messageEl = document.createElement('div');
        messageEl.className = 'chat-message bot-message';
        
        let content = `
            <div class="message-avatar">
                <i class="fas fa-robot"></i>
            </div>
            <div class="message-bubble">
                <div class="message-text">${escapeHtml(response.message)}</div>
                <div class="message-time">${getCurrentTime()}</div>
        `;

        // Add specific content based on response type
        if (response.type === 'product_list' && response.metadata?.products) {
            content += '<div class="products-list mt-2">';
            response.metadata.products.slice(0, 3).forEach(product => {
                content += `
                    <div class="product-item">
                        <img src="${product.image}" alt="${product.name}" class="product-image">
                        <div class="product-info">
                            <div class="product-name">${product.name}</div>
                            <div class="product-price">$${product.price}</div>
                            <div class="product-shop">${product.shop}</div>
                        </div>
                    </div>
                `;
            });
            content += '</div>';
        } else if (response.type === 'job_list' && response.metadata?.jobs) {
            content += '<div class="jobs-list mt-2">';
            response.metadata.jobs.slice(0, 3).forEach(job => {
                content += `
                    <div class="job-item">
                        <div class="job-title">${job.title}</div>
                        <div class="job-company">${job.company} - ${job.location}</div>
                        <div class="job-type">${job.type} | ${job.salary}</div>
                        <div class="job-date">${job.posted_date}</div>
                    </div>
                `;
            });
            content += '</div>';
        } else if (response.type === 'lead_list' && response.metadata?.leads) {
            content += '<div class="leads-list mt-2">';
            response.metadata.leads.slice(0, 3).forEach(lead => {
                content += `
                    <div class="lead-item">
                        <div class="lead-name">${lead.name}</div>
                        <div class="lead-product">${lead.product_name}</div>
                        <div class="lead-status">Status: ${lead.status}</div>
                        <div class="lead-date">${lead.created_at}</div>
                    </div>
                `;
            });
            content += '</div>';
        } else if (response.type === 'membership_plans' && response.metadata?.plans) {
            content += '<div class="plans-list mt-2">';
            response.metadata.plans.forEach(plan => {
                content += `
                    <div class="plan-item">
                        <div class="plan-name">${plan.name}</div>
                        <div class="plan-price">$${plan.price}/${plan.duration}</div>
                        <div class="plan-features">${plan.features.slice(0, 2).join(', ')}</div>
                    </div>
                `;
            });
            content += '</div>';
        } else if (response.type === 'language_selector' && response.metadata?.languages) {
            content += '<div class="language-list mt-2">';
            response.metadata.languages.forEach(lang => {
                content += `<button class="suggestion-chip" onclick="switchLanguage('${lang.code}')">${lang.flag} ${lang.name}</button>`;
            });
            content += '</div>';
        } else if (response.type === 'form' && response.metadata?.fields) {
            content += '<button class="btn btn-primary btn-sm mt-2" onclick="openWidgetForm(\'' + JSON.stringify(response.metadata).replace(/'/g, "\\'") + '\')">Fill Form</button>';
        }

        // Add suggestions if available
        if (response.metadata?.suggestions) {
            content += '<div class="quick-suggestions mt-2">';
            response.metadata.suggestions.slice(0, 3).forEach(suggestion => {
                content += `<button class="suggestion-chip" data-message="${suggestion}">${suggestion}</button>`;
            });
            content += '</div>';
        }

        content += '</div>';
        messageEl.innerHTML = content;
        widgetChatMessages.appendChild(messageEl);
        scrollToBottom();
    }

    // Helper functions
    function showTypingIndicator() {
        widgetTypingIndicator.style.display = 'flex';
        scrollToBottom();
    }

    function hideTypingIndicator() {
        widgetTypingIndicator.style.display = 'none';
    }

    function scrollToBottom() {
        widgetChatMessages.scrollTop = widgetChatMessages.scrollHeight;
    }

    function getCurrentTime() {
        return new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function showNotificationBadge() {
        document.getElementById('chatBadge').style.display = 'block';
    }

    function hideNotificationBadge() {
        document.getElementById('chatBadge').style.display = 'none';
    }

    // Global function for form opening
    window.openWidgetForm = function(metadataJson) {
        const metadata = JSON.parse(metadataJson);
        const modal = new bootstrap.Modal(document.getElementById('widgetFormModal'));
        
        // Build form fields
        const formFields = document.getElementById('widgetFormFields');
        formFields.innerHTML = '';
        
        metadata.fields.forEach(field => {
            const fieldHtml = createFormField(field);
            formFields.innerHTML += fieldHtml;
        });
        
        document.getElementById('widgetFormType').value = metadata.form_type;
        modal.show();
    };

    function createFormField(field) {
        let fieldHtml = `<div class="mb-3">`;
        fieldHtml += `<label class="form-label">${field.label} ${field.required ? '<span class="text-danger">*</span>' : ''}</label>`;
        
        switch (field.type) {
            case 'text':
                fieldHtml += `<input type="text" name="${field.name}" class="form-control" ${field.required ? 'required' : ''}>`;
                break;
            case 'email':
                fieldHtml += `<input type="email" name="${field.name}" class="form-control" ${field.required ? 'required' : ''}>`;
                break;
            case 'textarea':
                fieldHtml += `<textarea name="${field.name}" class="form-control" rows="3" ${field.required ? 'required' : ''}></textarea>`;
                break;
            case 'select':
                fieldHtml += `<select name="${field.name}" class="form-control" ${field.required ? 'required' : ''}>`;
                fieldHtml += `<option value="">Choose...</option>`;
                if (field.options) {
                    field.options.forEach(option => {
                        fieldHtml += `<option value="${option}">${option}</option>`;
                    });
                }
                fieldHtml += `</select>`;
                break;
        }
        
        fieldHtml += `</div>`;
        return fieldHtml;
    }

    // Handle form submission
    document.getElementById('widgetSubmitForm').addEventListener('click', function() {
        const form = document.getElementById('widgetDynamicForm');
        const formData = new FormData(form);
        const data = {};
        
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }

        fetch('{{ route("chatbot.submit-form") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                form_type: data.form_type,
                form_data: data,
                session_id: sessionId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                addBotMessage({
                    message: data.message,
                    type: 'text'
                });
                bootstrap.Modal.getInstance(document.getElementById('widgetFormModal')).hide();
            }
        })
        .catch(error => {
            console.error('Form submission error:', error);
        });
    });
});
</script>
@endpush