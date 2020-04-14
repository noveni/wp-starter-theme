<?php
/**
 * Twenty Twenty SVG Icon helper functions
 *
 * @package WordPress
 
 * @since 1.0.0
 */

if ( ! function_exists( 'ecrannoir_the_theme_svg' ) ) {
	/**
	 * Output and Get Theme SVG.
	 * Output and get the SVG markup for an icon in the EcranNoir_SVG_Icons class.
	 *
	 * @param string $svg_name The name of the icon.
	 * @param string $group The group the icon belongs to.
	 * @param string $color Color code.
	 */
	function ecrannoir_the_theme_svg( $svg_name, $group = 'ui', $color = '' ) {
		echo ecrannoir_get_theme_svg( $svg_name, $group, $color ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in ecrannoir_get_theme_svg();.
	}
}

if ( ! function_exists( 'ecrannoir_get_theme_svg' ) ) {

	/**
	 * Get information about the SVG icon.
	 *
	 * @param string $svg_name The name of the icon.
	 * @param string $group The group the icon belongs to.
	 * @param string $color Color code.
	 */
	function ecrannoir_get_theme_svg( $svg_name, $group = 'ui', $color = '' ) {

		// Make sure that only our allowed tags and attributes are included.
		$svg = wp_kses(
			EcranNoir_SVG_Icons::get_svg( $svg_name, $group, $color ),
			array(
				'svg'     => array(
					'class'       => true,
					'xmlns'       => true,
					'width'       => true,
					'height'      => true,
					'viewbox'     => true,
					'aria-hidden' => true,
					'role'        => true,
					'focusable'   => true,
				),
				'path'    => array(
					'fill'      => true,
					'fill-rule' => true,
					'd'         => true,
					'transform' => true,
				),
				'polygon' => array(
					'fill'      => true,
					'fill-rule' => true,
					'points'    => true,
					'transform' => true,
					'focusable' => true,
				),
				'circle' => array(
					'stroke'      => true,
					'stroke-width' => true,
					'cx'    => true,
					'cy' => true,
					'r' => true,
					'transform' => true,
					'focusable' => true,
				),
				'g' => array(
					'fill'      => true,
					'fill-rule' => true,
				)
			)
		);

		if ( ! $svg ) {
			return false;
		}
		return $svg;
	}
}
