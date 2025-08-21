<?php
/**
 * Enqueue Scripts and Styles
 */

// 防止直接访问
if (!defined('ABSPATH')) {
    exit;
}

function cardplanet_scripts() {
    // Google Fonts - Inter字体系统
    wp_enqueue_style(
        'cardplanet-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap',
        array(),
        null
    );
    
    // Font Awesome图标
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
        array(),
        '6.4.0'
    );
    
    // Bootstrap Icons
    wp_enqueue_style(
        'bootstrap-icons',
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css',
        array(),
        '1.11.0'
    );
    
    // 主主题样式
    wp_enqueue_style(
        'cardplanet-style',
        get_template_directory_uri() . '/assets/css/main.css',
        array('cardplanet-google-fonts'),
        '1.0.0'
    );
    
    // 主JavaScript文件
    wp_enqueue_script(
        'cardplanet-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array('jquery'),
        '1.0.0',
        true
    );
    
    // 为JavaScript文件添加本地化数据
    wp_localize_script('cardplanet-main', 'cardplanet_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('cardplanet_nonce'),
        'home_url' => home_url(),
        'theme_url' => get_template_directory_uri(),
    ));
    
    // 评论回复脚本
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'cardplanet_scripts');

// 管理后台样式
function cardplanet_admin_styles() {
    wp_enqueue_style(
        'cardplanet-admin',
        get_template_directory_uri() . '/assets/css/admin.css',
        array(),
        '1.0.0'
    );
}
add_action('admin_enqueue_scripts', 'cardplanet_admin_styles');

// 优化Google字体加载
function cardplanet_preconnect_google_fonts() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
add_action('wp_head', 'cardplanet_preconnect_google_fonts', 1);