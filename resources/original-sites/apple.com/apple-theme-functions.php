<?php
/**
 * Apple Website Theme Functions
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function apple_theme_setup() {
    // Add theme support for various features
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'script',
        'style',
    ));
    
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('custom-header');
    add_theme_support('custom-background');
    
    // Add RSS feed links to head
    add_theme_support('automatic-feed-links');
    
    // Add responsive embeds
    add_theme_support('responsive-embeds');
    
    // Add wide alignment support
    add_theme_support('align-wide');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Navigation', 'apple-theme'),
        'footer' => __('Footer Navigation', 'apple-theme'),
    ));
}
add_action('after_setup_theme', 'apple_theme_setup');

/**
 * Enqueue Scripts and Styles
 */
function apple_theme_scripts() {
    // Theme stylesheet
    wp_enqueue_style(
        'apple-theme-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get('Version')
    );
    
    // Apple-specific fonts (SF Pro)
    wp_enqueue_style(
        'apple-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap',
        array(),
        null
    );
    
    // Theme JavaScript
    wp_enqueue_script(
        'apple-theme-script',
        get_template_directory_uri() . '/assets/js/main.js',
        array('jquery'),
        wp_get_theme()->get('Version'),
        true
    );
    
    // Smooth scrolling and interactions
    wp_enqueue_script(
        'apple-interactions',
        get_template_directory_uri() . '/assets/js/interactions.js',
        array('jquery'),
        wp_get_theme()->get('Version'),
        true
    );
    
    // Localize script for AJAX
    wp_localize_script('apple-theme-script', 'apple_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('apple_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'apple_theme_scripts');

/**
 * Remove WordPress default styles that conflict with Apple design
 */
function apple_theme_dequeue_styles() {
    // Remove block library CSS for cleaner Apple aesthetic
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-block-style');
}
add_action('wp_enqueue_scripts', 'apple_theme_dequeue_styles', 100);

/**
 * Customize WordPress admin for Apple theme
 */
function apple_theme_admin_style() {
    echo '<style>
        .wp-admin #wpadminbar {
            background: rgba(255, 255, 255, 0.72) !important;
            backdrop-filter: saturate(180%) blur(20px) !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1) !important;
        }
        .wp-admin #wpadminbar .ab-item {
            color: #1d1d1f !important;
        }
    </style>';
}
add_action('admin_head', 'apple_theme_admin_style');
add_action('wp_head', 'apple_theme_admin_style');

/**
 * Add Apple-specific body classes
 */
function apple_theme_body_classes($classes) {
    $classes[] = 'apple-design';
    $classes[] = 'no-js';
    
    if (is_front_page()) {
        $classes[] = 'page-home';
    }
    
    return $classes;
}
add_filter('body_class', 'apple_theme_body_classes');

/**
 * Custom logo setup
 */
function apple_theme_custom_logo_setup() {
    $defaults = array(
        'height'      => 44,
        'width'       => 16,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array('site-title', 'site-description'),
    );
    add_theme_support('custom-logo', $defaults);
}
add_action('after_setup_theme', 'apple_theme_custom_logo_setup');

/**
 * Disable WordPress emoji scripts (for performance)
 */
function apple_theme_disable_emoji() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'apple_theme_disable_emoji');

/**
 * Clean up WordPress head
 */
function apple_theme_clean_head() {
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'start_post_rel_link', 10, 0);
    remove_action('wp_head', 'parent_post_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
}
add_action('init', 'apple_theme_clean_head');

/**
 * Add Apple-specific meta tags
 */
function apple_theme_meta_tags() {
    echo '<meta name="apple-mobile-web-app-capable" content="yes">' . "\n";
    echo '<meta name="apple-mobile-web-app-status-bar-style" content="default">' . "\n";
    echo '<meta name="apple-mobile-web-app-title" content="' . get_bloginfo('name') . '">' . "\n";
    echo '<meta name="format-detection" content="telephone=no">' . "\n";
    echo '<meta name="theme-color" content="#000000">' . "\n";
}
add_action('wp_head', 'apple_theme_meta_tags');

/**
 * Remove WordPress version from scripts and styles
 */
function apple_theme_remove_version_scripts_styles($src) {
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'apple_theme_remove_version_scripts_styles', 9999);
add_filter('script_loader_src', 'apple_theme_remove_version_scripts_styles', 9999);

/**
 * Add JavaScript to replace 'no-js' class with 'js'
 */
function apple_theme_js_detection() {
    echo "<script>document.documentElement.className = document.documentElement.className.replace('no-js', 'js');</script>\n";
}
add_action('wp_head', 'apple_theme_js_detection', 0);

/**
 * Customize excerpt length
 */
function apple_theme_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'apple_theme_excerpt_length', 999);

/**
 * Customize excerpt more string
 */
function apple_theme_excerpt_more($more) {
    return '…';
}
add_filter('excerpt_more', 'apple_theme_excerpt_more');

/**
 * Register sidebar areas
 */
function apple_theme_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'apple-theme'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here.', 'apple-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer', 'apple-theme'),
        'id'            => 'footer-1',
        'description'   => __('Add footer widgets here.', 'apple-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'apple_theme_widgets_init');

/**
 * Add theme customizer options
 */
function apple_theme_customize_register($wp_customize) {
    // Hero Section
    $wp_customize->add_section('apple_hero', array(
        'title'    => __('Hero Section', 'apple-theme'),
        'priority' => 30,
    ));
    
    $wp_customize->add_setting('hero_title', array(
        'default'           => 'Discover the innovative world of Apple',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('hero_title', array(
        'label'   => __('Hero Title', 'apple-theme'),
        'section' => 'apple_hero',
        'type'    => 'text',
    ));
    
    $wp_customize->add_setting('hero_subtitle', array(
        'default'           => 'Shop everything iPhone, iPad, Apple Watch, Mac, and Apple TV',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('hero_subtitle', array(
        'label'   => __('Hero Subtitle', 'apple-theme'),
        'section' => 'apple_hero',
        'type'    => 'text',
    ));
}
add_action('customize_register', 'apple_theme_customize_register');

/**
 * Add support for editor styles
 */
function apple_theme_add_editor_styles() {
    add_theme_support('editor-styles');
    add_editor_style('style-editor.css');
}
add_action('after_setup_theme', 'apple_theme_add_editor_styles');

/**
 * Security enhancements
 */
function apple_theme_security() {
    // Remove WordPress version from head
    remove_action('wp_head', 'wp_generator');
    
    // Disable XML-RPC
    add_filter('xmlrpc_enabled', '__return_false');
    
    // Remove unnecessary headers
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
}
add_action('init', 'apple_theme_security');
?>