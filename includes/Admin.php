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
