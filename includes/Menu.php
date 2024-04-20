<?php

namespace Fixolab\WpDatabaseCrudOperations;

/**
 * The Menu handler
 */
class Menu {

	private $table_name;
	private $all_data;

	function __construct( $all_data ) {
		global $wpdb;
		// Set table name with prefix
		$this->table_name = $wpdb->prefix . 'wdco_table';

		$this->allData = $all_data;
		// Create admin menu
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
	}
	/**
	 * Add admin menu
	 */
	public function add_admin_menu() {
		add_menu_page(
			esc_html__( 'WP Database CRUD Operations', 'wp-database-crud-operations' ), // page title
			esc_html__( 'WP Database CRUD Operations', 'wp-database-crud-operations' ), // menu title
			'manage_options', // capability
			'wp-database-crud-operations',
			array( $this->allData, 'plugin_page' ),
			'dashicons-database'
		);

		// Add sub-menu for adding new data
		add_submenu_page(
			'wp-database-crud-operations', // parent slug
			esc_html__( 'All Data', 'wp-database-crud-operations' ), // page title
			esc_html__( 'All Data', 'wp-database-crud-operations' ), // menu title
			'manage_options', // capability
			'wp-database-crud-operations', // menu slug
			array( $this->allData, 'plugin_page' ) // callback function to display the page content
		);
		// Add sub-menu for adding new data
		add_submenu_page(
			'wp-database-crud-operations', // parent slug
			esc_html__( 'Add New Data', 'wp-database-crud-operations' ), // page title
			esc_html__( 'Add New Data', 'wp-database-crud-operations' ), // menu title
			'manage_options', // capability
			'wp-database-crud-operations&action=new', // menu slug
			array( $this->allData, 'add_new_data_page' ) // callback function to display the page content
		);
	}
}
