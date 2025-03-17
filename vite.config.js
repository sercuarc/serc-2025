import { defineConfig } from "vite";
import tailwindcss from "@tailwindcss/vite";

const root = "wp-content/themes/serc-2025/vite";

export default defineConfig({
  root,
  server: {
    host: true,
    origin: "http://localhost:5173",
    cors: true,
  },
  plugins: [tailwindcss()],
  build: {
    outDir: `../dist`,
    emptyOutDir: true,
    manifest: "manifest.json",
    rollupOptions: {
      input: {
        main: `/js/main.js`,
        search: `/js/search.js`,
      },
    },
  },
  resolve: {
    alias: {
      "@": root,
    },
  },
});
