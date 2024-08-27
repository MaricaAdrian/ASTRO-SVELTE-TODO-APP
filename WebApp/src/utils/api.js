export async function apiFetch(url, options = {}) {
    options.credentials = 'include';  // Always include credentials for requests

    const response = await fetch(url, options);

    console.log(response);

    if (response.status === 401) {
        // Token is invalid or expired
        // Redirect to login page
        window.location.href = '/login';
    }

    return response.json();
}