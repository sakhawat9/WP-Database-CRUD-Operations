<?php
/**
 * Plugin Name:       WP Database CRUD Operations
 * Description:       Displays the wordPress database CRUD operations.
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Sakhawat Hossain
 * Author URI:        https://sakhawat.vercel.app/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-database-crud-operations
 * Domain Path:       /languages
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class WP_Database_CRUD_Operations
{
    private $table_name;
    private $dbv = '1.0';

    /**
     * Constructor
     */
    function __construct()
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
    function add_admin_menu()
    {
        add_menu_page(
            'WP Database CRUD Operations',
            'WP Database CRUD Operations',
            'manage_options',
            'wp-database-crud-operations',
            [$this, 'admin_page'],
            'dashicons-admin-generic'
        );
    }

    /**
     * Admin page content
     */
    function admin_page()
    {
        global $wpdb;
        $this->handle_actions(); // Handle form submissions

        // Display add new data form
        $this->display_add_new_form();

        // Get data from database
        $results = $wpdb->get_results("SELECT * FROM {$this->table_name}");

        // Output admin page
        echo '<div class="wrap">';
        echo '<h2>' . esc_html__('WP Database CRUD Operations', 'wp-database-crud-operations') . '</h2>';
        echo '<p>' . esc_html__('This is a custom admin page for WP Database CRUD Operations plugin.', 'wp-database-crud-operations') . '</p>';

        // Display data in a table
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>' . esc_html__('ID', 'wp-database-crud-operations') . '</th>';
        echo '<th>' . esc_html__('Name', 'wp-database-crud-operations') . '</th>';
        echo '<th>' . esc_html__('Email', 'wp-database-crud-operations') . '</th>';
        echo '<th>' . esc_html__('Actions', 'wp-database-crud-operations') . '</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach ($results as $row) {
            echo '<tr>';
            echo '<td>' . esc_html($row->id) . '</td>';
            echo '<td>' . esc_html($row->name) . '</td>';
            echo '<td>' . esc_html($row->email) . '</td>';
            echo '<td>';
            echo '<a href="?page=wp-database-crud-operations&action=edit&id=' . esc_attr($row->id) . '">' . esc_html__('Edit', 'wp-database-crud-operations') . '</a>';
            echo ' | ';
            echo '<a href="?page=wp-database-crud-operations&action=delete&id=' . esc_attr($row->id) . '" onclick="return confirm(\'Are you sure you want to delete this item?\');">' . esc_html__('Delete', 'wp-database-crud-operations') . '</a>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    }

    /**
     * Display add new data form
     */
    function display_add_new_form()
    {
        echo '<h3>' . esc_html__('Add New Data', 'wp-database-crud-operations') . '</h3>';
        echo '<form method="post">';
        echo '<input type="hidden" name="action" value="add">';
        echo '<label for="name">' . esc_html__('Name:', 'wp-database-crud-operations') . '</label>';
        echo '<input type="text" name="name" id="name" required>';
        echo '<label for="email">' . esc_html__('Email:', 'wp-database-crud-operations') . '</label>';
        echo '<input type="email" name="email" id="email" required>';
        echo '<input type="submit" value="' . esc_attr__('Add', 'wp-database-crud-operations') . '">';
        echo '</form>';
    }

    /**
     * Handle form submissions
     */
    function handle_actions()
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
     * Delete data from the database
     */
    function delete_data($id)
    {
        global $wpdb;
        $wpdb->delete($this->table_name, array('id' => $id));
    }

    /**
     * Add new data to the database
     */
    function add_data()
    {
        if (isset($_POST['name']) && isset($_POST['email'])) {
            global $wpdb;
            $name = sanitize_text_field($_POST['name']);
            $email = sanitize_email($_POST['email']);
            $wpdb->insert($this->table_name, array('name' => $name, 'email' => $email));
        }
    }

    /**
     * Display edit data form
     */
    function display_edit_form($id)
    {
        global $wpdb;
        $data = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$this->table_name} WHERE id = %d", $id));
        if ($data) {
            echo '<h3>' . esc_html__('Edit Data', 'wp-database-crud-operations') . '</h3>';
            echo '<form method="post">';
            echo '<input type="hidden" name="action" value="update">';
            echo '<input type="hidden" name="id" value="' . esc_attr($data->id) . '">';
            echo '<label for="name">' . esc_html__('Name:', 'wp-database-crud-operations') . '</label>';
            echo '<input type="text" name="name" id="name" value="' . esc_attr($data->name) . '" required>';
            echo '<label for="email">' . esc_html__('Email:', 'wp-database-crud-operations') . '</label>';
            echo '<input type="email" name="email" id="email" value="' . esc_attr($data->email) . '" required>';
            echo '<input type="submit" value="' . esc_attr__('Update', 'wp-database-crud-operations') . '">';
            echo '</form>';
        }
    }

    /**
     * Update data in the database
     */
    function update_data()
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
    function create_database_tables()
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

// Instantiate the class
new WP_Database_CRUD_Operations();
