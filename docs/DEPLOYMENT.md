# Deployment notes

Operational checklist for putting this on the live host. Not part of the
project's public documentation; see the README for the architecture.

The repository is not a complete deployment on its own. Four things have to be
true on the server.

1. **`.htaccess` must be uploaded.** It carries the clean URL and relocation
   rules for every page that lives in `pages/` or `belts/`. Without it those
   pages return 404.
2. **The credential files must already exist**, since they are deliberately not
   in version control: `admin/config.php`, `chatbot-php/config.php`,
   `chatbot-php/.env` with the Anthropic API key, and `email_config.php` one
   level above the web root. `.example` templates in the repository show the
   shape of each.
3. **Run `composer install`** so `vendor/` exists. PHP 8.0 or newer is required.
4. **`data/` and `chatbot-php/cache/` must be writable** by the web server, for
   captured enquiries, rate limit counters and the chatbot cache.

Two notes for an existing install. The chat endpoint was renamed from
`test_chatbot_simple.php` to `chat-api.php`, so the old file can be deleted once
the new one is in place. And the page templates that used to sit in the web root
now live in `pages/` and `belts/`; the stale copies at the root are shadowed by
the relocation rules and can be removed.

Errors are logged rather than displayed everywhere, on the public forms and in
the admin. Set `KAIZEN_DEBUG=1` in the environment to see them while working on
a change.

## Order of operations

1. `composer install` on the server, or upload `vendor/`.
2. Upload the application files.
3. Upload `.htaccess`. Nothing routes correctly until this is in place.
4. Confirm the credential files are present and readable only by the web user.
5. Load the homepage, a page under `pages/` such as `/faq`, an older style link
   such as `/faq.php`, and the admin login.
6. Ask the assistant one question to confirm the API key and model are working.
7. Remove the superseded files: `chatbot-php/test_chatbot_simple.php` and the
   old page templates left in the web root.
