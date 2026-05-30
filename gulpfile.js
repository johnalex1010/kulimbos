'use strict';

/**
 * gulpfile.js — Pipeline de build del tema Kulimbos.
 *
 * Salidas del build CSS:
 *   assets/css/main.css                   ← Expandido, legible (WP_DEBUG true)
 *   assets/production/mincss/main.min.css ← Minificado (WP_DEBUG false / producción)
 *
 * Salida del build JS:
 *   assets/production/minjs/main.min.js
 *
 * Tareas disponibles:
 *   npm run dev     → build completo + watch
 *   npm run build   → build completo sin watch
 *   npm run watch   → solo watch
 *   npm run css     → solo compilar SCSS (ambas salidas)
 *   npm run js      → solo compilar JS
 *
 * IMPORTANTE: No editar manualmente assets/css/ ni assets/production/.
 * Son artefactos generados. Los fuentes viven en assets/scss/ y assets/js/.
 */

const { src, dest, watch, series, parallel } = require( 'gulp' );
const sass         = require( 'gulp-sass' )( require( 'sass' ) );
const autoprefixer = require( 'gulp-autoprefixer' );
const cleanCSS     = require( 'gulp-clean-css' );
const terser       = require( 'gulp-terser' );
const concat       = require( 'gulp-concat' );
const rename       = require( 'gulp-rename' );
const { deleteAsync } = require( 'del' );

// ─── Rutas ────────────────────────────────────────────────────────────────────

const paths = {
  scss: {
    entry:    './assets/scss/main.scss',
    watch:    './assets/scss/**/*.scss',
    destDev:  './assets/css/',
    destProd: './assets/production/mincss/',
  },
  js: {
    src:    './assets/js/**/*.js',
    dest:   './assets/production/minjs/',
    output: 'main.min.js',
  },
};

// ─── Limpieza ─────────────────────────────────────────────────────────────────

async function cleanCSSDevDir()  { return deleteAsync( [ paths.scss.destDev ] ); }
async function cleanCSSProdDir() { return deleteAsync( [ paths.scss.destProd ] ); }
async function cleanJSDir()      { return deleteAsync( [ paths.js.dest ] ); }

// ─── CSS expandido → assets/css/main.css (desarrollo / inspección) ────────────

function compileSCSSdev() {
  return src( paths.scss.entry )
    .pipe( sass( {
      outputStyle: 'expanded',
      silenceDeprecations: [ 'legacy-js-api' ],
    } ).on( 'error', sass.logError ) )
    .pipe( autoprefixer() )
    .pipe( rename( 'main.css' ) )
    .pipe( dest( paths.scss.destDev ) );
}

// ─── CSS minificado → assets/production/mincss/main.min.css (producción) ──────

function compileSCSSmin() {
  return src( paths.scss.entry )
    .pipe( sass( {
      outputStyle: 'expanded',
      silenceDeprecations: [ 'legacy-js-api' ],
    } ).on( 'error', sass.logError ) )
    .pipe( autoprefixer() )
    .pipe( cleanCSS( { level: 2 } ) )
    .pipe( rename( 'main.min.css' ) )
    .pipe( dest( paths.scss.destProd ) );
}

// ─── JS: Concat → Minify ─────────────────────────────────────────────────────

function compileJS() {
  return src( paths.js.src )
    .pipe( concat( paths.js.output ) )
    .pipe(
      terser( {
        compress: { drop_console: true },
        format:   { comments: false },
      } )
    )
    .pipe( dest( paths.js.dest ) );
}

// ─── Watch ────────────────────────────────────────────────────────────────────

function watchFiles() {
  watch( paths.scss.watch, compileSCSS );
  watch( paths.js.src,     compileJS );
}

// ─── Tasks compuestos ─────────────────────────────────────────────────────────

// Compila siempre ambas salidas CSS en paralelo.
const compileSCSS = parallel( compileSCSSdev, compileSCSSmin );

const clean = parallel( cleanCSSDevDir, cleanCSSProdDir, cleanJSDir );
const build = series( clean, parallel( compileSCSS, compileJS ) );
const dev   = series( build, watchFiles );

exports.css   = compileSCSS;
exports.js    = compileJS;
exports.clean = clean;
exports.build = build;
exports.watch = watchFiles;
exports.default = dev;
