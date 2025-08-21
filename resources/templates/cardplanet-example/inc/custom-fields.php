<?php
/**
 * ACF Custom Fields Configuration
 */

// 防止直接访问
if (!defined('ABSPATH')) {
    exit;
}

if (function_exists('acf_add_local_field_group')) {
    
    // Hero Section Fields
    acf_add_local_field_group(array(
        'key' => 'group_hero_section',
        'title' => 'Hero Section',
        'fields' => array(
            array(
                'key' => 'field_hero_title',
                'label' => 'Hero Title',
                'name' => 'hero_title',
                'type' => 'text',
                'default_value' => 'Turn your ideas into stunning shareable knowledge cards',
                'instructions' => '主标题文字，支持HTML标签',
            ),
            array(
                'key' => 'field_hero_subtitle',
                'label' => 'Hero Subtitle',
                'name' => 'hero_subtitle',
                'type' => 'textarea',
                'default_value' => 'Convert your complex ideas into visually engaging cards that simplify information, boost engagement, and skyrocket shares. AI-powered, 12 design styles, optimized for all social platforms.',
                'instructions' => '副标题描述文字',
            ),
            array(
                'key' => 'field_hero_cta_text',
                'label' => 'CTA Button Text',
                'name' => 'hero_cta_text',
                'type' => 'text',
                'default_value' => 'Start Creating Free',
                'instructions' => '主要行动按钮文字',
            ),
            array(
                'key' => 'field_hero_cta_link',
                'label' => 'CTA Button Link',
                'name' => 'hero_cta_link',
                'type' => 'url',
                'default_value' => '#contact',
                'instructions' => '主要行动按钮链接',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-templates/front-page.php',
                ),
            ),
        ),
    ));
    
    // Showcase Gallery Fields
    acf_add_local_field_group(array(
        'key' => 'group_showcase_gallery',
        'title' => 'Showcase Gallery',
        'fields' => array(
            array(
                'key' => 'field_showcase_title',
                'label' => 'Gallery Title',
                'name' => 'showcase_title',
                'type' => 'text',
                'default_value' => 'Real Examples Created with CardPlanet',
            ),
            array(
                'key' => 'field_showcase_subtitle',
                'label' => 'Gallery Subtitle',
                'name' => 'showcase_subtitle',
                'type' => 'text',
                'default_value' => 'Click on any card to view the complete case study',
            ),
            array(
                'key' => 'field_showcase_items',
                'label' => 'Showcase Items',
                'name' => 'showcase_items',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_showcase_item_title',
                        'label' => 'Item Title',
                        'name' => 'title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_showcase_item_style',
                        'label' => 'Design Style',
                        'name' => 'style',
                        'type' => 'select',
                        'choices' => array(
                            'System Clean' => 'System Clean',
                            'Impressionist Soft' => 'Impressionist Soft',
                            'Geometric Symphony' => 'Geometric Symphony',
                            'Minimal' => 'Minimal',
                            'Pin Board' => 'Pin Board',
                            'Editorial Soft' => 'Editorial Soft',
                            'Luxe Print' => 'Luxe Print',
                            'Woven Texture' => 'Woven Texture',
                            'Cosmic Empire' => 'Cosmic Empire',
                            'Fluid Zen' => 'Fluid Zen',
                            'Chinese Artistry' => 'Chinese Artistry',
                            'Bubble Fresh' => 'Bubble Fresh',
                        ),
                    ),
                    array(
                        'key' => 'field_showcase_item_image',
                        'label' => 'Preview Image',
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'cardplanet-showcase',
                    ),
                    array(
                        'key' => 'field_showcase_item_link',
                        'label' => 'Detail Page Link',
                        'name' => 'link',
                        'type' => 'url',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-templates/front-page.php',
                ),
            ),
        ),
    ));
    
    // Features Section Fields
    acf_add_local_field_group(array(
        'key' => 'group_features_section',
        'title' => 'Features Section',
        'fields' => array(
            array(
                'key' => 'field_features_list',
                'label' => 'Features List',
                'name' => 'features_list',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_feature_title',
                        'label' => 'Feature Title',
                        'name' => 'title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_feature_description',
                        'label' => 'Feature Description',
                        'name' => 'description',
                        'type' => 'wysiwyg',
                        'toolbar' => 'basic',
                        'media_upload' => 0,
                    ),
                    array(
                        'key' => 'field_feature_media',
                        'label' => 'Feature Media',
                        'name' => 'media',
                        'type' => 'group',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_media_type',
                                'label' => 'Media Type',
                                'name' => 'type',
                                'type' => 'select',
                                'choices' => array(
                                    'video' => 'Video',
                                    'image' => 'Image',
                                    'gallery' => 'Image Gallery',
                                ),
                            ),
                            array(
                                'key' => 'field_media_video',
                                'label' => 'Video File',
                                'name' => 'video',
                                'type' => 'file',
                                'return_format' => 'array',
                                'conditional_logic' => array(
                                    array(
                                        array(
                                            'field' => 'field_media_type',
                                            'operator' => '==',
                                            'value' => 'video',
                                        ),
                                    ),
                                ),
                            ),
                            array(
                                'key' => 'field_media_image',
                                'label' => 'Image',
                                'name' => 'image',
                                'type' => 'image',
                                'return_format' => 'array',
                                'preview_size' => 'cardplanet-feature',
                                'conditional_logic' => array(
                                    array(
                                        array(
                                            'field' => 'field_media_type',
                                            'operator' => '==',
                                            'value' => 'image',
                                        ),
                                    ),
                                ),
                            ),
                            array(
                                'key' => 'field_media_gallery',
                                'label' => 'Image Gallery',
                                'name' => 'gallery',
                                'type' => 'gallery',
                                'conditional_logic' => array(
                                    array(
                                        array(
                                            'field' => 'field_media_type',
                                            'operator' => '==',
                                            'value' => 'gallery',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                    array(
                        'key' => 'field_feature_layout',
                        'label' => 'Layout Direction',
                        'name' => 'layout',
                        'type' => 'select',
                        'choices' => array(
                            'left' => 'Content Left, Media Right',
                            'right' => 'Content Right, Media Left',
                        ),
                        'default_value' => 'left',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-templates/front-page.php',
                ),
            ),
        ),
    ));
    
    // Capabilities Section Fields
    acf_add_local_field_group(array(
        'key' => 'group_capabilities_section',
        'title' => 'Capabilities Section',
        'fields' => array(
            array(
                'key' => 'field_capabilities_title',
                'label' => 'Section Title',
                'name' => 'capabilities_title',
                'type' => 'text',
                'default_value' => 'Creating Viral Knowledge Cards Has Never Been Easier',
            ),
            array(
                'key' => 'field_capabilities_list',
                'label' => 'Capabilities List',
                'name' => 'capabilities_list',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_capability_icon',
                        'label' => 'Icon Class',
                        'name' => 'icon',
                        'type' => 'text',
                        'instructions' => 'Font Awesome图标类名，如：fas fa-share',
                    ),
                    array(
                        'key' => 'field_capability_title',
                        'label' => 'Capability Title',
                        'name' => 'title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_capability_description',
                        'label' => 'Capability Description',
                        'name' => 'description',
                        'type' => 'textarea',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-templates/front-page.php',
                ),
            ),
        ),
    ));
}

// 检查ACF插件是否激活
function cardplanet_check_acf() {
    if (!class_exists('ACF')) {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-warning is-dismissible">';
            echo '<p><strong>CardPlanet主题提醒：</strong>请安装并激活 Advanced Custom Fields 插件以获得完整功能。</p>';
            echo '</div>';
        });
    }
}
add_action('after_setup_theme', 'cardplanet_check_acf');