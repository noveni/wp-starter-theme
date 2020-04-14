<?php
/**
 * Post Meta
 */



/**
 * Get and Output Post Meta.
 * If it's a single post, output the post meta values specified in the Customizer settings.
 *
 * @param int    $post_id The ID of the post for which the post meta should be output.
 * @param string $location Which post meta location to output – single or preview.
 */
function ecrannoir_the_post_meta( $post_id = null, $location = 'single-top' ) {

	echo ecrannoir_get_post_meta( $post_id, $location ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in ecrannoir_get_post_meta().

}

/**
 * Get the post meta.
 *
 * @param int    $post_id The ID of the post.
 * @param string $location The location where the meta is shown.
 */
function ecrannoir_get_post_meta( $post_id = null, $location = 'single-top' ) {

	// Require post ID.
	if ( ! $post_id ) {
		return;
	}

	/**
	 * Filters post types array
	 *
	 * This filter can be used to hide post meta information of post, page or custom post type registerd by child themes or plugins
	 *
	 * @since 1.0.0
	 *
	 * @param array Array of post types
	 */
	$disallowed_post_types = apply_filters( 'ecrannoir_disallowed_post_types_for_meta_output', array( 'page' ) );
	// Check whether the post type is allowed to output post meta.
	if ( in_array( get_post_type( $post_id ), $disallowed_post_types, true ) ) {
		return;
	}

	$post_meta_wrapper_classes = '';
	$post_meta_classes         = '';

	// Get the post meta settings for the location specified.
	if ( 'single-top' === $location ) {
		/**
		* Filters post meta info visibility
		*
		* Use this filter to hide post meta information like Author, Post date, Comments, Is sticky status
		*
		* @since 1.0.0
		*
		* @param array $args {
		*  @type string 'author'
		*  @type string 'post-date'
		*  @type string 'comments'
		*  @type string 'sticky'
		* }
		*/
		$post_meta = apply_filters(
			'ecrannoir_post_meta_location_single_top',
			array(
				'post-date',
				'sticky',
			)
		);

		$post_meta_wrapper_classes = ' post-meta-single post-meta-single-top';

	} elseif ( 'single-bottom' === $location ) {

		/**
		* Filters post tags visibility
		*
		* Use this filter to hide post tags
		*
		* @since 1.0.0
		*
		* @param array $args {
		*   @type string 'tags'
		* }
		*/
		$post_meta = apply_filters(
			'ecrannoir_post_meta_location_single_bottom',
			array(
				'tags',
			)
		);

		$post_meta_wrapper_classes = ' post-meta-single post-meta-single-bottom';

	}

	// If the post meta setting has the value 'empty', it's explicitly empty and the default post meta shouldn't be output.
	if ( $post_meta && ! in_array( 'empty', $post_meta, true ) ) {

		// Make sure we don't output an empty container.
		$has_meta = false;

		global $post;
		$the_post = get_post( $post_id );
		setup_postdata( $the_post );

		ob_start();

		?>

		<div class="post-meta-wrapper<?php echo esc_attr( $post_meta_wrapper_classes ); ?>">

			<ul class="post-meta<?php echo esc_attr( $post_meta_classes ); ?>">

				<?php

				/**
				 * Fires before post meta html display.
				 *
				 * Allow output of additional post meta info to be added by child themes and plugins.
				 *
				 * @since 1.0.0
				 * @since Twenty Twenty 1.1 Added the `$post_meta` and `$location` parameters.
				 *
				 * @param int    $post_id   Post ID.
				 * @param array  $post_meta An array of post meta information.
				 * @param string $location  The location where the meta is shown.
				 *                          Accepts 'single-top' or 'single-bottom'.
				 */
				do_action( 'ecrannoir_start_of_post_meta_list', $post_id, $post_meta, $location );

				// Author.
				if ( in_array( 'author', $post_meta, true ) ) {

					$has_meta = true;
					?>
					<li class="post-author meta-wrapper">
						<span class="meta-icon">
							<span class="screen-reader-text"><?php _e( 'Post author', 'ecrannoir' ); ?></span>
							<?php ecrannoir_the_theme_svg( 'user' ); ?>
						</span>
						<span class="meta-text">
							<?php
							printf(
								/* translators: %s: Author name */
								__( 'By %s', 'ecrannoir' ),
								'<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author_meta( 'display_name' ) ) . '</a>'
							);
							?>
						</span>
					</li>
					<?php

				}

				// Post date.
				if ( in_array( 'post-date', $post_meta, true ) ) {

					$has_meta = true;
					?>
					<li class="post-date meta-wrapper">
						<span class="meta-icon">
							<span class="screen-reader-text"><?php _e( 'Post date', 'ecrannoir' ); ?></span>
							<?php ecrannoir_the_theme_svg( 'calendar' ); ?>
						</span>
						<span class="meta-text">
							<a href="<?php the_permalink(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a>
						</span>
					</li>
					<?php

				}

				// Categories.
				if ( in_array( 'categories', $post_meta, true ) && has_category() ) {

					$has_meta = true;
					?>
					<li class="post-categories meta-wrapper">
						<span class="meta-icon">
							<span class="screen-reader-text"><?php _e( 'Categories', 'ecrannoir' ); ?></span>
							<?php ecrannoir_the_theme_svg( 'folder' ); ?>
						</span>
						<span class="meta-text">
							<?php _ex( 'In', 'A string that is output before one or more categories', 'ecrannoir' ); ?> <?php the_category( ', ' ); ?>
						</span>
					</li>
					<?php

				}

				// Tags.
				if ( in_array( 'tags', $post_meta, true ) && has_tag() ) {

					$has_meta = true;
					?>
					<li class="post-tags meta-wrapper">
						<span class="meta-icon">
							<span class="screen-reader-text"><?php _e( 'Tags', 'ecrannoir' ); ?></span>
							<?php ecrannoir_the_theme_svg( 'tag' ); ?>
						</span>
						<span class="meta-text">
							<?php the_tags( '', ', ', '' ); ?>
						</span>
					</li>
					<?php

				}

				// Comments link.
				if ( in_array( 'comments', $post_meta, true ) && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {

					$has_meta = true;
					?>
					<li class="post-comment-link meta-wrapper">
						<span class="meta-icon">
							<?php ecrannoir_the_theme_svg( 'comment' ); ?>
						</span>
						<span class="meta-text">
							<?php comments_popup_link(); ?>
						</span>
					</li>
					<?php

				}

				// Sticky.
				if ( in_array( 'sticky', $post_meta, true ) && is_sticky() ) {

					$has_meta = true;
					?>
					<li class="post-sticky meta-wrapper">
						<span class="meta-icon">
							<?php ecrannoir_the_theme_svg( 'bookmark' ); ?>
						</span>
						<span class="meta-text">
							<?php _e( 'Sticky post', 'ecrannoir' ); ?>
						</span>
					</li>
					<?php

				}

				/**
				 * Fires after post meta html display.
				 *
				 * Allow output of additional post meta info to be added by child themes and plugins.
				 *
				 * @since 1.0.0
				 * @since Twenty Twenty 1.1 Added the `$post_meta` and `$location` parameters.
				 *
				 * @param int    $post_id   Post ID.
				 * @param array  $post_meta An array of post meta information.
				 * @param string $location  The location where the meta is shown.
				 *                          Accepts 'single-top' or 'single-bottom'.
				 */
				do_action( 'ecrannoir_end_of_post_meta_list', $post_id, $post_meta, $location );

				?>

			</ul><!-- .post-meta -->

		</div><!-- .post-meta-wrapper -->

		<?php

		wp_reset_postdata();

		$meta_output = ob_get_clean();

		// If there is meta to output, return it.
		if ( $has_meta && $meta_output ) {

			return $meta_output;

		}
	}

}
