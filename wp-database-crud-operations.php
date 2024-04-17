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
require_once plugin_dir_path(__FILE__) . 'autoload.php';

// Instantiate the main plugin class
new WP_Database_CRUD_Operations();
