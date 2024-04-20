<?php
/**
 * Template: List Data
 *
 * @package WP_Database_CRUD_Operations
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="wrap">
	<h1 class="wp-heading-inline"><?php esc_html_e( 'WP Database CRUD Operations', 'wp-database-crud-operations' ); ?></h1>
	<a class="page-title-action" href="<?php echo esc_url( admin_url( 'admin.php?page=wp-database-crud-operations&action=new' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Add New Data', 'wp-database-crud-operations' ); ?></a>

	<br>
	<br>
	<?php
	// Determine the column to sort by.
	$wdco_orderby = isset( $_GET['orderby'] ) ? wp_unslash( $_GET['orderby'] ) : 'id';
	// Determine the order (ascending or descending).
	$order = isset( $_GET['order'] ) ? $_GET['order'] : 'asc';
    
	// Define sorting icons.
	$asc_icon  = '<span class="dashicons dashicons-arrow-up"></span>';
	$desc_icon = '<span class="dashicons dashicons-arrow-down"></span>';

	// Display data in a table.
	?>
	<table class="wp-list-table widefat fixed striped">
		<thead>
			<tr>
				<th><a href="
				<?php
				echo esc_url(
					add_query_arg(
						array(
							'orderby' => 'id',
							'order'   => ( $wdco_orderby === 'id' && $order === 'asc' ) ? 'desc' : 'asc',
						)
					)
				);
				?>
				"><?php esc_html_e( 'ID', 'wp-database-crud-operations' ); ?></a><?php echo ( $wdco_orderby === 'id' ) ? ( $order === 'asc' ? wp_kses_post( $asc_icon ) : wp_kses_post( $desc_icon ) ) : ''; ?></th>
				<th><a href="
				<?php
				echo esc_url(
					add_query_arg(
						array(
							'orderby' => 'name',
							'order'   => ( $wdco_orderby === 'name' && $order === 'asc' ) ? 'desc' : 'asc',
						)
					)
				);
				?>
				"><?php esc_html_e( 'Name', 'wp-database-crud-operations' ); ?></a><?php echo ( $wdco_orderby === 'name' ) ? ( $order === 'asc' ? wp_kses_post( $asc_icon ) : wp_kses_post( $desc_icon ) ) : ''; ?></th>
				<th><a href="
				<?php
				echo esc_url(
					add_query_arg(
						array(
							'orderby' => 'email',
							'order'   => ( $wdco_orderby === 'email' && $order === 'asc' ) ? 'desc' : 'asc',
						)
					)
				);
				?>
				"><?php esc_html_e( 'Email', 'wp-database-crud-operations' ); ?></a><?php echo ( $wdco_orderby === 'email' ) ? ( $order === 'asc' ? wp_kses_post( $asc_icon ) : wp_kses_post( $desc_icon ) ) : ''; ?></th>
				<th><?php esc_html_e( 'Actions', 'wp-database-crud-operations' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			// Prepare the SQL query with ordering.
			$wdco_orderby = esc_sql( $wdco_orderby );
			$order        = esc_sql( $order );
			$sql          = "SELECT * FROM {$this->table_name} ORDER BY $wdco_orderby $order LIMIT $per_page OFFSET $offset";
			$results      = $wpdb->get_results( $sql );

			foreach ( $results as $row ) {
				?>
				<tr>
					<td><?php echo esc_html( $row->id ); ?></td>
					<td><a href="?page=wp-database-crud-operations&action=edit&id=<?php echo esc_attr( $row->id ); ?>"><strong><?php echo esc_html( $row->name ); ?></strong></a></td>
					<td><?php echo esc_html( $row->email ); ?></td>
					<td>
						<?php
						echo '<a href="?page=wp-database-crud-operations&action=edit&id=' . esc_attr( $row->id ) . '">' . esc_html__( 'Edit', 'wp-database-crud-operations' ) . '</a>';
						echo ' | ';
						echo '<a href="?page=wp-database-crud-operations&action=delete&id=' . esc_attr( $row->id ) . '" onclick="return confirm(\'Are you sure you want to delete this item?\');">' . esc_html__( 'Delete', 'wp-database-crud-operations' ) . '</a>';
						?>
					</td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
</div>
