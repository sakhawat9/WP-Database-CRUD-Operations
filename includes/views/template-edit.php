<h2 class="font-bold"><?php echo esc_html__('Edit Data', 'wp-database-crud-operations'); ?></h2>
<form class="w-2/4" method="post">
    <?php wp_nonce_field('add_new_data_action', 'add_new_data_nonce'); ?>
    <input type="hidden" name="action" value="update">
    <input type="hidden" name="id" value="<?php echo esc_attr($data->id); ?>">
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="name"><?php echo esc_html__('Name:', 'wp-database-crud-operations'); ?></label>
            </th>
            <td scope="row">
                <input type="text" name="name" id="name" value="<?php echo esc_attr($data->name); ?>" required>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="email"><?php echo esc_html__('Email:', 'wp-database-crud-operations'); ?></label>
            </th>
            <td scope="row">
                <input type="email" name="email" id="email" value="<?php echo esc_attr($data->email); ?>" required>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <input class="button action" type="submit" value="<?php echo esc_attr__('Update', 'wp-database-crud-operations'); ?>">
            </th>
        </tr>
    </table>
</form>