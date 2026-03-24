<script>
    import { page, inertia } from '@inertiajs/svelte';
    import { router } from '@inertiajs/svelte';

    let { posts } = $props();
</script>

<section class="posts-page">
    <div class="container">
        <div class="posts-header">
            <h1>Posts</h1>
            {#if $page.props.auth.user}
                <wa-button variant="brand" onclick={() => router.visit('/posts/create')} size="small">
                    <i class="fa-solid fa-plus" slot="prefix"></i>
                    New Post
                </wa-button>
            {/if}
        </div>

        {#if posts.data.length === 0}
            <wa-card class="empty-state">
                <div class="empty-body">
                    <i class="fa-light fa-file-pen empty-icon"></i>
                    <p class="empty-title">No posts yet</p>
                    <p class="empty-hint">Be the first to create a post.</p>
                </div>
            </wa-card>
        {:else}
            <div class="posts-list">
                {#each posts.data as post (post.id)}
                    <a href="/posts/{post.id}" use:inertia class="post-card-link">
                        <wa-card class="post-card">
                            <div class="post-card-body">
                                <h2 class="post-title">{post.title}</h2>
                                <p class="post-excerpt">{post.body.substring(0, 150)}{post.body.length > 150 ? '...' : ''}</p>
                                <div class="post-meta">
                                    <span class="post-author">
                                        <i class="fa-solid fa-user fa-sm"></i>
                                        {post.user.name}
                                    </span>
                                    <span class="post-date">
                                        <i class="fa-solid fa-clock fa-sm"></i>
                                        {new Date(post.created_at).toLocaleDateString()}
                                    </span>
                                </div>
                            </div>
                        </wa-card>
                    </a>
                {/each}
            </div>

            <!-- Pagination -->
            {#if posts.last_page > 1}
                <div class="pagination">
                    {#each posts.links as link}
                        {#if link.url}
                            <wa-button
                                size="small"
                                variant={link.active ? 'brand' : 'neutral'}
                                appearance={link.active ? 'filled' : 'outlined'}
                                onclick={() => router.visit(link.url)}
                            >
                                {@html link.label}
                            </wa-button>
                        {:else}
                            <wa-button size="small" variant="neutral" appearance="text" disabled>
                                {@html link.label}
                            </wa-button>
                        {/if}
                    {/each}
                </div>
            {/if}
        {/if}
    </div>
</section>

<style>
    .posts-page {
        padding: 2rem 0;
    }

    .posts-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--color-text);
    }

    .posts-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .post-card-link {
        text-decoration: none;
        color: inherit;
    }

    .post-card {
        width: 100%;
        transition: box-shadow 0.2s;
    }

    .post-card:hover {
        box-shadow: var(--shadow-md);
    }

    .post-card-body {
        padding: .1rem;
    }

    .post-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--color-text);
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .post-excerpt {
        color: var(--color-text-muted);
        font-size: 0.875rem;
        line-height: 1.5;
        margin-bottom: 0.75rem;
    }

    .post-meta {
        font-size: 0.8125rem;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.25rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

    @media (min-width: 640px) {
        h1 {
            font-size: 1.75rem;
        }
    }
</style>
