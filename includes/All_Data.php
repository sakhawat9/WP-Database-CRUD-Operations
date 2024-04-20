<?php

namespace Fixolab\WpDatabaseCrudOperations;

/**
 * The All Data Class
 */

class All_Data {

	private $table_name;
	/**
	 * Constructor for the All_Data class.
	 * Initializes the class by setting the table name.
	 */
	public function __construct() {
		global $wpdb;
		$this->table_name = $wpdb->prefix . 'custom_table';
	}

	/**
	 * Handles different actions and includes corresponding templates.
	 */
	public function plugin_page() {
		global $wpdb;

		// Pagination parameters.
		$per_page     = 10; // Number of items per page.
		$current_page = isset( $_GET['paged'] ) ? max( 1, intval( $_GET['paged'] ) ) : 1; // Current page number.

		// Calculate offset.
		$offset = ( $current_page - 1 ) * $per_page;

		// Get total count of items.
		$total_items = $wpdb->get_var( "SELECT COUNT(*) FROM {$this->table_name}" );

		// Calculate total number of pages.
		$total_pages = ceil( $total_items / $per_page );

		// Get data from database with pagination.
		$results = $wpdb->get_results( "SELECT * FROM {$this->table_name} LIMIT $per_page OFFSET $offset" );

		$action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
		$id     = isset( $_GET['id'] ) ? $_GET['id'] : 0;

		switch ( $action ) {
			case 'new':
				$template = __DIR__ . '/views/template-add.php';
				break;
			case 'edit':
				$data     = display_edit_form( $id );
				$template = __DIR__ . '/views/template-edit.php';
				break;
			case 'view':
				$template = __DIR__ . '/views/template-view.php';
				break;
			default:
				$template = __DIR__ . '/views/template-list.php';
				break;
		}

		if ( file_exists( $template ) ) {
			include $template;
		}

		// Output pagination links.
		if ( $action === 'list' ) {
			Pagination::display_pagination_links( $total_items, $per_page, $current_page );
		}
	}

	/**
	 * Handles form submissions and performs CRUD operations.
	 */
	public function form_handler() {
		if ( isset( $_GET['action'] ) ) {
			switch ( $_GET['action'] ) {
				case 'edit':
					display_edit_form( intval( $_GET['id'] ) );
					break;
				case 'delete':
					delete_data( intval( $_GET['id'] ) );
					break;
				default:
					break;
			}
		}

		if ( isset( $_POST['action'] ) ) {
			// Verify nonce.
			$nonce = isset( $_POST['wdco_data_nonce'] ) ? $_POST['wdco_data_nonce'] : '';
			if ( ! wp_verify_nonce( $nonce, 'wdco_data_action' ) ) {
				// Nonce verification failed, handle the error.
				wp_die( 'Nonce verification failed' );
			}
			if ( ! current_user_can( 'manage_options' ) ) {
				// Current user failed, handle the error.
				wp_die( 'Are you cheating' );
			}

			switch ( $_POST['action'] ) {
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
