( () => {
  const settings = window.kulimbosProductGalleryAdmin || {};

  const getAttachmentUrl = ( attachment ) => {
    if ( attachment.sizes && attachment.sizes.thumbnail ) {
      return attachment.sizes.thumbnail.url;
    }

    return attachment.url || '';
  };

  const updateState = ( field ) => {
    const input = field.querySelector( '[data-product-gallery-input]' );
    const empty = field.querySelector( '[data-product-gallery-empty]' );
    const items = Array.from( field.querySelectorAll( '[data-product-gallery-item]' ) );

    if ( input ) {
      input.value = items
        .map( ( item ) => item.dataset.attachmentId )
        .filter( Boolean )
        .join( ',' );
    }

    if ( empty ) {
      empty.hidden = items.length > 0;
    }
  };

  const createActionButton = ( action, icon, text, extraClass = '' ) => {
    const button = document.createElement( 'button' );
    button.type = 'button';
    button.className = `button button-small ${ extraClass }`.trim();
    button.dataset[ action ] = '';

    const iconElement = document.createElement( 'span' );
    iconElement.className = `dashicons ${ icon }`;
    iconElement.setAttribute( 'aria-hidden', 'true' );

    button.append( iconElement, document.createTextNode( text ) );

    return button;
  };

  const createItem = ( attachment ) => {
    const item = document.createElement( 'li' );
    item.className = 'kulimbos-product-gallery-field__item';
    item.dataset.productGalleryItem = '';
    item.dataset.attachmentId = String( attachment.id );

    const thumb = document.createElement( 'div' );
    thumb.className = 'kulimbos-product-gallery-field__thumb';

    const image = document.createElement( 'img' );
    image.src = getAttachmentUrl( attachment );
    image.alt = '';
    image.width = 120;
    image.height = 120;

    const actions = document.createElement( 'div' );
    actions.className = 'kulimbos-product-gallery-field__actions';
    actions.append(
      createActionButton( 'productGalleryMoveUp', 'dashicons-arrow-up-alt2', settings.moveUpText || 'Subir' ),
      createActionButton( 'productGalleryMoveDown', 'dashicons-arrow-down-alt2', settings.moveDownText || 'Bajar' ),
      createActionButton( 'productGalleryRemove', 'dashicons-trash', settings.removeText || 'Quitar', 'kulimbos-product-gallery-field__remove' )
    );

    thumb.appendChild( image );
    item.append( thumb, actions );

    return item;
  };

  const setupField = ( field ) => {
    const selectButton = field.querySelector( '[data-product-gallery-select]' );
    const list = field.querySelector( '[data-product-gallery-list]' );

    if ( ! selectButton || ! list || ! window.wp || ! window.wp.media ) return;

    updateState( field );

    const frame = window.wp.media( {
      title: settings.frameTitle || 'Seleccionar imágenes de galería',
      button: {
        text: settings.buttonText || 'Usar imágenes seleccionadas',
      },
      library: {
        type: 'image',
      },
      multiple: 'add',
    } );

    selectButton.addEventListener( 'click', () => {
      frame.open();
    } );

    frame.on( 'select', () => {
      const existingIds = new Set(
        Array.from( list.querySelectorAll( '[data-product-gallery-item]' ) )
          .map( ( item ) => item.dataset.attachmentId )
      );

      frame.state().get( 'selection' ).each( ( image ) => {
        const attachment = image.toJSON();
        const attachmentId = String( attachment.id );

        if ( existingIds.has( attachmentId ) || ! getAttachmentUrl( attachment ) ) {
          return;
        }

        existingIds.add( attachmentId );
        list.appendChild( createItem( attachment ) );
      } );

      updateState( field );
    } );

    list.addEventListener( 'click', ( event ) => {
      const button = event.target.closest( 'button' );
      const item = event.target.closest( '[data-product-gallery-item]' );

      if ( ! button || ! item ) return;

      if ( button.matches( '[data-product-gallery-remove]' ) ) {
        item.remove();
      }

      if ( button.matches( '[data-product-gallery-move-up]' ) && item.previousElementSibling ) {
        list.insertBefore( item, item.previousElementSibling );
      }

      if ( button.matches( '[data-product-gallery-move-down]' ) && item.nextElementSibling ) {
        list.insertBefore( item.nextElementSibling, item );
      }

      updateState( field );
    } );
  };

  document.addEventListener( 'DOMContentLoaded', () => {
    document
      .querySelectorAll( '[data-product-gallery-field]' )
      .forEach( setupField );
  } );
} )();
