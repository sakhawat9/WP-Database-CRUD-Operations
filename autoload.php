<?php
// Autoload classes
spl_autoload_register('wp_database_crud_operations_autoloader');

function wp_database_crud_operations_autoloader($class_name) {
    if (strpos($class_name, 'WP_Database_CRUD_Operations') === 0) {
        $class_file = plugin_dir_path(__FILE__) . 'includes/' . $class_name . '.php';
        if (file_exists($class_file)) {
            require_once $class_file;
        }
    }
}
