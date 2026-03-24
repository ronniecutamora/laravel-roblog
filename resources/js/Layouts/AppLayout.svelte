<script>
    import { page, inertia } from '@inertiajs/svelte';
    import { router } from '@inertiajs/svelte';

    let { children } = $props();
    let menuOpen = $state(false);

    function logout() {
        router.post('/logout');
    }

    function toggleMenu() {
        menuOpen = !menuOpen;
    }

    function closeMenu() {
        menuOpen = false;
    }
</script>

<div class="app-layout">
    <header class="app-header">
        <div class="header-inner">
            <a href="/" use:inertia class="logo">
                <wa-icon name="pen-nib" library="fa" style="font-size: 1.25rem;"></wa-icon>
                <span>Roblog</span>
            </a>

            <!-- svelte-ignore a11y_click_events_have_key_events, a11y_no_static_element_interactions -->
            <button class="menu-toggle" onclick={toggleMenu} aria-label="Toggle menu">
                <i class="fa-solid {menuOpen ? 'fa-xmark' : 'fa-bars'}"></i>
            </button>

            <!-- Nav links -->
            <nav class="nav-links" class:open={menuOpen}>
                <!-- <a href="/posts" use:inertia class="nav-link" onclick={closeMenu}>
                    <i class="fa-solid fa-file-pen fa-fw"></i>
                    Posts
                </a> -->
                {#if $page.props.auth.user}
                    <span class="nav-user">
                        <wa-icon name="circle-user" library="fa"></wa-icon>
                        {$page.props.auth.user.name}
                    </span>
                    <!-- svelte-ignore a11y_click_events_have_key_events, a11y_no_static_element_interactions -->
                    <wa-button variant="text" size="small" onclick={() => { closeMenu(); logout(); }}>
                        <wa-icon name="right-from-bracket" library="fa" slot="prefix"></wa-icon>
                        Logout
                    </wa-button>
                {:else}
                    <a href="/login" use:inertia class="nav-link" onclick={closeMenu}>
                        <wa-icon name="right-to-bracket" library="fa"></wa-icon>
                        Login
                    </a>
                    <a href="/register" use:inertia class="nav-link" onclick={closeMenu}>
                        <wa-icon name="user-plus" library="fa"></wa-icon>
                        Register
                    </a>
                {/if}
            </nav>
        </div>
    </header>

    <main class="app-main">
        {@render children()}
    </main>
</div>

<style>
    .app-layout {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .app-header {
        background: var(--color-surface);
        border-bottom: 1px solid var(--color-border);
        box-shadow: var(--shadow-sm);
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .header-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        padding-block: 0.75rem;
        gap: 0.5rem;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 700;
        font-size: 1.25rem;
        color: var(--color-text);
        text-decoration: none;
    }

    .menu-toggle {
        display: block;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1.25rem;
        color: var(--color-text);
        padding: 0.375rem 0.5rem;
        border-radius: var(--radius);
    }

    .menu-toggle:hover {
        color: var(--color-primary);
    }

    .nav-links {
        display: none;
        width: 100%;
        flex-direction: column;
        gap: 0.5rem;
        padding-top: 0.75rem;
        border-top: 1px solid var(--color-border);
    }

    .nav-links.open {
        display: flex;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 0;
        color: var(--color-text-muted);
        text-decoration: none;
        font-size: 0.9375rem;
    }

    .nav-link:hover {
        color: var(--color-primary);
        text-decoration: none;
    }

    .nav-user {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--color-text);
        font-weight: 500;
        font-size: 0.9375rem;
        padding: 0.5rem 0;
    }

    .app-main {
        flex: 1;
    }

    /* Tablet+ */
    @media (min-width: 640px) {
        .menu-toggle {
            display: none;
        }

        .nav-links {
            display: flex;
            width: auto;
            flex-direction: row;
            align-items: center;
            padding-top: 0;
            border-top: none;
            gap: 1rem;
        }
    }
</style>
