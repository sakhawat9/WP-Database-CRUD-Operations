<div class="wrap">
    <h2><?php echo esc_html__('WP Database CRUD Operations', 'wp-database-crud-operations') ?></h2>
    <p><?php echo esc_html__('This is a custom admin page for WP Database CRUD Operations plugin.', 'wp-database-crud-operations') ?></p>

    <?php
    // Display data in a table 
    ?>
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th><?php echo esc_html__('ID', 'wp-database-crud-operations') ?></th>
                <th><?php echo esc_html__('Name', 'wp-database-crud-operations') ?></th>
                <th><?php echo esc_html__('Email', 'wp-database-crud-operations') ?></th>
                <th><?php echo esc_html__('Actions', 'wp-database-crud-operations') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($results as $row) {
            ?>
                <tr>
                    <td><?php echo esc_html($row->id) ?></td>
                    <td><?php echo esc_html($row->name) ?></td>
                    <td><?php echo esc_html($row->email) ?></td>
                    <td>
                        <?php

                        echo '<a href="?page=wp-database-crud-operations&action=edit&id=' . esc_attr($row->id) . '">' . esc_html__('Edit', 'wp-database-crud-operations') . '</a>';
                        echo ' | ';
                        echo '<a href="?page=wp-database-crud-operations&action=delete&id=' . esc_attr($row->id) . '" onclick="return confirm(\'Are you sure you want to delete this item?\');">' . esc_html__('Delete', 'wp-database-crud-operations') . '</a>';
                        ?>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>