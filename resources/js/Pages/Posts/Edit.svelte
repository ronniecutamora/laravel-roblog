<script>
    import { useForm, inertia, router } from '@inertiajs/svelte';

    let { post } = $props();

    const form = useForm({
        title: post.title,
        body: post.body,
    });

    function submit(e) {
        e.preventDefault();
        $form.put(`/posts/${post.id}`);
    }
</script>

<section class="post-form-page">
    <div class="container form-container">
        <div class="form-header">
            <a href="/posts/{post.id}" use:inertia class="back-link">
                <i class="fa-solid fa-arrow-left"></i>
                Back to post
            </a>
            <h1>Edit Post</h1>
        </div>

        <wa-card>
            <form onsubmit={submit} class="post-form">
                <div class="field">
                    <wa-input
                        label="Title"
                        value={$form.title}
                        oninput={(e) => $form.title = e.target.value}
                        required
                    >
                        <i class="fa-solid fa-heading" slot="prefix"></i>
                    </wa-input>
                    {#if $form.errors.title}
                        <p class="field-error">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            {$form.errors.title}
                        </p>
                    {/if}
                </div>

                <div class="field">
                    <wa-textarea
                        label="Content"
                        value={$form.body}
                        oninput={(e) => $form.body = e.target.value}
                        rows="10"
                        required
                    ></wa-textarea>
                    {#if $form.errors.body}
                        <p class="field-error">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            {$form.errors.body}
                        </p>
                    {/if}
                </div>

                <div class="form-actions">
                    <wa-button variant="neutral" onclick={() => router.visit(`/posts/${post.id}`)} size="small">Cancel</wa-button>
                    <wa-button variant="brand" type="submit" loading={$form.processing || null}>
                        <i class="fa-solid fa-floppy-disk" slot="prefix"></i>
                        Update Post
                    </wa-button>
                </div>
            </form>
        </wa-card>
    </div>
</section>

<style>
    h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--color-text);
    }
</style>
