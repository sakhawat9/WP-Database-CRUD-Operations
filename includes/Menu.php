<?php

namespace Fixolab\WpDatabaseCrudOperations;

/**
 * The Menu handler.
 */
class Menu {

	private $table_name;
	private $all_data;

	function __construct( $all_data ) {
		global $wpdb;
		// Set table name with prefix.
		$this->table_name = $wpdb->prefix . 'wdco_table';

		$this->all_data = $all_data;
		// Create admin menu
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
	}
	/**
	 * Add admin menu.
	 */
	public function add_admin_menu() {
		add_menu_page(
			esc_html__( 'WP Database CRUD Operations', 'wp-database-crud-operations' ),
			esc_html__( 'WP Database CRUD Operations', 'wp-database-crud-operations' ),
			'manage_options',
			'wp-database-crud-operations',
			array( $this->all_data, 'plugin_page' ),
			'dashicons-database'
		);

		// Add sub-menu for adding new data.
		add_submenu_page(
			'wp-database-crud-operations',
			esc_html__( 'All Data', 'wp-database-crud-operations' ),
			esc_html__( 'All Data', 'wp-database-crud-operations' ),
			'manage_options',
			'wp-database-crud-operations',
			array( $this->all_data, 'plugin_page' )
		);
		// Add sub-menu for adding new data.
		add_submenu_page(
			'wp-database-crud-operations',
			esc_html__( 'Add New Data', 'wp-database-crud-operations' ),
			esc_html__( 'Add New Data', 'wp-database-crud-operations' ),
			'manage_options',
			'wp-database-crud-operations&action=new',
			array( $this->all_data, 'add_new_data_page' )
		);
	}
}
