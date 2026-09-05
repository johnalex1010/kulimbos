( () => {
  const settings = window.kulimbosProductCategoryImageAdmin || {};

  const getAttachmentUrl = ( attachment ) => {
    if ( attachment.sizes && attachment.sizes.thumbnail ) {
      return attachment.sizes.thumbnail.url;
    }

    return attachment.url || '';
  };

  const renderPreview = ( field, attachment ) => {
    const input = field.querySelector( '[data-term-image-input]' );
    const preview = field.querySelector( '[data-term-image-preview]' );
    const removeButton = field.querySelector( '[data-term-image-remove]' );
    const imageUrl = getAttachmentUrl( attachment );

    if ( ! input || ! preview || ! imageUrl ) return;

    input.value = String( attachment.id );
    preview.replaceChildren();

    const image = document.createElement( 'img' );
    image.src = imageUrl;
    image.alt = attachment.alt || '';
    image.width = 120;
    image.height = 120;

    preview.appendChild( image );
    preview.hidden = false;

    if ( removeButton ) {
      removeButton.hidden = false;
    }
  };

  const clearPreview = ( field ) => {
    const input = field.querySelector( '[data-term-image-input]' );
    const preview = field.querySelector( '[data-term-image-preview]' );
    const removeButton = field.querySelector( '[data-term-image-remove]' );

    if ( input ) {
      input.value = '';
    }

    if ( preview ) {
      preview.replaceChildren();
      preview.hidden = true;
    }

    if ( removeButton ) {
      removeButton.hidden = true;
    }
  };

  const setupField = ( field ) => {
    const selectButton = field.querySelector( '[data-term-image-select]' );
    const removeButton = field.querySelector( '[data-term-image-remove]' );

    if ( ! selectButton || ! window.wp || ! window.wp.media ) return;

    const frame = window.wp.media( {
      title: settings.frameTitle || 'Seleccionar imagen de categoría',
      button: {
        text: settings.buttonText || 'Usar esta imagen',
      },
      library: {
        type: 'image',
      },
      multiple: false,
    } );

    selectButton.addEventListener( 'click', () => {
      frame.open();
    } );

    frame.on( 'select', () => {
      const attachment = frame.state().get( 'selection' ).first();

      if ( attachment ) {
        renderPreview( field, attachment.toJSON() );
      }
    } );

    if ( removeButton ) {
      removeButton.addEventListener( 'click', () => clearPreview( field ) );
    }
  };

  document.addEventListener( 'DOMContentLoaded', () => {
    document
      .querySelectorAll( '[data-term-image-field]' )
      .forEach( setupField );
  } );
} )();
