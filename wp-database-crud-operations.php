<?php
/*
Plugin Name: WP Database CRUD Operations
Description: Displays the WordPress database CRUD operations.
Version: 1.0
Requires at least: 5.2
Requires PHP: 7.2
Author: Sakhawat Hossain
Author URI: https://sakhawat.vercel.app/
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
Text Domain: wp-database-crud-operations
Domain Path: /languages
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include the autoloader
require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
class WP_Database_CRUD_Operations
{
    /**
     * Plugin version
     *
     * @var string
     */
    const version = '1.0';

    /**
     * Class construcotr
     */
    public function __construct()
    {
        $this->define_constants();
        // Register activation hook
        register_activation_hook(__FILE__, [$this, 'wdco_activate']);

        if (is_admin()) {
            new Fixolab\WpDatabaseCrudOperations\Admin();
        }
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants()
    {
        define('WDCO_VERSION', self::version);
    }

    /**
     * Initializes a singleton instance
     *
     * @return \WP_Database_CRUD_Operations
     */
    public static function init()
    {
        static $instance = false;

        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }
}

/**
 * Initializes the main plugin
 *
 * @return \WP_Database_CRUD_Operations
 */
function wdco_crud_operations()
{
    return WP_Database_CRUD_Operations::init();
}

// kick-off the plugin
wdco_crud_operations();
