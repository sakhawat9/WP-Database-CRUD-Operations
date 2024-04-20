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

// Define constants for plugin directory path.
if (!defined('WDCO_DIR_URL')) {
    define('WDCO_DIR_URL', plugin_dir_url(__FILE__));
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
        define('WDCO_FILE', __FILE__);
        define('WDCO_PATH', __DIR__);
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

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function wdco_activate()
    {
        $installer = new Fixolab\WpDatabaseCrudOperations\Installer();
        
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
