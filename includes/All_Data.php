<?php

namespace Fixolab\WpDatabaseCrudOperations;

/**
 * The Menu handler
 */

class All_Data
{
    private $table_name;
    public function __construct()
    {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'custom_table';
    }

    public function plugin_page()
    {
        global $wpdb;

        // // Get data from database
        $results = $wpdb->get_results("SELECT * FROM {$this->table_name}");

        $action = isset($_GET['action']) ? $_GET['action'] : 'list';
        $id = isset($_GET['id']) ? $_GET['id'] : 0;

        switch ($action) {
            case 'new':
                $template = __DIR__ . '/views/template-add.php';
                break;
            case 'edit':
                $data = display_edit_form($id);
                $template = __DIR__ . '/views/template-edit.php';
                break;
            case 'view':
                $template = __DIR__ . '/views/template-view.php';
                break;
            default:
                $template = __DIR__ . '/views/template-list.php';
                break;
        }

        if (file_exists($template)) {
            include $template;
        }
    }
    public function form_handler()
    {
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'edit':
                    display_edit_form(intval($_GET['id']));
                    break;
                case 'delete':
                    delete_data(intval($_GET['id']));
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
            if (!current_user_can('manage_options')) {
                // Current user failed, handle the error
                wp_die('Are you cheating');
            }

            switch ($_POST['action']) {
                case 'add':
                    add_data();
                    break;
                case 'update':
                    update_data();
                    break;
                default:
                    break;
            }
        }
    }
}
