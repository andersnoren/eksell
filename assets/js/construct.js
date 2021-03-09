/*	-----------------------------------------------------------------------------------------------
	Namespace
--------------------------------------------------------------------------------------------------- */

var eksell = eksell || {},
    $ = jQuery;


/*	-----------------------------------------------------------------------------------------------
	Global variables
--------------------------------------------------------------------------------------------------- */

var $doc = $( document ),
    $win = $( window ),
    winHeight = $win.height(),
    winWidth = $win.width();

var viewport = {};
	viewport.top = $win.scrollTop();
	viewport.bottom = viewport.top + $win.height();


/*	-----------------------------------------------------------------------------------------------
	Helper functions
--------------------------------------------------------------------------------------------------- */

/* Output AJAX errors ------------------------ */

function eksellAjaxErrors( jqXHR, exception ) {
	var message = '';
	if ( jqXHR.status === 0 ) {
		message = 'Not connect.n Verify Network.';
	} else if ( jqXHR.status == 404 ) {
		message = 'Requested page not found. [404]';
	} else if ( jqXHR.status == 500 ) {
		message = 'Internal Server Error [500].';
	} else if ( exception === 'parsererror' ) {
		message = 'Requested JSON parse failed.';
	} else if ( exception === 'timeout' ) {
		message = 'Time out error.';
	} else if ( exception === 'abort' ) {
		message = 'Ajax request aborted.';
	} else {
		message = 'Uncaught Error.n' + jqXHR.responseText;
	}
	console.log( 'AJAX ERROR:' + message );
}

/* Toggle an attribute ----------------------- */

function eksellToggleAttribute( $element, attribute, trueVal, falseVal ) {

	if ( typeof trueVal === 'undefined' ) { trueVal = true; }
	if ( typeof falseVal === 'undefined' ) { falseVal = false; }

	if ( $element.attr( attribute ) !== trueVal ) {
		$element.attr( attribute, trueVal );
	} else {
		$element.attr( attribute, falseVal );
	}
}


/*	-----------------------------------------------------------------------------------------------
	Interval Scroll
--------------------------------------------------------------------------------------------------- */

eksell.intervalScroll = {

	init: function() {

		didScroll = false;

		// Check for the scroll event.
		$win.on( 'scroll load', function() {
			didScroll = true;
		} );

		// Once every 250ms, check if we have scrolled, and if we have, do the intensive stuff.
		setInterval( function() {
			if ( didScroll ) {
				didScroll = false;

				// When this triggers, we know that we have scrolled.
				$win.trigger( 'did-interval-scroll' );

			}

		}, 250 );

	},

} // eksell.intervalScroll


/*	-----------------------------------------------------------------------------------------------
	Toggles
--------------------------------------------------------------------------------------------------- */

eksell.toggles = {

	init: function() {

		// Do the toggle.
		eksell.toggles.toggle();

		// Check for toggle/untoggle on resize.
		eksell.toggles.resizeCheck();

		// Check for untoggle on escape key press.
		eksell.toggles.untoggleOnEscapeKeyPress();

	},

	// Do the toggle.
	toggle: function() {

		$( '*[data-toggle-target]' ).on( 'click', function( e ) {

			// Get our targets
			var $toggle 		= $( this ),
				targetString 	= $( this ).data( 'toggle-target' ),
				$target 		= $( targetString );

			// Trigger events on the toggle targets before they are toggled.
			if ( $target.is( '.active' ) ) {
				$target.trigger( 'toggle-target-before-active' );
			} else {
				$target.trigger( 'toggle-target-before-inactive' );
			}

			// For cover modals, set a short timeout duration so the class animations have time to play out.
			var timeOutTime = $target.hasClass( 'cover-modal' ) ? 5 : 0;

			setTimeout( function() {

				// Toggle the target of the clicked toggle.
				if ( $toggle.data( 'toggle-type' ) == 'slidetoggle' ) {
					var duration = $toggle.data( 'toggle-duration' ) ? $toggle.data( 'toggle-duration' ) : 250;
					if ( $( 'body' ).hasClass( 'has-anim' ) ) {
						$target.slideToggle( duration );
					} else {
						$target.toggle();
					}
				} else {
					$target.toggleClass( 'active' );
				}

				// Toggle all toggles with this toggle target.
				$( '*[data-toggle-target="' + targetString + '"]' ).toggleClass( 'active' );

				// Toggle aria-expanded on the target.
				eksellToggleAttribute( $target, 'aria-expanded', 'true', 'false' );

				// Toggle aria-pressed on the toggle.
				eksellToggleAttribute( $toggle, 'aria-pressed', 'true', 'false' );

				// Toggle body class.
				if ( $toggle.data( 'toggle-body-class' ) ) {
					$( 'body' ).toggleClass( $toggle.data( 'toggle-body-class' ) );
				}

				// Check whether to lock the screen.
				if ( $toggle.data( 'lock-screen' ) ) {
					eksell.scrollLock.setTo( true );
				} else if ( $toggle.data( 'unlock-screen' ) ) {
					eksell.scrollLock.setTo( false );
				} else if ( $toggle.data( 'toggle-screen-lock' ) ) {
					eksell.scrollLock.setTo();
				}

				// Check whether to set focus.
				if ( $toggle.data( 'set-focus' ) ) {
					var $focusElement = $( $toggle.data( 'set-focus' ) );
					if ( $focusElement.length ) {
						if ( $toggle.is( '.active' ) ) {
							$focusElement.focus();
						} else {
							$focusElement.blur();
						}
					}
				}

				// Trigger the toggled event on the toggle target.
				$target.trigger( 'toggled' );

				// Trigger events on the toggle targets after they are toggled.
				if ( $target.is( '.active' ) ) {
					$target.trigger( 'toggle-target-after-active' );
				} else {
					$target.trigger( 'toggle-target-after-inactive' );
				}

			}, timeOutTime );

			return false;

		} );
	},

	// Check for toggle/untoggle on screen resize.
	resizeCheck: function() {

		if ( $( '*[data-untoggle-above], *[data-untoggle-below], *[data-toggle-above], *[data-toggle-below]' ).length ) {

			$win.on( 'resize', function() {

				var winWidth = $win.width(),
					$toggles = $( '.toggle' );

				$toggles.each( function() {

					$toggle = $( this );

					var unToggleAbove = $toggle.data( 'untoggle-above' ),
						unToggleBelow = $toggle.data( 'untoggle-below' ),
						toggleAbove = $toggle.data( 'toggle-above' ),
						toggleBelow = $toggle.data( 'toggle-below' );

					// If no width comparison is set, continue
					if ( ! unToggleAbove && ! unToggleBelow && ! toggleAbove && ! toggleBelow ) {
						return;
					}

					// If the toggle width comparison is true, toggle the toggle
					if ( 
						( ( ( unToggleAbove && winWidth > unToggleAbove ) ||
						( unToggleBelow && winWidth < unToggleBelow ) ) &&
						$toggle.hasClass( 'active' ) )
						||
						( ( ( toggleAbove && winWidth > toggleAbove ) ||
						( toggleBelow && winWidth < toggleBelow ) ) &&
						! $toggle.hasClass( 'active' ) )
					) {
						$toggle.trigger( 'click' );
					}

				} );

			} );

		}

	},

	// Close toggle on escape key press.
	untoggleOnEscapeKeyPress: function() {

		$doc.keyup( function( e ) {
			if ( e.key === "Escape" ) {

				$( '*[data-untoggle-on-escape].active' ).each( function() {
					if ( $( this ).hasClass( 'active' ) ) {
						$( this ).trigger( 'click' );
					}
				} );
					
			}
		} );

	},

} // eksell.toggles


/*	-----------------------------------------------------------------------------------------------
	Cover Modals
--------------------------------------------------------------------------------------------------- */

eksell.coverModals = {

	init: function () {

		if ( $( '.cover-modal' ).length ) {

			// Handle cover modals when they're toggled.
			eksell.coverModals.onToggle();

			// When toggled, untoggle if visitor clicks on the wrapping element of the modal.
			eksell.coverModals.outsideUntoggle();

			// Close on escape key press.
			eksell.coverModals.closeOnEscape();

			// Hide and show modals before and after their animations have played out.
			eksell.coverModals.hideAndShowModals();

		}

	},

	// Handle cover modals when they're toggled.
	onToggle: function() {

		$( '.cover-modal' ).on( 'toggled', function() {

			var $modal = $( this ),
				$body = $( 'body' );

			if ( $modal.hasClass( 'active' ) ) {
				$body.addClass( 'showing-modal' );
			} else {
				$body.removeClass( 'showing-modal' ).addClass( 'hiding-modal' );

				// Remove the hiding class after a delay, when animations have been run
				setTimeout ( function() {
					$body.removeClass( 'hiding-modal' );
				}, 500 );
			}
		} );

	},

	// Close modal on outside click.
	outsideUntoggle: function() {

		$doc.on( 'click', function( e ) {

			var $target = $( e.target ),
				modal = '.cover-modal.active';

			if ( $target.is( modal ) ) {

				eksell.coverModals.untoggleModal( $target );

			}

		} );

	},

	// Close modal on escape key press.
	closeOnEscape: function() {

		$doc.keyup( function( e ) {
			if ( e.key === "Escape" ) {
				$( '.cover-modal.active' ).each( function() {
					eksell.coverModals.untoggleModal( $( this ) );
				} );
			}
		} );

	},

	// Hide and show modals before and after their animations have played out.
	hideAndShowModals: function() {

		var $modals = $( '.cover-modal' );

		// Show the modal.
		$modals.on( 'toggle-target-before-inactive', function( e ) {
			if ( e.target != this ) return;
			$( this ).addClass( 'show-modal' );
		} );

		// Hide the modal after a delay, so animations have time to play out.
		$modals.on( 'toggle-target-after-inactive', function( e ) {
			if ( e.target != this ) return;

			var $modal = $( this );
			setTimeout( function() {
				$modal.removeClass( 'show-modal' );
			}, 250 );
		} );

	},

	// Untoggle a modal.
	untoggleModal: function( $modal ) {

		$modalToggle = false;

		// If the modal has specified the string (ID or class) used by toggles to target it, untoggle the toggles with that target string.
		// The modal-target-string must match the string toggles use to target the modal.
		if ( $modal.data( 'modal-target-string' ) ) {
			var modalTargetClass = $modal.data( 'modal-target-string' ),
				$modalToggle = $( '*[data-toggle-target="' + modalTargetClass + '"]' ).first();
		}

		// If a modal toggle exists, trigger it so all of the toggle options are included.
		if ( $modalToggle && $modalToggle.length ) {
			$modalToggle.trigger( 'click' );

		// If one doesn't exist, just hide the modal.
		} else {
			$modal.removeClass( 'active' );
		}

	}

} // eksell.coverModals


/*	-----------------------------------------------------------------------------------------------
	Stick Me
--------------------------------------------------------------------------------------------------- */

eksell.stickMe = {

	init: function() {

		var $stickyElement = $( '.stick-me' );

		if ( $stickyElement.length ) {

			var stickyClass = 'is-sticky',
				stickyOffset = $stickyElement.scrollTop();

			// Our stand-in element for stickyElement while stickyElement is off on a scroll.
			if ( ! $( '.sticky-adjuster' ).length ) {
				$stickyElement.before( '<div class="sticky-adjuster"></div>' );
			}

			// Stick it on resize, scroll and load.
			$win.on( 'resize scroll load', function() {
				var stickyOffset = $( '.sticky-adjuster' ).offset().top;
				eksell.stickMe.stickIt( $stickyElement, stickyClass, stickyOffset );
			} );

			eksell.stickMe.stickIt( $stickyElement, stickyClass, stickyOffset );

		}

	},

	// Check whether to stick the element.
	stickIt: function ( $stickyElement, stickyClass, stickyOffset ) {

		var winScroll = $win.scrollTop();

		if ( $stickyElement.css( 'display' ) != 'none' && winScroll > stickyOffset ) {

			// If a sticky edge element exists and we've scrolled past it, stick it.
			if ( ! $stickyElement.hasClass( stickyClass ) ) {
				$stickyElement.addClass( stickyClass );
				$( '.sticky-adjuster' ).height( $stickyElement.outerHeight() ).css( 'margin-bottom', parseInt( $stickyElement.css( 'marginBottom' ) ) );
				if ( $stickyElement.is( '.header-inner' ) ) {
					$( 'body' ).addClass( 'header-is-sticky' );
				}
			}

		// If not, remove class and sticky-adjuster properties.
		} else {
			eksell.stickMe.unstickIt( $stickyElement, stickyClass );
		}

	},

	unstickIt: function( $stickyElement, stickyClass ) {

		$stickyElement.removeClass( stickyClass );
		$( '.sticky-adjuster' ).height( 0 ).css( 'margin-bottom', '0' );

		if ( $stickyElement.is( '.header-inner' ) ) {
			$( 'body' ).removeClass( 'header-is-sticky' );
		}

	}

} // Stick Me


/*	-----------------------------------------------------------------------------------------------
	Intrinsic Ratio Embeds
--------------------------------------------------------------------------------------------------- */

eksell.instrinsicRatioVideos = {

	init: function() {

		eksell.instrinsicRatioVideos.makeFit();

		$win.on( 'resize fit-videos', function() {
			eksell.instrinsicRatioVideos.makeFit();
		} );

	},

	makeFit: function() {

		var vidSelector = "iframe, object, video";

		$( vidSelector ).each( function() {

			var $video = $( this ),
				$container = $video.parent(),
				iTargetWidth = $container.width();

			// Skip videos we want to ignore.
			if ( $video.hasClass( 'intrinsic-ignore' ) || $video.parent().hasClass( 'intrinsic-ignore' ) ) {
				return true;
			}

			if ( ! $video.attr( 'data-origwidth' ) ) {

				// Get the video element proportions.
				$video.attr( 'data-origwidth', $video.attr( 'width' ) );
				$video.attr( 'data-origheight', $video.attr( 'height' ) );

			}

			// Get ratio from proportions.
			var ratio = iTargetWidth / $video.attr( 'data-origwidth' );

			// Scale based on ratio, thus retaining proportions.
			$video.css( 'width', iTargetWidth + 'px' );
			$video.css( 'height', ( $video.attr( 'data-origheight' ) * ratio ) + 'px' );

		} );

	}

} // eksell.instrinsicRatioVideos


/*	-----------------------------------------------------------------------------------------------
	Scroll Lock
--------------------------------------------------------------------------------------------------- */

eksell.scrollLock = {

	init: function() {

		// Initialize variables.
		window.scrollLocked = false,
		window.prevScroll = {
			scrollLeft : $win.scrollLeft(),
			scrollTop  : $win.scrollTop()
		},
		window.prevLockStyles = {},
		window.lockStyles = {
			'overflow-y' : 'scroll',
			'position'   : 'fixed',
			'width'      : '100%'
		};

		// Instantiate cache in case someone tries to unlock before locking.
		eksell.scrollLock.saveStyles();

	},

	// Save context's inline styles in cache.
	saveStyles: function() {

		var styleAttr = $( 'html' ).attr( 'style' ),
			styleStrs = [],
			styleHash = {};

		if ( ! styleAttr ) {
			return;
		}

		styleStrs = styleAttr.split( /;\s/ );

		$.each( styleStrs, function serializeStyleProp( styleString ) {
			if ( ! styleString ) {
				return;
			}

			var keyValue = styleString.split( /\s:\s/ );

			if ( keyValue.length < 2 ) {
				return;
			}

			styleHash[ keyValue[ 0 ] ] = keyValue[ 1 ];
		} );

		$.extend( prevLockStyles, styleHash );
	},

	// Lock the scroll
	lock: function() {

		var appliedLock = {};

		if ( scrollLocked ) {
			return;
		}

		// Save scroll state and styles
		prevScroll = {
			scrollLeft : $win.scrollLeft(),
			scrollTop  : $win.scrollTop()
		};

		eksell.scrollLock.saveStyles();

		// Compose our applied CSS, with scroll state as styles.
		$.extend( appliedLock, lockStyles, {
			'left' : - prevScroll.scrollLeft + 'px',
			'top'  : - prevScroll.scrollTop + 'px'
		} );

		// Then lock styles and state.
		$( 'html' ).css( appliedLock );
		$( 'html' ).addClass( 'scroll-locked' );
		$( 'html' ).attr( 'scroll-lock-top', prevScroll.scrollTop );
		$win.scrollLeft( 0 ).scrollTop( 0 );

		window.scrollLocked = true;
	},

	// Unlock the scroll.
	unlock: function() {

		if ( ! window.scrollLocked ) {
			return;
		}

		// Revert styles and state.
		$( 'html' ).attr( 'style', $( '<x>' ).css( prevLockStyles ).attr( 'style' ) || '' );
		$( 'html' ).removeClass( 'scroll-locked' );
		$( 'html' ).attr( 'scroll-lock-top', '' );
		$win.scrollLeft( prevScroll.scrollLeft ).scrollTop( prevScroll.scrollTop );

		window.scrollLocked = false;
	},

	// Call this to lock or unlock the scroll.
	setTo: function( on ) {

		// If an argument is passed, lock or unlock accordingly.
		if ( arguments.length ) {
			if ( on ) {
				eksell.scrollLock.lock();
			} else {
				eksell.scrollLock.unlock();
			}
			// If not, toggle to the inverse state.
		} else {
			if ( window.scrollLocked ) {
				eksell.scrollLock.unlock();
			} else {
				eksell.scrollLock.lock();
			}
		}

	},

} // eksell.scrollLock


/*	-----------------------------------------------------------------------------------------------
	Focus Management
--------------------------------------------------------------------------------------------------- */

eksell.focusManagement = {

	init: function() {

		// If the visitor tabs out of the search modal, return focus to the search field.
		eksell.focusManagement.focusLoop();

	},

	focusLoop: function() {
		$( 'a' ).on( 'focus', function() {
			if ( $( '.search-modal' ).is( '.active' ) ) {
				if ( ! $( this ).parents( '.search-modal' ).length ) {
					$( '.search-modal .search-field' ).focus();
				}
			}
		} );
	}

} // eksell.focusManagement


/*	-----------------------------------------------------------------------------------------------
	Main Menu
--------------------------------------------------------------------------------------------------- */

eksell.mainMenu = {

	init: function() {

		// If the current menu item is in a sub level, expand all the levels higher up on load.
		eksell.mainMenu.expandLevel();

	},

	// If the current menu item is in a sub level, expand all the levels higher up on load.
	expandLevel: function() {
		var $activeMenuItem = $( '.main-menu .current-menu-item' );

		if ( $activeMenuItem.length !== false ) {
			$activeMenuItem.parents( 'li' ).each( function() {
				$subMenuToggle = $( this ).find( '.sub-menu-toggle' ).first();
				if ( $subMenuToggle.length ) {
					$subMenuToggle.trigger( 'click' );
				}
			} )
		}
	},

} // eksell.mainMenu


/*	-----------------------------------------------------------------------------------------------
	Load More
--------------------------------------------------------------------------------------------------- */

eksell.loadMore = {

	init: function() {

		var $pagination = $( '#pagination' );

		// First, check that there's a pagination.
		if ( $pagination.length ) {

			// Default values for variables.
			window.eksellIsLoading = false;
			window.eksellIsLastPage = $( '.pagination-wrapper' ).hasClass( 'last-page' );

			eksell.loadMore.prepare( $pagination );

		}

		// When the pagination query args are updated, reset the posts to reflect the new pagination
		$win.on( 'reset-posts', function() {

			// Fade out existing posts.
			$( $pagination.data( 'load-more-target' ) ).find( '.article-wrapper' ).animate( { opacity: 0 }, 300, 'linear' );

			// Reset posts.
			eksell.loadMore.prepare( $pagination, resetPosts = true );
		} );

	},

	prepare: function( $pagination, resetPosts ) {

		// Default resetPosts to false.
		if ( typeof resetPosts === 'undefined' || ! resetPosts ) {
			resetPosts = false;
		}

		// Get the query arguments from the pagination element.
		var queryArgs = JSON.parse( $pagination.attr( 'data-query-args' ) );

		// If we're resetting posts, reset them.
		if ( resetPosts ) {
			eksell.loadMore.loadPosts( $pagination, resetPosts );
		}

		// If not, check the paged value against the max_num_pages.
		else {
			if ( queryArgs.paged == queryArgs.max_num_pages ) {
				$( '.pagination-wrapper' ).addClass( 'last-page' );
			}

			// Get the load more type (button or scroll).
			var loadMoreType = $pagination.data( 'pagination-type' ) ? $pagination.data( 'pagination-type' ) : 'button';

			// Do the appropriate load more detection, depending on the type.
			if ( loadMoreType == 'scroll' ) {
				eksell.loadMore.detectScroll( $pagination );
			} else if ( loadMoreType == 'button' ) {
				eksell.loadMore.detectButtonClick( $pagination );
			}
		}

	},

	// Load more on scroll
	detectScroll: function( $pagination, query_args ) {

		$win.on( 'did-interval-scroll', function() {

			// If it's the last page, or we're already loading, we're done here.
			if ( eksellIsLastPage || eksellIsLoading ) {
				return;
			}

			var paginationOffset 	= $pagination.offset().top,
				winOffset 			= $win.scrollTop() + $win.outerHeight();

			// If the bottom of the window is below the top of the pagination, start loading.
			if ( ( winOffset > paginationOffset ) ) {
				eksell.loadMore.loadPosts( $pagination, query_args );
			}

		} );

	},

	// Load more on click.
	detectButtonClick: function( $pagination, query_args ) {

		// Load on click.
		$( '#load-more' ).on( 'click', function() {

			// Make sure we aren't already loading.
			if ( eksellIsLoading ) return;

			eksell.loadMore.loadPosts( $pagination, query_args );
			return false;
		} );

	},

	// Load the posts
	loadPosts: function( $pagination, resetPosts ) {

		// Default resetPosts to false.
		if ( typeof resetPosts === 'undefined' || ! resetPosts ) {
			resetPosts = false;
		}

		// Get the query arguments.
		var queryArgs 			= $pagination.attr( 'data-query-args' ),
			queryArgsParsed 	= JSON.parse( queryArgs ),
			$paginationWrapper 	= $( '.pagination-wrapper' ),
			$articleWrapper 	= $( $pagination.data( 'load-more-target' ) );

		// We're now loading.
		eksellIsLoading = true;
		$paginationWrapper.addClass( 'loading' );

		// If we're not resetting posts, increment paged (reset = initial paged is correct).
		if ( ! resetPosts ) {
			queryArgsParsed.paged++;
		} else {
			queryArgsParsed.paged = 1;
		}

		// Prepare the query args for submission.
		var jsonQueryArgs = JSON.stringify( queryArgsParsed );

		$.ajax({
			url: eksell_ajax_load_more.ajaxurl,
			type: 'post',
			data: {
				action: 'eksell_ajax_load_more',
				json_data: jsonQueryArgs
			},
			success: function( result ) {

				// Get the results.
				var $result = $( result );

				// If we're resetting posts, remove the existing posts.
				if ( resetPosts ) {
					$articleWrapper.find( '*:not(.grid-sizer)' ).remove();
				}

				// If there are no results, we're at the last page.
				if ( ! $result.length ) {
					eksellIsLoading = false;
					$articleWrapper.addClass( 'no-results' );
					$paginationWrapper.addClass( 'last-page' ).removeClass( 'loading' );
				}

				if ( $result.length ) {

					$articleWrapper.removeClass( 'no-results' );

					// Add the paged attribute to the articles, used by updateHistoryOnScroll().
					$result.find( 'article' ).each( function() {
						$( this ).attr( 'data-post-paged', queryArgsParsed.paged );
					} );

					// Wait for the images to load.
					$result.imagesLoaded( function() {

						// Append the results.
						$articleWrapper.append( $result ).masonry( 'appended', $result ).masonry();

						$win.trigger( 'ajax-content-loaded' );
						$win.trigger( 'did-interval-scroll' );

						// We're now finished with the loading.
						eksellIsLoading = false;
						$paginationWrapper.removeClass( 'loading' );

						// Update the pagination query args.
						$pagination.attr( 'data-query-args', jsonQueryArgs );

						$( 'body' ).removeClass( 'filtering-posts' );

						// If that was the last page, make sure we don't check for more.
						if ( queryArgsParsed.paged == queryArgsParsed.max_num_pages ) {
							$paginationWrapper.addClass( 'last-page' );
							eksellIsLastPage = true;
							return;

						// If not, make sure the pagination is visible again.
						} else {
							$paginationWrapper.removeClass( 'last-page' );
							eksellIsLastPage = false;
						}

					} );

				}

			},

			error: function( jqXHR, exception ) {
				eksellAjaxErrors( jqXHR, exception );
			}
		} );

	},

} // eksell.loadMore


/*	-----------------------------------------------------------------------------------------------
	Filters
--------------------------------------------------------------------------------------------------- */

eksell.filters = {

	init: function() {

		$doc.on( 'click', '.filter-link', function() {

			if ( $( this ).hasClass( 'active' ) ) return false;

			$( 'body' ).addClass( 'filtering-posts' );

			var $link 		= $( this ),
				termId 		= $link.data( 'filter-term-id' ) ? $link.data( 'filter-term-id' ) : null,
				taxonomy 	= $link.data( 'filter-taxonomy' ) ? $link.data( 'filter-taxonomy' ) : null,
				postType 	= $link.data( 'filter-post-type' ) ? $link.data( 'filter-post-type' ) : '';

			$link.addClass( 'pre-active' );

			$.ajax({
				url: eksell_ajax_filters.ajaxurl,
				type: 'post',
				data: {
					action: 	'eksell_ajax_filters',
					post_type: 	postType,
					term_id: 	termId,
					taxonomy: 	taxonomy,
				},
				success: function( result ) {

					// Add them to the pagination.
					$( '#pagination' ).attr( 'data-query-args', result );

					// Reset the posts.
					$win.trigger( 'reset-posts' );

					// Update active class.
					$( '.filter-link' ).removeClass( 'pre-active active' );
					$link.addClass( 'active' );
	
				},
	
				error: function( jqXHR, exception ) {
					eksellAJAXErrors( jqXHR, exception );
				}
			} );

			return false;

		} );

	}

} // eksell.filters


/*	-----------------------------------------------------------------------------------------------
	Element In View
--------------------------------------------------------------------------------------------------- */

eksell.elementInView = {

	init: function() {

		$targets = $( 'body.has-anim .do-spot' );
		eksell.elementInView.run( $targets );

		// Rerun on AJAX content loaded.
		$win.on( 'ajax-content-loaded', function() {
			$targets = $( 'body.has-anim .do-spot' );
			eksell.elementInView.run( $targets );
		} );

	},

	run: function( $targets ) {

		if ( $targets.length ) {

			// Add class indicating the elements will be spotted.
			$targets.each( function() {
				$( this ).addClass( 'will-be-spotted' );
			} );

			eksell.elementInView.handleFocus( $targets );

			$win.on( 'load resize orientationchange did-interval-scroll', function() {
				eksell.elementInView.handleFocus( $targets );
			} );

		}

	},

	handleFocus: function( $targets ) {

		// Check for our targets.
		$targets.each( function() {

			var $this = $( this );

			if ( eksell.elementInView.isVisible( $this, checkAbove = true ) ) {
				$this.addClass( 'spotted' ).trigger( 'spotted' );
			}

		} );

	},

	// Determine whether the element is in view.
	isVisible: function( $elem, checkAbove ) {

		if ( typeof checkAbove === 'undefined' ) {
			checkAbove = false;
		}

		var winHeight 				= $win.height();

		var docViewTop 				= $win.scrollTop(),
			docViewBottom			= docViewTop + winHeight,
			docViewLimit 			= docViewBottom - 50;

		var elemTop 				= $elem.offset().top;

		// If checkAbove is set to true, which is default, return true if the browser has already scrolled past the element.
		if ( checkAbove && ( elemTop <= docViewBottom ) ) {
			return true;
		}

		// If not, check whether the scroll limit exceeds the element top.
		return ( docViewLimit >= elemTop );

	}

} // eksell.elementInView


/*	-----------------------------------------------------------------------------------------------
	Masonry
--------------------------------------------------------------------------------------------------- */

eksell.masonry = {

	init: function() {

		var $wrapper = $( '.posts-grid' );

		if ( $wrapper.length ) {

			$wrapper.imagesLoaded( function() {

				$grid = $wrapper.masonry( {
					columnWidth: 		'.grid-sizer',
					itemSelector: 		'.article-wrapper',
					percentPosition: 	true,
					stagger:			0,
					transitionDuration: 0,
				} );

				// Trigger will-be-spotted elements.
				$grid.on( 'layoutComplete', function() {
					$win.trigger( 'scroll' );
				} );

				// Check for Masonry layout changes on an interval. Accounts for DOM changes caused by lazyloading plugins.
				// The interval is cleared when all previews have been spotted.
				eksell.masonry.intervalUpdate( $grid );

				// Reinstate the interval when new content is loaded.
				$win.on( 'ajax-content-loaded', function() {
					eksell.masonry.intervalUpdate( $grid );
				} );

			} );

		}

	},

	intervalUpdate: function( $grid ) {

		var masonryLayoutInterval = setInterval( function() {

			$grid.masonry();

			// Clear the interval when all previews have been spotted.
			if ( ! $( '.preview.do-spot:not(.spotted)' ).length ) clearInterval( masonryLayoutInterval );

		}, 1000 );

	}

} // eksell.masonry


/*	-----------------------------------------------------------------------------------------------
	Dynamic Heights
--------------------------------------------------------------------------------------------------- */

eksell.dynamicHeights = {

	init: function() {

		eksell.dynamicHeights.resize();

		$win.on( 'resize orientationchange', function() {
			eksell.dynamicHeights.resize();
		} );

	},

	resize: function() {

		var $header 	= $( '#site-header' ),
			$footer 	= $( '#site-footer' ),
			$content 	= $( '#site-content' )
			
		var headerHeight = $header.outerHeight(),
			contentHeight = $win.outerHeight() - headerHeight - parseInt( $header.css( 'marginBottom' ) ) - $footer.outerHeight() - parseInt( $footer.css( 'marginTop' ) );

		// Set a min-height for the content.
		$content.css( 'min-height', contentHeight );

		// Set the desktop navigation toggle and search modal field to match the header height, including line-height of pseudo (thanks, Firefox).
		$( '#site-aside .nav-toggle-inner' ).css( 'height', headerHeight );
		$( '.search-modal .search-field' ).css( 'height', headerHeight );
		$( '<style>.modal-search-form .search-field::-moz-placeholder { line-height: ' + headerHeight + 'px }</style>' ).appendTo( 'head' );

	}

} // eksell.dynamicHeights


/*	-----------------------------------------------------------------------------------------------
	Function Calls
--------------------------------------------------------------------------------------------------- */

$doc.ready( function() {

	eksell.intervalScroll.init();			// Check for scroll on an interval.
	eksell.toggles.init();					// Handle toggles.
	eksell.coverModals.init();				// Handle cover modals.
	eksell.elementInView.init();			// Check if elements are in view.
	eksell.instrinsicRatioVideos.init();	// Retain aspect ratio of videos on window resize.
	eksell.stickMe.init();					// Stick elements on scroll.
	eksell.scrollLock.init();				// Scroll Lock.
	eksell.mainMenu.init();					// Main Menu.
	eksell.focusManagement.init();			// Focus Management.
	eksell.loadMore.init();					// Load More.
	eksell.filters.init();					// Filters.
	eksell.masonry.init();					// Masonry.
	eksell.dynamicHeights.init();			// Dynamic Heights.

	// Call css-vars-ponyfill.
	cssVars();

} );