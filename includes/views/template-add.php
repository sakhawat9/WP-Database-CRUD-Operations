<?php
/**
 * Template: Add New Data
 *
 * @package WP_Database_CRUD_Operations
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<h2 class="font-bold"><?php echo esc_html__( 'Add New Data', 'wp-database-crud-operations' ); ?></h2>
<form method="post">
	<?php wp_nonce_field( 'add_new_data_action', 'add_new_data_nonce' ); ?>
	<input type="hidden" name="action" value="add">
	<table class="form-table">
		<tr>
			<th scope="row">
				<label for="name"><?php echo esc_html__( 'Name:', 'wp-database-crud-operations' ); ?></label>
			</th>
			<td>
				<input type="text" name="name" id="name" required>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="email"><?php echo esc_html__( 'Email:', 'wp-database-crud-operations' ); ?></label>
			</th>
			<td>
				<input type="email" name="email" id="email" required>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<input class="button action" type="submit" value="<?php echo esc_attr__( 'Add Data', 'wp-database-crud-operations' ); ?>">
			</th>
		</tr>
	</table>
</form>