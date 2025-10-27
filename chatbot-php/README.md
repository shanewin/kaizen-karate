# Kaizen Karate AI Chat Widget

## 🚀 Quick Setup

### For Local Development:
1. Add your OpenAI API key to `.env` file:
   ```
   OPENAI_API_KEY=sk-proj-your-actual-key-here
   ```

### For Server Deployment:
1. Upload entire `chatbot-php/` folder to your server
2. Edit `config.php` line 13 and replace `'your-openai-api-key-here'` with your real API key
3. Ensure your server has PHP 7.4+ 
4. Test the API endpoint: `yoursite.com/chatbot-php/test_chatbot_simple.php`

## 📁 Files Included:
- `widget.js` & `widget.css` - Chat widget
- `SimpleChatbotEngine.php` - AI logic  
- `config.php` - Configuration (add your API key here)
- `demo.html` - See the widget in action
- `embed-code.html` - Integration instructions

## 🔗 Integration:
Add before `</body>` tag:
```html
<link rel="stylesheet" href="chatbot-php/widget.css">
<script src="chatbot-php/widget.js"></script>
```

## 🔒 Security:
- Never commit real API keys to GitHub
- Use `.env` files for local development
- Edit `config.php` directly on server