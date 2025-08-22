<?php
/**
 * CTA Section Template
 *
 * @package TubeScannerTheme
 */

$locale = get_locale();
$lang = (strpos($locale, 'zh') === 0) ? 'zh' : 'en';
$locale_content = tubescanner_get_locale_content();

$cta_button_text = get_theme_mod('cta_button_text', $locale_content['cta_button']);
$cta_button_url = get_theme_mod('cta_button_url', '#');
?>

<section id="cta" class="py-20 bg-gradient-to-br from-blue-600 via-purple-600 to-blue-700 relative overflow-hidden">
    <!-- Background decorations -->
    <div class="absolute inset-0 bg-black/10"></div>
    <div class="absolute top-0 left-1/4 w-72 h-72 bg-white/5 rounded-full filter blur-3xl"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-300/10 rounded-full filter blur-3xl"></div>
    
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Main CTA Content -->
        <div class="mb-12">
            <h2 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white mb-6 leading-tight">
                <?php 
                if ($lang === 'zh') {
                    echo '立即开始您的<br>社媒分析之旅';
                } else {
                    echo 'Start Your Social Media<br>Analytics Journey Today';
                }
                ?>
            </h2>
            
            <p class="text-xl sm:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto leading-relaxed">
                <?php 
                if ($lang === 'zh') {
                    echo '加入1000+企业的选择，用专业的数据洞察助力您的跨境电商成功';
                } else {
                    echo 'Join the choice of 1000+ enterprises and use professional data insights to boost your cross-border e-commerce success';
                }
                ?>
            </p>
        </div>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mb-12">
            <!-- Primary CTA -->
            <a href="<?php echo esc_url($cta_button_url); ?>" 
               class="group inline-flex items-center justify-center px-8 py-4 text-xl font-bold text-blue-600 bg-white hover:bg-gray-50 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                <?php echo esc_html($cta_button_text); ?>
                <svg class="ml-3 w-6 h-6 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
            
            <!-- Secondary CTA -->
            <a href="#features" 
               class="group inline-flex items-center justify-center px-8 py-4 text-xl font-semibold text-white border-2 border-white/30 hover:border-white hover:bg-white/10 rounded-xl transition-all duration-300">
                <?php echo ($lang === 'zh') ? '了解更多功能' : 'Learn More Features'; ?>
                <svg class="ml-3 w-6 h-6 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </a>
        </div>

        <!-- Trust indicators -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-8 text-blue-100">
            <!-- Free trial -->
            <div class="flex items-center">
                <svg class="w-6 h-6 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="font-medium">
                    <?php echo ($lang === 'zh') ? '免费试用' : 'Free Trial'; ?>
                </span>
            </div>
            
            <!-- No credit card -->
            <div class="flex items-center">
                <svg class="w-6 h-6 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="font-medium">
                    <?php echo ($lang === 'zh') ? '无需信用卡' : 'No Credit Card Required'; ?>
                </span>
            </div>
            
            <!-- Instant access -->
            <div class="flex items-center">
                <svg class="w-6 h-6 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="font-medium">
                    <?php echo ($lang === 'zh') ? '即时访问' : 'Instant Access'; ?>
                </span>
            </div>
        </div>

        <!-- Stats -->
        <div class="mt-16 grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
            <div class="group">
                <div class="text-4xl font-bold text-white mb-2 group-hover:scale-110 transition-transform duration-300">1000+</div>
                <div class="text-blue-200">
                    <?php echo ($lang === 'zh') ? '信任企业' : 'Trusted Companies'; ?>
                </div>
            </div>
            <div class="group">
                <div class="text-4xl font-bold text-white mb-2 group-hover:scale-110 transition-transform duration-300">24/7</div>
                <div class="text-blue-200">
                    <?php echo ($lang === 'zh') ? '专业支持' : 'Professional Support'; ?>
                </div>
            </div>
            <div class="group">
                <div class="text-4xl font-bold text-white mb-2 group-hover:scale-110 transition-transform duration-300">4.9★</div>
                <div class="text-blue-200">
                    <?php echo ($lang === 'zh') ? '用户评分' : 'User Rating'; ?>
                </div>
            </div>
        </div>

        <!-- Urgency message -->
        <div class="mt-12 inline-flex items-center justify-center px-6 py-3 bg-orange-500/20 border border-orange-400/30 rounded-full">
            <svg class="w-5 h-5 text-orange-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-orange-200 font-medium text-sm">
                <?php 
                if ($lang === 'zh') {
                    echo '限时免费试用，立即体验专业功能';
                } else {
                    echo 'Limited-time free trial, experience professional features now';
                }
                ?>
            </span>
        </div>
    </div>
</section>