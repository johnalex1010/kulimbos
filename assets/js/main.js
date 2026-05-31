/**
 * main.js - JavaScript principal del tema Kulimbos.
 *
 * Gulp minifica este archivo a assets/production/minjs/main.min.js
 * Los datos de PHP estan disponibles en window.kulimbosData (via wp_localize_script).
 *
 * Convenciones:
 *  - Todo el codigo vive bajo el namespace Kulimbos para no contaminar window.
 *  - Cada modulo se inicializa solo si su elemento raiz existe en el DOM.
 *  - Sin console.log en produccion.
 */

( function () {
  'use strict';

  const Kulimbos = {

    init() {
      this.mobileMenu.init();
      this.skipLink.init();
      this.lazyImages.init();
      this.stickyHeader.init();
      this.heroSlider.init();
      this.testimonialsSlider.init();
    },

    // --- Modulo: menu movil --------------------------------------------------

    mobileMenu: {
      toggle: null,
      menu:   null,
      isOpen: false,

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
        this.toggle.setAttribute( 'aria-label', this.isOpen ? 'Cerrar menu' : 'Abrir menu' );
      },

      close() {
        if ( ! this.isOpen ) return;
        this.isOpen = false;
        this.menu.classList.remove( 'is-open' );
        this.toggle.setAttribute( 'aria-expanded', 'false' );
        this.toggle.setAttribute( 'aria-label', 'Abrir menu' );
      },

      handleOutsideClick() {
        document.addEventListener( 'click', ( event ) => {
          if ( this.isOpen && ! this.toggle.contains( event.target ) && ! this.menu.contains( event.target ) ) {
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

    // --- Modulo: skip link ---------------------------------------------------

    skipLink: {
      init() {
        const link = document.querySelector( '.skip-link' );
        if ( ! link ) return;
        link.addEventListener( 'click', ( event ) => {
          const target = document.getElementById( link.getAttribute( 'href' ).replace( '#', '' ) );
          if ( ! target ) return;
          event.preventDefault();
          target.setAttribute( 'tabindex', '-1' );
          target.focus();
        } );
      },
    },

    // --- Modulo: lazy images -------------------------------------------------

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
              if ( img.dataset.srcset ) img.srcset = img.dataset.srcset;
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

    // --- Modulo: header sticky -----------------------------------------------

    stickyHeader: {
      header:    null,
      threshold: 10,

      init() {
        this.header = document.querySelector( '.site-header' );
        if ( ! this.header ) return;
        window.addEventListener( 'scroll', this.handleScroll.bind( this ), { passive: true } );
      },

      handleScroll() {
        this.header.classList.toggle( 'site-header--scrolled', window.scrollY > this.threshold );
      },
    },

    // --- Modulo: hero slider -------------------------------------------------

    heroSlider: {
      slider:    null,
      slides:    null,
      dots:      null,
      prevBtn:   null,
      nextBtn:   null,
      current:   0,
      total:     0,
      autoTimer: null,
      delay:     5000,

      init() {
        this.slider  = document.getElementById( 'hero-slider' );
        this.prevBtn = document.getElementById( 'hero-prev' );
        this.nextBtn = document.getElementById( 'hero-next' );
        if ( ! this.slider ) return;

        this.slides = this.slider.querySelectorAll( '.home-hero__slide' );
        this.dots   = document.querySelectorAll( '.home-hero__dot' );
        this.total  = this.slides.length;
        if ( this.total < 2 ) return;

        if ( this.prevBtn ) this.prevBtn.addEventListener( 'click', () => this.prev() );
        if ( this.nextBtn ) this.nextBtn.addEventListener( 'click', () => this.next() );

        this.dots.forEach( ( dot, i ) => dot.addEventListener( 'click', () => this.goTo( i ) ) );

        this.handleSwipe();
        this.slider.addEventListener( 'mouseenter', () => this.stopAuto() );
        this.slider.addEventListener( 'mouseleave', () => this.startAuto() );
        this.slider.addEventListener( 'focusin',    () => this.stopAuto() );
        this.slider.addEventListener( 'focusout',   () => this.startAuto() );
        this.startAuto();
      },

      goTo( index ) {
        if ( index < 0 )           index = this.total - 1;
        if ( index >= this.total ) index = 0;

        this.slides[ this.current ].classList.remove( 'home-hero__slide--active' );
        if ( this.dots[ this.current ] ) {
          this.dots[ this.current ].classList.remove( 'home-hero__dot--active' );
          this.dots[ this.current ].setAttribute( 'aria-selected', 'false' );
        }

        this.current = index;
        this.slides[ this.current ].classList.add( 'home-hero__slide--active' );
        if ( this.dots[ this.current ] ) {
          this.dots[ this.current ].classList.add( 'home-hero__dot--active' );
          this.dots[ this.current ].setAttribute( 'aria-selected', 'true' );
        }
      },

      next() { this.goTo( this.current + 1 ); },
      prev() { this.goTo( this.current - 1 ); },

      startAuto() {
        this.stopAuto();
        this.autoTimer = setInterval( () => this.next(), this.delay );
      },

      stopAuto() {
        clearInterval( this.autoTimer );
      },

      handleSwipe() {
        let startX = 0;
        this.slider.addEventListener( 'touchstart', ( e ) => {
          startX = e.touches[ 0 ].clientX;
        }, { passive: true } );
        this.slider.addEventListener( 'touchend', ( e ) => {
          const diff = startX - e.changedTouches[ 0 ].clientX;
          if ( Math.abs( diff ) > 40 ) diff > 0 ? this.next() : this.prev();
        }, { passive: true } );
      },
    },

    // --- Modulo: carrusel de testimonios ------------------------------------

    testimonialsSlider: {
      root:    null,
      track:   null,
      cards:   [],
      prevBtn: null,
      nextBtn: null,
      current: 0,
      visible: 1,
      gap:     0,

      init() {
        this.root = document.querySelector( '[data-testimonials-slider]' );
        if ( ! this.root ) return;

        this.track   = this.root.querySelector( '[data-testimonials-track]' );
        this.cards   = Array.from( this.root.querySelectorAll( '.testimonial-card' ) );
        this.prevBtn = this.root.querySelector( '[data-testimonials-prev]' );
        this.nextBtn = this.root.querySelector( '[data-testimonials-next]' );

        if ( ! this.track || ! this.cards.length ) return;

        if ( this.prevBtn ) this.prevBtn.addEventListener( 'click', () => this.goTo( this.current - 1 ) );
        if ( this.nextBtn ) this.nextBtn.addEventListener( 'click', () => this.goTo( this.current + 1 ) );

        window.addEventListener( 'resize', this.handleResize.bind( this ), { passive: true } );
        this.handleResize();
      },

      handleResize() {
        const styles = window.getComputedStyle( this.track );
        this.visible = Math.max( 1, parseInt( styles.getPropertyValue( '--testimonial-visible' ), 10 ) || 1 );
        this.gap     = parseFloat( styles.columnGap || styles.gap ) || 0;
        this.goTo( Math.min( this.current, this.getMaxIndex() ) );
      },

      getMaxIndex() {
        return Math.max( 0, this.cards.length - this.visible );
      },

      goTo( index ) {
        const maxIndex = this.getMaxIndex();
        this.current = Math.max( 0, Math.min( index, maxIndex ) );

        if ( window.matchMedia( '(max-width: 640px)' ).matches ) {
          this.track.style.transform = '';
          this.updateControls();
          return;
        }

        const cardWidth = this.cards[ 0 ].getBoundingClientRect().width;
        const offset = this.current * ( cardWidth + this.gap );
        this.track.style.transform = `translateX(-${ offset }px)`;
        this.updateControls();
      },

      updateControls() {
        const maxIndex = this.getMaxIndex();
        if ( this.prevBtn ) {
          this.prevBtn.disabled = this.current <= 0;
          this.prevBtn.hidden = this.current <= 0;
        }
        if ( this.nextBtn ) {
          this.nextBtn.disabled = this.current >= maxIndex;
          this.nextBtn.hidden = this.current >= maxIndex;
        }
      },
    },

  };

  // --- Inicializacion -------------------------------------------------------

  if ( document.readyState === 'loading' ) {
    document.addEventListener( 'DOMContentLoaded', () => Kulimbos.init() );
  } else {
    Kulimbos.init();
  }

} )();
