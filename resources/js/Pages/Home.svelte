<script>
    import { page } from '@inertiajs/svelte';
    import { router } from '@inertiajs/svelte';

    let { greeting } = $props();

    function logout() {
        router.post('/logout');
    }
</script>

<main>
    <h1>{greeting}</h1>
    <p>Laravel + Svelte + Inertia is working!</p>

    <nav>
        {#if $page.props.auth.user}
            <p>Welcome, {$page.props.auth.user.name}!</p>
            <button onclick={logout}>Logout</button>
        {:else}
            <a href="/login">Login</a>
            <a href="/register">Register</a>
        {/if}
    </nav>
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