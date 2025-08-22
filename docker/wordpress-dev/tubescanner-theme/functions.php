<?php
/**
 * TubeScanner Theme Functions
 * 
 * @package TubeScannerTheme
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function tubescanner_setup() {
    // Add theme support for various features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('custom-logo');
    add_theme_support('menus');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'tubescanner'),
        'footer' => __('Footer Menu', 'tubescanner'),
    ));
    
    // Add theme support for internationalization
    load_theme_textdomain('tubescanner', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'tubescanner_setup');

/**
 * Enqueue scripts and styles
 */
function tubescanner_scripts() {
    // Main stylesheet
    wp_enqueue_style('tubescanner-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Tailwind CSS CDN
    wp_enqueue_style('tailwind-css', 'https://cdn.tailwindcss.com', array(), '3.4.0');
    
    // Custom theme styles
    wp_enqueue_style('tubescanner-custom', get_template_directory_uri() . '/assets/css/custom.css', array('tubescanner-style'), '1.0.0');
    
    // JavaScript files
    wp_enqueue_script('tubescanner-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
    
    // Localize script for AJAX and translations
    wp_localize_script('tubescanner-main', 'tubescanner_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('tubescanner_nonce'),
        'locale' => get_locale(),
    ));
}
add_action('wp_enqueue_scripts', 'tubescanner_scripts');

/**
 * Widget Areas
 */
function tubescanner_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'tubescanner'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your sidebar.', 'tubescanner'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer', 'tubescanner'),
        'id'            => 'footer-1',
        'description'   => __('Add widgets here to appear in your footer.', 'tubescanner'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'tubescanner_widgets_init');

/**
 * Custom Post Types and Fields (if needed for features)
 */
function tubescanner_custom_post_types() {
    // Features post type
    register_post_type('features', array(
        'labels' => array(
            'name' => __('Features', 'tubescanner'),
            'singular_name' => __('Feature', 'tubescanner'),
            'add_new' => __('Add New Feature', 'tubescanner'),
            'edit_item' => __('Edit Feature', 'tubescanner'),
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-star-filled',
    ));
    
    // Testimonials post type
    register_post_type('testimonials', array(
        'labels' => array(
            'name' => __('Testimonials', 'tubescanner'),
            'singular_name' => __('Testimonial', 'tubescanner'),
            'add_new' => __('Add New Testimonial', 'tubescanner'),
            'edit_item' => __('Edit Testimonial', 'tubescanner'),
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-format-quote',
    ));
}
add_action('init', 'tubescanner_custom_post_types');

/**
 * Theme Customizer
 */
function tubescanner_customize_register($wp_customize) {
    // Hero Section
    $wp_customize->add_section('hero_section', array(
        'title' => __('Hero Section', 'tubescanner'),
        'priority' => 30,
    ));
    
    // Hero Title
    $wp_customize->add_setting('hero_title', array(
        'default' => __('TubeScanner - YouTube & TikTok Analytics Tool', 'tubescanner'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_title', array(
        'label' => __('Hero Title', 'tubescanner'),
        'section' => 'hero_section',
        'type' => 'text',
    ));
    
    // Hero Subtitle
    $wp_customize->add_setting('hero_subtitle', array(
        'default' => __('Professional social media analytics for cross-border e-commerce', 'tubescanner'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_subtitle', array(
        'label' => __('Hero Subtitle', 'tubescanner'),
        'section' => 'hero_section',
        'type' => 'text',
    ));
    
    // CTA Button Text
    $wp_customize->add_setting('cta_button_text', array(
        'default' => __('Get Started Now', 'tubescanner'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('cta_button_text', array(
        'label' => __('CTA Button Text', 'tubescanner'),
        'section' => 'hero_section',
        'type' => 'text',
    ));
    
    // CTA Button URL
    $wp_customize->add_setting('cta_button_url', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('cta_button_url', array(
        'label' => __('CTA Button URL', 'tubescanner'),
        'section' => 'hero_section',
        'type' => 'url',
    ));
}
add_action('customize_register', 'tubescanner_customize_register');

/**
 * Get localized content based on current locale
 */
function tubescanner_get_locale_content() {
    $locale = get_locale();
    $lang = (strpos($locale, 'zh') === 0) ? 'zh' : 'en';
    
    $content = array(
        'zh' => array(
            'hero_title' => '立即安装TubeScanner',
            'hero_subtitle' => '让您的跨境社媒运营更专业、更高效！',
            'hero_description' => '发现优质账号，获取市场洞察，制定制胜策略。',
            'cta_button' => '立即使用',
            'features_title' => '为什么选择 TubeScanner ？',
        ),
        'en' => array(
            'hero_title' => 'Install TubeScanner Now',
            'hero_subtitle' => 'Make your cross-border social media operations more professional and efficient!',
            'hero_description' => 'Discover quality accounts, get market insights, develop winning strategies.',
            'cta_button' => 'Get Started',
            'features_title' => 'Why Choose TubeScanner?',
        )
    );
    
    return $content[$lang];
}

/**
 * Add structured data for SEO
 */
function tubescanner_structured_data() {
    $locale_content = tubescanner_get_locale_content();
    
    $structured_data = array(
        '@context' => 'https://schema.org',
        '@type' => 'SoftwareApplication',
        'name' => $locale_content['hero_title'],
        'description' => $locale_content['hero_subtitle'],
        'applicationCategory' => 'BusinessApplication',
        'operatingSystem' => 'Web Browser',
        'offers' => array(
            '@type' => 'Offer',
            'price' => '0',
            'priceCurrency' => 'USD'
        )
    );
    
    echo '<script type="application/ld+json">' . json_encode($structured_data) . '</script>';
}
add_action('wp_head', 'tubescanner_structured_data');

/**
 * Add custom body classes
 */
function tubescanner_body_classes($classes) {
    $locale = get_locale();
    $lang = (strpos($locale, 'zh') === 0) ? 'zh' : 'en';
    $classes[] = 'lang-' . $lang;
    
    if (is_front_page()) {
        $classes[] = 'landing-page';
    }
    
    return $classes;
}
add_filter('body_class', 'tubescanner_body_classes');