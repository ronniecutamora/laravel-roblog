# Project Setup Guide: Laravel + Svelte Multi-Tenant SNS Platform

This guide walks you through setting up a new project using the same tech stack as this codebase — from scratch.

---

## Tech Stack Overview

| Layer | Technology | Version |
|-------|-----------|---------|
| Backend Framework | Laravel (with Sail) | 13.x |
| PHP Runtime | PHP-FPM | 8.4+ |
| Frontend Framework | Svelte 5 | 5.x |
| Server-Client Bridge | Inertia.js | 2.x |
| UI Components | Web Awesome Pro | 3.x |
| Icons | Font Awesome Pro | 6.x |
| Database | PostgreSQL | 18 |
| Cache / Queue / Session | Redis | Alpine |
| Search Engine | MeiliSearch (via Laravel Scout) | Latest |
| Real-time / WebSocket | Laravel Reverb | 1.x |
| Authentication | Laravel Sanctum | 4.x |
| Build Tool | Vite | 7.x |
| Dev Mail Server | Mailpit | Latest |
| Containerization | Docker Compose (Laravel Sail) | - |
| Production Deployment | Dokploy (Docker) | - |

---

## Prerequisites

- **Docker Desktop** installed and running
- **Git**
- **Node.js 22+** and **npm** (for local Vite if needed)
- **PHP 8.4+** and **Composer** (for initial project creation)
- A **Web Awesome Pro** license (or swap for a free alternative)
- A **Font Awesome Pro** license (or use Font Awesome Free)

---

## Step 1: Create the Laravel Project

```bash
# Create a new Laravel project
composer create-project laravel/laravel my-project
cd my-project

# Initialize git (required for Sail and version control)
git init
git add .
git commit -m "Initial Laravel project"
```

---

## Step 2: Install Laravel Sail (Docker Dev Environment)

Laravel Sail provides a Docker-based development environment with zero config.

```bash
# Step 1: Install Sail as a dev dependency via Composer FIRST
composer require laravel/sail --dev

# Step 2: Now the sail:install command becomes available
php artisan sail:install --with=pgsql,redis,meilisearch,mailpit

# Step 3: Start all containers
./vendor/bin/sail up -d
```

> **Common error:** If you see `There are no commands defined in the "sail" namespace`,
> it means you skipped `composer require laravel/sail --dev`. Run that first.

This generates a `compose.yaml` (or `docker-compose.yml`) with the following services:

| Service | Port | Purpose |
|---------|------|---------|
| laravel.test | 80 | Laravel app (PHP-FPM) |
| pgsql | 5432 | PostgreSQL database |
| redis | 6379 | Cache, queue, sessions |
| meilisearch | 7700 | Full-text search |
| mailpit | 8025 (web), 1025 (SMTP) | Mail testing UI |

### Add pgAdmin (Optional Database GUI)

Add this to your `compose.yaml` under `services:`:

```yaml
pgadmin:
    image: dpage/pgadmin4
    environment:
        PGADMIN_DEFAULT_EMAIL: admin@admin.com
        PGADMIN_DEFAULT_PASSWORD: admin
    ports:
        - '5050:80'
    networks:
        - sail
```

---

## Step 3: Configure Environment Variables

Copy and edit the `.env` file:

```bash
cp .env.example .env
./vendor/bin/sail artisan key:generate
```

Key `.env` settings for this stack:

```env
# App
APP_NAME=MyProject
APP_URL=http://localhost

# Database — PostgreSQL
DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password

# Cache, Queue, Session — Redis
CACHE_STORE=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
REDIS_HOST=redis

# Broadcasting — Reverb (WebSocket)
BROADCAST_CONNECTION=reverb

# Search — MeiliSearch
SCOUT_DRIVER=meilisearch
MEILISEARCH_HOST=http://meilisearch:7700
MEILISEARCH_KEY=masterKey

# Mail — Mailpit
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025

# Reverb (WebSocket server)
REVERB_APP_ID=my-app
REVERB_APP_KEY=my-app-key
REVERB_APP_SECRET=my-app-secret
REVERB_HOST=reverb
REVERB_PORT=9080
REVERB_SCHEME=http

# Vite needs these for client-side WebSocket connection
VITE_APP_NAME="${APP_NAME}"
VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"
```

---

## Step 4: Install Backend Packages

```bash
# Authentication (API tokens + SPA session auth)
./vendor/bin/sail composer require laravel/sanctum

# Real-time WebSocket server
./vendor/bin/sail composer require laravel/reverb

# Full-text search
./vendor/bin/sail composer require laravel/scout
./vendor/bin/sail composer require meilisearch/meilisearch-php http-interop/http-factory-guzzle

# Publish configs
./vendor/bin/sail artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
./vendor/bin/sail artisan install:broadcasting  # Sets up Reverb
```

---

## Step 5: Install Frontend — Svelte 5 + Inertia.js

### 5a. Install NPM packages

```bash
# Inertia (server-side)
./vendor/bin/sail composer require inertiajs/inertia-laravel

# Inertia + Svelte (client-side)
./vendor/bin/sail npm install @inertiajs/svelte

# Svelte 5 + Vite plugin
./vendor/bin/sail npm install svelte @sveltejs/vite-plugin-svelte

# Real-time client libraries
./vendor/bin/sail npm install laravel-echo pusher-js

# Utilities
./vendor/bin/sail npm install axios concurrently
```

### 5b. Configure Vite (`vite.config.js`)

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

### 5c. Configure Svelte (`svelte.config.js`)

```js
import { vitePreprocess } from '@sveltejs/vite-plugin-svelte';

export default {
    preprocess: vitePreprocess(),
    onwarn: (warning, handler) => {
        // Suppress Web Component warnings
        if (warning.code === 'a11y-unknown-element') return;
        handler(warning);
    },
};
```

### 5d. Set Up Inertia Root Template (`resources/views/app.blade.php`)

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>

    <!-- Font Awesome Pro (self-hosted) -->
    <link rel="stylesheet" href="/vendor/font-awesome-pro/css/all.min.css" />

    <!-- Web Awesome Pro (self-hosted) -->
    <link rel="stylesheet" href="/vendor/web-awesome-pro/dist/themes/default.css" />
    <script type="module" src="/vendor/web-awesome-pro/dist/web-awesome.loader.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
</head>
<body>
    @inertia
</body>
</html>
```

### 5e. Set Up Inertia Middleware

```bash
./vendor/bin/sail artisan inertia:middleware
```

Register it in `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->web(append: [
        \App\Http\Middleware\HandleInertiaRequests::class,
    ]);
})
```

### 5f. Create the App Entry Point (`resources/js/app.js`)

```js
import { createInertiaApp } from '@inertiajs/svelte';

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.svelte', { eager: true });
        return pages[`./Pages/${name}.svelte`];
    },
    setup({ el, App, props }) {
        new App({ target: el, props });
    },
});
```

### 5g. Create SSR Entry Point (`resources/js/ssr.js`)

```js
import { createInertiaApp } from '@inertiajs/svelte';
import createServer from '@inertiajs/svelte/server';

createServer((page) =>
    createInertiaApp({
        page,
        resolve: (name) => {
            const pages = import.meta.glob('./Pages/**/*.svelte', { eager: true });
            return pages[`./Pages/${name}.svelte`];
        },
    }),
);
```

### 5h. Create Your First Page (`resources/js/Pages/Home.svelte`)

```svelte
<script>
    // Props passed from Laravel controller via Inertia
    let { greeting } = $props();
</script>

<h1>{greeting}</h1>
```

---

## Step 6: Set Up Laravel Reverb (WebSocket)

### 6a. Add Reverb Service to `compose.yaml`

```yaml
reverb:
    build:
        context: ./vendor/laravel/sail/runtimes/8.4
        dockerfile: Dockerfile
    command: php artisan reverb:start --host=0.0.0.0 --port=9080
    ports:
        - '${REVERB_PORT:-9080}:9080'
    volumes:
        - '.:/var/www/html'
    networks:
        - sail
    depends_on:
        - pgsql
        - redis
```

### 6b. Configure Broadcasting Channels (`routes/channels.php`)

```php
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{roomId}', function ($user, $roomId) {
    // Authorization logic
    return true;
});
```

### 6c. Client-Side Echo Setup (`resources/js/bootstrap.js`)

```js
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT,
    wssPort: import.meta.env.VITE_REVERB_PORT,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});
```

---

## Step 7: Self-Host UI Libraries

### Web Awesome Pro

1. Download from your Web Awesome Pro account
2. Extract to `public/vendor/web-awesome-pro/`
3. Load in `app.blade.php` (see Step 5d)
4. Use in Svelte as plain HTML tags: `<wa-button>`, `<wa-dialog>`, etc.

### Font Awesome Pro

1. Download the **Web** package (CSS + Webfonts)
2. Extract to `public/vendor/font-awesome-pro/`
3. Structure should be:
   ```
   public/vendor/font-awesome-pro/
   ├── css/all.min.css
   └── webfonts/*.woff2
   ```
4. Load in `app.blade.php` (see Step 5d)
5. Use in Svelte: `<i class="fa-solid fa-heart"></i>`

---

## Step 8: Set Up Authentication (Sanctum)

### 8a. Sanctum Config (`config/sanctum.php`)

Key settings:

```php
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS',
    'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1'
)),
'expiration' => 43200, // 30 days in minutes
```

### 8b. User Model Setup

```php
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // For UUID primary keys (optional but recommended):
    use HasUuids;
    public $incrementing = false;
    protected $keyType = 'string';
}
```

### 8c. API Auth Routes (`routes/api.php`)

```php
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1');
    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth:sanctum');
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn (Request $request) => $request->user());
    // ... your API routes
});
```

---

## Step 9: Set Up Search (MeiliSearch + Scout)

### 9a. Make Models Searchable

```php
use Laravel\Scout\Searchable;

class Post extends Model
{
    use Searchable;

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
        ];
    }
}
```

### 9b. Index Existing Data

```bash
./vendor/bin/sail artisan scout:import "App\Models\Post"
```

---

## Step 10: Directory Structure

Organize your project like this:

```
app/
├── Actions/              # Single-purpose action classes
├── DTOs/                 # Data transfer objects
├── Enums/                # PHP enums (status types, roles, etc.)
├── Events/               # Broadcast events
├── Http/
│   ├── Controllers/
│   │   ├── Api/V1/       # REST API controllers
│   │   ├── Web/          # Inertia page controllers
│   │   └── Admin/        # Admin panel controllers
│   ├── Middleware/        # Custom middleware
│   ├── Requests/         # Form request validation
│   └── Resources/        # API resource transformers
├── Jobs/                 # Queued jobs
├── Models/               # Eloquent models
├── Observers/            # Model event observers
├── Policies/             # Authorization policies
├── Services/             # Business logic (service layer)
└── Providers/            # Service providers

resources/js/
├── app.js                # SPA entry point
├── ssr.js                # SSR entry point
├── bootstrap.js          # Echo/Pusher setup
├── Layouts/              # Svelte layout components
├── Pages/                # Svelte page components (Inertia routes)
│   ├── Auth/
│   ├── Admin/
│   └── MainSite/
└── Components/           # Reusable Svelte components
```

---

## Step 11: Development Workflow

### Running the Dev Environment

```bash
# Start Docker containers
./vendor/bin/sail up -d

# Run Vite dev server (HMR)
./vendor/bin/sail npm run dev

# Or run everything concurrently (add to package.json scripts):
# "dev": "concurrently \"sail up\" \"sail npm run dev\""
```

### Useful `package.json` Scripts

```json
{
    "scripts": {
        "dev": "vite",
        "build": "vite build"
    }
}
```

### Useful `composer.json` Scripts

```json
{
    "scripts": {
        "setup": [
            "@php artisan key:generate",
            "@php artisan migrate --seed",
            "npm install",
            "npm run build"
        ],
        "dev": "concurrently \"php artisan serve\" \"php artisan queue:listen\" \"php artisan pail\" \"npm run dev\""
    }
}
```

### Common Sail Commands

```bash
# Database
./vendor/bin/sail artisan migrate              # Run migrations
./vendor/bin/sail artisan migrate:fresh --seed  # Reset DB with seeds
./vendor/bin/sail artisan make:model Post -mfsc # Model + migration + factory + seeder + controller

# Testing
./vendor/bin/sail artisan test                 # Run all tests
./vendor/bin/sail artisan test --filter=PostTest

# Code style
./vendor/bin/sail composer exec pint           # Auto-fix PSR-12 style

# Queue & WebSocket
./vendor/bin/sail artisan queue:listen         # Process queued jobs
./vendor/bin/sail artisan reverb:start         # Start WebSocket server

# Search
./vendor/bin/sail artisan scout:import "App\Models\Post"

# Shell access
./vendor/bin/sail shell       # SSH into container
./vendor/bin/sail tinker      # Laravel REPL
./vendor/bin/sail psql        # PostgreSQL CLI
./vendor/bin/sail redis       # Redis CLI
```

---

## Step 12: Testing Setup

### PHPUnit Configuration (`phpunit.xml`)

Key test environment overrides:

```xml
<env name="APP_ENV" value="testing"/>
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
<env name="CACHE_STORE" value="array"/>
<env name="QUEUE_CONNECTION" value="sync"/>
<env name="SESSION_DRIVER" value="array"/>
<env name="SCOUT_DRIVER" value="collection"/>
<env name="MAIL_MAILER" value="array"/>
```

This uses **in-memory SQLite** for fast test execution, regardless of your dev database.

### Test Structure

```
tests/
├── Feature/          # Integration tests (HTTP, database)
│   ├── Auth/
│   ├── Post/
│   └── ...
├── Unit/             # Isolated unit tests
│   ├── Models/
│   └── Services/
└── Traits/           # Shared test helpers
```

---

## Step 13: Production Deployment (Dokploy / Docker)

### Production Dockerfile (Multi-stage)

```dockerfile
# Stage 1: Build frontend assets
FROM node:22-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# Stage 2: PHP production image
FROM php:8.4-fpm-alpine
RUN apk add --no-cache nginx supervisor postgresql-dev redis \
    && docker-php-ext-install pdo_pgsql opcache

WORKDIR /var/www/html
COPY . .
COPY --from=frontend /app/public/build public/build
RUN composer install --no-dev --optimize-autoloader

COPY deploy/nginx.conf /etc/nginx/http.d/default.conf
COPY deploy/supervisord.conf /etc/supervisord.conf

EXPOSE 80
CMD ["supervisord", "-c", "/etc/supervisord.conf"]
```

### Supervisor Config (`supervisord.conf`)

Manages multiple processes in a single container:

```ini
[supervisord]
nodaemon=true

[program:php-fpm]
command=php-fpm

[program:nginx]
command=nginx -g 'daemon off;'

[program:queue-worker]
command=php artisan queue:work redis --sleep=3 --tries=3

[program:reverb]
command=php artisan reverb:start --host=0.0.0.0 --port=9080
```

### Production `docker-compose.yaml`

```yaml
services:
    app:
        build: .
        ports:
            - "80:80"
        depends_on:
            - pgsql
            - redis
            - meilisearch
    pgsql:
        image: postgres:18-alpine
        volumes:
            - pg-data:/var/lib/postgresql/data
    redis:
        image: redis:7-alpine
    meilisearch:
        image: getmeili/meilisearch:latest

volumes:
    pg-data:
```

---

## Quick Start Checklist

- [ ] Install Docker Desktop
- [ ] `composer create-project laravel/laravel my-project`
- [ ] `php artisan sail:install --with=pgsql,redis,meilisearch,mailpit`
- [ ] `./vendor/bin/sail up -d`
- [ ] Configure `.env` (PostgreSQL, Redis, MeiliSearch, Reverb)
- [ ] Install Sanctum, Reverb, Scout, MeiliSearch packages
- [ ] Install Svelte 5, Inertia.js, Vite plugin, Echo, Pusher
- [ ] Configure `vite.config.js` and `svelte.config.js`
- [ ] Set up `app.blade.php` with Inertia + UI library loading
- [ ] Create `app.js` and `ssr.js` entry points
- [ ] Set up Inertia middleware
- [ ] Add Reverb service to Docker Compose
- [ ] Self-host Web Awesome Pro and Font Awesome Pro to `public/vendor/`
- [ ] Create first Svelte page and verify HMR works
- [ ] Run `./vendor/bin/sail artisan migrate`
- [ ] Run `./vendor/bin/sail npm run dev`
- [ ] Visit `http://localhost` and confirm everything works

---

## Service URLs (Development)

| URL | Service |
|-----|---------|
| http://localhost | Laravel App |
| http://localhost:5173 | Vite Dev Server (HMR) |
| http://localhost:8025 | Mailpit (mail testing) |
| http://localhost:7700 | MeiliSearch Dashboard |
| http://localhost:5050 | pgAdmin (database GUI) |
| ws://localhost:9080 | Reverb WebSocket |
