## Frontend Styling Approach

This repository uses a **pure CDN-based styling strategy** with no build tooling, no local CSS/SCSS files, and no component library framework beyond Bootstrap. All styles are delivered via external CDNs and inline `<style>` blocks within PHP view templates.

### Core Framework & Libraries

**Frontend (Public-facing pages):**
- **Bootstrap 5.3.2** — loaded from jsDelivr CDN for grid system, utilities, and base components
- **Font Awesome 6.5.0** — icon library from cdnjs CDN
- **Google Fonts (Plus Jakarta Sans)** — primary typeface for all frontend pages
- **AOS (Animate On Scroll) 2.3.4** — scroll-triggered animations
- **Lightbox2 2.11.4** — gallery image lightbox (gallery page only)

**Admin Panel:**
- **AdminLTE 3.2.0** — admin dashboard template from jsDelivr CDN
- **Bootstrap 4.6.2** — bundled with AdminLTE (note: version mismatch with frontend's Bootstrap 5)
- **Font Awesome 6.4.0** — slightly older version than frontend
- **Google Fonts (Poppins)** — admin-specific typeface

**Login Page:**
- Standalone Bootstrap 5.3.2 + Font Awesome 6.5.0 + Plus Jakarta Sans (same as frontend)

### Design Token System

Design tokens are defined as **CSS custom properties** in the `:root` selector within `app/Views/frontend/layout/header.php`:

```css
:root {
    --primary:   #0f2d5e;      /* Deep navy blue */
    --primary-light: #1a4a8a;  /* Lighter navy */
    --secondary: #f59e0b;      /* Amber/gold accent */
    --accent:    #3b82f6;      /* Bright blue */
    --dark:      #0a1628;      /* Near-black background */
    --light:     #f8fafc;      /* Off-white */
    --gray:      #64748b;      /* Muted text */
    --border:    #e2e8f0;      /* Subtle borders */
}
```

These tokens are referenced throughout inline styles for consistent theming across hero sections, cards, buttons, badges, and footer elements.

### Architecture & Conventions

1. **No Local Asset Pipeline** — The `public/` directory contains only uploads, `.htaccess`, `favicon.ico`, `index.php`, and `robots.txt`. There are no `css/`, `js/`, or `assets/` directories for project-specific stylesheets or scripts.

2. **Inline Styles in Layout Headers** — All custom CSS lives inside `<style>` tags in layout files:
   - `app/Views/frontend/layout/header.php` (~320 lines of inline CSS)
   - `app/Views/admin/layout/main.php` (~15 lines of override CSS)
   - `app/Views/admin/auth/login.php` (~80 lines of inline CSS)

3. **Two Distinct Visual Themes:**
   - **Frontend**: Modern dark-gradient aesthetic with glassmorphism effects (`backdrop-filter: blur()`), rounded corners (12–24px), gradient backgrounds, and smooth hover transitions
   - **Admin**: Standard AdminLTE theme with custom color overrides (sidebar/background set to `#1a3c6e` navy), Poppins font, and enhanced border-radius on cards

4. **Responsive Strategy**: Relies entirely on Bootstrap's grid system and utility classes. No custom media queries are defined; responsiveness is inherited from Bootstrap's breakpoints.

5. **Typography**: Two separate font families — Plus Jakarta Sans for frontend (weights 300–800) and Poppins for admin (weights 300–700).

### Rules Developers Should Follow

- **Do not create local CSS files** — The project convention is to keep all styles inline within view layouts. Adding a `public/css/` directory would break this pattern.
- **Use existing design tokens** — Reference `--primary`, `--secondary`, `--accent`, etc., rather than hardcoding hex values.
- **Maintain CDN consistency** — If adding new pages, use the same CDN versions already declared in the layout headers to avoid version conflicts.
- **Admin vs Frontend separation** — Do not mix AdminLTE components into frontend views or Bootstrap 5 components into admin views (they use different Bootstrap major versions).
- **No SCSS/build tooling** — There is no Sass compiler, PostCSS, Tailwind, Vite, or Webpack configuration. Any styling changes must be made directly in the inline `<style>` blocks.