<script>
    import { useForm } from '@inertiajs/svelte';

    let { errors = {} } = $props();

    const form = useForm({
        email: '',
        password: '',
        remember: false,
    });

    function submit(e) {
        e.preventDefault();
        $form.post('/login');
    }
</script>

<main>
    <div class="auth-card">
        <h1>Login</h1>

        {#if errors.email}
            <p class="error">{errors.email}</p>
        {/if}

        <form onsubmit={submit}>
            <label>
                Email
                <input type="email" bind:value={$form.email} required />
            </label>

            <label>
                Password
                <input type="password" bind:value={$form.password} required />
            </label>

            <label class="checkbox">
                <input type="checkbox" bind:checked={$form.remember} />
                Remember me
            </label>

            <button type="submit" disabled={$form.processing}>
                {$form.processing ? 'Logging in...' : 'Login'}
            </button>
        </form>

        <p class="link">Don't have an account? <a href="/register">Register</a></p>
    </div>
</main>

<style>
    main {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        font-family: system-ui, sans-serif;
        background: #f5f5f5;
    }
    .auth-card {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 400px;
    }
    h1 { text-align: center; margin-bottom: 1.5rem; color: #333; }
    label { display: block; margin-bottom: 1rem; color: #555; }
    input[type="email"],
    input[type="password"] {
        display: block;
        width: 100%;
        padding: 0.5rem;
        margin-top: 0.25rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }
    .checkbox { display: flex; align-items: center; gap: 0.5rem; }
    .checkbox input { width: auto; }
    button {
        width: 100%;
        padding: 0.75rem;
        background: #333;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1rem;
    }
    button:disabled { opacity: 0.6; cursor: not-allowed; }
    .error { color: #e53e3e; text-align: center; }
    .link { text-align: center; margin-top: 1rem; }
    .link a { color: #333; }
</style>
