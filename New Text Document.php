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
        // Get total rows count
        $total_rows = $wpdb->get_var("SELECT COUNT(*) FROM $this->table_name");
        // Output admin page
        echo '<div class="wrap">';
        echo '<h2>' . esc_html__('WP Database CRUD Operations', 'wp-database-crud-operations') . '</h2>';
        echo '<p>' . esc_html__('This is a custom admin page for WP Database CRUD Operations plugin.', 'wp-database-crud-operations') . '</p>';

        // Display results
        $results = $wpdb->get_results("SELECT * FROM {$this->table_name}");
?>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th><?php echo esc_html__('ID', 'wp-database-crud-operations') ?></th>
                    <th><?php echo esc_html__('Name', 'wp-database-crud-operations') ?></th>
                    <th><?php echo esc_html__('Email', 'wp-database-crud-operations') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($results as $row) {
                    echo '<tr>';
                    echo '<td>' . esc_html($row->id) . '</td>';
                    echo '<td>' . esc_html($row->name) . '</td>';
                    echo '<td>' . esc_html($row->email) . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
<?php
        // Output total rows count
        echo '<p>Total rows: ' . esc_html($total_rows) . '</p>';
        echo '</div>';
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
