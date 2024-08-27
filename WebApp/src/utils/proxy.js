import { createProxyMiddleware } from "http-proxy-middleware";

export default function proxyMiddleware(context, options) {
  return {
    name: 'proxy',
    hooks: {
      'astro:server:setup': ({ server }) => {

        const apiProxy = createProxyMiddleware(options);
        server.middlewares.use(context, apiProxy);
      },
    },
  };
}