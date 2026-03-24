# Post Feature Implementation Plan

Users can create, read, update, and delete posts (CRUD). Posts belong to authenticated users.

---

## Step 1: Migration — Define the `posts` table schema

**File:** `database/migrations/2026_03_24_061836_create_posts_table.php`

Add columns:

| Column | Type | Notes |
|--------|------|-------|
| `id` | bigIncrements | Primary key (already exists) |
| `user_id` | foreignId | References `users.id`, cascades on delete |
| `title` | string(255) | Required |
| `body` | text | Required, post content |
| `published_at` | timestamp | Nullable, null = draft |
| `timestamps` | timestamps | created_at, updated_at (already exists) |

Run: `sail artisan migrate`

---

## Step 2: Model — Set up Post model with relationships and fillable

**File:** `app/Models/Post.php`

- Add `$fillable`: `['title', 'body', 'published_at']`
- Add `belongsTo` relationship to `User`
- Cast `published_at` as datetime

**File:** `app/Models/User.php`

- Add `hasMany` relationship to `Post`

---

## Step 3: Policy — Authorization rules

**File:** `app/Policies/PostPolicy.php`

| Method | Rule |
|--------|------|
| `viewAny` | Allow all (return `true`) |
| `view` | Allow all (return `true`) |
| `create` | Authenticated users only (return `true` — policy auto-checks auth) |
| `update` | Only post owner (`$user->id === $post->user_id`) |
| `delete` | Only post owner (`$user->id === $post->user_id`) |

---

## Step 4: Form Requests — Validation

**File:** `app/Http/Requests/StorePostRequest.php`

- `authorize()`: return `true` (auth is handled by middleware)
- Rules: `title` required, max:255; `body` required

**File:** `app/Http/Requests/UpdatePostRequest.php`

- `authorize()`: return `true`
- Rules: same as StorePostRequest

---

## Step 5: Controller — Implement CRUD actions

**File:** `app/Http/Controllers/PostController.php`

| Method | Route | Action |
|--------|-------|--------|
| `index` | GET `/posts` | List all posts (paginated), render `Posts/Index` |
| `create` | GET `/posts/create` | Render `Posts/Create` form |
| `store` | POST `/posts` | Validate, create post for `auth()->user()`, redirect to show |
| `show` | GET `/posts/{post}` | Render `Posts/Show` with post + author |
| `edit` | GET `/posts/{post}/edit` | Authorize owner, render `Posts/Edit` form |
| `update` | PUT `/posts/{post}` | Authorize owner, validate, update, redirect to show |
| `destroy` | DELETE `/posts/{post}` | Authorize owner, delete, redirect to index |

Key details:
- `index`: Query `Post::with('user')->latest()->paginate(10)`, pass as Inertia prop
- `store`: `auth()->user()->posts()->create($validated)`
- `edit`/`update`/`destroy`: Use `$this->authorize('update', $post)` or `$this->authorize('delete', $post)`

---

## Step 6: Routes — Register resource routes

**File:** `routes/web.php`

```php
use App\Http\Controllers\PostController;

// Public routes
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// Auth-only routes
Route::middleware('auth')->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});
```

---

## Step 7: Svelte Pages — Create frontend views

All pages go in `resources/js/Pages/Posts/`.

### 7a. `Posts/Index.svelte` — Post listing

- Receive `posts` prop (paginated)
- Show each post as a `wa-card` with title, author, date, excerpt
- "New Post" button (visible if authenticated) links to `/posts/create`
- Pagination links at bottom
- Each card links to `/posts/{id}`

### 7b. `Posts/Create.svelte` — New post form

- Use `useForm` with `title` and `body` fields
- `wa-input` for title, `wa-textarea` for body
- Submit button with loading state
- POST to `/posts`
- Display validation errors using project's `field-error` pattern

### 7c. `Posts/Show.svelte` — Single post view

- Receive `post` prop (with `user` relation)
- Display title, author name, date (`wa-format-date`), and body
- Edit/Delete buttons visible only if current user is the author
- Delete uses `router.delete()` with confirmation dialog (`wa-dialog`)

### 7d. `Posts/Edit.svelte` — Edit post form

- Receive `post` prop
- Use `useForm` pre-filled with post data
- Same form layout as Create
- PUT to `/posts/{id}`

---

## Step 8: Navigation — Add Posts link to layout

**File:** `resources/js/Layouts/AppLayout.svelte`

- Add "Posts" link in the nav pointing to `/posts`
- Visible to all users (both guest and authenticated)

---

## Step 9: Factory & Seeder (optional, for testing)

**File:** `database/factories/PostFactory.php`

- Generate fake `title` (sentence), `body` (paragraphs), `user_id` (random user)

**File:** `database/seeders/PostSeeder.php`

- Create 20 posts with the factory
- Call from `DatabaseSeeder`

Run: `sail artisan db:seed --class=PostSeeder`

---

## Implementation Order

1. Migration (Step 1) — define schema, run migrate
2. Model + relationships (Step 2)
3. Policy (Step 3)
4. Form Requests (Step 4)
5. Routes (Step 6) — register before controller so routes are available
6. Controller (Step 5)
7. Svelte pages (Step 7) — Index → Create → Show → Edit
8. Navigation update (Step 8)
9. Factory & Seeder (Step 9) — seed test data
