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
    protected $configuration_taxonomy;
    

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

        $this->taxonomy_slug = 'term_';

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
        if ($this->hasTaxonomy()) {
            register_taxonomy( $this->taxonomy_slug . $this->type, $this->type, $this->getTaxonomyConfiguration() );
        }
    }

    public function getPostTypeConfiguration() {
       return $this->configuration_post_type;

    }
    
    public function getTaxonomyConfiguration() {
        return $this->configuration_taxonomy;
    }
    
    public function hasTaxonomy()
    {
        return !empty($this->configuration_taxonomy) ? true : false;
    }

}
