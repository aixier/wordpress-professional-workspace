<?php
/**
 * Theme Testing Script
 * Place this in your WordPress root and access via browser to test theme functionality
 *
 * @package TubeScannerTheme
 */

// Prevent direct access without WordPress
if (!defined('ABSPATH')) {
    // Simple WordPress detection
    define('ABSPATH', dirname(__FILE__) . '/../../../../');
    require_once(ABSPATH . 'wp-config.php');
}

// Test theme functions
function test_tubescanner_theme() {
    echo "<h1>TubeScanner Theme Test Results</h1>";
    
    // Test 1: Theme files exist
    echo "<h2>File Structure Test</h2>";
    $required_files = [
        'style.css',
        'functions.php', 
        'index.php',
        'header.php',
        'footer.php',
        'template-parts/sections/hero.php',
        'template-parts/sections/features.php',
        'template-parts/sections/testimonials.php',
        'template-parts/sections/faq.php',
        'template-parts/sections/cta.php'
    ];
    
    $theme_dir = get_template_directory();
    foreach ($required_files as $file) {
        $file_path = $theme_dir . '/' . $file;
        if (file_exists($file_path)) {
            echo "✅ {$file} exists<br>";
        } else {
            echo "❌ {$file} missing<br>";
        }
    }
    
    // Test 2: Theme support features
    echo "<h2>Theme Support Test</h2>";
    $features = [
        'title-tag' => 'Title Tag',
        'post-thumbnails' => 'Post Thumbnails',
        'html5' => 'HTML5',
        'custom-logo' => 'Custom Logo',
        'menus' => 'Navigation Menus'
    ];
    
    foreach ($features as $feature => $label) {
        if (current_theme_supports($feature)) {
            echo "✅ {$label} supported<br>";
        } else {
            echo "❌ {$label} not supported<br>";
        }
    }
    
    // Test 3: Functions exist
    echo "<h2>Function Test</h2>";
    $functions = [
        'tubescanner_setup' => 'Theme Setup',
        'tubescanner_scripts' => 'Scripts Enqueue',
        'tubescanner_get_locale_content' => 'Locale Content',
        'tubescanner_widgets_init' => 'Widgets Init'
    ];
    
    foreach ($functions as $function => $label) {
        if (function_exists($function)) {
            echo "✅ {$function}() exists<br>";
        } else {
            echo "❌ {$function}() missing<br>";
        }
    }
    
    // Test 4: Locale content
    echo "<h2>Locale Content Test</h2>";
    if (function_exists('tubescanner_get_locale_content')) {
        $content = tubescanner_get_locale_content();
        if (isset($content['hero_title']) && !empty($content['hero_title'])) {
            echo "✅ Locale content loaded: " . esc_html($content['hero_title']) . "<br>";
        } else {
            echo "❌ Locale content not loaded properly<br>";
        }
    }
    
    // Test 5: WordPress integration
    echo "<h2>WordPress Integration Test</h2>";
    echo "WordPress Version: " . get_bloginfo('version') . "<br>";
    echo "Active Theme: " . get_template() . "<br>";
    echo "Theme Directory: " . get_template_directory() . "<br>";
    
    // Test 6: Asset URLs
    echo "<h2>Asset URLs Test</h2>";
    echo "Theme URL: " . get_template_directory_uri() . "<br>";
    echo "Style URL: " . get_stylesheet_uri() . "<br>";
    
    echo "<h2>Test Complete!</h2>";
    echo "<p>If all tests pass, your TubeScanner theme is ready to use.</p>";
    echo "<p><a href='" . home_url() . "'>View your site →</a></p>";
}

// Run test if accessed directly
if (isset($_GET['test']) && $_GET['test'] === 'tubescanner') {
    test_tubescanner_theme();
    exit;
}
?>