import { defineConfig } from "vite";
import tailwindcss from "@tailwindcss/vite";
import path from "path";

const themeDir = path.resolve(__dirname, "wp-content/themes/serc-2025");

export default defineConfig({
  plugins: [tailwindcss()],
  build: {
    outDir: `${themeDir}/dist/`,
    emptyOutDir: true,
    manifest: "manifest.json",
    rollupOptions: {
      input: {
        main: `${themeDir}/src/js/main.js`,
      },
    },
  },
  resolve: {
    alias: {
      "@": `${themeDir}/src`,
    },
  },
});
