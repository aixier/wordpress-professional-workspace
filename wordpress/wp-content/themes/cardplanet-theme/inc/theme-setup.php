<?php
/**
 * Theme Setup Functions
 */

// 防止直接访问
if (!defined('ABSPATH')) {
    exit;
}

// 注册小工具区域
function cardplanet_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area', 'cardplanet'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Add widgets here.', 'cardplanet'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'cardplanet_widgets_init');

// 自定义页面模板
function cardplanet_page_templates($templates) {
    $templates['page-templates/front-page.php'] = 'CardPlanet 首页';
    $templates['page-templates/case-study.php'] = '案例研究页';
    $templates['page-templates/contact.php'] = '联系我们页';
    return $templates;
}
add_filter('theme_page_templates', 'cardplanet_page_templates');

// 优化WordPress查询
function cardplanet_pre_get_posts($query) {
    if (!is_admin() && $query->is_main_query()) {
        if (is_home()) {
            $query->set('posts_per_page', 10);
        }
    }
}
add_action('pre_get_posts', 'cardplanet_pre_get_posts');

// 添加自定义body类
function cardplanet_body_classes($classes) {
    if (is_front_page()) {
        $classes[] = 'cardplanet-homepage';
    }
    
    if (is_page_template('page-templates/case-study.php')) {
        $classes[] = 'cardplanet-case-study';
    }
    
    return $classes;
}
add_filter('body_class', 'cardplanet_body_classes');