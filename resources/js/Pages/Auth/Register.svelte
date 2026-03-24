<script>
    import { useForm, inertia } from '@inertiajs/svelte';

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

<section class="auth-page">
    <div class="auth-container">
        <wa-card class="auth-card">
            <div class="auth-header">
                <wa-icon name="user-plus" library="fa" class="auth-icon"></wa-icon>
                <h1>Create Account</h1>
                <p class="auth-subtitle">Sign up to get started</p>
            </div>

            <form onsubmit={submit} class="auth-form">
                <div class="field">
                    <wa-input
                        label="Name"
                        type="text"
                        value={$form.name}
                        oninput={(e) => $form.name = e.target.value}
                        required
                    >
                        <wa-icon name="user" library="fa" slot="prefix"></wa-icon>
                    </wa-input>
                    {#if $form.errors.name}
                        <p class="field-error">
                            <wa-icon name="circle-exclamation" library="fa"></wa-icon>
                            {$form.errors.name}
                        </p>
                    {/if}
                </div>

                <div class="field">
                    <wa-input
                        label="Email"
                        type="email"
                        value={$form.email}
                        oninput={(e) => $form.email = e.target.value}
                        required
                    >
                        <wa-icon name="envelope" library="fa" slot="prefix"></wa-icon>
                    </wa-input>
                    {#if $form.errors.email}
                        <p class="field-error">
                            <wa-icon name="circle-exclamation" library="fa"></wa-icon>
                            {$form.errors.email}
                        </p>
                    {/if}
                </div>

                <div class="field">
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
                    {#if $form.errors.password}
                        <p class="field-error">
                            <wa-icon name="circle-exclamation" library="fa"></wa-icon>
                            {$form.errors.password}
                        </p>
                    {/if}
                </div>

                <div class="field">
                    <wa-input
                        label="Confirm Password"
                        type="password"
                        password-toggle
                        value={$form.password_confirmation}
                        oninput={(e) => $form.password_confirmation = e.target.value}
                        required
                    >
                        <wa-icon name="lock" library="fa" slot="prefix"></wa-icon>
                    </wa-input>
                </div>

                <wa-button
                    variant="brand"
                    type="submit"
                    loading={$form.processing || null}
                    style="width: 100%;"
                >
                    <wa-icon name="user-plus" library="fa" slot="prefix"></wa-icon>
                    Create Account
                </wa-button>
            </form>

            <p class="auth-footer">
                Already have an account?
                <a href="/login" use:inertia>Login</a>
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

    @media (min-width: 640px) {
        h1 {
            font-size: 1.75rem;
        }
    }
</style>
