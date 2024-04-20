<?php

/**
 * The admin class
 *
 * @package wp-database-crud-operations
 */

namespace Fixolab\WpDatabaseCrudOperations;

class Admin {


	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_notices', array( $this, 'display_success_message' ) );
		add_action( 'admin_notices', array( $this, 'display_update_success_message' ) );
		$all_data = new All_Data();
		$this->dispatch_actions( $all_data );
		new Menu( $all_data );
	}
	/**
	 * Display success message
	 */
	public function display_success_message() {
		if ( isset( $_GET['inserted'] ) && $_GET['inserted'] === 'true' ) {
			echo '<div class="notice notice-success is-dismissible"><p></p>' . esc_html__( 'Data inserted successfully!', 'wp-database-crud-operations' ) . '</p></div>';
		}
	}

	/**
	 * Display update success message
	 */
	public function display_update_success_message() {
		if ( isset( $_GET['updated'] ) && 'true' === $_GET['updated'] ) {

			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Data updated successfully!', 'wp-database-crud-operations' ) . '</p></div>';
		}
	}


	/**
	 * Dispatch and bind actions
	 *
	 * @param All_Data $all_data The All_Data instance.
	 * @return void
	 */
	public function dispatch_actions( $all_data ) {
		add_action( 'admin_init', array( $all_data, 'form_handler' ) );
	}
}
