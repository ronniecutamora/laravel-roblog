# Project Setup Guide: Laravel Sail + Inertia.js + Svelte 5

A step-by-step guide to set up a new Laravel project with Docker (Sail), Inertia.js, and Svelte 5.

---

## Prerequisites

Make sure these are installed before starting:

```bash
# Check each one — if any command fails, install that tool first
php --version        # PHP 8.4+
composer --version   # Composer 2.x
node --version       # Node.js 22+
npm --version        # npm 10+
docker --version     # Docker Desktop (must be running)
git --version        # Git
```

**Install on macOS (if missing):**

```bash
brew install php composer node git
```

Docker Desktop: download from https://www.docker.com/products/docker-desktop/

**Make sure Docker Desktop is running before you continue.**

---

## Step 1: Create the Laravel project

```bash
composer create-project laravel/laravel my-project
```

This downloads Laravel and all its PHP dependencies into a new `my-project/` folder.

```bash
cd my-project
```

All commands from here on are run inside this folder.

Initialize git — Sail expects a git repository:

```bash
git init
git add .
git commit -m "Initial Laravel project"
```

---

## Step 2: Install Laravel Sail

Sail gives you a Docker-based dev environment (PHP, PostgreSQL, Redis, etc.) so you don't have to install them on your machine.

```bash
# Install the Sail package
composer require laravel/sail --dev
```

> If you skip this and jump to `sail:install`, you'll get:
> `There are no commands defined in the "sail" namespace`

Now run the Sail installer. This generates a `compose.yaml` file with Docker services:

```bash
php artisan sail:install --with=pgsql,redis,meilisearch,mailpit
```

It will ask you to confirm — press Enter.

This creates/updates:
- `compose.yaml` — Docker services configuration
- `.env` — database and Redis connection settings (auto-configured for Docker)

---

## Step 3: Start the Docker containers

```bash
./vendor/bin/sail up -d
```

`-d` runs in the background. First time takes a few minutes to download Docker images.

**Wait 30-60 seconds** for all services to fully start, then verify:

```bash
docker ps
```

You should see 5 containers running: `laravel.test`, `pgsql`, `redis`, `meilisearch`, `mailpit`.

---

## Step 4: Generate app key and run migrations

Laravel needs an encryption key, and the database needs its tables created. **You must do this before visiting the app**, otherwise you'll get a 500 error (`relation "sessions" does not exist`).

```bash
# Generate encryption key (stored in .env as APP_KEY)
./vendor/bin/sail artisan key:generate

# Create database tables (users, sessions, cache, jobs, etc.)
./vendor/bin/sail artisan migrate
```

**Verify — expected output from migrate:**

```
Running migrations...
  0001_01_01_000000_create_users_table ............. DONE
  0001_01_01_000001_create_cache_table ............. DONE
  0001_01_01_000002_create_jobs_table .............. DONE
```

> **If you get `Connection refused`:** The PostgreSQL container isn't ready yet.
> Wait 10-20 seconds and run the migrate command again.

**Now verify the app is running:**

Open http://localhost in your browser. You should see the Laravel welcome page.

> **If you get a 500 error instead:**
> - `relation "sessions" does not exist` → you didn't run `migrate`. Run it now.
> - `No application encryption key` → you didn't run `key:generate`. Run it now.
> - Page doesn't load at all → Docker containers aren't running. Run `./vendor/bin/sail up -d`.

---

## Step 5: Install Inertia.js (server-side)

Inertia.js is the bridge between Laravel (backend) and Svelte (frontend). It lets you write Svelte pages that receive data directly from Laravel controllers — no REST API needed for your web pages.

```bash
# Install Inertia's Laravel adapter
./vendor/bin/sail composer require inertiajs/inertia-laravel
```

### 5a. Create the Inertia root template

This is the single Blade file that loads your entire Svelte app. Every page renders inside `@inertia`.

Delete the default welcome page and create the Inertia template:

```bash
rm resources/views/welcome.blade.php
```

Create `resources/views/app.blade.php` with this content:

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
</head>
<body>
    @inertia
</body>
</html>
```

What each line does:
- `@vite(...)` — loads your CSS and JS files (compiled by Vite)
- `@inertiaHead` — lets Inertia set the page `<title>` dynamically
- `@inertia` — this is where your Svelte pages render

### 5b. Set up the Inertia middleware

This middleware shares data (like the current user) with every Svelte page:

```bash
./vendor/bin/sail artisan inertia:middleware
```

This creates `app/Http/Middleware/HandleInertiaRequests.php`.

Now register it. Open `bootstrap/app.php` and find the `withMiddleware` section. Add the Inertia middleware:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->web(append: [
        \App\Http\Middleware\HandleInertiaRequests::class,
    ]);
})
```

---

## Step 6: Install Svelte 5 + frontend packages

### 6a. Install NPM packages

```bash
# Svelte 5 and its Vite plugin
./vendor/bin/sail npm install svelte @sveltejs/vite-plugin-svelte

# Inertia's Svelte adapter (connects Inertia to Svelte)
./vendor/bin/sail npm install @inertiajs/svelte
```

**Verify they installed:**

```bash
./vendor/bin/sail npm ls svelte @inertiajs/svelte
```

You should see version numbers, not errors.

### 6b. Configure Vite

Vite is the build tool that compiles your Svelte files into browser-ready JavaScript.

Open `vite.config.js` and replace everything with:

```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { svelte } from '@sveltejs/vite-plugin-svelte';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            ssr: 'resources/js/ssr.js',
            refresh: true,
        }),
        svelte(),
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        hmr: {
            host: 'localhost',
        },
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
```

What this does:
- `laravel(...)` — tells Vite where your CSS and JS entry files are
- `svelte()` — enables Vite to compile `.svelte` files
- `server` block — configures the dev server to work inside Docker
- `refresh: true` — auto-reloads the browser when you change PHP files
- `ssr` — entry point for server-side rendering (optional, but good to have)

### 6c. Create Svelte config

Create a new file `svelte.config.js` in the project root:

```js
import { vitePreprocess } from '@sveltejs/vite-plugin-svelte';

export default {
    preprocess: vitePreprocess(),
};
```

This lets you use `<style lang="scss">` or TypeScript in Svelte files (optional but recommended to have).

### 6d. Create the JavaScript entry point

This file is what boots your Svelte app. It tells Inertia how to find and render your page components.

Open `resources/js/app.js` and replace everything with:

```js
import '../css/app.css';
import { createInertiaApp } from '@inertiajs/svelte';

createInertiaApp({
    // When Laravel says "render page 'Home'", this finds './Pages/Home.svelte'
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.svelte', { eager: true });
        return pages[`./Pages/${name}.svelte`];
    },
    // Mount the Svelte app onto the @inertia element in app.blade.php
    setup({ el, App, props }) {
        new App({ target: el, props });
    },
});
```

How the page resolution works:
1. Your Laravel controller calls `Inertia::render('Home', ['greeting' => 'Hello'])`
2. Inertia sends that to the browser
3. `resolve('Home')` maps to `./Pages/Home.svelte`
4. That Svelte component receives `{ greeting: 'Hello' }` as props

### 6e. Create your first Svelte page

Create the Pages directory:

```bash
mkdir -p resources/js/Pages
```

Create `resources/js/Pages/Home.svelte`:

```svelte
<script>
    // These props come from the Laravel controller
    // Whatever you pass in Inertia::render('Home', [...]) arrives here
    let { greeting } = $props();
</script>

<main>
    <h1>{greeting}</h1>
    <p>Laravel + Svelte + Inertia is working!</p>
</main>

<style>
    main {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        font-family: system-ui, sans-serif;
    }
    h1 {
        color: #333;
    }
</style>
```

### 6f. Create a route that renders the page

Open `routes/web.php` and replace everything with:

```php
<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    // 'Home' maps to resources/js/Pages/Home.svelte
    // The array becomes the component's $props()
    return Inertia::render('Home', [
        'greeting' => 'Hello from Laravel + Svelte!',
    ]);
});
```

This is the key pattern: **Laravel handles the route, Inertia renders a Svelte component with data.**

---

## Step 7: Run the dev server and verify

```bash
./vendor/bin/sail npm run dev
```

This starts the Vite dev server with Hot Module Replacement (HMR) — when you edit a Svelte file, the browser updates instantly without a full reload.

**Open http://localhost in your browser.**

You should see:

> **Hello from Laravel + Svelte!**
>
> Laravel + Svelte + Inertia is working!

If you see this, everything is working. You now have:
- Laravel running in Docker (via Sail)
- PostgreSQL, Redis, MeiliSearch, Mailpit all running
- Inertia.js connecting Laravel to Svelte
- Svelte 5 rendering pages with data from Laravel
- HMR for instant browser updates during development

> **If you see a blank white page:** Open browser console (F12 → Console tab). Common causes:
> - `Failed to resolve module` → `npm install` didn't finish. Run it again.
> - `Pages/Home.svelte not found` → check the file path matches exactly.
> - No errors but blank → make sure `@inertia` is in `app.blade.php`.

Press `Ctrl+C` to stop Vite when done.

---

## Quick Reference: Daily Commands

```bash
# Start everything
./vendor/bin/sail up -d          # Start Docker containers
./vendor/bin/sail npm run dev     # Start Vite dev server (keep this running)

# Database
./vendor/bin/sail artisan migrate                 # Run new migrations
./vendor/bin/sail artisan migrate:fresh --seed     # Reset DB + seed

# Create things
./vendor/bin/sail artisan make:model Post -mfsc    # Model + migration + factory + seeder + controller
./vendor/bin/sail artisan make:controller PostController

# Testing
./vendor/bin/sail artisan test

# Stop everything
./vendor/bin/sail down
```

---

## What to do next

Now that the base is working, you can add more features from this project's stack:

| Feature | Package | Install command |
|---------|---------|----------------|
| API Authentication | Laravel Sanctum | `./vendor/bin/sail composer require laravel/sanctum` |
| WebSocket / Real-time | Laravel Reverb | `./vendor/bin/sail composer require laravel/reverb` |
| Full-text Search | Laravel Scout + MeiliSearch | `./vendor/bin/sail composer require laravel/scout meilisearch/meilisearch-php` |
| Code Style Formatter | Laravel Pint | `./vendor/bin/sail composer require laravel/pint --dev` |
| Real-time Log Viewer | Laravel Pail | `./vendor/bin/sail composer require laravel/pail --dev` |

After installing each package, run:

```bash
# Publish its config file
./vendor/bin/sail artisan vendor:publish --provider="<ProviderClass>"

# Run any new migrations it added
./vendor/bin/sail artisan migrate
```

For detailed setup of each feature, see the other guides in this `docs/onboarding/` folder.
