<?php
/**
 * Hero Section Template
 *
 * @package TubeScannerTheme
 */

$locale_content = tubescanner_get_locale_content();

// Get customizer values with fallbacks
$hero_title = get_theme_mod('hero_title', $locale_content['hero_title']);
$hero_subtitle = get_theme_mod('hero_subtitle', $locale_content['hero_subtitle']);
$hero_description = $locale_content['hero_description'];
$cta_button_text = get_theme_mod('cta_button_text', $locale_content['cta_button']);
$cta_button_url = get_theme_mod('cta_button_url', '#');
?>

<section id="hero" class="hero-section bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-900 dark:to-blue-900">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
        <!-- Main Hero Content -->
        <div class="max-w-4xl mx-auto">
            <!-- CTA Content -->
            <div class="space-y-6 mb-12">
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold tracking-tight text-slate-900 dark:text-gray-200 leading-tight">
                    <?php echo esc_html($hero_title); ?>
                </h1>
                
                <p class="text-xl sm:text-2xl md:text-3xl text-slate-700 dark:text-slate-300 leading-relaxed">
                    <?php echo esc_html($hero_subtitle); ?>
                </p>
                
                <p class="text-lg sm:text-xl md:text-2xl text-slate-600 dark:text-slate-400 leading-relaxed max-w-3xl mx-auto">
                    <?php echo esc_html($hero_description); ?>
                </p>
            </div>

            <!-- CTA Button -->
            <div class="mb-16">
                <a href="<?php echo esc_url($cta_button_url); ?>" 
                   class="cta-button inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                    <?php echo esc_html($cta_button_text); ?>
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>

            <!-- Social Proof -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-8 text-slate-600 dark:text-slate-400">
                <div class="flex items-center">
                    <div class="flex -space-x-2">
                        <!-- User avatars -->
                        <div class="w-8 h-8 bg-blue-500 rounded-full border-2 border-white flex items-center justify-center">
                            <span class="text-white text-xs font-bold">1K</span>
                        </div>
                        <div class="w-8 h-8 bg-green-500 rounded-full border-2 border-white"></div>
                        <div class="w-8 h-8 bg-purple-500 rounded-full border-2 border-white"></div>
                        <div class="w-8 h-8 bg-orange-500 rounded-full border-2 border-white flex items-center justify-center">
                            <span class="text-white text-xs">+</span>
                        </div>
                    </div>
                    <span class="ml-3 text-sm font-medium">
                        <?php 
                        $locale = get_locale();
                        if (strpos($locale, 'zh') === 0) {
                            echo '已有1000+企业选择';
                        } else {
                            echo 'Trusted by 1000+ businesses';
                        }
                        ?>
                    </span>
                </div>
                
                <div class="flex items-center">
                    <div class="flex text-yellow-400">
                        <?php for ($i = 0; $i < 5; $i++) : ?>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        <?php endfor; ?>
                    </div>
                    <span class="ml-2 text-sm font-medium">
                        <?php 
                        if (strpos($locale, 'zh') === 0) {
                            echo '4.9/5 用户评分';
                        } else {
                            echo '4.9/5 user rating';
                        }
                        ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Structured Data for SEO -->
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebApplication",
            "name": "<?php echo esc_js($hero_title); ?>",
            "description": "<?php echo esc_js($hero_subtitle); ?>",
            "applicationCategory": "BusinessApplication",
            "operatingSystem": "Web Browser",
            "offers": {
                "@type": "Offer",
                "price": "0",
                "priceCurrency": "USD"
            },
            "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "4.9",
                "reviewCount": "1000"
            }
        }
        </script>
    </div>
</section>