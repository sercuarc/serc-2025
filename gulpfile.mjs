import { src, dest, parallel, series } from "gulp";
import postcss from "gulp-postcss";
import autoprefixer from "autoprefixer";
import cssnano from "cssnano";
import tailwindcss from "@tailwindcss/postcss";
import esbuild from "gulp-esbuild";
import { deleteAsync } from "del";

const themePath = "wp-content/themes/serc-2025";

const paths = {
  srcJs: `${themePath}/assets/src/js`,
  srcCss: `${themePath}/assets/src/css`,
  dist: `${themePath}/assets/dist`,
};

const jsEntryPoints = ["main.js", "app.search.js"].map(
  (file) => `${paths.srcJs}/${file}`
);

export function clean() {
  return deleteAsync([`${paths.dist}/*`]);
}

export function css() {
  return src(`${paths.srcCss}/main.css`)
    .pipe(postcss([tailwindcss(), autoprefixer(), cssnano()]))
    .pipe(dest(`${paths.dist}/css`));
}

export function js() {
  return src(jsEntryPoints, { base: paths.srcJs })
    .pipe(
      esbuild({
        bundle: true,
        minify: true,
        sourcemap: true,
        target: "es2017",
        outdir: "js",
        entryNames: "[name]",
      })
    )
    .pipe(dest(paths.dist));
}

export default series(clean, parallel(css, js));
