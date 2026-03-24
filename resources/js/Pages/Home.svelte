<script>
    import { page, inertia, router } from '@inertiajs/svelte';

    let { greeting } = $props();
</script>

<section class="hero">
    <div class="hero-content container">
        <wa-icon name="blog" library="fa" class="hero-icon"></wa-icon>
        <h1>{greeting}</h1>
        <p class="subtitle">Laravel + Svelte + Inertia is working!</p>

        {#if $page.props.auth.user}
            <wa-card class="welcome-card">
                <div class="welcome-body">
                    <wa-icon name="hand-wave" library="fa" style="font-size: 1.5rem; color: var(--color-primary);"></wa-icon>
                    <div>
                        <p class="welcome-name">Welcome back, {$page.props.auth.user.name}!</p>
                        <p class="welcome-hint">You're logged in and ready to go.</p>
                    </div>
                </div>
            </wa-card>
        {:else}
            <div class="cta-buttons">
                <wa-button variant="brand" size="large" onclick={() => router.visit('/login')}>
                    <wa-icon name="right-to-bracket" library="fa" slot="prefix"></wa-icon>
                    Login
                </wa-button>
                <wa-button variant="neutral" size="large" onclick={() => router.visit('/register')} outline>
                    <wa-icon name="user-plus" library="fa" slot="prefix"></wa-icon>
                    Register
                </wa-button>
            </div>
        {/if}
    </div>
</section>

<style>
    .hero {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: calc(100vh - 3.5rem);
        text-align: center;
        padding: 2rem 0;
    }

    .hero-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .hero-icon {
        font-size: 3rem;
        color: var(--color-primary);
    }

    h1 {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--color-text);
        line-height: 1.2;
    }

    .subtitle {
        color: var(--color-text-muted);
        font-size: 1rem;
    }

    .welcome-card {
        margin-top: 1rem;
        width: 100%;
        max-width: 24rem;
    }

    .welcome-body {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        text-align: left;
    }

    .welcome-name {
        font-weight: 600;
        color: var(--color-text);
    }

    .welcome-hint {
        font-size: 0.875rem;
        color: var(--color-text-muted);
    }

    .cta-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-top: 1rem;
        width: 100%;
        max-width: 16rem;
    }

    /* Tablet+ */
    @media (min-width: 640px) {
        h1 {
            font-size: 2.5rem;
        }

        .subtitle {
            font-size: 1.125rem;
        }

        .hero-icon {
            font-size: 4rem;
        }

        .cta-buttons {
            flex-direction: row;
            max-width: none;
            width: auto;
        }
    }
</style>
