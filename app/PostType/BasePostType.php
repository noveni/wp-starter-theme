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
        register_taxonomy( 'type_' . $this->type, $this->type, $this->getTaxonomyConfiguration() );
    }

    public function getPostTypeConfiguration() {
       return $this->configuration_post_type;

    }
    
    public function getTaxonomyConfiguration() {
        return $this->configuration_taxonomy;
    }

}
