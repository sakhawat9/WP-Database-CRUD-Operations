<?php

namespace Fixolab\WpDatabaseCrudOperations;

/**
 * Installer class.
 */
class Installer {

	private $table_name;

	public function __construct() {
		global $wpdb;
		// Set table name with prefix.
		$this->table_name = $wpdb->prefix . 'wdco_table';
	}

	/**
	 * Add time and version on DB.
	 */
	public function add_version() {
		// Check and update database version.
		$dbv = get_option( 'dbv' );
		if ( $dbv ) {
			update_option( 'dbv', $dbv );
		}

		update_option( 'dbv', WDCO_VERSION );
	}

	/**
	 * Create necessary database tables.
	 *
	 * @return void
	 */
	public function create_tables() {
		global $wpdb;
		// Charset collate for creating tables.
		$charset_collate = $wpdb->get_charset_collate();
		// SQL query to create table
		$sql = "CREATE TABLE $this->table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(50) NOT NULL,
            email varchar(50) NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

		// Include upgrade.php for dbDelta function.
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		// Execute SQL query to create table.
		dbDelta( $sql );
	}
}
