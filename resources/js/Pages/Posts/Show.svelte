<script>
    import { inertia } from '@inertiajs/svelte';
    import { router } from '@inertiajs/svelte';

    let { post, canEdit } = $props();
    let showDeleteDialog = $state(false);

    function deletePost() {
        router.delete(`/posts/${post.id}`);
    }
</script>

<section class="post-show-page">
    <div class="container post-container">
        <a href="/posts" use:inertia class="back-link">
            <i class="fa-solid fa-arrow-left"></i>
            Back to posts
        </a>

        <article class="post-article">
            <header class="post-header">
                <h1>{post.title}</h1>
                <div class="post-meta">
                    <span class="post-author">
                        <i class="fa-solid fa-user fa-sm"></i>
                        {post.user.name}
                    </span>
                    <span class="post-date">
                        <i class="fa-solid fa-clock fa-sm"></i>
                        {new Date(post.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}
                    </span>
                </div>
            </header>

            <div class="post-body">
                {#each post.body.split('\n') as paragraph}
                    {#if paragraph.trim()}
                        <p>{paragraph}</p>
                    {/if}
                {/each}
            </div>

            {#if canEdit}
                <footer class="post-actions">
                    <wa-button variant="neutral" size="small" onclick={() => router.visit(`/posts/${post.id}/edit`)}>
                        <i class="fa-solid fa-pen" slot="prefix"></i>
                        Edit
                    </wa-button>
                    <wa-button variant="danger" size="small" appearance="outlined" onclick={() => showDeleteDialog = true}>
                        <i class="fa-solid fa-trash" slot="prefix"></i>
                        Delete
                    </wa-button>
                </footer>
            {/if}
        </article>
    </div>
</section>

<!-- Delete confirmation dialog -->
{#if canEdit}
    <wa-dialog label="Delete Post" open={showDeleteDialog || null} onwa-after-hide={() => showDeleteDialog = false}>
        <p>Are you sure you want to delete "<strong>{post.title}</strong>"? This cannot be undone.</p>
        <div slot="footer" class="dialog-footer">
            <wa-button variant="neutral" size="small" onclick={() => showDeleteDialog = false}>Cancel</wa-button>
            <wa-button variant="danger" size="small" appearance="filled" onclick={deletePost}>
                <i class="fa-solid fa-trash" slot="prefix"></i>
                Delete
            </wa-button>
        </div>
    </wa-dialog>
{/if}

<style>
    .post-show-page {
        padding: 2rem 0;
    }

    .post-container {
        max-width: 48rem;
    }

    .back-link {
        margin-bottom: 1.5rem;
    }

    .post-header {
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--color-border);
    }

    h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--color-text);
        line-height: 1.3;
        margin-bottom: 0.75rem;
    }

    .post-meta {
        font-size: 0.875rem;
    }

    .post-body {
        line-height: 1.75;
        color: var(--color-text);
    }

    .post-body p {
        margin-bottom: 1rem;
    }

    .post-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--color-border);
    }

    @media (min-width: 640px) {
        h1 {
            font-size: 2rem;
        }
    }
</style>
