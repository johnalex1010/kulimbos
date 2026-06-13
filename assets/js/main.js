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
      this.productGallery.init();
      this.productQuantity.init();
      this.cart.init();
      this.favorites.init();
      this.plushiesFilters.init();
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

    // --- Modulo: galeria de producto -----------------------------------------

    productGallery: {
      galleries: [],

      init() {
        this.galleries = Array.from( document.querySelectorAll( '[data-product-gallery]' ) );
        if ( ! this.galleries.length ) return;

        this.galleries.forEach( ( gallery ) => this.setupGallery( gallery ) );
      },

      setupGallery( gallery ) {
        const mainImage = gallery.querySelector( '[data-product-gallery-image]' );
        const thumbs    = Array.from( gallery.querySelectorAll( '[data-product-gallery-thumb]' ) );
        const prevBtn   = gallery.querySelector( '[data-product-gallery-prev]' );
        const nextBtn   = gallery.querySelector( '[data-product-gallery-next]' );

        if ( ! mainImage || ! thumbs.length ) return;

        const visibleThumbs = 5;
        let current = thumbs.findIndex( ( thumb ) => thumb.classList.contains( 'is-active' ) );
        current = current >= 0 ? current : 0;
        let visibleStart = Math.floor( current / visibleThumbs ) * visibleThumbs;

        const updateVisibleThumbs = () => {
          if ( thumbs.length <= visibleThumbs ) return;

          if ( current < visibleStart ) {
            visibleStart = current;
          }

          if ( current >= visibleStart + visibleThumbs ) {
            visibleStart = current - visibleThumbs + 1;
          }

          visibleStart = Math.max( 0, Math.min( visibleStart, thumbs.length - visibleThumbs ) );

          thumbs.forEach( ( thumb, thumbIndex ) => {
            const thumbItem = thumb.closest( 'li' );
            if ( thumbItem ) {
              thumbItem.hidden = thumbIndex < visibleStart || thumbIndex >= visibleStart + visibleThumbs;
            }
          } );
        };

        const goTo = ( index ) => {
          const total = thumbs.length;
          current = ( index + total ) % total;

          thumbs.forEach( ( thumb, thumbIndex ) => {
            const isActive = thumbIndex === current;
            thumb.classList.toggle( 'is-active', isActive );
            thumb.setAttribute( 'aria-current', String( isActive ) );
          } );

          updateVisibleThumbs();

          const activeThumb = thumbs[ current ];
          const imageUrl = activeThumb.dataset.galleryImage;
          if ( imageUrl ) {
            mainImage.src = imageUrl;
          }
          if ( activeThumb.dataset.galleryAlt ) {
            mainImage.alt = activeThumb.dataset.galleryAlt;
          }
        };

        thumbs.forEach( ( thumb, index ) => {
          thumb.addEventListener( 'click', () => goTo( index ) );
        } );

        if ( prevBtn ) {
          prevBtn.addEventListener( 'click', () => goTo( current - 1 ) );
        }

        if ( nextBtn ) {
          nextBtn.addEventListener( 'click', () => goTo( current + 1 ) );
        }

        goTo( current );
      },
    },

    // --- Modulo: cantidad de producto ----------------------------------------

    productQuantity: {
      controls: [],

      init() {
        this.controls = Array.from( document.querySelectorAll( '[data-product-quantity]' ) );
        if ( ! this.controls.length ) return;

        this.controls.forEach( ( control ) => this.setupControl( control ) );
      },

      setupControl( control ) {
        const input = control.querySelector( '[data-product-quantity-input]' );
        const decreaseBtn = control.querySelector( '[data-product-quantity-decrease]' );
        const increaseBtn = control.querySelector( '[data-product-quantity-increase]' );
        const actions = control.closest( '.product-actions' );
        const whatsappLink = actions ? actions.querySelector( '[data-product-whatsapp]' ) : null;

        if ( ! input || ! decreaseBtn || ! increaseBtn ) return;

        const minAttribute = Number.parseInt( input.getAttribute( 'min' ), 10 );
        const min = Number.isNaN( minAttribute ) ? 1 : minAttribute;
        const maxAttribute = Number.parseInt( input.getAttribute( 'max' ), 10 );
        const max = Number.isNaN( maxAttribute ) ? Number.POSITIVE_INFINITY : Math.max( min, maxAttribute );

        const clampQuantity = ( value ) => Math.min( max, Math.max( min, value ) );

        const updateButtonState = () => {
          const quantity = Number.parseInt( input.value, 10 ) || min;
          decreaseBtn.disabled = quantity <= min || input.disabled;
          increaseBtn.disabled = quantity >= max || input.disabled;
        };

        const updateWhatsappLink = () => {
          if ( ! whatsappLink || ! whatsappLink.dataset.whatsappMessage ) return;

          const quantity = Number.parseInt( input.value, 10 ) || min;
          const message = whatsappLink.dataset.whatsappMessage.replace( /Cantidad:\s*\d+/u, `Cantidad: ${ quantity }` );
          whatsappLink.href = `https://wa.me/?text=${ encodeURIComponent( message ) }`;
        };

        const normalize = () => {
          const value = Number.parseInt( input.value, 10 );
          input.value = String( Number.isNaN( value ) ? min : clampQuantity( value ) );
          updateWhatsappLink();
          updateButtonState();
        };

        decreaseBtn.addEventListener( 'click', () => {
          normalize();
          input.value = String( clampQuantity( Number.parseInt( input.value, 10 ) - 1 ) );
          updateWhatsappLink();
          updateButtonState();
          input.dispatchEvent( new Event( 'change', { bubbles: true } ) );
        } );

        increaseBtn.addEventListener( 'click', () => {
          normalize();
          input.value = String( clampQuantity( Number.parseInt( input.value, 10 ) + 1 ) );
          updateWhatsappLink();
          updateButtonState();
          input.dispatchEvent( new Event( 'change', { bubbles: true } ) );
        } );

        input.addEventListener( 'change', normalize );
        input.addEventListener( 'blur', normalize );
        normalize();
      },
    },

    // --- Modulo: carrito local ----------------------------------------------

    cart: {
      storageKey: 'kulimbos_cart_v1',
      shippingFee: 12800,
      items: [],

      init() {
        const cartConfig = window.kulimbosData && window.kulimbosData.cart ? window.kulimbosData.cart : {};
        this.storageKey = cartConfig.storageKey || this.storageKey;
        this.shippingFee = Number.parseInt( cartConfig.shippingFee, 10 ) || this.shippingFee;
        this.items = this.read();

        this.bindAddButtons();
        this.bindCartPage();
        this.updateHeaderCount();

        window.addEventListener( 'storage', ( event ) => {
          if ( event.key !== this.storageKey ) return;
          this.items = this.read();
          this.updateHeaderCount();
          this.renderCartPage();
        } );
      },

      formatCurrency( value ) {
        return `$${ Number( value || 0 ).toLocaleString( 'es-CO' ) }`;
      },

      read() {
        try {
          const parsed = JSON.parse( window.localStorage.getItem( this.storageKey ) || '[]' );
          return Array.isArray( parsed ) ? parsed.map( ( item ) => this.normalizeItem( item ) ).filter( Boolean ) : [];
        } catch ( error ) {
          return [];
        }
      },

      write() {
        window.localStorage.setItem( this.storageKey, JSON.stringify( this.items ) );
        this.updateHeaderCount();
        this.renderCartPage();
      },

      normalizeItem( item ) {
        if ( ! item || ! item.id || ! item.name ) return null;

        const stock = Number.parseInt( item.stock, 10 );
        const safeStock = Number.isNaN( stock ) || stock < 1 ? 99 : stock;
        const quantity = Math.min(
          safeStock,
          Math.max( 1, Number.parseInt( item.quantity, 10 ) || 1 )
        );

        return {
          id: String( item.id ),
          name: String( item.name ),
          price: Math.max( 0, Number.parseInt( item.price, 10 ) || 0 ),
          quantity,
          stock: safeStock,
          url: item.url ? String( item.url ) : '#',
          image: item.image ? String( item.image ) : '',
        };
      },

      getTotalQuantity() {
        return this.items.reduce( ( total, item ) => total + item.quantity, 0 );
      },

      getSubtotal() {
        return this.items.reduce( ( total, item ) => total + ( item.price * item.quantity ), 0 );
      },

      getCheckoutMessage() {
        const subtotal = this.getSubtotal();
        const shipping = this.items.length ? this.shippingFee : 0;
        const productLines = this.items.map( ( item, index ) => [
          `${ index + 1 }. ${ item.name }`,
          `Cantidad: ${ item.quantity }`,
          `Precio unitario: ${ this.formatCurrency( item.price ) }`,
          `Subtotal: ${ this.formatCurrency( item.price * item.quantity ) }`,
          `URL: ${ item.url }`,
        ].join( '\n' ) );

        return [
          'Hola, estoy interesado en estos productos:',
          '',
          productLines.join( '\n\n' ),
          '',
          `Subtotal productos: ${ this.formatCurrency( subtotal ) }`,
          `Envío: ${ this.formatCurrency( shipping ) }`,
          `Total: ${ this.formatCurrency( subtotal + shipping ) }`,
        ].join( '\n' );
      },

      updateHeaderCount() {
        const count = this.getTotalQuantity();
        const badges = document.querySelectorAll( '#cart-count, [data-cart-count]' );

        badges.forEach( ( badge ) => {
          badge.textContent = String( count );
          badge.dataset.count = String( count );
        } );
      },

      getQuantityFromButton( button ) {
        if ( ! button.dataset.cartQuantityInput ) return 1;

        const input = document.querySelector( button.dataset.cartQuantityInput );
        if ( ! input ) return 1;

        const quantity = Number.parseInt( input.value, 10 );
        return Number.isNaN( quantity ) ? 1 : Math.max( 1, quantity );
      },

      getProductFromButton( button ) {
        const quantity = this.getQuantityFromButton( button );
        const stock = Number.parseInt( button.dataset.cartProductStock, 10 );

        return this.normalizeItem( {
          id: button.dataset.cartProductId,
          name: button.dataset.cartProductName,
          price: button.dataset.cartProductPrice,
          url: button.dataset.cartProductUrl,
          image: button.dataset.cartProductImage,
          stock: Number.isNaN( stock ) || stock < 1 ? quantity : stock,
          quantity,
        } );
      },

      addItem( item ) {
        if ( ! item ) return false;

        const existing = this.items.find( ( cartItem ) => cartItem.id === item.id );

        if ( existing ) {
          existing.quantity = Math.min( existing.stock, existing.quantity + item.quantity );
        } else {
          this.items.push( item );
        }

        this.write();
        return true;
      },

      bindAddButtons() {
        document.querySelectorAll( '[data-cart-add]' ).forEach( ( button ) => {
          button.addEventListener( 'click', () => {
            if ( button.disabled ) return;

            const added = this.addItem( this.getProductFromButton( button ) );
            if ( ! added ) return;

            const label = button.querySelector( 'span' );
            const originalText = label ? label.textContent : '';

            button.classList.add( 'is-added' );
            if ( label ) label.textContent = 'Agregado';

            window.setTimeout( () => {
              button.classList.remove( 'is-added' );
              if ( label && originalText ) label.textContent = originalText;
            }, 1400 );
          } );
        } );
      },

      bindCartPage() {
        this.cartPage = document.querySelector( '[data-cart-page]' );
        if ( ! this.cartPage ) return;

        const clearButton = this.cartPage.querySelector( '[data-cart-clear]' );
        if ( clearButton ) {
          clearButton.addEventListener( 'click', () => {
            this.items = [];
            this.write();
          } );
        }

        this.renderCartPage();
      },

      createItemElement( item ) {
        const itemElement = document.createElement( 'li' );
        itemElement.className = 'cart-product';
        itemElement.dataset.cartItem = item.id;

        const imageLink = document.createElement( 'a' );
        imageLink.className = 'cart-product__image';
        imageLink.href = item.url;
        imageLink.tabIndex = -1;
        imageLink.setAttribute( 'aria-hidden', 'true' );

        if ( item.image ) {
          const image = document.createElement( 'img' );
          image.src = item.image;
          image.alt = '';
          image.width = 96;
          image.height = 96;
          image.loading = 'lazy';
          image.decoding = 'async';
          imageLink.appendChild( image );
        }

        const body = document.createElement( 'div' );
        body.className = 'cart-product__body';

        const name = document.createElement( 'a' );
        name.className = 'cart-product__name';
        name.href = item.url;
        name.textContent = item.name;

        const meta = document.createElement( 'p' );
        meta.className = 'cart-product__meta';
        meta.textContent = `${ item.stock } disponibles`;

        const controls = document.createElement( 'div' );
        controls.className = 'cart-product__controls';

        const decrease = document.createElement( 'button' );
        decrease.type = 'button';
        decrease.textContent = '−';
        decrease.setAttribute( 'aria-label', `Disminuir cantidad de ${ item.name }` );
        decrease.disabled = item.quantity <= 1;

        const quantity = document.createElement( 'span' );
        quantity.textContent = String( item.quantity );

        const increase = document.createElement( 'button' );
        increase.type = 'button';
        increase.textContent = '+';
        increase.setAttribute( 'aria-label', `Aumentar cantidad de ${ item.name }` );
        increase.disabled = item.quantity >= item.stock;

        controls.append( decrease, quantity, increase );

        const remove = document.createElement( 'button' );
        remove.className = 'cart-product__remove';
        remove.type = 'button';
        remove.textContent = 'Eliminar';

        body.append( name, meta, controls, remove );

        const price = document.createElement( 'strong' );
        price.className = 'cart-product__price';
        price.textContent = this.formatCurrency( item.price * item.quantity );

        decrease.addEventListener( 'click', () => this.updateItemQuantity( item.id, item.quantity - 1 ) );
        increase.addEventListener( 'click', () => this.updateItemQuantity( item.id, item.quantity + 1 ) );
        remove.addEventListener( 'click', () => this.removeItem( item.id ) );

        itemElement.append( imageLink, body, price );
        return itemElement;
      },

      updateItemQuantity( id, quantity ) {
        const item = this.items.find( ( cartItem ) => cartItem.id === id );
        if ( ! item ) return;

        item.quantity = Math.min( item.stock, Math.max( 1, Number.parseInt( quantity, 10 ) || 1 ) );
        this.write();
      },

      removeItem( id ) {
        this.items = this.items.filter( ( item ) => item.id !== id );
        this.write();
      },

      renderCartPage() {
        if ( ! this.cartPage ) return;

        const list = this.cartPage.querySelector( '[data-cart-items]' );
        const empty = this.cartPage.querySelector( '[data-cart-empty]' );
        const clearButton = this.cartPage.querySelector( '[data-cart-clear]' );
        const checkoutButton = this.cartPage.querySelector( '[data-cart-checkout]' );
        const subtotal = this.getSubtotal();
        const quantity = this.getTotalQuantity();
        const shipping = this.items.length ? this.shippingFee : 0;

        if ( list ) {
          list.innerHTML = '';
          this.items.forEach( ( item ) => list.appendChild( this.createItemElement( item ) ) );
        }

        if ( empty ) empty.hidden = this.items.length > 0;
        if ( list ) list.hidden = this.items.length === 0;
        if ( clearButton ) clearButton.hidden = this.items.length === 0;
        if ( checkoutButton ) {
          const hasItems = this.items.length > 0;
          checkoutButton.setAttribute( 'aria-disabled', String( ! hasItems ) );
          checkoutButton.href = hasItems ? `https://wa.me/?text=${ encodeURIComponent( this.getCheckoutMessage() ) }` : '#';
        }

        this.cartPage.querySelectorAll( '[data-cart-summary-count]' ).forEach( ( node ) => {
          node.textContent = `(${ quantity })`;
        } );
        this.cartPage.querySelectorAll( '[data-cart-summary-subtotal]' ).forEach( ( node ) => {
          node.textContent = this.formatCurrency( subtotal );
        } );
        this.cartPage.querySelectorAll( '[data-cart-summary-shipping]' ).forEach( ( node ) => {
          node.textContent = this.formatCurrency( shipping );
        } );
        this.cartPage.querySelectorAll( '[data-cart-summary-total]' ).forEach( ( node ) => {
          node.textContent = this.formatCurrency( subtotal + shipping );
        } );
      },
    },

    // --- Modulo: favoritos locales ------------------------------------------

    favorites: {
      storageKey: 'kulimbos_favorites_v1',
      items: [],
      searchTerm: '',
      sortMode: 'recent',

      init() {
        const favoriteConfig = window.kulimbosData && window.kulimbosData.favorites ? window.kulimbosData.favorites : {};
        this.storageKey = favoriteConfig.storageKey || this.storageKey;
        this.items = this.read();

        this.bindToggleButtons();
        this.bindFavoritesPage();
        this.updateHeaderCount();
        this.updateToggleStates();

        window.addEventListener( 'storage', ( event ) => {
          if ( event.key !== this.storageKey ) return;
          this.items = this.read();
          this.updateHeaderCount();
          this.updateToggleStates();
          this.renderFavoritesPage();
        } );
      },

      formatCurrency( value ) {
        return `$${ Number( value || 0 ).toLocaleString( 'es-CO' ) }`;
      },

      read() {
        try {
          const parsed = JSON.parse( window.localStorage.getItem( this.storageKey ) || '[]' );
          return Array.isArray( parsed ) ? parsed.map( ( item ) => this.normalizeItem( item ) ).filter( Boolean ) : [];
        } catch ( error ) {
          return [];
        }
      },

      write() {
        window.localStorage.setItem( this.storageKey, JSON.stringify( this.items ) );
        this.updateHeaderCount();
        this.updateToggleStates();
        this.renderFavoritesPage();
      },

      normalizeItem( item ) {
        if ( ! item || ! item.id || ! item.name ) return null;

        return {
          id: String( item.id ),
          name: String( item.name ),
          price: Math.max( 0, Number.parseInt( item.price, 10 ) || 0 ),
          stock: Math.max( 1, Number.parseInt( item.stock, 10 ) || 99 ),
          url: item.url ? String( item.url ) : '#',
          image: item.image ? String( item.image ) : '',
          addedAt: Number.parseInt( item.addedAt, 10 ) || Date.now(),
        };
      },

      getProductFromButton( button ) {
        return this.normalizeItem( {
          id: button.dataset.favoriteProductId,
          name: button.dataset.favoriteProductName,
          price: button.dataset.favoriteProductPrice,
          url: button.dataset.favoriteProductUrl,
          image: button.dataset.favoriteProductImage,
          stock: button.dataset.favoriteProductStock,
          addedAt: Date.now(),
        } );
      },

      hasItem( id ) {
        return this.items.some( ( item ) => item.id === String( id ) );
      },

      toggleItem( item ) {
        if ( ! item ) return;

        if ( this.hasItem( item.id ) ) {
          this.items = this.items.filter( ( favorite ) => favorite.id !== item.id );
        } else {
          this.items.unshift( item );
        }

        this.write();
      },

      removeItem( id ) {
        this.items = this.items.filter( ( item ) => item.id !== id );
        this.write();
      },

      updateHeaderCount() {
        document.querySelectorAll( '#favorites-count, [data-favorites-count]' ).forEach( ( badge ) => {
          badge.textContent = String( this.items.length );
          badge.dataset.count = String( this.items.length );
        } );
      },

      updateToggleStates() {
        document.querySelectorAll( '[data-favorite-toggle]' ).forEach( ( button ) => {
          const isFavorite = this.hasItem( button.dataset.favoriteProductId );
          button.classList.toggle( 'is-active', isFavorite );
          button.setAttribute( 'aria-pressed', String( isFavorite ) );
        } );
      },

      bindToggleButtons() {
        document.querySelectorAll( '[data-favorite-toggle]' ).forEach( ( button ) => {
          button.addEventListener( 'click', () => {
            this.toggleItem( this.getProductFromButton( button ) );
          } );
        } );
      },

      bindFavoritesPage() {
        this.favoritesPage = document.querySelector( '[data-favorites-page]' );
        if ( ! this.favoritesPage ) return;

        const search = this.favoritesPage.querySelector( '[data-favorites-search]' );
        const sort = this.favoritesPage.querySelector( '[data-favorites-sort]' );
        const clear = this.favoritesPage.querySelector( '[data-favorites-clear]' );

        if ( search ) {
          search.addEventListener( 'input', () => {
            this.searchTerm = search.value.trim().toLowerCase();
            this.renderFavoritesPage();
          } );
        }

        if ( sort ) {
          sort.addEventListener( 'change', () => {
            this.sortMode = sort.value;
            this.renderFavoritesPage();
          } );
        }

        if ( clear ) {
          clear.addEventListener( 'click', () => {
            this.items = [];
            this.write();
          } );
        }

        this.renderFavoritesPage();
      },

      getVisibleItems() {
        const filtered = this.searchTerm
          ? this.items.filter( ( item ) => item.name.toLowerCase().includes( this.searchTerm ) )
          : [ ...this.items ];

        filtered.sort( ( itemA, itemB ) => {
          if ( this.sortMode === 'name' ) return itemA.name.localeCompare( itemB.name, 'es' );
          if ( this.sortMode === 'price-desc' ) return itemB.price - itemA.price;
          if ( this.sortMode === 'price-asc' ) return itemA.price - itemB.price;
          return itemB.addedAt - itemA.addedAt;
        } );

        return filtered;
      },

      createFavoriteElement( item ) {
        const itemElement = document.createElement( 'li' );
        itemElement.className = 'favorite-product';
        itemElement.dataset.favoriteItem = item.id;

        const imageLink = document.createElement( 'a' );
        imageLink.className = 'favorite-product__image';
        imageLink.href = item.url;
        imageLink.tabIndex = -1;
        imageLink.setAttribute( 'aria-hidden', 'true' );

        if ( item.image ) {
          const image = document.createElement( 'img' );
          image.src = item.image;
          image.alt = '';
          image.width = 140;
          image.height = 140;
          image.loading = 'lazy';
          image.decoding = 'async';
          imageLink.appendChild( image );
        }

        const body = document.createElement( 'div' );
        body.className = 'favorite-product__body';

        const name = document.createElement( 'a' );
        name.className = 'favorite-product__name';
        name.href = item.url;
        name.textContent = item.name;

        const price = document.createElement( 'strong' );
        price.className = 'favorite-product__price';
        price.textContent = this.formatCurrency( item.price );

        const date = document.createElement( 'p' );
        date.className = 'favorite-product__date';
        date.textContent = 'Artículo guardado en tu lista';

        const actions = document.createElement( 'div' );
        actions.className = 'favorite-product__actions';

        const addToCart = document.createElement( 'button' );
        addToCart.type = 'button';
        addToCart.textContent = 'Agregar al carrito';

        const remove = document.createElement( 'button' );
        remove.type = 'button';
        remove.textContent = 'Eliminar';

        addToCart.addEventListener( 'click', () => {
          Kulimbos.cart.addItem( {
            id: item.id,
            name: item.name,
            price: item.price,
            quantity: 1,
            stock: item.stock,
            url: item.url,
            image: item.image,
          } );
        } );

        remove.addEventListener( 'click', () => this.removeItem( item.id ) );

        actions.append( addToCart, remove );
        body.append( name, price, date, actions );
        itemElement.append( imageLink, body );

        return itemElement;
      },

      renderFavoritesPage() {
        if ( ! this.favoritesPage ) return;

        const list = this.favoritesPage.querySelector( '[data-favorites-items]' );
        const empty = this.favoritesPage.querySelector( '[data-favorites-empty]' );
        const clear = this.favoritesPage.querySelector( '[data-favorites-clear]' );
        const count = this.favoritesPage.querySelector( '[data-favorites-summary-count]' );
        const visibleItems = this.getVisibleItems();

        if ( list ) {
          list.innerHTML = '';
          visibleItems.forEach( ( item ) => list.appendChild( this.createFavoriteElement( item ) ) );
          list.hidden = visibleItems.length === 0;
        }

        if ( empty ) empty.hidden = this.items.length > 0;
        if ( clear ) clear.hidden = this.items.length === 0;
        if ( count ) count.textContent = String( this.items.length );
      },
    },

    // --- Modulo: filtros de peluches -----------------------------------------

    plushiesFilters: {
      roots: [],

      init() {
        this.roots = Array.from( document.querySelectorAll( '[data-plushies-listing]' ) );
        if ( ! this.roots.length ) return;

        this.roots.forEach( ( root ) => this.setupFilters( root ) );
      },

      setupFilters( root ) {
        const layout = root.querySelector( '.plushies-layout' );
        const grid = root.querySelector( '[data-filter-grid]' );
        const cards = Array.from( root.querySelectorAll( '[data-filter-card]' ) );
        const count = root.querySelector( '[data-filter-count]' );
        const empty = root.querySelector( '[data-filter-empty]' );
        const toggle = root.querySelector( '[data-filter-toggle]' );
        const clear = root.querySelector( '[data-filter-clear]' );
        const sort = root.querySelector( '[data-filter-sort]' );
        const priceMax = root.querySelector( '[data-filter-price-max]' );
        const priceLabel = root.querySelector( '[data-filter-price-label]' );
        const pagination = root.querySelector( '[data-filter-pagination]' );
        const categoryButtons = Array.from( root.querySelectorAll( '[data-filter-category]' ) );
        const colorButtons = Array.from( root.querySelectorAll( '[data-filter-color]' ) );
        const checkboxes = Array.from( root.querySelectorAll( '[data-filter-checkbox]' ) );
        const viewButtons = Array.from( root.querySelectorAll( '[data-view-mode]' ) );

        if ( ! grid || ! cards.length ) return;

        let currentPage = 1;
        const pageSize = 16;

        const formatCurrency = ( value ) => `$${ Number( value ).toLocaleString( 'es-CO' ) }`;

        const getCheckedValues = ( type ) => checkboxes
          .filter( ( checkbox ) => checkbox.dataset.filterCheckbox === type && checkbox.checked )
          .map( ( checkbox ) => checkbox.value );

        const getActiveCategory = () => {
          const active = categoryButtons.find( ( button ) => button.classList.contains( 'is-active' ) );
          return active ? active.dataset.filterCategory : 'all';
        };

        const getActiveColors = () => colorButtons
          .filter( ( button ) => button.classList.contains( 'is-active' ) )
          .map( ( button ) => button.dataset.filterColor );

        const matchesAny = ( value, selectedValues ) => {
          if ( ! selectedValues.length ) return true;

          const values = String( value || '' ).split( ' ' ).filter( Boolean );
          return values.some( ( item ) => selectedValues.includes( item ) );
        };

        const sortCards = ( visibleCards ) => {
          const mode = sort ? sort.value : 'popular';
          const sorted = [ ...visibleCards ];

          sorted.sort( ( cardA, cardB ) => {
            if ( 'price-asc' === mode ) return Number( cardA.dataset.price ) - Number( cardB.dataset.price );
            if ( 'price-desc' === mode ) return Number( cardB.dataset.price ) - Number( cardA.dataset.price );
            if ( 'name-asc' === mode ) return cardA.dataset.name.localeCompare( cardB.dataset.name, 'es' );
          return Number( cardB.dataset.popularity ) - Number( cardA.dataset.popularity );
          } );

          return sorted;
        };

        const renderPagination = ( totalPages ) => {
          if ( ! pagination ) return;

          pagination.innerHTML = '';
          pagination.hidden = totalPages <= 1;

          if ( totalPages <= 1 ) return;

          const createButton = ( label, page, options = {} ) => {
            const button = document.createElement( 'button' );
            button.type = 'button';
            button.textContent = label;
            button.dataset.filterPage = String( page );
            if ( options.ariaLabel ) button.setAttribute( 'aria-label', options.ariaLabel );
            if ( options.current ) button.classList.add( 'is-current' );
            if ( options.disabled ) button.disabled = true;
            button.addEventListener( 'click', () => {
              if ( button.disabled ) return;
              currentPage = page;
              applyFilters( { preservePage: true } );
            } );
            return button;
          };

          pagination.appendChild(
            createButton( '‹', Math.max( 1, currentPage - 1 ), {
              ariaLabel: 'Página anterior',
              disabled: currentPage <= 1,
            } )
          );

          for ( let page = 1; page <= totalPages; page += 1 ) {
            pagination.appendChild(
              createButton( String( page ), page, {
                current: page === currentPage,
              } )
            );
          }

          pagination.appendChild(
            createButton( '›', Math.min( totalPages, currentPage + 1 ), {
              ariaLabel: 'Página siguiente',
              disabled: currentPage >= totalPages,
            } )
          );
        };

        const applyFilters = ( options = {} ) => {
          if ( ! options.preservePage ) {
            currentPage = 1;
          }

          const activeCategory = getActiveCategory();
          const activeColors = getActiveColors();
          const selectedAges = getCheckedValues( 'age' );
          const selectedSizes = getCheckedValues( 'size' );
          const selectedMaterials = getCheckedValues( 'material' );
          const maxPrice = priceMax ? Number( priceMax.value ) : Number.POSITIVE_INFINITY;
          const isPriceFilterActive = priceMax && priceMax.value !== priceMax.max;

          if ( priceLabel && priceMax ) {
            priceLabel.textContent = formatCurrency( priceMax.value );
          }

          const visibleCards = cards.filter( ( card ) => {
            const cardCategories = ( card.dataset.categories || card.dataset.category || '' ).split( ' ' );
            const categoryMatches = 'all' === activeCategory || cardCategories.includes( activeCategory );
            const priceMatches = ! isPriceFilterActive || ( card.dataset.hasPrice === 'true' && Number( card.dataset.price ) <= maxPrice );
            const ageMatches = matchesAny( card.dataset.age, selectedAges );
            const sizeMatches = matchesAny( card.dataset.size, selectedSizes );
            const colorMatches = matchesAny( card.dataset.color, activeColors );
            const materialMatches = matchesAny( card.dataset.material, selectedMaterials );

            return categoryMatches && priceMatches && ageMatches && sizeMatches && colorMatches && materialMatches;
          } );

          const sortedCards = sortCards( visibleCards );
          const totalPages = Math.max( 1, Math.ceil( sortedCards.length / pageSize ) );
          currentPage = Math.min( currentPage, totalPages );

          const pageStart = ( currentPage - 1 ) * pageSize;
          const pageEnd = pageStart + pageSize;
          const pageCards = sortedCards.slice( pageStart, pageEnd );

          cards.forEach( ( card ) => {
            card.hidden = ! pageCards.includes( card );
          } );

          sortedCards.forEach( ( card ) => grid.appendChild( card ) );

          if ( count ) {
            if ( sortedCards.length ) {
              count.textContent = `Mostrando ${ pageStart + 1 }-${ Math.min( pageEnd, sortedCards.length ) } de ${ sortedCards.length } productos`;
            } else {
              count.textContent = `Mostrando 0 de ${ cards.length } productos`;
            }
          }

          if ( empty ) {
            empty.hidden = sortedCards.length > 0;
          }

          renderPagination( totalPages );
        };

        categoryButtons.forEach( ( button ) => {
          button.addEventListener( 'click', () => {
            categoryButtons.forEach( ( item ) => item.classList.remove( 'is-active' ) );
            button.classList.add( 'is-active' );
            applyFilters();
          } );
        } );

        colorButtons.forEach( ( button ) => {
          button.addEventListener( 'click', () => {
            button.classList.toggle( 'is-active' );
            applyFilters();
          } );
        } );

        checkboxes.forEach( ( checkbox ) => {
          checkbox.addEventListener( 'change', applyFilters );
        } );

        if ( priceMax ) {
          priceMax.addEventListener( 'input', applyFilters );
        }

        if ( sort ) {
          sort.addEventListener( 'change', applyFilters );
        }

        viewButtons.forEach( ( button ) => {
          button.addEventListener( 'click', () => {
            const mode = button.dataset.viewMode || 'grid';
            viewButtons.forEach( ( item ) => item.classList.toggle( 'is-active', item === button ) );
            grid.classList.toggle( 'is-list-view', 'list' === mode );
            grid.classList.toggle( 'is-grid-view', 'grid' === mode );
          } );
        } );

        if ( clear ) {
          clear.addEventListener( 'click', () => {
            categoryButtons.forEach( ( button ) => button.classList.toggle( 'is-active', 'all' === button.dataset.filterCategory ) );
            colorButtons.forEach( ( button ) => button.classList.remove( 'is-active' ) );
            checkboxes.forEach( ( checkbox ) => {
              checkbox.checked = false;
            } );
            if ( priceMax ) priceMax.value = priceMax.max;
            if ( sort ) sort.value = 'popular';
            applyFilters();
          } );
        }

        if ( toggle && layout ) {
          toggle.addEventListener( 'click', () => {
            const isHidden = layout.classList.toggle( 'is-filter-hidden' );
            toggle.setAttribute( 'aria-expanded', String( ! isHidden ) );
            const label = toggle.querySelector( 'span' );
            if ( label ) label.textContent = isHidden ? 'Mostrar filtros' : 'Ocultar filtros';
          } );
        }

        applyFilters();
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
