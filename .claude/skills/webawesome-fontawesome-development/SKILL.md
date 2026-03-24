---
name: webawesome-fontawesome-development
description: "Develops UI with Web Awesome Pro components and Font Awesome Pro icons. Activates when creating or styling UI with wa-* web components (wa-button, wa-input, wa-card, wa-dialog, wa-select, etc.), using Font Awesome icons (fa-solid, fa-regular, fa-light, fa-thin, fa-duotone, fa-sharp, fa-brands), theming with Web Awesome CSS custom properties, or using wa-icon inside components."
license: MIT
metadata:
  author: roblog
---

# Web Awesome & Font Awesome Development

## When to Apply

Activate this skill when:

- Creating or modifying UI using `wa-*` web components
- Adding icons with Font Awesome classes or `<wa-icon>`
- Styling components with `::part()` selectors or Web Awesome CSS custom properties
- Using Web Awesome layout utilities (`wa-stack`, `wa-cluster`, `wa-grid`, `wa-split`)
- Working with Web Awesome themes
- Building forms with `wa-input`, `wa-select`, `wa-checkbox`, `wa-switch`, etc.
- Creating dialogs, drawers, toasts, or other overlay components

## Project Setup

Assets are loaded in `resources/views/app.blade.php`:

```html
<link rel="stylesheet" href="/vendor/font-awesome-pro/css/all.min.css">
<link rel="stylesheet" href="/vendor/web-awesome-pro/styles/webawesome.css">
<script type="module" src="/vendor/web-awesome-pro/webawesome.loader.js"></script>
```

Global styles are in `resources/css/app.css` with CSS custom properties:

```css
:root {
    --color-primary: #4f46e5;
    --color-primary-hover: #4338ca;
    --color-bg: #f8fafc;
    --color-surface: #ffffff;
    --color-text: #1e293b;
    --color-text-muted: #64748b;
    --color-border: #e2e8f0;
    --color-error: #ef4444;
    --radius: 0.5rem;
}
```

## Critical Rules

1. **Never use self-closing tags** with web components: `<wa-button></wa-button>` NOT `<wa-button />`
2. **Never use `<wa-button href="...">`** for navigation — it renders a native `<a>` inside Shadow DOM which Inertia cannot intercept, causing full page reloads. Use `onclick={() => router.visit('/path')}` instead.
3. **Boolean attributes** on `wa-*` components must use `|| undefined` to avoid `="false"` being treated as truthy. Example: `loading={$form.processing || undefined}`, `open={showDialog || undefined}`, `disabled={isDisabled || undefined}`
4. **Use `oninput` events** to sync web component values with Svelte state (Shadow DOM prevents `bind:value`)
5. **Use `wa-icon`** inside `wa-*` components, use `<i class="fa-*">` for standalone icons
6. Prefer the project's CSS custom properties (`--color-primary`, etc.) for consistency
7. Use mobile-first responsive design matching the existing `.container` pattern

## Web Awesome Components

### Buttons

```svelte
<!-- Variants: neutral, brand, success, warning, danger -->
<wa-button variant="brand" appearance="filled">Submit</wa-button>
<wa-button variant="danger" appearance="outlined">Delete</wa-button>
<wa-button variant="neutral" appearance="text">Cancel</wa-button>

<!-- Sizes: small, medium (default), large -->
<wa-button size="large">Big Button</wa-button>

<!-- States -->
<wa-button disabled>Disabled</wa-button>
<wa-button loading>Loading</wa-button>
<wa-button pill>Rounded</wa-button>

<!-- With icons -->
<wa-button variant="brand">
    <wa-icon name="floppy-disk" library="fa" slot="prefix"></wa-icon>
    Save
</wa-button>

<!-- Navigation (NEVER use href on wa-button — use router.visit) -->
<wa-button onclick={() => router.visit('/path')}>Navigate</wa-button>

<!-- Button group -->
<wa-button-group>
    <wa-button>Left</wa-button>
    <wa-button>Center</wa-button>
    <wa-button>Right</wa-button>
</wa-button-group>
```

### Form Inputs (with Svelte)

```svelte
<script>
    let name = $state('');
    let email = $state('');
</script>

<!-- Text input with icon -->
<wa-input
    label="Name"
    type="text"
    value={name}
    oninput={(e) => name = e.target.value}
    required
>
    <wa-icon name="user" library="fa" slot="prefix"></wa-icon>
</wa-input>

<!-- Email input -->
<wa-input
    label="Email"
    type="email"
    value={email}
    oninput={(e) => email = e.target.value}
    required
>
    <wa-icon name="envelope" library="fa" slot="prefix"></wa-icon>
</wa-input>

<!-- Password with toggle -->
<wa-input label="Password" type="password" password-toggle>
    <wa-icon name="lock" library="fa" slot="prefix"></wa-icon>
</wa-input>

<!-- Textarea -->
<wa-textarea label="Message" rows="4"></wa-textarea>

<!-- Number input -->
<wa-number-input label="Quantity" min="0" max="100" value="1"></wa-number-input>

<!-- Select -->
<wa-select label="Country" placeholder="Select one">
    <wa-option value="us">United States</wa-option>
    <wa-option value="kr">South Korea</wa-option>
</wa-select>

<!-- Combobox (searchable) -->
<wa-combobox label="Fruit" placeholder="Type to search...">
    <wa-option value="apple">Apple</wa-option>
    <wa-option value="banana">Banana</wa-option>
</wa-combobox>

<!-- Checkbox, Radio, Switch -->
<wa-checkbox>I agree to the terms</wa-checkbox>

<wa-radio-group label="Color">
    <wa-radio value="red">Red</wa-radio>
    <wa-radio value="blue">Blue</wa-radio>
</wa-radio-group>

<wa-switch>Enable notifications</wa-switch>

<!-- Slider, Rating, Color Picker -->
<wa-slider label="Volume" min="0" max="100" value="50"></wa-slider>
<wa-rating label="Rate this" max="5"></wa-rating>
<wa-color-picker label="Color" value="#ff6600"></wa-color-picker>
```

### Using with Inertia useForm

```svelte
<script>
    import { useForm } from '@inertiajs/svelte';

    const form = useForm({
        name: '',
        email: '',
    });

    function submit(e) {
        e.preventDefault();
        $form.post('/users');
    }
</script>

<form onsubmit={submit}>
    <div class="field">
        <wa-input
            label="Name"
            value={$form.name}
            oninput={(e) => $form.name = e.target.value}
            required
        >
            <wa-icon name="user" library="fa" slot="prefix"></wa-icon>
        </wa-input>
        {#if $form.errors.name}
            <p class="field-error">
                <wa-icon name="circle-exclamation" library="fa"></wa-icon>
                {$form.errors.name}
            </p>
        {/if}
    </div>

    <wa-button variant="brand" type="submit" loading={$form.processing || undefined} style="width: 100%;">
        Submit
    </wa-button>
</form>
```

### Cards

```html
<!-- Basic card -->
<wa-card>
    <h3 slot="header">Title</h3>
    <p>Content here.</p>
    <wa-button slot="footer" variant="brand">Action</wa-button>
</wa-card>

<!-- With media -->
<wa-card>
    <img slot="media" src="/images/photo.jpg" alt="Photo" />
    <h3 slot="header">Photo Card</h3>
    <p>Description.</p>
</wa-card>

<!-- Appearances: outlined, filled-outlined, filled, accent, plain -->
<wa-card appearance="filled">Filled card</wa-card>
```

### Dialogs & Overlays

```html
<!-- Dialog -->
<wa-button onclick="document.querySelector('#my-dialog').show()">Open</wa-button>
<wa-dialog id="my-dialog" label="Confirm">
    Are you sure?
    <wa-button slot="footer" variant="brand" onclick="this.closest('wa-dialog').hide()">
        Confirm
    </wa-button>
</wa-dialog>

<!-- Drawer -->
<wa-drawer id="my-drawer" label="Menu">
    <p>Drawer content</p>
</wa-drawer>

<!-- Tooltip -->
<wa-tooltip content="Helpful tip">
    <wa-button>Hover me</wa-button>
</wa-tooltip>

<!-- Popover -->
<wa-popover>
    <wa-button slot="trigger">Click</wa-button>
    <p>Popover content.</p>
</wa-popover>

<!-- Toast -->
<wa-toast id="my-toast"></wa-toast>
<script>
    document.querySelector('#my-toast').push('Saved!', { variant: 'success' });
</script>
```

### Navigation

```html
<!-- Tabs -->
<wa-tab-group>
    <wa-tab slot="nav" panel="general">General</wa-tab>
    <wa-tab slot="nav" panel="settings">Settings</wa-tab>
    <wa-tab-panel name="general">General content.</wa-tab-panel>
    <wa-tab-panel name="settings">Settings content.</wa-tab-panel>
</wa-tab-group>

<!-- Breadcrumbs -->
<wa-breadcrumb>
    <wa-breadcrumb-item href="/">Home</wa-breadcrumb-item>
    <wa-breadcrumb-item href="/blog">Blog</wa-breadcrumb-item>
    <wa-breadcrumb-item>Current Post</wa-breadcrumb-item>
</wa-breadcrumb>

<!-- Tree -->
<wa-tree>
    <wa-tree-item>
        Documents
        <wa-tree-item>Resume.pdf</wa-tree-item>
    </wa-tree-item>
</wa-tree>
```

### Data Display

```html
<wa-badge variant="brand">New</wa-badge>
<wa-badge variant="success">Active</wa-badge>
<wa-tag>Default</wa-tag>
<wa-tag variant="brand" removable>Category</wa-tag>
<wa-avatar image="avatar.jpg" label="John"></wa-avatar>
<wa-avatar initials="JD" label="John Doe"></wa-avatar>
<wa-divider></wa-divider>
```

### Progress & Loading

```html
<wa-progress-bar value="60"></wa-progress-bar>
<wa-progress-ring value="75"></wa-progress-ring>
<wa-spinner></wa-spinner>
<wa-skeleton effect="sheen"></wa-skeleton>
```

### Formatting

```html
<wa-format-date date="2026-03-24" month="long" day="numeric" year="numeric"></wa-format-date>
<wa-format-number value="1234567" type="decimal"></wa-format-number>
<wa-format-bytes value="1048576"></wa-format-bytes>
<wa-relative-time date="2026-03-23"></wa-relative-time>
```

### Other Useful Components

```html
<wa-qr-code value="https://example.com"></wa-qr-code>
<wa-copy-button value="Text to copy"></wa-copy-button>
<wa-details summary="Click to expand">Hidden content.</wa-details>
<wa-callout variant="warning">Important warning.</wa-callout>
<wa-split-panel>
    <div slot="start">Left</div>
    <div slot="end">Right</div>
</wa-split-panel>
```

### Charts

```html
<wa-bar-chart></wa-bar-chart>
<wa-line-chart></wa-line-chart>
<wa-pie-chart></wa-pie-chart>
<wa-doughnut-chart></wa-doughnut-chart>
<wa-sparkline></wa-sparkline>
```

## Font Awesome Icons

### Basic Usage

Pattern: `fa-{style} fa-{icon-name}`

```html
<i class="fa-solid fa-heart"></i>
<i class="fa-regular fa-heart"></i>
<i class="fa-light fa-heart"></i>
<i class="fa-thin fa-heart"></i>
<i class="fa-duotone fa-heart"></i>
<i class="fa-sharp fa-solid fa-heart"></i>
<i class="fa-brands fa-github"></i>
```

### Inside Web Awesome Components

```html
<wa-icon name="heart" library="fa"></wa-icon>
<wa-icon name="heart" library="fa" family="regular"></wa-icon>
<wa-icon name="heart" library="fa" family="light"></wa-icon>

<!-- In buttons -->
<wa-button>
    <wa-icon name="gear" library="fa" slot="prefix"></wa-icon>
    Settings
</wa-button>
```

### Sizing

```html
<i class="fa-solid fa-heart fa-xs"></i>
<i class="fa-solid fa-heart fa-sm"></i>
<i class="fa-solid fa-heart fa-lg"></i>
<i class="fa-solid fa-heart fa-xl"></i>
<i class="fa-solid fa-heart fa-2xl"></i>
<i class="fa-solid fa-heart fa-3x"></i>
```

### Animations

```html
<i class="fa-solid fa-spinner fa-spin"></i>
<i class="fa-solid fa-heart fa-beat"></i>
<i class="fa-solid fa-bell fa-shake"></i>
<i class="fa-solid fa-heart fa-bounce"></i>
<i class="fa-solid fa-heart fa-fade"></i>
```

### Fixed Width (for alignment in lists/nav)

```html
<i class="fa-solid fa-house fa-fw"></i> Home
<i class="fa-solid fa-user fa-fw"></i> Profile
<i class="fa-solid fa-gear fa-fw"></i> Settings
```

### Rotations & Flips

```html
<i class="fa-solid fa-arrow-right fa-rotate-90"></i>
<i class="fa-solid fa-heart fa-flip-horizontal"></i>
```

### Stacking

```html
<span class="fa-stack fa-2x">
    <i class="fa-solid fa-circle fa-stack-2x"></i>
    <i class="fa-solid fa-flag fa-stack-1x fa-inverse"></i>
</span>
```

### Common Icon Names

| Purpose | Icon Name |
|---------|-----------|
| Home | `house` |
| User | `user` |
| Settings | `gear` |
| Search | `magnifying-glass` |
| Edit | `pen` |
| Delete | `trash` |
| Save | `floppy-disk` |
| Close | `xmark` |
| Check | `check` |
| Plus | `plus` |
| Arrow | `arrow-right` |
| Heart | `heart` |
| Star | `star` |
| Bell | `bell` |
| Email | `envelope` |
| Lock | `lock` |
| Eye | `eye` |
| Download | `download` |
| Spinner | `spinner` |
| Warning | `triangle-exclamation` |
| Info | `circle-info` |
| Menu | `bars` |
| Login | `right-to-bracket` |
| Logout | `right-from-bracket` |
| Add user | `user-plus` |

## Layout Utilities

```html
<!-- Vertical stack -->
<div class="wa-stack wa-gap-m">...</div>

<!-- Horizontal cluster (wraps) -->
<div class="wa-cluster wa-gap-s">...</div>

<!-- Auto grid -->
<div class="wa-grid wa-gap-m">...</div>

<!-- Split apart -->
<div class="wa-split">
    <span>Left</span>
    <span>Right</span>
</div>
```

Gap sizes: `wa-gap-0`, `wa-gap-3xs`, `wa-gap-2xs`, `wa-gap-xs`, `wa-gap-s`, `wa-gap-m`, `wa-gap-l`, `wa-gap-xl`, `wa-gap-2xl`, `wa-gap-3xl`

## Typography Utilities

```html
<p class="wa-heading-xl">Heading</p>
<p class="wa-body-m">Body text</p>
<p class="wa-caption-s">Caption</p>
```

Sizes: `2xs`, `xs`, `s`, `m`, `l`, `xl`, `2xl`, `3xl`, `4xl`

Weight: `wa-font-weight-light`, `wa-font-weight-normal`, `wa-font-weight-semibold`, `wa-font-weight-bold`

## Theming

### Built-in Themes

Add before `webawesome.css` in `app.blade.php`:

```html
<link rel="stylesheet" href="/vendor/web-awesome-pro/styles/themes/awesome.css">
```

Available: `default`, `awesome`, `brutalist`, `glossy`, `matter`, `mellow`, `playful`, `premium`, `shoelace`, `tailspin`, `active`

### Color Variants on Containers

```html
<div class="wa-brand">Brand colored section</div>
<div class="wa-success">Success section</div>
<div class="wa-danger">Danger section</div>
```

### Styling with CSS Parts

```css
wa-button::part(base) {
    border-radius: 20px;
}

wa-card::part(header) {
    background: #f0f0f0;
}

wa-input::part(base) {
    border-color: #ccc;
}
```

## Error Display Pattern (Project Convention)

```svelte
{#if $form.errors.fieldName}
    <p class="field-error">
        <wa-icon name="circle-exclamation" library="fa"></wa-icon>
        {$form.errors.fieldName}
    </p>
{/if}
```

```css
.field-error {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    color: var(--color-error);
    font-size: 0.8125rem;
    margin-top: 0.25rem;
}
```

## Complete Component List

**Buttons:** `wa-button`, `wa-button-group`
**Inputs:** `wa-input`, `wa-textarea`, `wa-number-input`, `wa-file-input`, `wa-select`, `wa-option`, `wa-combobox`
**Toggles:** `wa-checkbox`, `wa-radio`, `wa-radio-group`, `wa-switch`
**Pickers:** `wa-color-picker`, `wa-slider`, `wa-rating`
**Display:** `wa-card`, `wa-badge`, `wa-tag`, `wa-avatar`, `wa-icon`, `wa-divider`
**Charts:** `wa-bar-chart`, `wa-line-chart`, `wa-pie-chart`, `wa-doughnut-chart`, `wa-bubble-chart`, `wa-radar-chart`, `wa-polar-area-chart`, `wa-scatter-chart`, `wa-sparkline`, `wa-chart`
**Navigation:** `wa-breadcrumb`, `wa-breadcrumb-item`, `wa-tab-group`, `wa-tab`, `wa-tab-panel`, `wa-tree`, `wa-tree-item`
**Overlays:** `wa-dialog`, `wa-drawer`, `wa-popover`, `wa-popup`, `wa-tooltip`, `wa-toast`, `wa-toast-item`
**Media:** `wa-carousel`, `wa-carousel-item`, `wa-animated-image`, `wa-comparison`, `wa-zoomable-frame`
**Progress:** `wa-progress-bar`, `wa-progress-ring`, `wa-spinner`, `wa-skeleton`
**Formatting:** `wa-format-date`, `wa-format-number`, `wa-format-bytes`, `wa-relative-time`
**Utilities:** `wa-qr-code`, `wa-copy-button`, `wa-include`, `wa-details`, `wa-callout`, `wa-split-panel`, `wa-scroller`, `wa-animation`, `wa-page`
**Observers:** `wa-intersection-observer`, `wa-mutation-observer`, `wa-resize-observer`
