/**
 * Kaizen Karate Professional Chat Widget
 * Production-ready version for website integration
 */

class KaizenChatWidget {
    constructor(config = {}) {
        this.config = {
            position: config.position || 'bottom-right', // bottom-right, bottom-left
            primaryColor: config.primaryColor || '#c41e3a',
            primaryDark: config.primaryDark || '#a01729',
            apiEndpoint: config.apiEndpoint || './test_chatbot_simple.php',
            greeting: config.greeting || "Hi! I'm the Kaizen Karate Assistant. Ask me anything about our programs, classes, pricing, or instructors! 🥋",
            businessHours: config.businessHours || null, // "Mon-Fri 9am-6pm" or null
            ...config
        };
        
        this.isOpen = false;
        this.isTyping = false;
        this.messageHistory = [];
        
        this.init();
    }
    
    init() {
        this.createWidget();
        this.bindEvents();
        this.addInitialMessage();
        this.applyCustomization();
        this.showIndicatorDelayed();
    }
    
    createWidget() {
        // Create widget HTML
        const widgetHTML = `
            <!-- Chat Widget Bubble -->
            <div id="kaizen-chat-widget" title="Chat with Kaizen Karate Assistant">
                <div id="kaizen-chat-icon">💬</div>
            </div>
            
            <!-- Chat Container -->
            <div id="kaizen-chat-container">
                <!-- Header -->
                <div id="kaizen-chat-header">
                    <h3 id="kaizen-chat-title">
                        🥋 Kaizen Karate Assistant
                    </h3>
                    <button id="kaizen-chat-close" title="Close chat">&times;</button>
                </div>
                
                <!-- Messages Area -->
                <div id="kaizen-chat-messages">
                    <!-- Messages will be inserted here -->
                </div>
                
                <!-- Typing Indicator -->
                <div id="kaizen-typing-indicator">
                    <div class="kaizen-typing-bubble">
                        <div class="kaizen-typing-dot"></div>
                        <div class="kaizen-typing-dot"></div>
                        <div class="kaizen-typing-dot"></div>
                    </div>
                </div>
                
                <!-- Input Area -->
                <div id="kaizen-chat-input-area">
                    <div id="kaizen-chat-input-container">
                        <textarea id="kaizen-chat-input" 
                                  placeholder="Ask about classes, pricing, instructors..." 
                                  rows="1"></textarea>
                        <button id="kaizen-chat-send" title="Send message" disabled>
                            ▶
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        // Insert widget into page
        document.body.insertAdjacentHTML('beforeend', widgetHTML);
        
        // Add attention indicator
        const indicatorHTML = `
            <div id="kaizen-chat-indicator">
                Questions? Use Kaizen's AI-Powered Chat Assistant!
                <button class="chat-indicator-close" title="Dismiss">&times;</button>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', indicatorHTML);
        
        // Get references
        this.widget = document.getElementById('kaizen-chat-widget');
        this.container = document.getElementById('kaizen-chat-container');
        this.messages = document.getElementById('kaizen-chat-messages');
        this.input = document.getElementById('kaizen-chat-input');
        this.sendBtn = document.getElementById('kaizen-chat-send');
        this.closeBtn = document.getElementById('kaizen-chat-close');
        this.typingIndicator = document.getElementById('kaizen-typing-indicator');
        this.inputContainer = document.getElementById('kaizen-chat-input-container');
        this.indicator = document.getElementById('kaizen-chat-indicator');
        this.indicatorCloseBtn = document.querySelector('.chat-indicator-close');
    }
    
    bindEvents() {
        // Widget click to toggle
        this.widget.addEventListener('click', () => this.toggleChat());
        
        // Close button
        this.closeBtn.addEventListener('click', () => this.closeChat());
        
        // Send button
        this.sendBtn.addEventListener('click', () => this.sendMessage());
        
        // Input events
        this.input.addEventListener('input', (e) => this.handleInput(e));
        this.input.addEventListener('keydown', (e) => this.handleKeydown(e));
        this.input.addEventListener('focus', () => this.inputContainer.classList.add('focused'));
        this.input.addEventListener('blur', () => this.inputContainer.classList.remove('focused'));
        
        // Auto-resize textarea
        this.input.addEventListener('input', () => this.autoResizeTextarea());
        
        // Close on outside click
        document.addEventListener('click', (e) => {
            if (this.isOpen && !this.container.contains(e.target) && !this.widget.contains(e.target)) {
                this.closeChat();
            }
        });
        
        // Escape key to close
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen) {
                this.closeChat();
            }
        });
        
        // Indicator close button
        this.indicatorCloseBtn.addEventListener('click', () => this.hideIndicator());
        
        // Hide indicator when chat is opened
        this.widget.addEventListener('click', () => this.hideIndicator());
    }
    
    applyCustomization() {
        const root = document.documentElement;
        
        // Apply custom colors
        if (this.config.primaryColor) {
            root.style.setProperty('--primary-color', this.config.primaryColor);
        }
        if (this.config.primaryDark) {
            root.style.setProperty('--primary-dark', this.config.primaryDark);
        }
        
        // Apply position
        if (this.config.position === 'bottom-left') {
            this.widget.style.left = '20px';
            this.widget.style.right = 'auto';
            this.container.style.left = '20px';
            this.container.style.right = 'auto';
        }
    }
    
    toggleChat() {
        if (this.isOpen) {
            this.closeChat();
        } else {
            this.openChat();
        }
    }
    
    openChat() {
        this.isOpen = true;
        this.widget.classList.add('chat-open');
        this.container.classList.add('visible');
        
        // Focus input after animation
        setTimeout(() => {
            this.input.focus();
        }, 300);
        
        // Track opening (analytics hook)
        this.trackEvent('chat_opened');
    }
    
    closeChat() {
        this.isOpen = false;
        this.widget.classList.remove('chat-open');
        this.container.classList.remove('visible');
        
        // Track closing (analytics hook)
        this.trackEvent('chat_closed');
    }
    
    addInitialMessage() {
        const welcomeMessage = this.config.greeting;
        let businessHoursNote = '';
        
        if (this.config.businessHours) {
            businessHoursNote = `\n\nOur office hours are ${this.config.businessHours}. I'm available 24/7 to answer questions about our programs!`;
        }
        
        this.addMessage(welcomeMessage + businessHoursNote, 'bot', false);
    }
    
    handleInput(e) {
        const value = e.target.value.trim();
        this.sendBtn.disabled = !value;
        
        // Auto-resize
        this.autoResizeTextarea();
    }
    
    handleKeydown(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            if (!this.sendBtn.disabled) {
                this.sendMessage();
            }
        }
    }
    
    autoResizeTextarea() {
        const textarea = this.input;
        textarea.style.height = 'auto';
        textarea.style.height = Math.min(textarea.scrollHeight, 80) + 'px';
    }
    
    sendMessage() {
        const message = this.input.value.trim();
        if (!message || this.isTyping) return;
        
        // Add user message
        this.addMessage(message, 'user');
        
        // Clear input
        this.input.value = '';
        this.sendBtn.disabled = true;
        this.autoResizeTextarea();
        
        // Show dynamic loading messages
        this.showDynamicLoading(message);
        
        // Send to chatbot
        this.sendToChatbot(message);
        
        // Track message (analytics hook)
        this.trackEvent('message_sent', { message: message });
    }
    
    async sendToChatbot(message) {
        try {
            const response = await fetch(this.config.apiEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `question=${encodeURIComponent(message)}`
            });
            
            const text = await response.text();
            
            // Parse JSON safely
            let data;
            try {
                data = JSON.parse(text);
            } catch (e) {
                console.error('JSON Parse Error:', e);
                console.error('Raw Response:', text);
                throw new Error('Invalid response from server');
            }
            
            this.hideDynamicLoading();
            
            if (data.success) {
                this.addMessage(data.response, 'bot');
                this.trackEvent('bot_response_success');
            } else {
                this.addMessage(
                    "I'm sorry, I'm having trouble processing your request right now. Please try again or contact us directly at 301-938-2711.",
                    'bot',
                    true
                );
                this.trackEvent('bot_response_error', { error: data.error });
            }
        } catch (error) {
            this.hideDynamicLoading();
            console.error('Chat Error:', error);
            
            this.addMessage(
                "I'm having trouble connecting right now. Please try again in a moment or call us at 301-938-2711 for immediate assistance.",
                'bot',
                true
            );
            this.trackEvent('chat_error', { error: error.message });
        }
    }
    
    addMessage(content, sender, isError = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `kaizen-message ${sender}`;
        
        const bubbleDiv = document.createElement('div');
        bubbleDiv.className = `kaizen-message-bubble ${isError ? 'kaizen-error-message' : ''}`;
        
        // Convert line breaks to <br> and make links clickable
        const formattedContent = this.formatMessageContent(content);
        bubbleDiv.innerHTML = formattedContent;
        
        messageDiv.appendChild(bubbleDiv);
        this.messages.appendChild(messageDiv);
        
        // Scroll to bottom
        this.scrollToBottom();
        
        // Store in history
        this.messageHistory.push({ content, sender, timestamp: Date.now() });
    }
    
    formatMessageContent(content) {
        let formatted = content;
        
        try {
            // Handle markdown links FIRST: [text](url)
            const markdownLinkRegex = /\[([^\]]+)\]\(([^)]+)\)/g;
            formatted = formatted.replace(markdownLinkRegex, '<a href="$2" target="_blank" rel="noopener noreferrer">$1</a>');
            
            // THEN clean up any malformed HTML patterns
            formatted = formatted.replace(/\" target=\"_blank\" rel=\"noopener noreferrer\">/g, '');
            formatted = formatted.replace(/target=\"_blank\" rel=\"noopener noreferrer\">/g, '');
            formatted = formatted.replace(/" target="_blank" rel="noopener noreferrer">/g, '');
            formatted = formatted.replace(/target="_blank" rel="noopener noreferrer">/g, '');
            formatted = formatted.replace(/rel="noopener noreferrer">/g, '');
            formatted = formatted.replace(/target="_blank">/g, '');
            
            // Make remaining URLs clickable BEFORE converting line breaks
            const urlRegex = /(https?:\/\/[^\s<>")\]]+)/g;
            formatted = formatted.replace(urlRegex, '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>');
            
            // Format bold text **text** -> <strong>text</strong>
            formatted = formatted.replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>');
            
            // Format italic text *text* -> <em>text</em> (simple version)
            formatted = formatted.replace(/\*([^*]+)\*/g, '<em>$1</em>');
            
            // Format bullet points
            formatted = formatted.replace(/^[•\-]\s+/gm, '• ');
            formatted = formatted.replace(/\n[•\-]\s+/g, '\n• ');
            
            // Convert line breaks
            formatted = formatted.replace(/\n/g, '<br>');
            
        } catch (error) {
            console.error('Error formatting message:', error);
            // If formatting fails, just do basic line break conversion
            formatted = content.replace(/\n/g, '<br>');
        }
        
        return formatted;
    }
    
    showTyping() {
        this.isTyping = true;
        this.typingIndicator.classList.add('visible');
        this.scrollToBottom();
    }
    
    hideTyping() {
        this.isTyping = false;
        this.typingIndicator.classList.remove('visible');
    }
    
    /**
     * Show dynamic, context-aware loading messages
     */
    showDynamicLoading(userMessage) {
        this.isTyping = true;
        this.loadingMessageIndex = 0;
        this.loadingMessages = this.getContextualLoadingMessages(userMessage);
        
        // Update the typing indicator with the first message
        this.updateLoadingMessage();
        this.typingIndicator.classList.add('visible');
        
        // Start cycling through messages every 2.5 seconds
        this.loadingInterval = setInterval(() => {
            this.loadingMessageIndex = (this.loadingMessageIndex + 1) % this.loadingMessages.length;
            this.updateLoadingMessage();
        }, 2500);
        
        this.scrollToBottom();
    }
    
    /**
     * Get contextual loading messages based on user's question
     */
    getContextualLoadingMessages(userMessage) {
        const message = userMessage.toLowerCase();
        
        // Pricing related
        if (message.includes('price') || message.includes('cost') || message.includes('tuition') || 
            message.includes('fee') || message.includes('how much') || message.includes('expensive')) {
            return [
                "💰 Searching for pricing information...",
                "📊 Reviewing tuition rates...",
                "💳 Finding cost details..."
            ];
        }
        
        // Instructors related
        if (message.includes('instructor') || message.includes('teacher') || message.includes('sensei') || 
            message.includes('coach') || message.includes('who teaches')) {
            return [
                "👨‍🏫 Looking up our instructors...",
                "🥋 Getting instructor bios...",
                "📋 Reviewing teaching staff..."
            ];
        }
        
        // Schedule/Classes related
        if (message.includes('schedule') || message.includes('class') || message.includes('time') || 
            message.includes('when') || message.includes('hours') || message.includes('day')) {
            return [
                "📅 Checking class schedules...",
                "⏰ Looking up available times...",
                "📋 Reviewing program schedules..."
            ];
        }
        
        // Summer Camp related
        if (message.includes('summer') || message.includes('camp') || message.includes('vacation')) {
            return [
                "🏕️ Reviewing summer camp details...",
                "☀️ Checking camp programs...",
                "🎯 Finding camp information..."
            ];
        }
        
        // Belt/Testing related
        if (message.includes('belt') || message.includes('test') || message.includes('exam') || 
            message.includes('rank') || message.includes('promotion')) {
            return [
                "🥋 Reviewing belt exam requirements...",
                "📝 Checking testing procedures...",
                "🏆 Looking up promotion details..."
            ];
        }
        
        // Registration related
        if (message.includes('register') || message.includes('sign up') || message.includes('enroll') || 
            message.includes('join') || message.includes('start')) {
            return [
                "📝 Finding registration information...",
                "✍️ Looking up enrollment process...",
                "🎯 Getting signup details..."
            ];
        }
        
        // Location/Contact related
        if (message.includes('location') || message.includes('address') || message.includes('where') || 
            message.includes('contact') || message.includes('phone') || message.includes('email')) {
            return [
                "📍 Looking up location details...",
                "📞 Getting contact information...",
                "🗺️ Finding address information..."
            ];
        }
        
        // After School Program related
        if (message.includes('after school') || message.includes('afterschool')) {
            return [
                "🎒 Checking after school programs...",
                "📚 Reviewing after school details...",
                "⏰ Looking up program schedules..."
            ];
        }
        
        // Kaizen Dojo related
        if (message.includes('kaizen dojo') || message.includes('dojo')) {
            return [
                "🏢 Reviewing Kaizen Dojo programs...",
                "🥋 Checking dojo information...",
                "📋 Getting program details..."
            ];
        }
        
        // Default messages for general questions
        return [
            "🔍 Searching through our information...",
            "💭 Let me find that for you...",
            "📚 Looking through our programs...",
            "⚡ Almost there...",
            "🎯 Gathering the details..."
        ];
    }
    
    /**
     * Update the loading message display with smooth transition
     */
    updateLoadingMessage() {
        const currentMessage = this.loadingMessages[this.loadingMessageIndex];
        const bubble = this.typingIndicator.querySelector('.kaizen-typing-bubble');
        
        // Add fade-out effect
        bubble.style.opacity = '0.5';
        bubble.style.transform = 'scale(0.95)';
        
        setTimeout(() => {
            // Update the message content
            bubble.innerHTML = `
                <span class="dynamic-loading-text">${currentMessage}</span>
                <div class="kaizen-typing-dots">
                    <div class="kaizen-typing-dot"></div>
                    <div class="kaizen-typing-dot"></div>
                    <div class="kaizen-typing-dot"></div>
                </div>
            `;
            
            // Add fade-in effect
            bubble.style.opacity = '1';
            bubble.style.transform = 'scale(1)';
        }, 200);
    }
    
    /**
     * Hide dynamic loading messages
     */
    hideDynamicLoading() {
        this.isTyping = false;
        this.typingIndicator.classList.remove('visible');
        
        // Clear the loading interval
        if (this.loadingInterval) {
            clearInterval(this.loadingInterval);
            this.loadingInterval = null;
        }
        
        // Reset the typing indicator to original dots
        const bubble = this.typingIndicator.querySelector('.kaizen-typing-bubble');
        bubble.innerHTML = `
            <div class="kaizen-typing-dot"></div>
            <div class="kaizen-typing-dot"></div>
            <div class="kaizen-typing-dot"></div>
        `;
        bubble.style.opacity = '1';
        bubble.style.transform = 'scale(1)';
    }
    
    scrollToBottom() {
        setTimeout(() => {
            this.messages.scrollTop = this.messages.scrollHeight;
        }, 100);
    }
    
    trackEvent(event, data = {}) {
        // Analytics hook - integrate with your analytics platform
        if (typeof gtag !== 'undefined') {
            gtag('event', event, {
                event_category: 'chat_widget',
                ...data
            });
        }
        
        // Console log for debugging (remove in production)
        console.log('Chat Event:', event, data);
    }
    
    // Public API methods
    open() {
        this.openChat();
    }
    
    close() {
        this.closeChat();
    }
    
    sendBotMessage(message) {
        this.addMessage(message, 'bot');
    }
    
    setConfig(newConfig) {
        this.config = { ...this.config, ...newConfig };
        this.applyCustomization();
    }
    
    // Indicator Management Methods
    showIndicatorDelayed() {
        // Show indicator after 3 seconds
        setTimeout(() => {
            if (!this.indicatorDismissed && !this.isOpen) {
                this.showIndicator();
            }
        }, 3000);
    }
    
    showIndicator() {
        if (this.indicator && !this.indicatorDismissed) {
            this.indicator.classList.add('visible');
            
            // Set up reappearance after 30 seconds if not used
            if (this.indicatorTimer) {
                clearTimeout(this.indicatorTimer);
            }
            
            this.indicatorTimer = setTimeout(() => {
                if (!this.indicatorDismissed && !this.isOpen) {
                    this.showIndicator();
                }
            }, 30000);
        }
    }
    
    hideIndicator() {
        if (this.indicator) {
            this.indicator.classList.remove('visible');
            this.indicator.classList.add('hidden');
            this.indicatorDismissed = true;
            
            if (this.indicatorTimer) {
                clearTimeout(this.indicatorTimer);
                this.indicatorTimer = null;
            }
        }
    }
}

// Initialize widget when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Check if widget is already initialized
    if (window.kaizenChat) return;
    
    // Get configuration from global variable if available
    const config = window.kaizenChatConfig || {};
    
    // Initialize widget
    window.kaizenChat = new KaizenChatWidget(config);
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = KaizenChatWidget;
}