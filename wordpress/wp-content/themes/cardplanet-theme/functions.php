<?php
/**
 * CardPlanet Theme Functions
 */

// 防止直接访问
if (!defined('ABSPATH')) {
    exit;
}

// 主题设置
require_once get_template_directory() . '/inc/theme-setup.php';
require_once get_template_directory() . '/inc/enqueue-scripts.php';
require_once get_template_directory() . '/inc/custom-fields.php';
require_once get_template_directory() . '/inc/custom-functions.php';

// 主题支持
function cardplanet_theme_setup() {
    // 添加主题支持
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('custom-logo');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    
    // 注册菜单
    register_nav_menus(array(
        'primary' => __('主导航', 'cardplanet'),
        'footer' => __('页脚导航', 'cardplanet'),
    ));
    
    // 设置内容宽度
    if (!isset($content_width)) {
        $content_width = 1200;
    }
}
add_action('after_setup_theme', 'cardplanet_theme_setup');

// 移除WordPress默认样式和脚本
function cardplanet_dequeue_wp_styles() {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-blocks-style');
    wp_dequeue_style('classic-theme-styles');
}
add_action('wp_enqueue_scripts', 'cardplanet_dequeue_wp_styles', 100);

// 自定义后台编辑器样式
function cardplanet_add_editor_styles() {
    add_editor_style(get_template_directory_uri() . '/assets/css/editor-style.css');
}
add_action('after_setup_theme', 'cardplanet_add_editor_styles');

// 自定义图片尺寸
function cardplanet_custom_image_sizes() {
    add_image_size('cardplanet-showcase', 320, 481, true); // 展示画廊
    add_image_size('cardplanet-card', 280, 373, true); // 卡片预览
    add_image_size('cardplanet-feature', 600, 400, true); // 功能展示
}
add_action('after_setup_theme', 'cardplanet_custom_image_sizes');