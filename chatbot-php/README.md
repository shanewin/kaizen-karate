# Kaizen Karate AI Assistant

Retrieval + Claude API integration and the embeddable chat widget.

## How it works

`SmartDataLoader` routes an incoming question to the relevant topic files in
`data/content/topics/`, formats them into plain text, and passes that as context
to `SimpleChatbotEngine`, which calls the Anthropic Messages API.

Those topic files are **generated** from `data/content/site-content.json` by
`includes/TopicProjector.php` — the same document the website renders from.
Do not edit them by hand; run `php scripts/generate-topics.php` instead. See the
root README for the reasoning.

## Setup

```bash
cp config.example.php config.php
cp .env.example .env        # add ANTHROPIC_API_KEY
```

`.env` and `config.php` are gitignored. The key may also be supplied purely
through the environment, which is preferred in production.

## Embedding

```html
<link rel="stylesheet" href="chatbot-php/widget.css">
<script src="chatbot-php/widget.js"></script>
```

`demo.html` runs the widget standalone.

## Files

| File | Role |
|---|---|
| `SmartDataLoader.php` | Topic routing — selects which knowledge-base slices to load |
| `SimpleChatbotEngine.php` | Prompt assembly and Anthropic API calls |
| `BusinessChatbotEngine.php` | Variant supporting uploaded documents (CSV/XLSX/PDF) as context |
| `widget.js` / `widget.css` | Embeddable front end |
| `config.example.php` | Configuration template |
