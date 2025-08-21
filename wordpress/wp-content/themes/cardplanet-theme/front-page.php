<?php
/**
 * The front page template
 */

get_header(); ?>

<div class="cardplanet-homepage">
    <?php
    // Check if the page is using the front-page template
    if (get_page_template_slug() === 'page-templates/front-page.php') {
        // Use the custom template parts
        get_template_part('template-parts/hero-section');
    } else {
        // Default front page content
        if (have_posts()) :
            while (have_posts()) : the_post();
                ?>
                <div class="hero">
                    <div class="hero__container">
                        <div class="hero__grid">
                            <div class="hero__content">
                                <h1 class="hero__title">
                                    <?php 
                                    if (get_the_title()) {
                                        the_title();
                                    } else {
                                        echo 'Welcome to <span class="highlight">CardPlanet</span>';
                                    }
                                    ?>
                                </h1>
                                <?php if (get_the_content()) : ?>
                                    <div class="hero__subtitle">
                                        <?php the_content(); ?>
                                    </div>
                                <?php else : ?>
                                    <p class="hero__subtitle">
                                        AI-Powered Creative Card Design Platform. Transform your ideas into stunning shareable knowledge cards.
                                    </p>
                                <?php endif; ?>
                                <a href="#contact" class="hero__cta">
                                    <?php echo cardplanet_get_feature_icon('star'); ?>
                                    Get Started
                                    <?php echo cardplanet_get_feature_icon('arrow'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            endwhile;
        else :
            ?>
            <div class="hero">
                <div class="hero__container">
                    <div class="hero__grid">
                        <div class="hero__content">
                            <h1 class="hero__title">
                                Welcome to <span class="highlight">CardPlanet</span>
                            </h1>
                            <p class="hero__subtitle">
                                AI-Powered Creative Card Design Platform. Transform your ideas into stunning shareable knowledge cards.
                            </p>
                            <a href="#contact" class="hero__cta">
                                <?php echo cardplanet_get_feature_icon('star'); ?>
                                Get Started
                                <?php echo cardplanet_get_feature_icon('arrow'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        endif;
    ?>
</div>

<?php get_footer(); ?>