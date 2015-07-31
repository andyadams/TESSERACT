jQuery( function ( $ ) {
	$( '.fl-builder-bar-actions .fl-builder-tools-button' ).after(
		'<span class="fl-builder-tesseract-blocks-button fl-builder-button">Content Blocks</span>'
	);

	var contentBlocksLightbox = new FLLightbox({
		className: 'fl-builder-tesseract-blocks-lightbox'
	});

	$( '.fl-builder-tesseract-blocks-button' ).on( 'click', function() {
		contentBlocksLightbox.open( $( '#tesseract-content-blocks-wrapper' ).html() );
	} );
} );