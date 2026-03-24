<script>
    import { useForm, inertia } from '@inertiajs/svelte';

    const form = useForm({
        title: '',
        body: '',
    });

    function submit(e) {
        e.preventDefault();
        $form.post('/posts');
    }
</script>

<section class="post-form-page">
    <div class="container form-container">
        <div class="form-header">
            <a href="/posts" use:inertia class="back-link">
                <i class="fa-solid fa-arrow-left"></i>
                Back to posts
            </a>
            <h1>Create Post</h1>
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
                    <wa-button variant="brand" type="submit" loading={$form.processing || null}>
                        <i class="fa-solid fa-paper-plane" slot="prefix"></i>
                        Publish Post
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
