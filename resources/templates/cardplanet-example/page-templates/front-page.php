<?php
/**
 * Template Name: CardPlanet 首页
 * 
 * The front page template for CardPlanet
 */

get_header(); ?>

<div class="cardplanet-homepage">
    <?php
    // Hero Section
    get_template_part('template-parts/hero-section');
    
    // Showcase Gallery Section
    get_template_part('template-parts/showcase-section');
    
    // Features Section
    get_template_part('template-parts/features-section');
    
    // Capabilities Section
    get_template_part('template-parts/capabilities-section');
    
    // Pricing Section
    get_template_part('template-parts/pricing-section');
    ?>
</div>

<?php get_footer(); ?>