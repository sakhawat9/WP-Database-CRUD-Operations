<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('WP Database CRUD Operations', 'wp-database-crud-operations') ?></h1>
    <a class="page-title-action" href="<?php echo admin_url('admin.php?page=wp-database-crud-operations&action=new');?>" class="button button-primary"><?php _e('Add New Data', 'wp-database-crud-operations');?></a>

    <br>
    <br>
    <?php
    // Display data in a table 
    ?>
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th><?php _e('ID', 'wp-database-crud-operations') ?></th>
                <th><?php _e('Name', 'wp-database-crud-operations') ?></th>
                <th><?php _e('Email', 'wp-database-crud-operations') ?></th>
                <th><?php _e('Actions', 'wp-database-crud-operations') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($results as $row) {
            ?>
                <tr>
                    <td><?php echo esc_html($row->id) ?></td>
                    <td><a href="?page=wp-database-crud-operations&action=edit&id=<?php echo esc_attr($row->id) ?>"><strong><?php echo esc_html($row->name) ?></strong></a></td>
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