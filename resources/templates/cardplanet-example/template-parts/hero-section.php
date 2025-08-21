<?php
/**
 * Hero Section Template Part
 */

$hero_title = get_field('hero_title') ?: 'Turn your ideas into stunning<br>shareable <span class="highlight">knowledge cards</span>';
$hero_subtitle = get_field('hero_subtitle') ?: 'Convert your complex ideas into visually engaging cards that simplify information, boost engagement, and skyrocket shares. AI-powered, 12 design styles, optimized for all social platforms.';
$hero_cta_text = get_field('hero_cta_text') ?: 'Start Creating Free';
$hero_cta_link = get_field('hero_cta_link') ?: '#contact';
?>

<section class="hero" id="hero">
    <div class="hero__container">
        <div class="hero__grid">
            <div class="hero__content">
                <h1 class="hero__title">
                    <?php echo wp_kses_post($hero_title); ?>
                </h1>
                <p class="hero__subtitle">
                    <?php echo esc_html($hero_subtitle); ?>
                </p>
                <a href="<?php echo esc_url($hero_cta_link); ?>" class="hero__cta">
                    <?php echo cardplanet_get_feature_icon('star'); ?>
                    <?php echo esc_html($hero_cta_text); ?>
                    <?php echo cardplanet_get_feature_icon('arrow'); ?>
                </a>
            </div>
        </div>
    </div>
</section>