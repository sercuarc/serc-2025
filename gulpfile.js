const { src, dest, parallel, series } = require("gulp");
const postcss = require("gulp-postcss");
const autoprefixer = require("autoprefixer");
const cssnano = require("cssnano");
const tailwindcss = require("@tailwindcss/postcss");
const esbuild = require("gulp-esbuild");
const del = require("del");

const themePath = "wp-content/themes/serc-2025";

const paths = {
  srcJs: `${themePath}/assets/src/js`,
  srcCss: `${themePath}/assets/src/css`,
  dist: `${themePath}/assets/dist`,
};

const jsEntryPoints = ["main.js", "app.search.js"].map(
  (file) => `${paths.srcJs}/${file}`
);

function clean() {
  return del([`${paths.dist}/*`]);
}

function css() {
  return src(`${paths.srcCss}/main.css`) // Adjust your source path
    .pipe(postcss([tailwindcss(), autoprefixer(), cssnano()]))
    .pipe(dest(`${paths.dist}/css`));
}

function js() {
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

exports.default = series(clean, parallel(css, js));
