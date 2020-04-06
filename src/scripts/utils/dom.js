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
