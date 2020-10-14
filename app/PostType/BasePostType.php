<?php

namespace PostType;
/**
 * 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly


abstract class BasePostType {


    /**
     * The current type we are working on
     * public $type;
     */
    public $type;


    /**
     * The prefix for custom taxonomy
     * public $taxonomy_slug;
     */
    public $taxonomy_slug;


    /**
     * Determines whether a class has already been instanciated.
     *
     * @access private
     */
    private static $instance = null;   

    /**
     *
     * @access protected
     */
    protected $configuration_post_type;
    protected $configuration_taxonomies = array();
    

    public static function instance()
	{
		$class = get_called_class();
        if ( ! isset(self::$instance[$class]) ) {
            self::$instance[$class] = new $class();
        }

        return self::$instance[$class];
    }

     /** 
     * Constructor. This allows the class to be only initialized once.
     */
    public function __construct() {

        // Set our properties based upon the arrays defined within a view
        $this->setConfigurations();

        add_action('init', [$this, 'initPostType']);
    }

    /**
     * Sets all basic properties that are retrieved from our customizer or meta settings. Can only be defined in child class
     * This function should define $this->properties
     */
    abstract protected function setConfigurations();
    
    public function initPostType()
    {
        register_post_type( $this->type, $this->getPostTypeConfiguration());
        if ($this->hasTaxonomies()) {
            foreach ($this->configuration_taxonomies as $slug => $tax_args) {
                register_taxonomy( $this->type . $slug, $this->type, $tax_args);
            }
        }
    }

    public function getPostTypeConfiguration() {
       return $this->configuration_post_type;

    }
    
    public function getTaxonomiesConfiguration() {
        return $this->configuration_taxonomies;
    }
    
    public function hasTaxonomies()
    {
        return !empty($this->configuration_taxonomies) ? true : false;
    }

}
