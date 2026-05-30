'use strict';

/**
 * gulpfile.js — Pipeline de build del tema Kulimbos.
 *
 * Tareas disponibles:
 *   npm run dev     → build completo + watch (desarrollo)
 *   npm run build   → build completo sin watch (CI / producción)
 *   npm run watch   → solo watch
 *   npm run css     → solo compilar SCSS
 *   npm run js      → solo compilar JS
 *
 * IMPORTANTE: No editar manualmente archivos en assets/production/.
 * Son artefactos generados. Todo cambio va en assets/scss/ o assets/js/.
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
    entry:  './assets/scss/main.scss',
    watch:  './assets/scss/**/*.scss',
    dest:   './assets/production/mincss/',
    output: 'main.min.css',
  },
  js: {
    src:    './assets/js/**/*.js',
    dest:   './assets/production/minjs/',
    output: 'main.min.js',
  },
};

// ─── Limpieza ─────────────────────────────────────────────────────────────────

async function cleanCSSDir() {
  return deleteAsync( [ paths.scss.dest ] );
}

async function cleanJSDir() {
  return deleteAsync( [ paths.js.dest ] );
}

// ─── CSS: SCSS → CSS → Autoprefixer → Minify ─────────────────────────────────

function compileSCSS() {
  return src( paths.scss.entry )
    .pipe(
      sass( { outputStyle: 'expanded' } ).on( 'error', sass.logError )
    )
    .pipe( autoprefixer() )
    .pipe( cleanCSS( { level: 2 } ) )
    .pipe( rename( paths.scss.output ) )
    .pipe( dest( paths.scss.dest ) );
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

// ─── Tasks exportadas ─────────────────────────────────────────────────────────

const clean = parallel( cleanCSSDir, cleanJSDir );
const build = series( clean, parallel( compileSCSS, compileJS ) );
const dev   = series( build, watchFiles );

exports.css   = compileSCSS;
exports.js    = compileJS;
exports.clean = clean;
exports.build = build;
exports.watch = watchFiles;
exports.default = dev;
