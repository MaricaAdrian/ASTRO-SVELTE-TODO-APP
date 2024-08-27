<script>
    import { userStore } from '../stores/userStore';

    let email = '';
    let password = '';
    let error = '';

    const login = async () => {
        const res = await fetch(`/api/login_check`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ email, password }),
            credentials: 'include',
        });

        if (res.ok) {
            userStore.set({ username: email, isLoggedIn: true });

            window.location.href='/mylists';
        } else {
            error = 'Login failed, please try again.';
        }
    };
</script>

<div class="max-w-md mx-auto p-4">
    <h3 class="text-2xl font-bold mb-4 text-white">Login</h3>
    {#if error}
        <p class="text-red-500 mb-4 animate-fade">{error}</p>
    {/if}
    <div class="mb-4">
        <input type="email" placeholder="Email" bind:value={email} class="w-full p-2 border rounded" />
    </div>
    <div class="mb-4">
        <input type="password" placeholder="Password" bind:value={password} class="w-full p-2 border rounded" />
    </div>
    <button on:click={login} class="w-full p-2 bg-blue-500 text-white rounded">Login</button>
</div>