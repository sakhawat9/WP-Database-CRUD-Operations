<?php

namespace Fixolab\WpDatabaseCrudOperations;

/**
 * The Pagination Class
 */
class Pagination
{
    /**
     * Display pagination links
     *
     * @param int $total_items Total number of items
     * @param int $per_page Number of items per page
     * @param int $current_page Current page number
     */
    public static function display_pagination_links($total_items, $per_page, $current_page)
    {
        $total_pages = ceil($total_items / $per_page);

        // Output pagination links
        echo '<div class="wrap"><div class="tablenav bottom">';
        echo '<div class="tablenav-pages"><span class="displaying-num">' . esc_html($total_items) . ' ' . esc_html('items', 'wp-database-crud-operations') . '</span>';
        echo '<span class="pagination-links">';
        if ($total_pages > 1) {
            // Previous page link
            echo '<a class="prev-page button ';
            echo ($current_page == 1) ? 'disabled' : '';
            echo '" href="' . esc_url(add_query_arg('paged', max(1, $current_page - 1))) . '">&laquo;</a>';

            // Current page
            echo '<span class="tablenav-paging-text">';
            echo $current_page . ' of <span class="total-pages">' . esc_html($total_pages) . '</span>';
            echo '</span>';

            // Next page link
            echo '<a class="next-page button ';
            echo ($current_page == $total_pages) ? 'disabled' : '';
            echo '" href="' . esc_url(add_query_arg('paged', min($total_pages, $current_page + 1))) . '">&raquo;</a>';

            echo '</span></div></div></div>';
        }
    }
}
