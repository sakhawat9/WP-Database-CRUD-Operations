<h3><?php echo esc_html__('Edit Data', 'wp-database-crud-operations'); ?></h3>
<form method="post">
    <input type="hidden" name="action" value="update">
    <input type="hidden" name="id" value="<?php echo esc_attr($data->id); ?>">
    <label for="name"><?php echo esc_html__('Name:', 'wp-database-crud-operations'); ?></label>
    <input type="text" name="name" id="name" value="<?php echo esc_attr($data->name); ?>" required>
    <label for="email"><?php echo esc_html__('Email:', 'wp-database-crud-operations'); ?></label>
    <input type="email" name="email" id="email" value="<?php echo esc_attr($data->email); ?>" required>
    <input type="submit" value="<?php echo esc_attr__('Update', 'wp-database-crud-operations'); ?>">
</form>
