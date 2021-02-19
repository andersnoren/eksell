( function( $ ) {

	/*	-----------------------------------------------------------------------------------------------
		Dark Mode
		Hide and show the Dark Mode color settings depending on the value of the Dark Mode checkbox.
	--------------------------------------------------------------------------------------------------- */

	var dark_mode_setting 	= '#customize-control-eksell_enable_dark_mode_palette input',
		dark_mode_colors 	= 'li[id^="customize-control-eksell_dark_mode_"]';

	// Hide or show on load
	wp.customize.bind( 'ready', function() {

		if ( $( dark_mode_setting ).prop( 'checked' ) ) {
			$( dark_mode_colors ).show();
			console.log( 'start show' );
		} else {
			$( dark_mode_colors ).hide();
			console.log( 'start hide' );
		}

	} );

	// Hide or show on change
	$( document ).on( 'change', dark_mode_setting, function() {
		console.log( 'change' );
		if ( this.checked ) {
			console.log( 'checked' );
			$( dark_mode_colors ).show();
		} else {
			console.log( 'not checked' );
			$( dark_mode_colors ).hide();
		}
	} );

} )( jQuery );
