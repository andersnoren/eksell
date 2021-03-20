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
		} else {
			$( dark_mode_colors ).hide();
		}

	} );

	// Hide or show on change
	$( document ).on( 'change', dark_mode_setting, function() {
		if ( this.checked ) {
			$( dark_mode_colors ).show();
		} else {
			$( dark_mode_colors ).hide();
		}
	} );
	

	/*	-----------------------------------------------------------------------------------------------
		Multiple Checkboxes
		Add the values of the checked checkboxes to the hidden input
	--------------------------------------------------------------------------------------------------- */

	$( document ).on( 'change', '.customize-control-checkbox-multiple input[type="checkbox"]', function() {

		// Get the values of all of the checkboxes into a comma seperated variable
		checkbox_values = $( this ).parents( '.customize-control' ).find( 'input[type="checkbox"]:checked' ).map(
			function() {
				return this.value;
			}
		).get().join( ',' );

		// If there are no values, make that explicit in the variable so we know whether the default output is needed
		if ( ! checkbox_values ) {
			checkbox_values = 'empty';
		}

		// Update the hidden input with the variable
		$( this ).parents( '.customize-control' ).find( 'input[type="hidden"]' ).val( checkbox_values ).trigger( 'change' );

	} );

} )( jQuery );
