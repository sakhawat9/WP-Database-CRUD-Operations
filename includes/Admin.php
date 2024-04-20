<?php

namespace Fixolab\WpDatabaseCrudOperations;

/**
 * The admin class
 */
class Admin
{

    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('admin_notices', [$this, 'display_success_message']);
        add_action('admin_notices', [$this, 'display_update_success_message']);
        $allData = new All_Data();
        $this->dispatch_actions($allData);
        new Menu($allData);
    }
    public function display_success_message()
    {
        if (isset($_GET['inserted']) && $_GET['inserted'] === 'true') {
            echo '<div class="notice notice-success is-dismissible"><p></p>' . esc_html__('Data inserted successfully!', 'wp-database-crud-operations') . '</p></div>';
        }
    }

    public function display_update_success_message()
    {
        if (isset($_GET['updated']) && $_GET['updated'] === 'true') {
            echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Data updated successfully!', 'wp-database-crud-operations') . '</p></div>';
        }
    }

    /**
     * Dispatch and bind actions
     *
     * @return void
     */
    public function dispatch_actions($allData)
    {
        add_action('admin_init', [$allData, 'form_handler']);
    }
}
