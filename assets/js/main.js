/**
 * main.js — JavaScript principal del tema Kulimbos.
 *
 * Gulp minifica este archivo a assets/production/minjs/main.min.js
 * Los datos de PHP están disponibles en window.kulimbosData (via wp_localize_script).
 *
 * Convenciones:
 *  - Todo el código vive bajo el namespace Kulimbos para no contaminar window.
 *  - Cada módulo se inicializa solo si su elemento raíz existe en el DOM.
 *  - Sin console.log en producción.
 */

( function () {
  'use strict';

  // ─── Namespace del tema ────────────────────────────────────────────────────

  const Kulimbos = {

    /**
     * Punto de entrada. Se llama cuando el DOM está listo.
     */
    init() {
      this.mobileMenu.init();
      this.skipLink.init();
      this.lazyImages.init();
      this.stickyHeader.init();
    },

    // ── Módulo: menú móvil ──────────────────────────────────────────────────

    mobileMenu: {
      toggle:   null,
      menu:     null,
      isOpen:   false,

      init() {
        this.toggle = document.getElementById( 'menu-toggle' );
        this.menu   = document.getElementById( 'primary-menu-list' );

        if ( ! this.toggle || ! this.menu ) return;

        this.toggle.addEventListener( 'click', this.handleToggle.bind( this ) );
        this.handleOutsideClick();
        this.handleEscape();
      },

      handleToggle() {
        this.isOpen = ! this.isOpen;
        this.menu.classList.toggle( 'is-open', this.isOpen );
        this.toggle.setAttribute( 'aria-expanded', String( this.isOpen ) );
        this.toggle.setAttribute(
          'aria-label',
          this.isOpen ? 'Cerrar menú' : 'Abrir menú'
        );
      },

      close() {
        if ( ! this.isOpen ) return;
        this.isOpen = false;
        this.menu.classList.remove( 'is-open' );
        this.toggle.setAttribute( 'aria-expanded', 'false' );
        this.toggle.setAttribute( 'aria-label', 'Abrir menú' );
      },

      handleOutsideClick() {
        document.addEventListener( 'click', ( event ) => {
          if (
            this.isOpen &&
            ! this.toggle.contains( event.target ) &&
            ! this.menu.contains( event.target )
          ) {
            this.close();
          }
        } );
      },

      handleEscape() {
        document.addEventListener( 'keydown', ( event ) => {
          if ( this.isOpen && event.key === 'Escape' ) {
            this.close();
            this.toggle.focus();
          }
        } );
      },
    },

    // ── Módulo: skip link suavizado ─────────────────────────────────────────

    skipLink: {
      init() {
        const link = document.querySelector( '.skip-link' );
        if ( ! link ) return;

        link.addEventListener( 'click', ( event ) => {
          const target = document.getElementById(
            link.getAttribute( 'href' ).replace( '#', '' )
          );
          if ( ! target ) return;
          event.preventDefault();
          target.setAttribute( 'tabindex', '-1' );
          target.focus();
        } );
      },
    },

    // ── Módulo: lazy images con Intersection Observer ───────────────────────
    // Solo activa para imágenes que no usan el atributo nativo loading="lazy".

    lazyImages: {
      init() {
        if ( ! ( 'IntersectionObserver' in window ) ) return;

        const images = document.querySelectorAll( 'img[data-src]' );
        if ( ! images.length ) return;

        const observer = new IntersectionObserver(
          ( entries, obs ) => {
            entries.forEach( ( entry ) => {
              if ( ! entry.isIntersecting ) return;
              const img = entry.target;
              img.src = img.dataset.src;
              if ( img.dataset.srcset ) {
                img.srcset = img.dataset.srcset;
              }
              img.removeAttribute( 'data-src' );
              img.removeAttribute( 'data-srcset' );
              obs.unobserve( img );
            } );
          },
          { rootMargin: '200px 0px' }
        );

        images.forEach( ( img ) => observer.observe( img ) );
      },
    },

    // ── Módulo: header sticky con clase al hacer scroll ─────────────────────

    stickyHeader: {
      header:    null,
      threshold: 10,

      init() {
        this.header = document.querySelector( '.site-header' );
        if ( ! this.header ) return;

        window.addEventListener( 'scroll', this.handleScroll.bind( this ), {
          passive: true,
        } );
      },

      handleScroll() {
        const scrolled = window.scrollY > this.threshold;
        this.header.classList.toggle( 'site-header--scrolled', scrolled );
      },
    },

  };

  // ─── Inicialización ────────────────────────────────────────────────────────

  if ( document.readyState === 'loading' ) {
    document.addEventListener( 'DOMContentLoaded', () => Kulimbos.init() );
  } else {
    Kulimbos.init();
  }

} )();
