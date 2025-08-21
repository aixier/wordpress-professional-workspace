<?php
/**
 * Minimal CardPlanet Theme Functions
 */

// 防止直接访问
if (!defined('ABSPATH')) {
    exit;
}

// 最基本的主题设置
function cardplanet_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'cardplanet_theme_setup');