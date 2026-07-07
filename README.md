<div align="center">

# Purfolio Theme 2026 &nbsp;·&nbsp; Purfolio Addon Plugin

**A modern, Elementor-ready WordPress portfolio system in a signature purple → magenta palette.**

*Boldonse display · Inter body · glass-morphism cards · dark-first dark-mode.*

`Theme v3.0.5` &nbsp;·&nbsp; `Plugin v2.0.5` &nbsp;·&nbsp; `GPL v2+`

</div>

---

## 📸 Screenshots

<p align="center">
<img width="1919" height="877" alt="home" src="https://github.com/user-attachments/assets/10afb5a9-8a1b-4538-a735-483e70ae5de9" />
<img width="1900" height="916" alt="work" src="https://github.com/user-attachments/assets/e6e914e3-231f-4793-9cb9-4df715fd3ff0" />
<img width="1904" height="914" alt="about" src="https://github.com/user-attachments/assets/c45b529e-feba-4c7b-b268-608ff92d4b36" />
<img width="1906" height="918" alt="bolg" src="https://github.com/user-attachments/assets/1bbc3847-a050-4273-804e-354eca471386" />
<img width="1904" height="916" alt="contact" src="https://github.com/user-attachments/assets/9c85ee78-67da-4e46-b342-c7befb589928" />


</p>

---

## Highlights

- **Signature design system** — palette `#a259ff → #ff5ec4`, dark `#08021a` canvas, glass cards, gradient text, elegant shadows.
- **11 Elementor widgets** — Hero, Services, Projects, Stats, CTA, Contact Info, Site Nav, Footer, Tools, Timeline, Blog Posts.
- **Fully responsive** — every widget exposes per-breakpoint controls (desktop / laptop / tablet / mobile) for typography, color, alignment, padding, margin, gap and radius.
- **Editable header + footer** — Customizer copyright, social repeater, Footer Menu location, Footer Widgets sidebar, and Elementor Pro `header` / `footer` theme locations.
- **Motion** — one `IntersectionObserver` drives fade-ups; data-driven typing rotator; honors `prefers-reduced-motion`.
- **One-click installer** — creates Home, Work, About, Blog, Contact with Elementor sections and wires the primary menu.
- **Zero dependencies** — plain PHP + CSS + vanilla ES6. No npm, no build step.

---


## 🧱 Tech Stack

| Layer         | Technology                                     | Version           |
| ------------- | ---------------------------------------------- | ----------------- |
| Language      | **PHP**                                        | 7.4 – 8.3         |
| CMS           | **WordPress**                                  | 5.9 – 6.6         |
| Page Builder  | **Elementor (free)**                           | 3.5 – 3.23        |
| Database      | **MySQL** / MariaDB                            | 5.7+ / 10.3+      |
| Markup        | HTML5, semantic sectioning                     | —                 |
| Styling       | CSS3 (custom properties, grid, flexbox, `clamp()`, `backdrop-filter`) | — |
| Scripting     | Vanilla **JavaScript ES6** — no framework      | —                 |
| Fonts         | Google Fonts — Boldonse (display) + Inter (body) | —               |
| Server        | Apache 2.4+ or Nginx 1.18+ (pretty permalinks) | —                 |
| Build tooling | None                                           | —                 |

**Browsers:** Chrome/Edge 100+, Firefox 100+, Safari 15+, iOS Safari 15+.

---

## 📦 Repository Layout

```
.
├── wp-theme/
│   └── purple-folio/                 # Purfolio Theme 2026
│       ├── style.css                 # Theme header + full design system
│       ├── functions.php             # Setup, menus, Customizer, enqueue
│       ├── header.php  footer.php
│       ├── front-page.php            # Elementor-aware home router
│       ├── page.php  single.php  home.php  archive.php  index.php
│       ├── js/scripts.js             # Nav + animations + typing
│       ├── assets/                   # Profile & hero imagery
│       ├── inc/page-installer.php    # Appearance → Purfolio Setup
│       └── screenshot.png            # 1200×900 preview
│
└── wp-plugin/
    └── purple-folio-widgets/         # Purfolio Addon Plugin
        ├── purfolio-addon-plugin.php # Bootstrap + widget registration
        ├── assets/
        │   ├── editor.css            # Fallback styling for Elementor editor
        │   └── frontend.js           # Animations, counters, typing
        └── widgets/                  # 10× class-pfw-*.php Elementor widgets
```

---

## 🚀 Quick Install (users)

1. Download or build the two zips:
   - `Purfolio Theme 2026.zip`
   - `Purfolio Addon Plugin.zip`
2. In WordPress admin:
   1. **Plugins → Add New → Upload** → install & activate **Elementor**.
   2. **Plugins → Add New → Upload** → install & activate **Purfolio Addon Plugin**.
   3. **Appearance → Themes → Add New → Upload** → install & activate **Purfolio Theme 2026**.
3. Go to **Appearance → Purfolio Setup** and click **“Install / repair pages & menu.”**  
   This creates Home, Work, About, Blog, Contact — each pre-built in Elementor.
4. Edit any page with Elementor. Every heading, image, chip, card, timeline entry and CTA is a Purfolio widget with responsive Style controls.

> **Permalinks:** WordPress → *Settings → Permalinks → Post name* is required so `/work`, `/about`, `/blog`, `/contact` resolve.

---

## 🛠️ Local Development

Use any WordPress-friendly stack (Local by Flywheel, XAMPP, MAMP, Laragon, Docker).

```bash
# Clone
git clone https://github.com/<your-username>/purfolio-theme-2026.git
cd purfolio-theme-2026

# Symlink into your local WP install
ln -s "$(pwd)/wp-theme/purple-folio"           /path/to/wp-content/themes/purple-folio
ln -s "$(pwd)/wp-plugin/purple-folio-widgets"  /path/to/wp-content/plugins/purple-folio-widgets

# Or copy
cp -R wp-theme/purple-folio           /path/to/wp-content/themes/
cp -R wp-plugin/purple-folio-widgets  /path/to/wp-content/plugins/
```

Lint PHP before shipping:

```bash
find wp-theme wp-plugin -name '*.php' -exec php -l {} \;
```

Build distributable zips:

```bash
(cd wp-theme  && zip -qr "../Purfolio Theme 2026.zip"  purple-folio)
(cd wp-plugin && zip -qr "../Purfolio Addon Plugin.zip" purple-folio-widgets)
```

---

## 🧩 Included Elementor Widgets

| Widget            | Purpose                                          |
| ----------------- | ------------------------------------------------ |
| `PF Hero`         | Animated hero with eyebrow, gradient title, chip, typing rotator, dual CTAs, image |
| `PF Services`     | 2/3-column service card grid with icon & description |
| `PF Projects`     | Portfolio grid with cover image, category, hover reveal |
| `PF Stats`        | Animated counting stat blocks                    |
| `PF CTA Banner`   | Gradient call-to-action banner                   |
| `PF Contact Info` | Icon-labelled contact rows (email, socials, location) |
| `PF Site Nav`     | Drops the theme nav bar inside Elementor Canvas layouts |
| `PF Footer`       | Editable footer block for Elementor Canvas / visual footer builds |
| `PF Tools`        | Chip-style tech-stack list                       |
| `PF Timeline`     | Scroll-animated vertical timeline                |
| `PF Blog Posts`   | Latest posts grid with excerpt + read link       |

Every widget exposes:

- **Content tab** — text, images, icons, links, repeater items.
- **Style tab** — responsive typography, alignment, padding, margin, gap, border radius, colors.
- Scoped selectors via `{{WRAPPER}}` so changes never bleed into sibling widgets.

---

## Editable Areas

| Area              | Where to edit                                          |
| ----------------- | ------------------------------------------------------ |
| Logo / brand text | Appearance → Customize → **Site Identity**             |
| Header CTA button | Appearance → Customize → **Header CTA**                |
| Primary nav       | Appearance → **Menus** → *Primary Menu (Desktop / Mobile)* |
| Footer copyright  | Appearance → Customize → **Footer**                    |
| Footer socials    | Appearance → Customize → **Footer** (JSON list)        |
| Footer menu       | Appearance → **Menus** → *Footer Menu*                 |
| Footer widgets    | Appearance → **Widgets** → *Footer Widgets*            |
| Page content      | **Elementor** — every section is a Purfolio widget     |
| Header / Footer (Pro) | **Elementor Pro Theme Builder** — locations `header`, `footer` |

---

## Animations

- `data-anim`, `.pfw-animate`, `.pfw-fade-up` classes trigger fade-up entrances via a single `IntersectionObserver`.
- `.stat-num[data-count]` blocks count up when they enter the viewport.
- `.typing[data-phrases="Word One | Word Two"]` cycles through phrases with a typewriter effect.
- All animation is skipped when the user prefers reduced motion.

---

## 🧪 Screenshots

The theme ships a `1200×900` `screenshot.png` used by WordPress in **Appearance → Themes**. Update it any time by replacing `wp-theme/purple-folio/screenshot.png` with a fresh export.

---

## 🔐 Security & Standards

- Escapes all output with `esc_html`, `esc_attr`, `esc_url`, `wp_kses_post`.
- Uses WordPress nonces on admin actions.
- Follows the [WordPress Plugin Handbook](https://developer.wordpress.org/plugins/) and the [Detailed Plugin Guidelines](https://developer.wordpress.org/plugins/wordpress-org/detailed-plugin-guidelines/).
- No remote asset loading beyond Google Fonts.
- Compatible with WordPress Theme Check.

---

## 📚 Documentation

A full developer guide (VSCode-style syntax-highlighted PDF) walks through building the theme + plugin from scratch:

- 📄 `Purfolio-Developer-Guide.pdf` — architecture, code walk-through, packaging, QA checklist.

---

## 🤝 Contributing

1. Fork the repo.
2. Create a feature branch: `git checkout -b feat/my-improvement`.
3. Run `php -l` on any files you change.
4. Open a pull request describing the change and any WP/Elementor versions tested.

---

## 📄 License

Released under the **GNU General Public License v2.0 or later**. You may fork, modify and redistribute freely under the same license.

---

## 🙌 Credits

- **Author & Design:** Moahjjalin Khan
- **Featured Persona:** Yousuf Zai — WordPress Developer
- **Reference site:** https://mohajjalin.lovable.app
- **Best-practice references:**
  - https://www.whitelabeliq.com/blog/custom-wordpress-theme-development-best-practices/
  - https://developer.wordpress.org/plugins/wordpress-org/detailed-plugin-guidelines/
  - https://colorwhistle.com/wordpress-plugin-development-best-practices/
