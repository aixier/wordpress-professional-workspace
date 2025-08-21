<?php
/**
 * Basic Migration Theme Functions
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Theme setup
function basic_migration_theme_setup() {
    // Add theme support
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
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Navigation', 'basic-theme'),
        'footer' => __('Footer Navigation', 'basic-theme'),
    ));
    
    // Set content width
    if (!isset($content_width)) {
        $content_width = 1200;
    }
}
add_action('after_setup_theme', 'basic_migration_theme_setup');

// Remove WordPress default styles that might conflict with your design
function basic_migration_dequeue_wp_styles() {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('classic-theme-styles');
}
add_action('wp_enqueue_scripts', 'basic_migration_dequeue_wp_styles', 100);

// Enqueue custom styles and scripts
function basic_migration_enqueue_scripts() {
    // Enqueue your custom CSS
    wp_enqueue_style('basic-migration-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Enqueue custom JavaScript if needed
    // wp_enqueue_script('basic-migration-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'basic_migration_enqueue_scripts');

// Add custom image sizes if needed
function basic_migration_custom_image_sizes() {
    // Example: add_image_size('custom-size', 300, 200, true);
}
add_action('after_setup_theme', 'basic_migration_custom_image_sizes');

// Custom functions for your migrated site
// Add any custom functionality your original site had here

?>