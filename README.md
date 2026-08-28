# Kaizen Karate — Content Platform

Production website, admin CMS, and AI assistant for a martial arts school with
two locations. Live at [kaizenkarateusa.com](https://kaizenkarateusa.com).

**The core idea:** one JSON knowledge base is the single source of truth for the
website, the AI assistant, and the operational reporting. Content is authored
once and everything downstream is derived from it — there is no second store to
sync and no ETL job between the CMS and the AI layer.

```
                         ┌──────────────────────────┐
   Staff edit content →  │   admin/  (CMS)          │
                         │   draft → review → publish│
                         └────────────┬─────────────┘
                                      │ writes
                                      ▼
                    ┌───────────────────────────────────┐
                    │  data/content/site-content.json   │  ← single source of truth
                    │  16 sections · 208 KB · versioned │
                    └──┬──────────────┬─────────────────┘
                       │              │ projected at publish time
          reads        │              │ (includes/TopicProjector.php)
                       ▼              ▼
        ┌──────────────────────┐   ┌────────────────────────────┐
        │ includes/            │   │ data/content/topics/*.json │
        │ content-loader.php   │   │ 7 topic-scoped slices      │
        │ → renders the site   │   └──────────┬─────────────────┘
        └──────────────────────┘              │ retrieval
                                              ▼
                                   ┌──────────────────────────┐
                                   │ chatbot-php/             │
                                   │ SmartDataLoader → Claude │
                                   └──────────────────────────┘
```

---

## Why this design

A school this size cannot staff a content team, a data team, and an AI team.
The constraint that shaped every decision: **a front-desk employee updates the
summer camp price once, and the website, the chatbot, and the reports are all
correct immediately** — with no engineer in the loop.

That rules out the conventional approach of a CMS database plus a separate
vector store populated by a nightly sync. Two stores means two states, and the
gap between them is exactly where a chatbot starts quoting last season's prices
to a parent. So the retrieval corpus is not a copy — it is a **projection**,
regenerated from the source on every publish and never edited by hand.

### Retrieval: topic routing, not embeddings

`chatbot-php/SmartDataLoader.php` selects which slices of the knowledge base to
load by matching the query against topic keywords, then formats only those into
the model's context.

This deliberately is not vector search. At this corpus size — seven topic files,
~125 KB total — an embedding index would add a second store to keep in sync,
which is the exact failure mode the architecture exists to avoid. Keyword
routing is inspectable, has no build step, and costs nothing to keep current.
It replaced a "load the entire knowledge base on every turn" approach that was
triggering API rate limits.

Measured input cost per query, before and after the projection work in this repo:

| Query | Loads | Before | After |
|---|---|---|---|
| "what belt exams do you have" | `general` + `belt_exams` | 15,248 tok | **7,528 tok** |
| "what is your refund policy" | `general` + `policies` | *unanswerable* | 4,882 tok |
| "where are you located" | `general` + `locations` | *unanswerable* | 3,429 tok |
| "what are your hours" | `general` | 3,205 tok | 3,205 tok |

The belt-exam halving comes from pruning `lightbox_content` — 104 KB of rendered
curriculum HTML that the website needs and the model does not. The two
previously unanswerable queries were content the site published but no topic
file exposed; the projector's coverage check now makes that class of gap
impossible to ship silently.

### The invariant, and how it is enforced

Derived data rots the moment someone edits it by hand. When this work started,
**four of five topic files had already drifted from the source** and the
assistant was answering from stale content.

Three things now prevent that:

1. `admin/publish.php` regenerates every topic file as part of publishing, so
   the corpus cannot lag the site.
2. `scripts/generate-topics.php --check` projects into a scratch directory and
   exits non-zero if the committed output differs — drift becomes a build
   failure, not a support ticket.
3. `TopicProjector::verifyCoverage()` reports any content section no topic
   exposes, catching the "the bot can't answer about the thing we just added"
   failure at publish time.

---

## Operational reporting

Because the knowledge base and the captured leads are both plain files on the
same host, reporting reads them directly — no warehouse, no extract step.

`admin/submissions.php` aggregates enquiries captured by `form-handler.php`
with the attribution field the forms record (`Google`, walk-in, referral), so
staff can see enquiry volume and where it came from next to the content they
are editing. It is a modest BI surface by design: the point is that it required
no infrastructure beyond what already existed.

---

## Repository layout

| Path | Role |
|---|---|
| `data/content/site-content.json` | **Source of truth** — 16 content sections |
| `data/content/topics/` | Derived retrieval corpus (generated; do not edit) |
| `includes/TopicProjector.php` | Projection: source → topic slices, with pruning + coverage checks |
| `includes/content-loader.php` | Renders site sections from the knowledge base |
| `admin/` | CMS: draft → publish → backup, with a change log |
| `chatbot-php/` | Retrieval + Claude API integration, embeddable widget |
| `scripts/generate-topics.php` | CLI projector; `--check` mode for CI |
| `pages/` | Page templates, served at clean URLs via `.htaccess` |
| `belts/` | Belt curriculum pages sharing one parameterised template |
| `sections/`, `sections/home/` | Page sections; the homepage's own sections, extracted from `index.php` |
| `styles/home.css`, `scripts/home/` | Homepage styling and behaviour, extracted from `index.php` |
| `modules/nyc/` | Second-location module |
| `chatbot-business/` | Standalone document-context chatbot tool |
| `tests/` | Unit tests for the projection invariant |

---

## Running locally

Requires PHP 8.0+ and Composer.

```bash
composer install

cp admin/config.example.php admin/config.php
cp chatbot-php/config.example.php chatbot-php/config.php
cp chatbot-php/.env.example chatbot-php/.env    # add your Anthropic API key

# Admin credentials are bcrypt hashes supplied via the environment:
export KAIZEN_ADMIN_HASH="$(php -r "echo password_hash('choose-a-password', PASSWORD_DEFAULT);")"

php scripts/generate-topics.php    # build the retrieval corpus
php tests/TopicProjectorTest.php   # 13 assertions
php -S localhost:8000
```

### What is not in this repo

- **`assets/videos/` and `assets/images/gallery/`** — 2.6 GB of production media,
  excluded to keep the repo cloneable. Page structure renders without them.
- **Captured form submissions** — real customer enquiries, excluded permanently.
- **`admin/config.php`, `chatbot-php/.env`** — credentials; `.example` templates
  are tracked in their place.

---

## Known limitations

Honest notes on what a reviewer will find:

- **`index.php` is now a 332-line page shell** (from 4,672 lines and 270 KB): the
  `<head>`, the nav include, twelve section includes, and the script tags. The
  homepage sections live in `sections/home/`, its CSS in `styles/home.css`, and
  its behaviour in `scripts/home/`. A few small inline blocks remain where
  extracting them would not help - the analytics snippet, the chat widget config
  that must precede the widget, and two short handlers.
- **A staging mirror, `testing.php`, is hand-synced with `index.php`** and is
  excluded from this repo as a deployment artifact. It is the duplication the
  projector pattern exists to eliminate, and it should be replaced by the same
  approach: one source, rendered twice.
- **Flat-file storage** for leads and rate limiting. Appropriate at this volume
  (~4,500 records) and it is what makes the zero-ETL reporting possible, but it
  has no concurrent-write story and would need a real datastore to scale.
- **Retrieval is keyword-routed**, so a question phrased entirely outside a
  topic's vocabulary falls back to general content. Fine for a bounded FAQ
  domain; it would not survive an open corpus.

## License

Source published as a portfolio reference. Kaizen Karate brand assets and
content are not licensed for reuse.
