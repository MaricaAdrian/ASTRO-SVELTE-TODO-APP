import { defineConfig } from 'astro/config';
import svelte from '@astrojs/svelte';
import tailwind from '@astrojs/tailwind';
import proxyMiddleware from './src/utils/proxy.js';

// https://astro.build/config
export default defineConfig({
  integrations: [
    svelte(),
    tailwind({}),
    proxyMiddleware("/api", {
      target: "http://todoapp.local/api",
      changeOrigin: true,
      secure: false,
      cookieDomainRewrite: "localhost",
      pathRewrite: {
        '^/api': '/api',
      },
    }),
  ]
});