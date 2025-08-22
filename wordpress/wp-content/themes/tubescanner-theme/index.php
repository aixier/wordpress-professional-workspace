<?php
/**
 * Main template file
 *
 * @package TubeScannerTheme
 */

get_header(); ?>

<main id="primary" class="site-main">
    <?php if (is_front_page()) : ?>
        <!-- Hero Section -->
        <?php get_template_part('template-parts/sections/hero'); ?>
        
        <!-- Features Section -->
        <?php get_template_part('template-parts/sections/features'); ?>
        
        <!-- Testimonials Section -->
        <?php get_template_part('template-parts/sections/testimonials'); ?>
        
        <!-- FAQ Section -->
        <?php get_template_part('template-parts/sections/faq'); ?>
        
        <!-- CTA Section -->
        <?php get_template_part('template-parts/sections/cta'); ?>
        
    <?php else : ?>
        <!-- Standard content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('mb-12'); ?>>
                        <header class="entry-header mb-6">
                            <?php the_title('<h1 class="entry-title text-4xl font-bold">', '</h1>'); ?>
                        </header>
                        
                        <div class="entry-content prose lg:prose-xl max-w-none">
                            <?php the_content(); ?>
                        </div>
                    </article>
                <?php endwhile; ?>
                
                <?php the_posts_navigation(); ?>
                
            <?php else : ?>
                <div class="text-center py-12">
                    <h1 class="text-2xl font-bold mb-4"><?php esc_html_e('Nothing here', 'tubescanner'); ?></h1>
                    <p class="text-gray-600"><?php esc_html_e('It looks like nothing was found at this location.', 'tubescanner'); ?></p>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</main>

<?php
get_sidebar();
get_footer();