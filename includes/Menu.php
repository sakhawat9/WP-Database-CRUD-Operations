<?php

namespace Fixolab\WpDatabaseCrudOperations;

/**
 * The Menu handler
 */
class Menu
{
    private $table_name;
    private $allData;

    function __construct($allData)
    {
        global $wpdb;
        // Set table name with prefix
        $this->table_name = $wpdb->prefix . 'wdco_table';

        $this->allData = $allData;
        // Create admin menu
        add_action('admin_menu', [$this, 'add_admin_menu']);
    }
    /**
     * Add admin menu
     */
    public function add_admin_menu()
    {
        add_menu_page(
            esc_html__('WP Database CRUD Operations', 'wp-database-crud-operations'), // page title
            esc_html__('WP Database CRUD Operations', 'wp-database-crud-operations'), // menu title
            'manage_options', // capability
            'wp-database-crud-operations',
            [$this->allData, 'plugin_page'],
            'dashicons-database'
        );

        // Add sub-menu for adding new data
        add_submenu_page(
            'wp-database-crud-operations', // parent slug
            esc_html__('All Data', 'wp-database-crud-operations'), // page title
            esc_html__('All Data', 'wp-database-crud-operations'), // menu title
            'manage_options', // capability
            'wp-database-crud-operations', // menu slug
            [$this->allData, 'plugin_page'] // callback function to display the page content
        );
        // Add sub-menu for adding new data
        add_submenu_page(
            'wp-database-crud-operations', // parent slug
            esc_html__('Add New Data', 'wp-database-crud-operations'), // page title
            esc_html__('Add New Data', 'wp-database-crud-operations'), // menu title
            'manage_options', // capability
            'wp-database-crud-operations&action=new', // menu slug
            [$this->allData, 'add_new_data_page'] // callback function to display the page content
        );
    }

}
