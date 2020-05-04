<?php

namespace PostType;

/**
 * 
 */

class ExampleCpt extends \PostType\BasePostType
{

    /** 
     * Constructor. This allows the class to be only initialized once.
     */
    protected function setConfigurations() {
        $this->type = 'app_custom_post_type';
        $this->configuration_post_type = $this->getConfiguration();
        $this->configuration_taxonomy = $this->getTaxonomyConfiguration();
    }

    public function getConfiguration() {
        $labels = array(
            'name'                      => __( 'Custom Types', 'app' ),
            'singular_name'             => __( 'Custom Type', 'app' ),
            'add_new'                   => __( 'Add New', 'app' ),
            'add_new_item'              => __( 'Add new Custom Type', 'app' ),
            'view_item'                 => __( 'View Custom Type', 'app' ),
            'edit_item'                 => __( 'Edit Custom Type', 'app' ),
            'new_item'                  => __( 'New Custom Type', 'app' ),
            'view_item'                 => __( 'View Custom Type', 'app' ),
            'search_items'              => __( 'Search Custom Types', 'app' ),
            'not_found'                 => __( 'No custom types found', 'app' ),
            'not_found_in_trash'        => __( 'No custom types found in trash', 'app' ),
            'all_items'                 => __( 'All Custom Types', 'ecrannoir'),
            'archives'                  => __( 'Custom Type Archives ', 'ecrannoir'),
            'menu_name'                 => __( 'Custom Types', 'ecrannoir'),
            'items_list_navigation'     => __( 'Custom Types list navigation', 'ecrannoir'),
            'items_list'                => __( 'Custom Types list', 'ecrannoir'),
            'item_published'            => __( 'Custom Type published.', 'ecrannoir'),
            'item_published_privately'  => __( 'Custom Type published privately.', 'ecrannoir'),
            'item_reverted_to_draft'    => __( 'Custom Type reverted to draft.', 'ecrannoir'),
            'item_scheduled'            => __( 'Custom Type scheduled.', 'ecrannoir'),
            'item_updated'              => __( 'Custom Type updated.', 'ecrannoir'),
        );

        $args = array(
            'labels'                    => $labels,
            'public'                    => true,
            'show_in_rest'              => true,
            'menu_position'             => 5, 
            'menu_icon'                 => 'dashicons-admin-post',
            'supports'                  => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'excerpt', 'revisions' ),
            'taxonomies'                => array('category', 'post_tag', 'term_' . $this->type ),
            'has_archive'               => true,
            'exclude_from_search'       => false,
            'show_ui'                   => true,
            'capability_type'           => 'post',
            'hierarchical'              => false,
            '_edit_link'                => 'post.php?post=%d',
            'query_var'                 => true,
            'template'                  => $this::getTemplateBlock(),
            // 'template_lock'             => 'all', // Verrouiller le modèle pour empêcher les modifications
            'rewrite'                   => array(
                'slug'       => 'custom-post-type',
                'with_front' => false,
            ),
        );

        return $args;

    }

    public function getTaxonomyConfiguration() {

        $this->taxonomy_slug = 'term_';
        
        // Taxonomy Declaration
        $labels = array(
            'name'                          => __( 'Custom Taxonomies', 'app' ),
            'singular_name'                 => __( 'Custom Taxonomy', 'app' ),
            'search_items'                  => __( 'Search Custom Taxonomies', 'app' ),
            'all_items'                     => __( 'All Custom Taxonomies', 'app' ),
            'popular_items'                 => __( 'Popular Custom Taxonomies', 'app' ),
            'parent_item'                   => __( 'Parent Custom Taxonomy', 'app' ),
            'edit_item'                     => __( 'Edit Custom Taxonomy', 'app' ),
            'view_item'                     => __( 'View Custom Taxonomy', 'app' ),
            'update_item'                   => __( 'Update Custom Taxonomy', 'app' ),
            'add_new_item'                  => __( 'Add New Custom Taxonomy', 'app' ),
            'new_item_name'                 => __( 'New Custom Taxonomy Name', 'app' ),
            'menu_name'                     => __( 'Custom Taxonomies', 'app' ),
            'separate_items_with_commas'    => __( 'Separate Custom Taxonomy with commas', 'app'),
            'add_or_remove_items'           => __( 'Add or remove Custom Taxonomy', 'ecrannoir' ),
            'choose_from_most_used'         => __( 'Choose from the most used Custom Taxonomy', 'ecrannoir' ),
            'not_found'                     => __( 'No Custom Taxonomy found', 'ecrannoir' ),
            'no_terms'                      => __( 'No Custom Taxonomy', 'ecrannoir' ),
            'most_used'                     => __( 'Most Used', 'ecrannoir' ),
        );
        
        $args = array( 
            'labels'            => $labels,
            'public'            => true, 
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'custom-taxonomy' ),
        );

        return $args;
    }

    public static function getTemplateBlock() {
        return array(
            array( 'core/heading',
                array(
                    'align' => 'center',
                    'level' => 2,
                    'placeholder' => 'Titre du cpt'
                )
            ),
            array( 'core/paragraph', 
                array(
                'placeholder' => 'Contenus',
                )
            ),
            array( 
                'core/media-text', 
                array(
                    'align' => 'full',
                    'mediaPosition' => 'right',
                    'mediaType' => 'image',
                    'imageFill' => false),
                array(
                    array( 'core/heading', array(
                        'level' => 3,
                        'placeholder' => 'Titre du Block'
                    )),
                    array( 'core/paragraph', array(
                        'placeholder' => 'Contenus',
                    )),
                ),
            ),
            array( 'core/media-text', 
                array(
                    'align' => 'full',
                    'mediaPosition' => 'left',
                    'mediaType' => 'image',
                    'imageFill' => false
                ),
                array(
                    array( 'core/heading', array(
                        'level' => 3,
                        'placeholder' => 'Titre du block'
                    )),
                    array( 'core/paragraph', array(
                        'placeholder' => 'Contenus',
                    )),
                )
            ),
        );
    }
    

}
