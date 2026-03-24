# Web Awesome Pro - Crash Course

Web Awesome (v3) is a library of **web components** using the `wa-` prefix. Framework-agnostic — works with Svelte, Vue, React, or plain HTML.

---

## Setup (already done in this project)

```html
<!-- In app.blade.php -->
<link rel="stylesheet" href="/vendor/web-awesome-pro/styles/webawesome.css">
<script type="module" src="/vendor/web-awesome-pro/webawesome.loader.js"></script>
```

> **Important:** Never use self-closing tags with web components.
> `<wa-button />` is WRONG. Use `<wa-button></wa-button>`.

---

## Buttons

```html
<wa-button>Default</wa-button>
<wa-button variant="brand">Brand</wa-button>
<wa-button variant="success">Success</wa-button>
<wa-button variant="warning">Warning</wa-button>
<wa-button variant="danger">Danger</wa-button>
<wa-button variant="neutral">Neutral</wa-button>
```

**Appearances:** `filled`, `outlined`, `text` (ghost)

```html
<wa-button variant="brand" appearance="filled">Filled</wa-button>
<wa-button variant="brand" appearance="outlined">Outlined</wa-button>
<wa-button variant="brand" appearance="text">Text</wa-button>
```

**Sizes:** `small`, `medium` (default), `large`

```html
<wa-button size="small">Small</wa-button>
<wa-button size="large">Large</wa-button>
```

**States:**

```html
<wa-button disabled>Disabled</wa-button>
<wa-button loading>Loading</wa-button>
<wa-button pill>Rounded Pill</wa-button>
```

**With icons (using slots):**

```html
<wa-button>
  <wa-icon slot="start" name="gear"></wa-icon>
  Settings
</wa-button>

<wa-button>
  Next
  <wa-icon slot="end" name="arrow-right"></wa-icon>
</wa-button>
```

**As a link:**

```html
<wa-button href="https://example.com" target="_blank">Open Link</wa-button>
```

**Button group:**

```html
<wa-button-group>
  <wa-button>Left</wa-button>
  <wa-button>Center</wa-button>
  <wa-button>Right</wa-button>
</wa-button-group>
```

---

## Form Inputs

All form components are **form-associated** — they work with native `<form>` elements and validation.

### Text Input

```html
<wa-input label="Username" name="username" placeholder="Enter username" required></wa-input>
<wa-input label="Email" name="email" type="email"></wa-input>
<wa-input label="Password" name="password" type="password"></wa-input>
```

**With icons:**

```html
<wa-input label="Search" placeholder="Search...">
  <wa-icon slot="start" name="magnifying-glass"></wa-icon>
</wa-input>
```

### Textarea

```html
<wa-textarea label="Message" name="message" rows="4" placeholder="Write something..."></wa-textarea>
```

### Number Input

```html
<wa-number-input label="Quantity" name="qty" value="1" min="0" max="100"></wa-number-input>
```

### File Input

```html
<wa-file-input label="Upload" name="file"></wa-file-input>
```

### Select / Dropdown

```html
<wa-select label="Country" name="country" placeholder="Select one">
  <wa-option value="us">United States</wa-option>
  <wa-option value="kr">South Korea</wa-option>
  <wa-option value="jp">Japan</wa-option>
</wa-select>
```

### Combobox (searchable dropdown)

```html
<wa-combobox label="Fruit" name="fruit" placeholder="Type to search...">
  <wa-option value="apple">Apple</wa-option>
  <wa-option value="banana">Banana</wa-option>
  <wa-option value="cherry">Cherry</wa-option>
</wa-combobox>
```

### Checkbox, Radio, Switch

```html
<wa-checkbox name="agree">I agree to the terms</wa-checkbox>

<wa-radio-group label="Color" name="color">
  <wa-radio value="red">Red</wa-radio>
  <wa-radio value="blue">Blue</wa-radio>
  <wa-radio value="green">Green</wa-radio>
</wa-radio-group>

<wa-switch name="notifications">Enable notifications</wa-switch>
```

### Color Picker

```html
<wa-color-picker label="Pick a color" name="color" value="#ff6600"></wa-color-picker>
```

### Slider

```html
<wa-slider label="Volume" name="volume" min="0" max="100" value="50"></wa-slider>
```

### Rating

```html
<wa-rating label="Rate this" name="rating" max="5"></wa-rating>
```

### Complete Form Example

```html
<form id="signup-form">
  <wa-input label="Name" name="name" required></wa-input>
  <wa-input label="Email" name="email" type="email" required></wa-input>
  <wa-input label="Password" name="password" type="password" required></wa-input>
  <wa-checkbox name="terms" required>I agree to the terms</wa-checkbox>
  <wa-button type="submit" variant="brand" appearance="filled">Sign Up</wa-button>
</form>
```

---

## Cards

```html
<wa-card>
  <h3 slot="header">Card Title</h3>
  <p>Card body content goes here.</p>
  <wa-button slot="footer" variant="brand">Action</wa-button>
</wa-card>
```

**With media:**

```html
<wa-card>
  <img slot="media" src="/images/photo.jpg" alt="Photo" />
  <h3 slot="header">Photo Card</h3>
  <p>Description text here.</p>
</wa-card>
```

**Appearances:** `outlined`, `filled-outlined`, `filled`, `accent`, `plain`

```html
<wa-card appearance="filled">Filled card</wa-card>
```

---

## Icons

Web Awesome uses Font Awesome icons via the `<wa-icon>` component:

```html
<wa-icon name="heart"></wa-icon>
<wa-icon name="user"></wa-icon>
<wa-icon name="gear"></wa-icon>
<wa-icon name="magnifying-glass"></wa-icon>
```

**Icon families:**

```html
<wa-icon name="heart" family="solid"></wa-icon>
<wa-icon name="heart" family="regular"></wa-icon>
<wa-icon name="heart" family="light"></wa-icon>
<wa-icon name="heart" family="thin"></wa-icon>
<wa-icon name="heart" family="duotone"></wa-icon>
<wa-icon name="heart" family="sharp"></wa-icon>
```

---

## Badges & Tags

```html
<wa-badge variant="brand">New</wa-badge>
<wa-badge variant="success">Active</wa-badge>
<wa-badge variant="danger">3</wa-badge>

<wa-tag>Default</wa-tag>
<wa-tag variant="brand">Category</wa-tag>
<wa-tag removable>Removable</wa-tag>
```

---

## Avatar

```html
<wa-avatar label="User"></wa-avatar>
<wa-avatar image="avatar.jpg" label="John"></wa-avatar>
<wa-avatar initials="JD" label="John Doe"></wa-avatar>
```

---

## Dialogs & Overlays

### Dialog (Modal)

```html
<wa-button onclick="document.querySelector('#my-dialog').show()">Open Dialog</wa-button>

<wa-dialog id="my-dialog" label="Confirm Action">
  Are you sure you want to proceed?
  <wa-button slot="footer" variant="brand" onclick="this.closest('wa-dialog').hide()">
    Confirm
  </wa-button>
</wa-dialog>
```

### Drawer (Side Panel)

```html
<wa-drawer id="my-drawer" label="Menu">
  <p>Drawer content here</p>
</wa-drawer>
```

### Tooltip

```html
<wa-tooltip content="This is a tooltip">
  <wa-button>Hover me</wa-button>
</wa-tooltip>
```

### Popover

```html
<wa-popover>
  <wa-button slot="trigger">Click me</wa-button>
  <p>Popover content here.</p>
</wa-popover>
```

---

## Toast Notifications

```html
<wa-toast id="my-toast"></wa-toast>

<script>
  const toast = document.querySelector('#my-toast');
  toast.push('File saved successfully!', { variant: 'success' });
  toast.push('Something went wrong.', { variant: 'danger' });
</script>
```

---

## Navigation

### Tabs

```html
<wa-tab-group>
  <wa-tab slot="nav" panel="general">General</wa-tab>
  <wa-tab slot="nav" panel="settings">Settings</wa-tab>
  <wa-tab slot="nav" panel="advanced">Advanced</wa-tab>

  <wa-tab-panel name="general">General settings here.</wa-tab-panel>
  <wa-tab-panel name="settings">Settings content here.</wa-tab-panel>
  <wa-tab-panel name="advanced">Advanced options here.</wa-tab-panel>
</wa-tab-group>
```

### Breadcrumbs

```html
<wa-breadcrumb>
  <wa-breadcrumb-item href="/">Home</wa-breadcrumb-item>
  <wa-breadcrumb-item href="/blog">Blog</wa-breadcrumb-item>
  <wa-breadcrumb-item>Current Post</wa-breadcrumb-item>
</wa-breadcrumb>
```

### Tree

```html
<wa-tree>
  <wa-tree-item>
    Documents
    <wa-tree-item>Resume.pdf</wa-tree-item>
    <wa-tree-item>Cover Letter.pdf</wa-tree-item>
  </wa-tree-item>
  <wa-tree-item>Photos</wa-tree-item>
</wa-tree>
```

---

## Progress & Loading

```html
<wa-progress-bar value="60"></wa-progress-bar>
<wa-progress-ring value="75"></wa-progress-ring>
<wa-spinner></wa-spinner>
<wa-skeleton effect="sheen"></wa-skeleton>
```

---

## Carousel

```html
<wa-carousel navigation pagination>
  <wa-carousel-item><img src="slide1.jpg" alt="Slide 1" /></wa-carousel-item>
  <wa-carousel-item><img src="slide2.jpg" alt="Slide 2" /></wa-carousel-item>
  <wa-carousel-item><img src="slide3.jpg" alt="Slide 3" /></wa-carousel-item>
</wa-carousel>
```

---

## Charts

```html
<wa-bar-chart>
  <!-- Chart data via JavaScript -->
</wa-bar-chart>

<wa-line-chart></wa-line-chart>
<wa-pie-chart></wa-pie-chart>
<wa-doughnut-chart></wa-doughnut-chart>
<wa-sparkline></wa-sparkline>
```

---

## Formatting Utilities

```html
<wa-format-date date="2026-03-24" month="long" day="numeric" year="numeric"></wa-format-date>
<!-- Output: March 24, 2026 -->

<wa-format-number value="1234567" type="decimal"></wa-format-number>
<!-- Output: 1,234,567 -->

<wa-format-bytes value="1048576"></wa-format-bytes>
<!-- Output: 1 MB -->

<wa-relative-time date="2026-03-23"></wa-relative-time>
<!-- Output: yesterday -->
```

---

## Other Components

```html
<!-- QR Code -->
<wa-qr-code value="https://example.com"></wa-qr-code>

<!-- Copy Button -->
<wa-copy-button value="Text to copy"></wa-copy-button>

<!-- Collapsible Details -->
<wa-details summary="Click to expand">
  Hidden content revealed here.
</wa-details>

<!-- Callout -->
<wa-callout variant="warning">
  This is an important warning message.
</wa-callout>

<!-- Divider -->
<wa-divider></wa-divider>

<!-- Split Panel (resizable) -->
<wa-split-panel>
  <div slot="start">Left panel</div>
  <div slot="end">Right panel</div>
</wa-split-panel>

<!-- Before/After Comparison -->
<wa-comparison>
  <img slot="before" src="before.jpg" alt="Before" />
  <img slot="after" src="after.jpg" alt="After" />
</wa-comparison>
```

---

## Layout Utility Classes

Web Awesome includes layout utilities (no Tailwind needed):

```html
<!-- Vertical stack with gap -->
<div class="wa-stack wa-gap-m">
  <div>Item 1</div>
  <div>Item 2</div>
</div>

<!-- Horizontal row (wraps) -->
<div class="wa-cluster wa-gap-s">
  <wa-button>A</wa-button>
  <wa-button>B</wa-button>
  <wa-button>C</wa-button>
</div>

<!-- Auto grid -->
<div class="wa-grid wa-gap-m">
  <wa-card>Card 1</wa-card>
  <wa-card>Card 2</wa-card>
  <wa-card>Card 3</wa-card>
</div>

<!-- Split two items apart -->
<div class="wa-split">
  <span>Left</span>
  <span>Right</span>
</div>
```

**Gap sizes:** `wa-gap-0`, `wa-gap-3xs`, `wa-gap-2xs`, `wa-gap-xs`, `wa-gap-s`, `wa-gap-m`, `wa-gap-l`, `wa-gap-xl`, `wa-gap-2xl`, `wa-gap-3xl`

**Alignment:** `wa-align-items-start`, `wa-align-items-center`, `wa-align-items-end`, `wa-align-items-stretch`, `wa-align-items-baseline`

---

## Typography Utility Classes

```html
<p class="wa-heading-xl">Large Heading</p>
<p class="wa-heading-m">Medium Heading</p>
<p class="wa-body-m">Body text</p>
<p class="wa-caption-s">Small caption</p>

<!-- Sizes: 2xs, xs, s, m, l, xl, 2xl, 3xl, 4xl -->
```

**Font weight:** `wa-font-weight-light`, `wa-font-weight-normal`, `wa-font-weight-semibold`, `wa-font-weight-bold`

**Text color:** `wa-color-text-quiet`, `wa-color-text-normal`, `wa-color-text-link`

**Truncate:** `wa-text-truncate`

---

## Theming

### Built-in Themes

Add a theme CSS file before `webawesome.css`:

```html
<link rel="stylesheet" href="/vendor/web-awesome-pro/styles/themes/awesome.css">
```

Available themes: `default`, `awesome`, `brutalist`, `glossy`, `matter`, `mellow`, `playful`, `premium`, `shoelace`, `tailspin`, `active`

### Color Variants

Apply semantic color to any container:

```html
<div class="wa-brand">Brand colored section</div>
<div class="wa-success">Success colored section</div>
<div class="wa-warning">Warning colored section</div>
<div class="wa-danger">Danger colored section</div>
<div class="wa-neutral">Neutral colored section</div>
```

### Custom Styling with CSS Parts

Components expose internal parts for styling:

```css
wa-button::part(base) {
  border-radius: 20px;
  font-weight: bold;
}

wa-card::part(header) {
  background: #f0f0f0;
}

wa-input::part(base) {
  border-color: #ccc;
}
```

### CSS Custom Properties

```css
:root {
  --wa-border-radius-m: 8px;
  --wa-transition-fast: 150ms;
  --wa-space-m: 1rem;
}
```

---

## Using in Svelte

Web components work directly in Svelte files:

```svelte
<script>
  let name = $state('');

  function handleSubmit(e) {
    e.preventDefault();
    console.log('Name:', name);
  }
</script>

<form onsubmit={handleSubmit}>
  <wa-input label="Name" value={name} oninput={(e) => name = e.target.value}></wa-input>
  <wa-button type="submit" variant="brand" appearance="filled">Submit</wa-button>
</form>
```

> **Note:** Since web components use Shadow DOM, use `oninput` events to sync values with Svelte state rather than `bind:value`.

---

## Complete Component List

| Category | Components |
|----------|-----------|
| Buttons | `wa-button`, `wa-button-group` |
| Inputs | `wa-input`, `wa-textarea`, `wa-number-input`, `wa-file-input`, `wa-select`, `wa-option`, `wa-combobox` |
| Toggles | `wa-checkbox`, `wa-radio`, `wa-radio-group`, `wa-switch` |
| Pickers | `wa-color-picker`, `wa-slider`, `wa-rating` |
| Display | `wa-card`, `wa-badge`, `wa-tag`, `wa-avatar`, `wa-icon`, `wa-divider` |
| Charts | `wa-bar-chart`, `wa-line-chart`, `wa-pie-chart`, `wa-doughnut-chart`, `wa-bubble-chart`, `wa-radar-chart`, `wa-polar-area-chart`, `wa-scatter-chart`, `wa-sparkline`, `wa-chart` |
| Navigation | `wa-breadcrumb`, `wa-breadcrumb-item`, `wa-tab-group`, `wa-tab`, `wa-tab-panel`, `wa-tree`, `wa-tree-item` |
| Overlays | `wa-dialog`, `wa-drawer`, `wa-popover`, `wa-popup`, `wa-tooltip`, `wa-toast`, `wa-toast-item` |
| Media | `wa-carousel`, `wa-carousel-item`, `wa-animated-image`, `wa-comparison`, `wa-zoomable-frame` |
| Progress | `wa-progress-bar`, `wa-progress-ring`, `wa-spinner`, `wa-skeleton` |
| Formatting | `wa-format-date`, `wa-format-number`, `wa-format-bytes`, `wa-relative-time` |
| Utilities | `wa-qr-code`, `wa-copy-button`, `wa-include`, `wa-details`, `wa-callout`, `wa-split-panel`, `wa-scroller`, `wa-animation`, `wa-page` |
| Observers | `wa-intersection-observer`, `wa-mutation-observer`, `wa-resize-observer` |
