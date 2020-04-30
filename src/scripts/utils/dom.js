/**
 * Is the DOM ready
 *
 * this implementation is coming from https://gomakethings.com/a-native-javascript-equivalent-of-jquerys-ready-method/
 *
 * @param {Function} fn Callback function to run.
 */
export const ecrannoirDomReady = ( cb ) => {
	if ( typeof cb !== 'function' ) {
		return;
	}

	if ( document.readyState === 'interactive' || document.readyState === 'complete' ) {
		return cb();
	}

	document.addEventListener( 'DOMContentLoaded', cb, false );
}

// Add a class to the body for when touch is enabled for browsers that don't support media queries
// for interaction media features. Adapted from <https://codepen.io/Ferie/pen/vQOMmO>
export const touchEnabled = () => {
	const matchMedia = function() {
		// Include the 'heartz' as a way to have a non matching MQ to help terminate the join. See <https://git.io/vznFH>.
		var prefixes = [ '-webkit-', '-moz-', '-o-', '-ms-' ];
		var query = [ '(', prefixes.join( 'touch-enabled),(' ), 'heartz', ')' ].join( '' );
		return window.matchMedia && window.matchMedia( query ).matches;
	};

	if ( ( 'ontouchstart' in window ) || ( window.DocumentTouch && document instanceof window.DocumentTouch ) || matchMedia() ) {
		document.body.classList.add( 'touch-enabled' );
	}
}

export const intrinsicRatioVideos = () => {
	const makeFit = () => {
		document.querySelectorAll( 'iframe, object, video' ).forEach( function( video ) {
			var ratio, iTargetWidth,
				container = video.parentNode;

			// Skip videos we want to ignore
			if ( video.classList.contains( 'intrinsic-ignore' ) || video.parentNode.classList.contains( 'intrinsic-ignore' ) ) {
				return true;
			}

			if ( ! video.dataset.origwidth ) {
				// Get the video element proportions
				video.setAttribute( 'data-origwidth', video.width );
				video.setAttribute( 'data-origheight', video.height );
			}

			iTargetWidth = container.offsetWidth;

			// Get ratio from proportions
			ratio = iTargetWidth / video.dataset.origwidth;

			// Scale based on ratio, thus retaining proportions
			video.style.width = iTargetWidth + 'px';
			video.style.height = ( video.dataset.origheight * ratio ) + 'px';
		} );
	}

	makeFit();
	window.addEventListener( 'resize', () => {
		makeFit();
	});
}


/**
 * traverses the DOM up to find elements matching the query
 *
 * @param {HTMLElement} target
 * @param {string} query
 * @return {NodeList} parents matching query
 */
export const ecrannoirFindParents = ( target, query ) => {
	let parents = [];

	// recursively go up the DOM adding matches to the parents array
	const traverse = ( item ) => {
		var parent = item.parentNode;
		if ( parent instanceof HTMLElement ) {
			if ( parent.matches( query ) ) {
				parents.push( parent );
			}
			traverse( parent );
		}
	}

	traverse( target );

	return parents;
}


export const createEvent = ( eventName ) => {
	let event;
	if ( typeof window.Event === 'function' ) {
		event = new Event( eventName );
	} else {
		event = document.createEvent( 'Event' );
		event.initEvent( eventName, true, false );
	}
	return event;
}
