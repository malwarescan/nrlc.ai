# Adding a New Video Watch Page

When you add a new video, only **one file** and **one command** are required. The watch page, hub, sitemap, and schema are all driven from `data/videos.json`.

## 1. Add an entry to `data/videos.json`

Add a new object to the `videos` array with:

| Field | Required | Example |
|-------|----------|---------|
| `slug` | Yes | `"ai-visibility-dictionary-overview"` → URL: `/en-us/videos/ai-visibility-dictionary-overview/` |
| `title` | Yes | Page H1 and meta title |
| `summary` | Yes | 40–60 word answer box (meta description, schema) |
| `description` | Yes | Longer description (schema, video sitemap) |
| `embedUrl` | Yes | `https://www.youtube.com/embed/VIDEO_ID?si=...` |
| `thumbnailUrl` | Yes | `https://img.youtube.com/vi/VIDEO_ID/maxresdefault.jpg` |
| `duration` | Yes | ISO 8601, e.g. `"PT5M0S"` (5 min), `"PT7M32S"` (7 min 32 sec) |
| `uploadDate` | Yes | `"YYYY-MM-DD"` |
| `topic` | No | e.g. `"tools"`, `"knowledge-base"` (for future topic hubs) |
| `related` | No | Array of other video slugs, e.g. `["bing-ai-citations-grounding-queries"]` |
| `chapters` | No | `[{ "start": "0:00", "title": "Intro" }, ...]` for key moments in schema |
| `transcript` | No | Full transcript text (improves SEO and accessibility) |

**Embed code:** Use the full iframe `src` from YouTube (including `?si=...`). Thumbnail: `https://img.youtube.com/vi/VIDEO_ID/maxresdefault.jpg`.

## 2. Regenerate the video sitemap

```bash
php scripts/build_sitemaps.php
```

This updates `public/sitemaps/videos-1.xml` (and `.gz`) and the sitemap index. Commit and deploy.

## What updates automatically

- **Watch page:** `https://nrlc.ai/en-us/videos/{slug}/` — no new PHP file; router serves all slugs from the registry.
- **Videos hub:** `https://nrlc.ai/en-us/videos/` — lists all entries from `videos.json`.
- **Video sitemap:** All entries in `videos.json` are written to the video sitemap.
- **Related videos:** Each watch page shows links to videos in its `related` array, or other videos if `related` is empty.

## Optional: cross-link from other pages

- Link to the new watch page from a relevant tool page, article, or the AI Visibility Dictionary page if the video is about that content.
