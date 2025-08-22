<?php
/**
 * Header template
 *
 * @package TubeScannerTheme
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Preload critical resources -->
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/assets/fonts/inter.woff2" as="font" type="font/woff2" crossorigin>
    
    <!-- Favicon and app icons -->
    <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/assets/images/tubescanner.png">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/tubescanner.png">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo esc_url(home_url('/')); ?>">
    <meta property="og:title" content="<?php bloginfo('name'); ?>">
    <meta property="og:description" content="<?php bloginfo('description'); ?>">
    <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/assets/images/og-image.png">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo esc_url(home_url('/')); ?>">
    <meta property="twitter:title" content="<?php bloginfo('name'); ?>">
    <meta property="twitter:description" content="<?php bloginfo('description'); ?>">
    <meta property="twitter:image" content="<?php echo get_template_directory_uri(); ?>/assets/images/og-image.png">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site min-h-screen flex flex-col">
    <a class="skip-link screen-reader-text sr-only" href="#primary"><?php esc_html_e('Skip to content', 'tubescanner'); ?></a>

    <header id="masthead" class="site-header bg-white dark:bg-gray-900 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="site-branding">
                    <?php if (has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <h1 class="site-title text-2xl font-bold">
                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="text-gray-900 dark:text-white no-underline">
                                <?php bloginfo('name'); ?>
                            </a>
                        </h1>
                        <?php
                        $description = get_bloginfo('description', 'display');
                        if ($description || is_customize_preview()) : ?>
                            <p class="site-description text-gray-600 dark:text-gray-300 text-sm"><?php echo $description; ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- Navigation Menu -->
                <nav id="site-navigation" class="main-navigation hidden md:block">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'flex space-x-6',
                        'container'      => false,
                        'fallback_cb'    => false,
                    ));
                    ?>
                </nav>

                <!-- CTA Button -->
                <div class="header-cta">
                    <?php 
                    $cta_url = get_theme_mod('cta_button_url', '#');
                    $cta_text = get_theme_mod('cta_button_text');
                    if (!$cta_text) {
                        $locale_content = tubescanner_get_locale_content();
                        $cta_text = $locale_content['cta_button'];
                    }
                    ?>
                    <a href="<?php echo esc_url($cta_url); ?>" class="cta-button">
                        <?php echo esc_html($cta_text); ?>
                    </a>
                </div>

                <!-- Mobile menu button -->
                <button id="mobile-menu-button" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                    <span class="sr-only"><?php esc_html_e('Open main menu', 'tubescanner'); ?></span>
                    <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="md:hidden hidden">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'mobile-primary-menu',
                        'menu_class'     => 'space-y-2',
                        'container'      => false,
                        'fallback_cb'    => false,
                    ));
                    ?>
                </div>
            </div>
        </div>
    </header>