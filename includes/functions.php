<?php
/**
 * Display edit data form
 */
function display_edit_form( $id ) {
	global $wpdb;
	return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}custom_table WHERE id = %d", $id ) );
}

/**
 * Add new data to the database
 */
function add_data() {
	if ( isset( $_POST['name'] ) && isset( $_POST['email'] ) ) {
		global $wpdb;
		$name  = sanitize_text_field( $_POST['name'] );
		$email = sanitize_email( $_POST['email'] );
		$wpdb->insert(
			$wpdb->prefix . 'custom_table',
			array(
				'name'  => $name,
				'email' => $email,
			)
		);

		// Add a parameter to the URL to indicate success
		$redirected_to = add_query_arg( array( 'inserted' => 'true' ), admin_url( 'admin.php?page=wp-database-crud-operations' ) );
		wp_redirect( $redirected_to );
		exit;
	}
}

/**
 * Update data in the database
 */
function update_data() {
	if ( isset( $_POST['id'] ) && isset( $_POST['name'] ) && isset( $_POST['email'] ) ) {
		global $wpdb;
		$id    = intval( $_POST['id'] );
		$name  = sanitize_text_field( $_POST['name'] );
		$email = sanitize_email( $_POST['email'] );
		$wpdb->update(
			$wpdb->prefix . 'custom_table',
			array(
				'name'  => $name,
				'email' => $email,
			),
			array( 'id' => $id )
		);

		// Redirect after successful update
		$redirected_to = add_query_arg( array( 'updated' => 'true' ), admin_url( 'admin.php?page=wp-database-crud-operations' ) );
		wp_redirect( $redirected_to );
		exit;
	}
}

/**
 * Delete data from the database
 */
function delete_data( $id ) {
	global $wpdb;
	$wpdb->delete( $wpdb->prefix . 'custom_table', array( 'id' => $id ) );
}
