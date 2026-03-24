# Font Awesome Pro - Crash Course

Font Awesome Pro 7 provides thousands of icons in multiple styles. Already loaded in this project via `all.min.css`.

---

## Setup (already done)

```html
<!-- In app.blade.php -->
<link rel="stylesheet" href="/vendor/font-awesome-pro/css/all.min.css">
```

---

## Basic Usage

```html
<i class="fa-solid fa-heart"></i>
<i class="fa-solid fa-user"></i>
<i class="fa-solid fa-gear"></i>
<i class="fa-solid fa-magnifying-glass"></i>
<i class="fa-solid fa-house"></i>
```

The pattern is always: `fa-{style} fa-{icon-name}`

---

## Icon Styles

Font Awesome Pro includes multiple styles for most icons:

### Classic Styles

```html
<!-- Solid (filled, bold) -->
<i class="fa-solid fa-star"></i>

<!-- Regular (outlined) -->
<i class="fa-regular fa-star"></i>

<!-- Light (thinner outline) -->
<i class="fa-light fa-star"></i>

<!-- Thin (thinnest) -->
<i class="fa-thin fa-star"></i>
```

### Duotone Styles (two-tone icons)

```html
<!-- Duotone (solid weight, two layers) -->
<i class="fa-duotone fa-star"></i>

<!-- Duotone Regular -->
<i class="fa-duotone fa-regular fa-star"></i>

<!-- Duotone Light -->
<i class="fa-duotone fa-light fa-star"></i>

<!-- Duotone Thin -->
<i class="fa-duotone fa-thin fa-star"></i>
```

### Sharp Styles (angular, geometric)

```html
<!-- Sharp Solid -->
<i class="fa-sharp fa-solid fa-star"></i>

<!-- Sharp Regular -->
<i class="fa-sharp fa-regular fa-star"></i>

<!-- Sharp Light -->
<i class="fa-sharp fa-light fa-star"></i>

<!-- Sharp Thin -->
<i class="fa-sharp fa-thin fa-star"></i>
```

### Sharp Duotone

```html
<i class="fa-sharp-duotone fa-solid fa-star"></i>
<i class="fa-sharp-duotone fa-regular fa-star"></i>
```

### Brands

```html
<i class="fa-brands fa-github"></i>
<i class="fa-brands fa-twitter"></i>
<i class="fa-brands fa-google"></i>
<i class="fa-brands fa-laravel"></i>
<i class="fa-brands fa-svelte"></i>
```

### Shorthand Classes

| Full Class | Shorthand |
|-----------|-----------|
| `fa-solid` | `fas` |
| `fa-regular` | `far` |
| `fa-light` | `fal` |
| `fa-thin` | `fat` |
| `fa-duotone` | `fad` |
| `fa-brands` | `fab` |
| `fa-sharp fa-solid` | `fass` |

```html
<!-- These are equivalent -->
<i class="fa-solid fa-heart"></i>
<i class="fas fa-heart"></i>
```

---

## Sizing

### Relative Sizes

```html
<i class="fa-solid fa-heart fa-2xs"></i>   <!-- 0.625em -->
<i class="fa-solid fa-heart fa-xs"></i>    <!-- 0.75em -->
<i class="fa-solid fa-heart fa-sm"></i>    <!-- 0.875em -->
<i class="fa-solid fa-heart"></i>          <!-- 1em (default) -->
<i class="fa-solid fa-heart fa-lg"></i>    <!-- 1.25em -->
<i class="fa-solid fa-heart fa-xl"></i>    <!-- 1.5em -->
<i class="fa-solid fa-heart fa-2xl"></i>   <!-- 2em -->
```

### Fixed Multipliers

```html
<i class="fa-solid fa-heart fa-1x"></i>   <!-- 1em -->
<i class="fa-solid fa-heart fa-2x"></i>   <!-- 2em -->
<i class="fa-solid fa-heart fa-3x"></i>   <!-- 3em -->
<i class="fa-solid fa-heart fa-5x"></i>   <!-- 5em -->
<i class="fa-solid fa-heart fa-10x"></i>  <!-- 10em -->
```

---

## Animations

```html
<!-- Continuous spin -->
<i class="fa-solid fa-spinner fa-spin"></i>

<!-- Reverse spin -->
<i class="fa-solid fa-gear fa-spin fa-spin-reverse"></i>

<!-- Pulsing spin (8 steps) -->
<i class="fa-solid fa-spinner fa-spin-pulse"></i>

<!-- Bounce -->
<i class="fa-solid fa-arrow-down fa-bounce"></i>

<!-- Fade in/out -->
<i class="fa-solid fa-heart fa-fade"></i>

<!-- Beat (scale pulse) -->
<i class="fa-solid fa-heart fa-beat"></i>

<!-- Beat + Fade combined -->
<i class="fa-solid fa-heart fa-beat-fade"></i>

<!-- Shake -->
<i class="fa-solid fa-bell fa-shake"></i>

<!-- Flip (3D rotation) -->
<i class="fa-solid fa-heart fa-flip"></i>
```

---

## Rotations & Flips

```html
<!-- Rotate -->
<i class="fa-solid fa-arrow-right fa-rotate-90"></i>
<i class="fa-solid fa-arrow-right fa-rotate-180"></i>
<i class="fa-solid fa-arrow-right fa-rotate-270"></i>

<!-- Flip -->
<i class="fa-solid fa-heart fa-flip-horizontal"></i>
<i class="fa-solid fa-heart fa-flip-vertical"></i>
<i class="fa-solid fa-heart fa-flip-both"></i>
```

---

## Fixed Width

Use `fa-fw` to make icons the same width (useful in lists and nav menus):

```html
<div><i class="fa-solid fa-house fa-fw"></i> Home</div>
<div><i class="fa-solid fa-user fa-fw"></i> Profile</div>
<div><i class="fa-solid fa-gear fa-fw"></i> Settings</div>
<div><i class="fa-solid fa-right-from-bracket fa-fw"></i> Logout</div>
```

---

## Lists

Replace default list bullets with icons:

```html
<ul class="fa-ul">
  <li><span class="fa-li"><i class="fa-solid fa-check"></i></span> Item one</li>
  <li><span class="fa-li"><i class="fa-solid fa-check"></i></span> Item two</li>
  <li><span class="fa-li"><i class="fa-solid fa-xmark"></i></span> Item three</li>
</ul>
```

---

## Stacking Icons

Layer icons on top of each other:

```html
<span class="fa-stack fa-2x">
  <i class="fa-solid fa-circle fa-stack-2x"></i>
  <i class="fa-solid fa-flag fa-stack-1x fa-inverse"></i>
</span>

<span class="fa-stack fa-2x">
  <i class="fa-solid fa-square fa-stack-2x"></i>
  <i class="fa-solid fa-terminal fa-stack-1x fa-inverse"></i>
</span>

<!-- "No" symbol over an icon -->
<span class="fa-stack fa-2x">
  <i class="fa-solid fa-camera fa-stack-1x"></i>
  <i class="fa-solid fa-ban fa-stack-2x" style="color: red; opacity: 0.7;"></i>
</span>
```

---

## Duotone Styling

Duotone icons have a primary and secondary layer that can be styled independently:

```html
<i class="fa-duotone fa-coffee"
   style="--fa-primary-color: #8B4513; --fa-secondary-color: #D2691E; --fa-secondary-opacity: 0.4;">
</i>
```

**CSS custom properties for duotone:**

```css
.my-icon {
  --fa-primary-color: #333;
  --fa-primary-opacity: 1;
  --fa-secondary-color: #999;
  --fa-secondary-opacity: 0.4;
}
```

---

## Styling with CSS

```css
/* Change color */
.fa-heart { color: red; }

/* Change size via font-size */
.big-icon { font-size: 3rem; }

/* Hover effects */
.fa-heart:hover {
  color: darkred;
  transform: scale(1.2);
  transition: all 0.2s;
}
```

---

## Using with Web Awesome

Inside Web Awesome components, use `<wa-icon>` which integrates Font Awesome:

```html
<!-- wa-icon uses Font Awesome names -->
<wa-icon name="heart"></wa-icon>
<wa-icon name="heart" family="regular"></wa-icon>
<wa-icon name="heart" family="light"></wa-icon>

<!-- In buttons -->
<wa-button>
  <wa-icon slot="start" name="download"></wa-icon>
  Download
</wa-button>

<!-- Standalone Font Awesome (outside wa- components) -->
<i class="fa-solid fa-heart"></i>
```

> **When to use which:**
> - Inside `<wa-*>` components: use `<wa-icon name="..." family="...">`
> - Standalone in HTML/Svelte: use `<i class="fa-solid fa-icon-name">`

---

## Common Icons Quick Reference

| Icon | Class |
|------|-------|
| Home | `fa-house` |
| User | `fa-user` |
| Settings | `fa-gear` |
| Search | `fa-magnifying-glass` |
| Edit | `fa-pen` |
| Delete | `fa-trash` |
| Save | `fa-floppy-disk` |
| Close | `fa-xmark` |
| Check | `fa-check` |
| Plus | `fa-plus` |
| Minus | `fa-minus` |
| Arrow right | `fa-arrow-right` |
| Chevron down | `fa-chevron-down` |
| Heart | `fa-heart` |
| Star | `fa-star` |
| Bell | `fa-bell` |
| Envelope | `fa-envelope` |
| Calendar | `fa-calendar` |
| Clock | `fa-clock` |
| Download | `fa-download` |
| Upload | `fa-upload` |
| Eye | `fa-eye` |
| Eye slash | `fa-eye-slash` |
| Lock | `fa-lock` |
| Unlock | `fa-unlock` |
| Spinner | `fa-spinner` |
| Circle check | `fa-circle-check` |
| Triangle exclamation | `fa-triangle-exclamation` |
| Circle info | `fa-circle-info` |
| Bars (hamburger) | `fa-bars` |
| Ellipsis | `fa-ellipsis` |

---

## Available CSS Files

For lighter builds, load only what you need instead of `all.min.css`:

```html
<!-- Always required base -->
<link rel="stylesheet" href="/vendor/font-awesome-pro/css/fontawesome.min.css">

<!-- Then add only the styles you use -->
<link rel="stylesheet" href="/vendor/font-awesome-pro/css/solid.min.css">
<link rel="stylesheet" href="/vendor/font-awesome-pro/css/regular.min.css">
<link rel="stylesheet" href="/vendor/font-awesome-pro/css/brands.min.css">
```

| File | Contains |
|------|----------|
| `all.min.css` | Everything (easiest) |
| `fontawesome.min.css` | Base styles (required) |
| `solid.min.css` | Solid icons |
| `regular.min.css` | Regular icons |
| `light.min.css` | Light icons |
| `thin.min.css` | Thin icons |
| `brands.min.css` | Brand logos |
| `duotone.min.css` | Duotone icons |
| `sharp-solid.min.css` | Sharp solid |
| `sharp-regular.min.css` | Sharp regular |
