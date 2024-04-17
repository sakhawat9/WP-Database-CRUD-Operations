<h3><?php echo esc_html__('Add New Data', 'wp-database-crud-operations'); ?></h3>
<form method="post">.
    <?php wp_nonce_field('add_new_data_action', 'add_new_data_nonce'); ?>
    <input type="hidden" name="action" value="add">
    <label for="name"><?php echo esc_html__('Name:', 'wp-database-crud-operations'); ?></label>
    <input type="text" name="name" id="name" required>
    <label for="email"><?php echo esc_html__('Email:', 'wp-database-crud-operations'); ?></label>
    <input type="email" name="email" id="email" required>
    <input type="submit" value="<?php echo esc_attr__('Add', 'wp-database-crud-operations'); ?>">
</form>