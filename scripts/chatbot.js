/**
 * Kaizen Karate Chatbot Widget
 * Enhanced chat functionality with improved UI and error handling
 */

class KaizenChatbot {
  constructor() {
    // Configuration
    this.API_URL = "https://1b464271-17da-4f31-a2c1-9a5d23070c05-00-1vocagoifybuc.kirk.replit.dev/chat";
    this.isOpen = false;
    this.isTyping = false;
    
    // Initialize the chatbot
    this.init();
  }

  // Initialize chatbot functionality
  init() {
    this.bindEvents();
    this.addWelcomeMessage();
  }

  // Bind event listeners
  bindEvents() {
    const toggleBtn = document.getElementById('kk-toggle');
    const closeBtn = document.getElementById('kk-close');
    const form = document.getElementById('kk-form');
    const input = document.getElementById('kk-input');

    if (toggleBtn) {
      toggleBtn.addEventListener('click', () => this.openChat());
    }

    if (closeBtn) {
      closeBtn.addEventListener('click', () => this.closeChat());
    }

    if (form) {
      form.addEventListener('submit', (e) => this.handleSubmit(e));
    }

    if (input) {
      input.addEventListener('keypress', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
          e.preventDefault();
          this.handleSubmit(e);
        }
      });
    }

    // Close chat when clicking outside
    document.addEventListener('click', (e) => {
      const chatWidget = document.getElementById('kk-chat');
      if (this.isOpen && chatWidget && !chatWidget.contains(e.target)) {
        // Uncomment the line below if you want to close chat when clicking outside
        // this.closeChat();
      }
    });
  }

  // Open chat panel
  openChat() {
    const panel = document.getElementById('kk-panel');
    const toggle = document.getElementById('kk-toggle');
    const input = document.getElementById('kk-input');

    if (panel && toggle) {
      panel.style.display = 'block';
      toggle.style.display = 'none';
      this.isOpen = true;

      // Focus on input with slight delay for better UX
      setTimeout(() => {
        if (input) input.focus();
      }, 100);

      // Add opening animation
      panel.style.opacity = '0';
      panel.style.transform = 'translateY(20px)';
      setTimeout(() => {
        panel.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        panel.style.opacity = '1';
        panel.style.transform = 'translateY(0)';
      }, 10);
    }
  }

  // Close chat panel
  closeChat() {
    const panel = document.getElementById('kk-panel');
    const toggle = document.getElementById('kk-toggle');

    if (panel && toggle) {
      // Add closing animation
      panel.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
      panel.style.opacity = '0';
      panel.style.transform = 'translateY(20px)';

      setTimeout(() => {
        panel.style.display = 'none';
        toggle.style.display = 'inline-block';
        this.isOpen = false;
      }, 300);
    }
  }

  // Add welcome message when chat loads
  addWelcomeMessage() {
    setTimeout(() => {
      this.addMessage({
        isUser: false,
        text: "👋 Hi! I'm here to help you with questions about Kaizen Karate. Ask me about class schedules, locations, belt requirements, or anything else!",
        isWelcome: true
      });
    }, 500);
  }

  // Add message to chat log
  addMessage({ isUser, text, isTyping = false, id = null }) {
    const log = document.getElementById('kk-log');
    if (!log) return;

    const messageDiv = document.createElement('div');
    messageDiv.className = `kk-msg ${isUser ? 'kk-me' : 'kk-bot'}`;
    
    if (id) {
      messageDiv.id = `msg-${id}`;
    }

    const bubbleDiv = document.createElement('div');
    bubbleDiv.className = `kk-bubble ${isTyping ? 'kk-typing' : ''}`;
    
    if (isTyping) {
      bubbleDiv.innerHTML = '💭 Thinking...';
    } else {
      bubbleDiv.innerHTML = text;
    }

    messageDiv.appendChild(bubbleDiv);
    log.appendChild(messageDiv);

    // Scroll to bottom
    this.scrollToBottom();
  }

  // Remove message by ID
  removeMessage(id) {
    const message = document.getElementById(`msg-${id}`);
    if (message) {
      message.remove();
    }
  }

  // Scroll chat to bottom
  scrollToBottom() {
    const log = document.getElementById('kk-log');
    if (log) {
      setTimeout(() => {
        log.scrollTop = log.scrollHeight;
      }, 50);
    }
  }

  // Handle form submission
  async handleSubmit(e) {
    e.preventDefault();
    
    const input = document.getElementById('kk-input');
    const sendBtn = document.getElementById('kk-send');
    
    if (!input || this.isTyping) return;

    const userText = input.value.trim();
    if (!userText) return;

    // Disable input and button
    input.disabled = true;
    if (sendBtn) {
      sendBtn.disabled = true;
      sendBtn.textContent = 'Sending...';
    }

    try {
      // Add user message
      this.addMessage({
        isUser: true,
        text: userText
      });

      // Clear input
      input.value = '';

      // Show typing indicator
      const typingId = Date.now();
      this.addMessage({
        isUser: false,
        text: '',
        isTyping: true,
        id: typingId
      });

      this.isTyping = true;

      // Send message to API
      const response = await this.sendToAPI(userText);

      // Remove typing indicator
      this.removeMessage(typingId);

      // Add bot response
      this.addMessage({
        isUser: false,
        text: response
      });

    } catch (error) {
      console.error('Chat error:', error);
      
      // Remove typing indicator
      const typingMsg = document.querySelector('.kk-typing');
      if (typingMsg && typingMsg.parentNode) {
        typingMsg.parentNode.remove();
      }

      // Show error message
      this.addMessage({
        isUser: false,
        text: "Sorry, I'm having trouble connecting right now. Please try again in a moment, or feel free to call us at (301) 938-2711!"
      });
    } finally {
      // Re-enable input and button
      input.disabled = false;
      if (sendBtn) {
        sendBtn.disabled = false;
        sendBtn.textContent = 'Send';
      }
      this.isTyping = false;
      input.focus();
    }
  }

  // Send message to API
  async sendToAPI(message) {
    const response = await fetch(this.API_URL, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ message: message })
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = await response.json();
    return data.reply || "I'm not sure how to help with that. Could you try rephrasing your question?";
  }

  // Public method to update API URL
  setAPIUrl(url) {
    this.API_URL = url;
  }

  // Public method to add custom message
  addCustomMessage(text, isUser = false) {
    this.addMessage({ isUser, text });
  }
}

// Initialize chatbot when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
  // Only initialize if chatbot elements exist
  if (document.getElementById('kk-chat')) {
    window.kaizenChatbot = new KaizenChatbot();
    
    // For development/testing - you can remove this
    console.log('Kaizen Chatbot initialized! Use window.kaizenChatbot to interact programmatically.');
  }
});

// Export for potential module usage
if (typeof module !== 'undefined' && module.exports) {
  module.exports = KaizenChatbot;
} 