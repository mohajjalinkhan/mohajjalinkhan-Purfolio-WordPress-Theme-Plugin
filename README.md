# Purfolio 2026

> **Private repository — personal use only.** Not for public distribution.
> © Yousuf Zai Md Ab Mohajjalin Khan. All rights reserved.

A modern, dark-mode WordPress portfolio system — **Purfolio Theme 2026** + **Purfolio Addon Plugin** — built for personal use.

`Theme v0.0.3` · `Plugin v0.0.1` · WordPress 5.9+ · Elementor 3.0+

---

## What this is

A private WordPress project that packages a custom portfolio theme and a companion Elementor widget plugin. Everything visible on the front end is editable through the WordPress Customizer or Elementor — no code changes required.

- Signature purple → magenta palette (`#a259ff → #ff5ec4`) on a deep `#08021a` canvas
- Boldonse display + Inter body (Google Fonts)
- Glass-morphism cards, gradient text, scroll-reveal animations, typing rotator
- 11 custom Elementor widgets
- One-click installer that builds Home, Work, About, Blog, Contact
- Fully responsive across desktop, laptop, tablet, and mobile

---

## Tech stack

| Layer | Version |
| --- | --- |
| PHP | 7.4 – 8.4 |
| WordPress | 5.9 – 6.6 |
| Elementor (free) | 3.5 – 3.23 |
| MySQL / MariaDB | 5.7+ / 10.3+ |
| Styling | CSS3 (custom properties, grid, flex, `clamp()`, `backdrop-filter`) |
| Scripting | Vanilla ES6 (no framework, no build step) |
| Fonts | Boldonse, Inter (Google Fonts) |
| Server | Apache 2.4+ / Nginx 1.18+ with pretty permalinks |

---

## Repository layout

```
.
├── wp-theme/purple-folio/          # Purfolio Theme 2026
└── wp-plugin/purple-folio-widgets/ # Purfolio Addon Plugin
```

Distributable zips (personal use):
- `Purfolio Theme 2026.zip`
- `Purfolio Addon Plugin.zip`

---

## Install (personal use)

1. WP admin → **Plugins → Add New → Upload** → install & activate **Elementor**.
2. WP admin → **Plugins → Add New → Upload** → install & activate `Purfolio Addon Plugin.zip`.
3. WP admin → **Appearance → Themes → Add New → Upload** → install & activate `Purfolio Theme 2026.zip`.
4. **Appearance → Purfolio Setup** → click *Install / repair pages & menu*.
5. **Settings → Permalinks** → set to *Post name*.

---

## Editable areas

| Area | Where |
| --- | --- |
| Logo / brand text | Customize → Site Identity |
| Header CTA | Customize → Header CTA |
| Primary menu | Menus → Primary Menu (Desktop / Mobile) |
| Footer copyright / socials | Customize → Footer |
| Footer menu / widgets | Menus / Widgets |
| Page content | Elementor — every section is a Purfolio widget |

---

## Rebuild the zips

```bash
(cd wp-theme  && zip -qr "../Purfolio Theme 2026.zip"  purple-folio)
(cd wp-plugin && zip -qr "../Purfolio Addon Plugin.zip" purple-folio-widgets)
```

Lint before shipping:

```bash
find wp-theme wp-plugin -name '*.php' -exec php -l {} \;
```

---

## Notes

- No remote asset loading beyond Google Fonts.
- All output escaped (`esc_html` / `esc_attr` / `esc_url` / `wp_kses_post`).
- Admin actions protected by WordPress nonces.
- Every plugin file guarded by `ABSPATH`.

---

**Private project. Do not fork, mirror, or redistribute publicly.**
