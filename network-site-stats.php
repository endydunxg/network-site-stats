<?php
/**
 * Plugin Name: Network Site Stats
 * Plugin URI:  https://github.com/
 * Description: Plugin dành cho Super Admin quản lý thống kê các trang web con trong hệ thống WordPress Multisite.
 * Version:     1.0.0
 * Author:      Ngo Duc Dung
 * Network:     true
 */

// Ngăn chặn truy cập trực tiếp
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Hook vào menu của Network Admin
 */
add_action( 'network_admin_menu', 'nss_add_network_admin_menu' );

function nss_add_network_admin_menu() {
    add_menu_page(
        'Thống kê mạng lưới',          // Page title
        'Site Stats',                  // Menu title
        'manage_network_options',      // Capability (Quyền Super Admin)
        'network-site-stats',          // Menu slug
        'nss_render_stats_page',       // Callback function
        'dashicons-chart-area',        // Icon
        30                             // Vị trí
    );
}

/**
 * Hiển thị giao diện trang cấu hình
 */
function nss_render_stats_page() {
    // Kiểm tra quyền truy cập
    if ( ! current_user_can( 'manage_network_options' ) ) {
        wp_die( __( 'Bạn không có quyền truy cập trang này.' ) );
    }
    ?>
    <div class="wrap">
        <h1>Thống kê mạng lưới Website (Multisite Network)</h1>
        <p>Danh sách các site con và thông tin tổng quan được thu thập thông qua <code>switch_to_blog()</code>.</p>
        
        <table class="wp-list-table widefat fixed striped table-view-list">
            <thead>
                <tr>
                    <th style="width: 80px;">ID</th>
                    <th>Tên Site (Blog Name)</th>
                    <th>Đường dẫn (URL)</th>
                    <th>Số lượng bài viết</th>
                    <th>Ngày cập nhật mới nhất</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Lấy danh sách tất cả các site trong Network
                $sites = get_sites( array(
                    'public'  => 1,
                    'deleted' => 0,
                ) );

                if ( ! empty( $sites ) ) {
                    foreach ( $sites as $site ) {
                        // Chuyển đổi ngữ cảnh sang site con
                        switch_to_blog( $site->blog_id );

                        // Thu thập dữ liệu của site con
                        $blog_id      = get_current_blog_id();
                        $blog_name    = get_bloginfo( 'name' );
                        $blog_url     = get_home_url();
                        
                        // Đếm số lượng bài viết (Post count)
                        $count_posts  = wp_count_posts( 'post' );
                        $total_posts  = isset( $count_posts->publish ) ? $count_posts->publish : 0;

                        // Lấy ngày đăng bài mới nhất
                        $latest_post  = get_posts( array(
                            'numberposts' => 1,
                            'post_type'   => 'post',
                            'post_status' => 'publish',
                            'orderby'     => 'date',
                            'order'       => 'DESC'
                        ) );

                        $last_updated = 'Chưa có bài viết';
                        if ( ! empty( $latest_post ) ) {
                            $last_updated = get_the_date( 'Y-m-d H:i:s', $latest_post[0]->ID );
                        }

                        // TRẢ LẠI NGỮ CẢNH CHO SITE GỐC (Rất quan trọng)
                        restore_current_blog();

                        // In dữ liệu ra bảng
                        echo '<tr>';
                        echo '<td><strong>' . esc_html( $blog_id ) . '</strong></td>';
                        echo '<td>' . esc_html( $blog_name ) . '</td>';
                        echo '<td><a href="' . esc_url( $blog_url ) . '" target="_blank">' . esc_url( $blog_url ) . '</a></td>';
                        echo '<td>' . esc_html( $total_posts ) . ' bài viết</td>';
                        echo '<td>' . esc_html( $last_updated ) . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="5">Không tìm thấy site con nào trong hệ thống.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
}