<?php
/**
 * Features Section Template
 *
 * @package TubeScannerTheme
 */

$locale = get_locale();
$lang = (strpos($locale, 'zh') === 0) ? 'zh' : 'en';
$locale_content = tubescanner_get_locale_content();

// Feature data arrays
$features_zh = array(
    array(
        'title' => '专业性',
        'content' => '专注跨境社媒分析\n深度数据洞察，持续更新迭代',
        'icon' => 'chart-line'
    ),
    array(
        'title' => '效率性', 
        'content' => '一键获取目标账号\n快速生成分析报告，节省调研时间',
        'icon' => 'rocket'
    ),
    array(
        'title' => '易用性',
        'content' => '界面简洁直观，操作便捷高效\n无需专业培训即可上手',
        'icon' => 'smile'
    ),
    array(
        'title' => '可靠性',
        'content' => '数据准确及时，性能稳定\n安全隐私保护，持续技术支持',
        'icon' => 'shield'
    ),
);

$features_en = array(
    array(
        'title' => 'Professional',
        'content' => 'Focused social media analysis\nDeep data insights with continuous updates',
        'icon' => 'chart-line'
    ),
    array(
        'title' => 'Efficient',
        'content' => 'One-click account discovery\nQuick report generation, saving research time',
        'icon' => 'rocket'
    ),
    array(
        'title' => 'User-Friendly',
        'content' => 'Clean, intuitive interface\nNo professional training needed',
        'icon' => 'smile'
    ),
    array(
        'title' => 'Reliable',
        'content' => 'Accurate and timely data\nSecure privacy protection with ongoing technical support',
        'icon' => 'shield'
    ),
);

$features = ($lang === 'zh') ? $features_zh : $features_en;

// Icon mapping
function get_feature_icon($icon_name) {
    $icons = array(
        'chart-line' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>',
        'rocket' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>',
        'smile' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        'shield' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>',
    );
    
    return isset($icons[$icon_name]) ? $icons[$icon_name] : $icons['chart-line'];
}
?>

<section id="features" class="py-20 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-4xl sm:text-5xl font-bold text-slate-900 dark:text-gray-200 mb-6">
                <span class="relative inline-block">
                    <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        <?php echo esc_html($locale_content['features_title']); ?>
                    </span>
                    <!-- Highlight decoration -->
                    <span class="absolute -inset-1 bg-blue-100 dark:bg-blue-900/20 transform rotate-1 rounded-lg -z-10"></span>
                </span>
            </h2>
            <p class="text-xl text-slate-600 dark:text-slate-400 max-w-3xl mx-auto">
                <?php 
                if ($lang === 'zh') {
                    echo '专为跨境电商运营者量身定制的社媒分析工具，助力您在竞争激烈的市场中脱颖而出。';
                } else {
                    echo 'A social media analytics tool tailored for cross-border e-commerce operators, helping you stand out in competitive markets.';
                }
                ?>
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
            <?php foreach ($features as $index => $feature) : ?>
                <div class="group relative">
                    <!-- Card -->
                    <div class="h-full bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 transform hover:-translate-y-1">
                        <!-- Icon -->
                        <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl mb-6 text-white group-hover:scale-110 transition-transform duration-300">
                            <?php echo get_feature_icon($feature['icon']); ?>
                        </div>
                        
                        <!-- Content -->
                        <div>
                            <h3 class="text-2xl font-bold text-slate-900 dark:text-gray-200 mb-4">
                                <?php echo esc_html($feature['title']); ?>
                            </h3>
                            <p class="text-slate-600 dark:text-slate-400 leading-relaxed whitespace-pre-line">
                                <?php echo esc_html($feature['content']); ?>
                            </p>
                        </div>
                        
                        <!-- Hover effect decoration -->
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500/5 to-purple-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                    </div>
                    
                    <!-- Background decoration -->
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl opacity-0 group-hover:opacity-10 transition-opacity duration-300 -z-10"></div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Bottom CTA -->
        <div class="text-center mt-16">
            <div class="inline-flex items-center justify-center px-6 py-3 bg-blue-50 dark:bg-blue-900/20 rounded-full">
                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                <span class="text-blue-600 dark:text-blue-400 font-medium">
                    <?php 
                    if ($lang === 'zh') {
                        echo '立即体验，快速上手';
                    } else {
                        echo 'Try now, get started quickly';
                    }
                    ?>
                </span>
            </div>
        </div>
    </div>
</section>