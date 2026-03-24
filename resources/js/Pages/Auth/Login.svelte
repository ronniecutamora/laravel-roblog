<script>
    import { useForm, inertia } from '@inertiajs/svelte';

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

<section class="auth-page">
    <div class="auth-container">
        <wa-card class="auth-card">
            <div class="auth-header">
                <wa-icon name="right-to-bracket" library="fa" class="auth-icon"></wa-icon>
                <h1>Welcome Back</h1>
                <p class="auth-subtitle">Sign in to your account</p>
            </div>

            {#if errors.email}
                <wa-callout variant="danger" open>
                    <wa-icon name="circle-exclamation" library="fa" slot="icon"></wa-icon>
                    {errors.email}
                </wa-callout>
            {/if}

            <form onsubmit={submit} class="auth-form">
                <wa-input
                    label="Email"
                    type="email"
                    value={$form.email}
                    oninput={(e) => $form.email = e.target.value}
                    required
                >
                    <wa-icon name="envelope" library="fa" slot="prefix"></wa-icon>
                </wa-input>

                <wa-input
                    label="Password"
                    type="password"
                    password-toggle
                    value={$form.password}
                    oninput={(e) => $form.password = e.target.value}
                    required
                >
                    <wa-icon name="lock" library="fa" slot="prefix"></wa-icon>
                </wa-input>

                <wa-checkbox
                    checked={$form.remember}
                    onchange={(e) => $form.remember = e.target.checked}
                >
                    Remember me
                </wa-checkbox>

                <wa-button
                    variant="brand"
                    type="submit"
                    loading={$form.processing || null}
                    style="width: 100%;"
                >
                    <wa-icon name="right-to-bracket" library="fa" slot="prefix"></wa-icon>
                    Login
                </wa-button>
            </form>

            <p class="auth-footer">
                Don't have an account?
                <a href="/register" use:inertia>Register</a>
            </p>
        </wa-card>
    </div>
</section>

<style>
    h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--color-text);
        margin-bottom: 0.25rem;
    }

    wa-callout {
        margin: 1rem 1.5rem 0;
    }

    @media (min-width: 640px) {
        h1 {
            font-size: 1.75rem;
        }
    }
</style>
