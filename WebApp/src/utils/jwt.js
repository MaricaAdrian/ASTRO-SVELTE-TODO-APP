/**
 *
 * @param {String} token
 * @returns parsed JSON or null
 */
export function parseJwt(token) {
    try {
        const base64Url = token.split('.')[1];
        const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
        const jsonPayload = decodeURIComponent(
            atob(base64)
                .split('')
                .map(function (c) {
                    return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
                })
                .join('')
        );

        return JSON.parse(jsonPayload);
    } catch (e) {
        return null;
    }
}

/**
 *
 * @param {Number} exp
 * @returns true if token expired, false otherwise
 */
export function isTokenExpired(exp) {
    try {
        return Date.now() >= exp * 1000;
    } catch (e) {
        return true; // If any error, consider the token expired
    }
}