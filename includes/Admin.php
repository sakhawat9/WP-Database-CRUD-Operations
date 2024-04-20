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
        $allData = new All_Data();

        $this->dispatch_actions($allData);

        new Menu($allData);
        add_action('admin_notices', [$this, 'display_success_message']);
        add_action('admin_notices', [$this, 'display_update_success_message']);
    }
    public function display_success_message()
    {
        if (isset($_GET['inserted']) && $_GET['inserted'] === 'true') {
            echo '<div class="notice notice-success is-dismissible"><p>Data inserted successfully!</p></div>';
        }
    }


    public function display_update_success_message()
    {
        if (isset($_GET['updated']) && $_GET['updated'] === 'true') {
            echo '<div class="notice notice-success is-dismissible"><p>Data updated successfully!</p></div>';
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
