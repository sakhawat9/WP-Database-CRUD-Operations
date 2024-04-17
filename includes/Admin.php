<?php

namespace Fixolab\WpDatabaseCrudOperations;

class Admin
{
    private $table_name;
    private $dbv = '1.0';

    /**
     * Constructor
     */
    public function __construct()
    {
        global $wpdb;
        // Set table name with prefix
        $this->table_name = $wpdb->prefix . 'custom_table';
        // Register activation hook
        register_activation_hook(__FILE__, [$this, 'create_database_tables']);

        // Create admin menu
        add_action('admin_menu', [$this, 'add_admin_menu']);

        // Check and update database version
        $dbv = get_option('dbv');
        if ($dbv != $this->dbv) {
            $this->create_database_tables();
            update_option('dbv', $this->dbv);
        }
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
            [$this, 'admin_page'],
            'dashicons-admin-generic'
        );

        // Add sub-menu for adding new data
        add_submenu_page(
            'wp-database-crud-operations', // parent slug
            esc_html__('Add New Data', 'wp-database-crud-operations'), // page title
            esc_html__('Add New Data', 'wp-database-crud-operations'), // menu title
            'manage_options', // capability
            'wp-database-crud-operations-add', // menu slug
            [$this, 'add_new_data_page'] // callback function to display the page content
        );
    }

    /**
     * Admin page content
     */
    public function admin_page()
    {
        global $wpdb;
        $this->handle_actions(); // Handle form submissions

        // Get data from database
        $results = $wpdb->get_results("SELECT * FROM {$this->table_name}");

        // Add New Data button
        echo '<div class="wrap">';
        echo '<a href="' . admin_url('admin.php?page=wp-database-crud-operations-add') . '" class="button button-primary">' . esc_html__('Add New Data', 'wp-database-crud-operations') . '</a>';
        echo '</div>';

        // Output admin page
        include_once(plugin_dir_path(__FILE__) . 'views/template-list.php');
    }

    /**
     * Add new data
     */
    public function add_new_data_page()
    {
        $this->handle_actions(); // Handle form submissions

        // Display add new data form
        $this->display_add_new_form();
    }

    /**
     * Display add new data form
     */
    public function display_add_new_form()
    {
        include_once(plugin_dir_path(__FILE__) . 'views/template-add.php');
    }

    /**
     * Handle form submissions
     */
    public function handle_actions()
    {
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'edit':
                    $this->display_edit_form(intval($_GET['id']));
                    break;
                case 'delete':
                    $this->delete_data(intval($_GET['id']));
                    break;
                default:
                    break;
            }
        }

        if (isset($_POST['action'])) {
            // Verify nonce
            $nonce = isset($_POST['add_new_data_nonce']) ? $_POST['add_new_data_nonce'] : '';
            if (!wp_verify_nonce($nonce, 'add_new_data_action')) {
                // Nonce verification failed, handle the error
                wp_die('Nonce verification failed');
            }

            switch ($_POST['action']) {
                case 'add':
                    $this->add_data();
                    break;
                case 'update':
                    $this->update_data();
                    break;
                default:
                    break;
            }
        }
    }

    /**
     * Add new data to the database
     */
    public function add_data()
    {
        if (isset($_POST['name']) && isset($_POST['email'])) {
            global $wpdb;
            $name = sanitize_text_field($_POST['name']);
            $email = sanitize_email($_POST['email']);
            $wpdb->insert($this->table_name, array('name' => $name, 'email' => $email));
        }
    }

    /**
     * Delete data from the database
     */
    public function delete_data($id)
    {
        global $wpdb;
        $wpdb->delete($this->table_name, array('id' => $id));
    }

    /**
     * Display edit data form
     */
    public function display_edit_form($id)
    {
        global $wpdb;
        $data = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$this->table_name} WHERE id = %d", $id));
        if ($data) {
            include_once(plugin_dir_path(__FILE__) . 'views/template-edit.php');
        }
    }

    /**
     * Update data in the database
     */
    public function update_data()
    {
        if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['email'])) {
            global $wpdb;
            $id = intval($_POST['id']);
            $name = sanitize_text_field($_POST['name']);
            $email = sanitize_email($_POST['email']);
            $wpdb->update($this->table_name, array('name' => $name, 'email' => $email), array('id' => $id));
        }
    }

    /**
     * Create database tables
     */
    public function create_database_tables()
    {
        global $wpdb;
        // Charset collate for creating tables
        $charset_collate = $wpdb->get_charset_collate();
        // SQL query to create table
        $sql = "CREATE TABLE $this->table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(50) NOT NULL,
            email varchar(50) NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        // Include upgrade.php for dbDelta function
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        // Execute SQL query to create table
        dbDelta($sql);
    }
}
