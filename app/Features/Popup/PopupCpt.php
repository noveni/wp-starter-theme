<?php

namespace Features\Popup;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Features\Popup\PopupCpt' ) ) {

	class PopupCpt extends \PostType\BasePostType
	{

		 /** 
		 * Constructor. This allows the class to be only initialized once.
		 */
		protected function setConfigurations() {
			$this->type = 'ecrannoir_popup_pt';
			$this->configuration_post_type = $this->getConfiguration();
		}

		public function getConfiguration() {
			$labels = array(
				'name'                      => __( 'Popups', 'app' ),
				'singular_name'             => __( 'Popup', 'app' ),
				'add_new'                   => __( 'Add New', 'app' ),
				'add_new_item'              => __( 'Add new Popup', 'app' ),
				'view_item'                 => __( 'View Popup', 'app' ),
				'edit_item'                 => __( 'Edit Popup', 'app' ),
				'new_item'                  => __( 'New Popup', 'app' ),
				'view_item'                 => __( 'View Popup', 'app' ),
				'search_items'              => __( 'Search Popups', 'app' ),
				'not_found'                 => __( 'No Popups found', 'app' ),
				'not_found_in_trash'        => __( 'No Popups found in trash', 'app' ),
				'all_items'                 => __( 'All Popups', 'ecrannoir'),
				'archives'                  => __( 'Popup Archives ', 'ecrannoir'),
				'menu_name'                 => __( 'Popups', 'ecrannoir'),
				'items_list_navigation'     => __( 'Popups list navigation', 'ecrannoir'),
				'items_list'                => __( 'Popups list', 'ecrannoir'),
				'item_published'            => __( 'Popup published.', 'ecrannoir'),
				'item_published_privately'  => __( 'Popup published privately.', 'ecrannoir'),
				'item_reverted_to_draft'    => __( 'Popup reverted to draft.', 'ecrannoir'),
				'item_scheduled'            => __( 'Popup scheduled.', 'ecrannoir'),
				'item_updated'              => __( 'Popup updated.', 'ecrannoir'),
			);
	
			$args = array(
				'labels'                    => $labels,
				'public'                    => true,
				'show_in_rest'              => true,
				'menu_position'             => 5, 
				'menu_icon'                 => 'dashicons-admin-post',
				'supports'                  => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'excerpt', 'custom-fields' ),
				'has_archive'               => false,
				'exclude_from_search'       => false,
				'show_ui'                   => true,
				'capability_type'           => 'post',
				'hierarchical'              => false,
				'query_var'                 => true,
			);
	
			return $args;
	
		}

		public function setMeta() {
			register_post_meta( $this->type, $this->type .'_date_start', array(
				'show_in_rest' => true,
				'single' => true,
				'type' => 'string',
			) );
			register_post_meta( $this->type, $this->type .'_date_end', array(
				'show_in_rest' => true,
				'single' => true,
				'type' => 'string',
			) );		
		}
		
	}
	
}
