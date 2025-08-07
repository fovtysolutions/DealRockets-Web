// Chatbot Main JavaScript
class Chatbot {
    constructor() {
        this.sessionId = localStorage.getItem('chatbot_session_id') || this.generateSessionId();
        this.isTyping = false;
        this.messageQueue = [];
        
        this.init();
    }

    init() {
        this.bindEvents();
        this.loadConversationHistory();
        this.setupVoiceRecognition();
        this.messageInput = document.getElementById('messageInput');
        this.chatMessages = document.getElementById('chatMessages');
        this.chatForm = document.getElementById('chatForm');
        this.sendBtn = document.getElementById('sendBtn');
        this.voiceBtn = document.getElementById('voiceBtn');
        this.clearChatBtn = document.getElementById('clearChat');
        
        // Focus on input
        if (this.messageInput) {
            this.messageInput.focus();
        }
    }

    generateSessionId() {
        const id = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            const r = Math.random() * 16 | 0;
            const v = c == 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
        localStorage.setItem('chatbot_session_id', id);
        return id;
    }

    bindEvents() {
        // Form submission
        document.addEventListener('DOMContentLoaded', () => {
            const chatForm = document.getElementById('chatForm');
            if (chatForm) {
                chatForm.addEventListener('submit', (e) => this.handleFormSubmit(e));
            }

            // Suggestion buttons
            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('suggestion-btn')) {
                    this.sendMessage(e.target.textContent.trim());
                }
            });

            // Clear chat
            const clearBtn = document.getElementById('clearChat');
            if (clearBtn) {
                clearBtn.addEventListener('click', () => this.clearChat());
            }

            // Voice button
            const voiceBtn = document.getElementById('voiceBtn');
            if (voiceBtn) {
                voiceBtn.addEventListener('click', () => this.startVoiceInput());
            }

            // Enter key handling
            const messageInput = document.getElementById('messageInput');
            if (messageInput) {
                messageInput.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        this.handleFormSubmit(e);
                    }
                });
            }
        });
    }

    handleFormSubmit(e) {
        e.preventDefault();
        const messageInput = document.getElementById('messageInput');
        const message = messageInput.value.trim();
        
        if (message && !this.isTyping) {
            this.sendMessage(message);
            messageInput.value = '';
        }
    }

    async sendMessage(message) {
        if (this.isTyping) return;

        this.addUserMessage(message);
        this.showTypingIndicator();
        this.isTyping = true;

        try {
            const response = await fetch('/chatbot/message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    message: message,
                    session_id: this.sessionId
                })
            });

            const data = await response.json();
            
            if (data.success) {
                this.sessionId = data.session_id;
                localStorage.setItem('chatbot_session_id', this.sessionId);
                
                await this.delay(1000); // Simulate thinking time
                this.hideTypingIndicator();
                this.addBotMessage(data.response);
            } else {
                this.hideTypingIndicator();
                this.addBotMessage({
                    message: 'Sorry, I encountered an error. Please try again.',
                    type: 'text'
                });
            }
        } catch (error) {
            console.error('Chatbot error:', error);
            this.hideTypingIndicator();
            this.addBotMessage({
                message: 'Connection error. Please check your internet and try again.',
                type: 'text'
            });
        } finally {
            this.isTyping = false;
        }
    }

    addUserMessage(message) {
        const messageEl = this.createMessageElement('user', {
            message: this.escapeHtml(message),
            type: 'text'
        });
        this.appendMessage(messageEl);
    }

    addBotMessage(response) {
        const messageEl = this.createMessageElement('bot', response);
        this.appendMessage(messageEl);
    }

    createMessageElement(sender, data) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${sender}-message`;
        
        const contentDiv = document.createElement('div');
        contentDiv.className = 'message-content';
        
        if (sender === 'bot') {
            const avatar = document.createElement('div');
            avatar.className = 'avatar';
            avatar.innerHTML = '<i class="fas fa-robot"></i>';
            contentDiv.appendChild(avatar);
        }
        
        const content = document.createElement('div');
        content.className = 'content';
        
        const textDiv = document.createElement('div');
        textDiv.className = 'text';
        
        // Handle different message types
        switch (data.type) {
            case 'product_list':
                textDiv.innerHTML = data.message;
                if (data.metadata && data.metadata.products) {
                    textDiv.appendChild(this.createProductList(data.metadata.products));
                }
                break;
                
            case 'order_list':
                textDiv.innerHTML = data.message;
                if (data.metadata && data.metadata.orders) {
                    textDiv.appendChild(this.createOrderList(data.metadata.orders));
                }
                break;
                
            case 'form':
                textDiv.innerHTML = data.message;
                if (data.metadata && data.metadata.fields) {
                    const formBtn = document.createElement('button');
                    formBtn.className = 'btn btn-primary btn-sm mt-2';
                    formBtn.textContent = 'Fill Form';
                    formBtn.onclick = () => this.openFormModal(data.metadata);
                    textDiv.appendChild(formBtn);
                }
                break;
                
            case 'contact_info':
                textDiv.innerHTML = data.message;
                if (data.metadata && data.metadata.contact) {
                    textDiv.appendChild(this.createContactInfo(data.metadata.contact));
                }
                break;
                
            case 'help_menu':
                textDiv.innerHTML = data.message;
                if (data.metadata && data.metadata.help_options) {
                    textDiv.appendChild(this.createHelpMenu(data.metadata.help_options));
                }
                break;
                
            case 'category_list':
                textDiv.innerHTML = data.message;
                if (data.metadata && data.metadata.categories) {
                    textDiv.appendChild(this.createCategoryList(data.metadata.categories));
                }
                break;
                
            default:
                textDiv.innerHTML = data.message;
        }
        
        content.appendChild(textDiv);
        
        // Add suggestions if available
        if (data.metadata && data.metadata.suggestions) {
            const suggestionsDiv = document.createElement('div');
            suggestionsDiv.className = 'suggestions mt-2';
            
            data.metadata.suggestions.forEach(suggestion => {
                const btn = document.createElement('button');
                btn.className = 'btn btn-sm btn-outline-primary suggestion-btn';
                btn.textContent = suggestion;
                suggestionsDiv.appendChild(btn);
            });
            
            content.appendChild(suggestionsDiv);
        }
        
        contentDiv.appendChild(content);
        
        if (sender === 'user') {
            const avatar = document.createElement('div');
            avatar.className = 'avatar';
            avatar.innerHTML = '<i class="fas fa-user"></i>';
            contentDiv.appendChild(avatar);
        }
        
        messageDiv.appendChild(contentDiv);
        return messageDiv;
    }

    createProductList(products) {
        const container = document.createElement('div');
        container.className = 'products-list mt-2';
        
        products.forEach(product => {
            const productDiv = document.createElement('div');
            productDiv.className = 'product-item';
            productDiv.onclick = () => window.open(product.url, '_blank');
            
            productDiv.innerHTML = `
                <img src="${product.image}" alt="${product.name}" class="product-image" />
                <div class="product-info">
                    <div class="product-name">${product.name}</div>
                    <div class="product-price">$${product.price}</div>
                </div>
            `;
            
            container.appendChild(productDiv);
        });
        
        return container;
    }

    createOrderList(orders) {
        const container = document.createElement('div');
        container.className = 'orders-list mt-2';
        
        orders.forEach(order => {
            const orderDiv = document.createElement('div');
            orderDiv.className = 'order-item';
            orderDiv.onclick = () => window.open(order.url, '_blank');
            
            orderDiv.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Order #${order.id}</strong>
                        <div class="small text-muted">${order.date}</div>
                    </div>
                    <div class="text-end">
                        <div class="order-status ${order.status}">${order.status}</div>
                        <div class="small">$${order.total}</div>
                    </div>
                </div>
            `;
            
            container.appendChild(orderDiv);
        });
        
        return container;
    }

    createContactInfo(contact) {
        const container = document.createElement('div');
        container.className = 'contact-info';
        
        container.innerHTML = `
            <div class="contact-item"><i class="fas fa-envelope"></i> ${contact.email}</div>
            <div class="contact-item"><i class="fas fa-phone"></i> ${contact.phone}</div>
            <div class="contact-item"><i class="fas fa-map-marker-alt"></i> ${contact.address}</div>
            <div class="contact-item"><i class="fas fa-clock"></i> ${contact.hours}</div>
        `;
        
        return container;
    }

    createHelpMenu(helpOptions) {
        const container = document.createElement('div');
        container.className = 'help-menu';
        
        helpOptions.forEach(option => {
            const optionDiv = document.createElement('div');
            optionDiv.className = 'help-option';
            optionDiv.onclick = () => this.sendMessage(option.title);
            
            optionDiv.innerHTML = `
                <div class="help-option-title">${option.title}</div>
                <div class="help-option-description">${option.description}</div>
            `;
            
            container.appendChild(optionDiv);
        });
        
        return container;
    }

    createCategoryList(categories) {
        const container = document.createElement('div');
        container.className = 'categories-list';
        
        categories.forEach(category => {
            const categoryDiv = document.createElement('div');
            categoryDiv.className = 'category-item';
            categoryDiv.textContent = category;
            categoryDiv.onclick = () => this.sendMessage(`Show me ${category} products`);
            
            container.appendChild(categoryDiv);
        });
        
        return container;
    }

    appendMessage(messageEl) {
        const chatMessages = document.getElementById('chatMessages');
        if (chatMessages) {
            chatMessages.appendChild(messageEl);
            this.scrollToBottom();
        }
    }

    showTypingIndicator() {
        document.getElementById('typingIndicator').style.display = 'inline';
    }

    hideTypingIndicator() {
        document.getElementById('typingIndicator').style.display = 'none';
    }

    scrollToBottom() {
        const chatMessages = document.getElementById('chatMessages');
        if (chatMessages) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    }

    clearChat() {
        const chatMessages = document.getElementById('chatMessages');
        if (chatMessages) {
            // Keep only the welcome message
            const welcomeMessage = chatMessages.firstElementChild;
            chatMessages.innerHTML = '';
            if (welcomeMessage) {
                chatMessages.appendChild(welcomeMessage.cloneNode(true));
            }
        }
        
        // Generate new session
        this.sessionId = this.generateSessionId();
    }

    async loadConversationHistory() {
        try {
            const response = await fetch(`/chatbot/conversation-history?session_id=${this.sessionId}`);
            const data = await response.json();
            
            if (data.success && data.conversations.length > 0) {
                // Skip welcome message and load previous conversations
                data.conversations.forEach(conv => {
                    if (conv.is_bot) {
                        this.addBotMessage({
                            message: conv.message,
                            type: conv.message_type,
                            metadata: conv.metadata
                        });
                    } else {
                        this.addUserMessage(conv.message);
                    }
                });
            }
        } catch (error) {
            console.log('Could not load conversation history:', error);
        }
    }

    openFormModal(metadata) {
        const modal = new bootstrap.Modal(document.getElementById('formModal'));
        const formFields = document.getElementById('formFields');
        const formType = document.getElementById('formType');
        
        formFields.innerHTML = '';
        formType.value = metadata.form_type;
        
        metadata.fields.forEach(field => {
            const fieldHtml = this.createFormField(field);
            formFields.innerHTML += fieldHtml;
        });
        
        modal.show();
    }

    createFormField(field) {
        let fieldHtml = `<div class="mb-3">`;
        fieldHtml += `<label class="form-label">${field.label}`;
        if (field.required) {
            fieldHtml += ' <span class="text-danger">*</span>';
        }
        fieldHtml += '</label>';
        
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
        
        fieldHtml += '</div>';
        return fieldHtml;
    }

    setupVoiceRecognition() {
        if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            this.recognition = new SpeechRecognition();
            
            this.recognition.continuous = false;
            this.recognition.interimResults = false;
            this.recognition.lang = 'en-US';
            
            this.recognition.onresult = (event) => {
                const transcript = event.results[0][0].transcript;
                const messageInput = document.getElementById('messageInput');
                if (messageInput) {
                    messageInput.value = transcript;
                    this.sendMessage(transcript);
                }
            };
            
            this.recognition.onerror = (event) => {
                console.error('Speech recognition error:', event.error);
            };
        }
    }

    startVoiceInput() {
        if (this.recognition) {
            const voiceBtn = document.getElementById('voiceBtn');
            voiceBtn.innerHTML = '<i class="fas fa-stop"></i>';
            voiceBtn.classList.add('btn-danger');
            voiceBtn.classList.remove('btn-outline-secondary');
            
            this.recognition.start();
            
            this.recognition.onend = () => {
                voiceBtn.innerHTML = '<i class="fas fa-microphone"></i>';
                voiceBtn.classList.remove('btn-danger');
                voiceBtn.classList.add('btn-outline-secondary');
            };
        } else {
            alert('Speech recognition is not supported in your browser.');
        }
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    delay(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }
}

// Form submission handler
document.addEventListener('DOMContentLoaded', function() {
    const submitFormBtn = document.getElementById('submitForm');
    if (submitFormBtn) {
        submitFormBtn.addEventListener('click', function() {
            const form = document.getElementById('dynamicForm');
            const formData = new FormData(form);
            const data = {};
            
            for (let [key, value] of formData.entries()) {
                data[key] = value;
            }

            fetch('/chatbot/submit-form', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    form_type: data.form_type,
                    form_data: data,
                    session_id: localStorage.getItem('chatbot_session_id')
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Add success message to chat
                    if (window.chatbot) {
                        window.chatbot.addBotMessage({
                            message: data.message,
                            type: 'text'
                        });
                    }
                    bootstrap.Modal.getInstance(document.getElementById('formModal')).hide();
                }
            })
            .catch(error => {
                console.error('Form submission error:', error);
            });
        });
    }
});

// Initialize chatbot
document.addEventListener('DOMContentLoaded', function() {
    window.chatbot = new Chatbot();
});