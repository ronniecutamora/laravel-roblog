<script>
    import { useForm } from '@inertiajs/svelte';

    let { errors = {} } = $props();

    const form = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    function submit(e) {
        e.preventDefault();
        $form.post('/register');
    }
</script>

<main>
    <div class="auth-card">
        <h1>Register</h1>

        <form onsubmit={submit}>
            <label>
                Name
                <input type="text" bind:value={$form.name} required />
                {#if $form.errors.name}<span class="error">{$form.errors.name}</span>{/if}
            </label>

            <label>
                Email
                <input type="email" bind:value={$form.email} required />
                {#if $form.errors.email}<span class="error">{$form.errors.email}</span>{/if}
            </label>

            <label>
                Password
                <input type="password" bind:value={$form.password} required />
                {#if $form.errors.password}<span class="error">{$form.errors.password}</span>{/if}
            </label>

            <label>
                Confirm Password
                <input type="password" bind:value={$form.password_confirmation} required />
            </label>

            <button type="submit" disabled={$form.processing}>
                {$form.processing ? 'Registering...' : 'Register'}
            </button>
        </form>

        <p class="link">Already have an account? <a href="/login">Login</a></p>
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
    input[type="text"],
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
    .error { color: #e53e3e; font-size: 0.85rem; }
    .link { text-align: center; margin-top: 1rem; }
    .link a { color: #333; }
</style>
