<?php
/**
 * Testimonials Section Template
 *
 * @package TubeScannerTheme
 */

$locale = get_locale();
$lang = (strpos($locale, 'zh') === 0) ? 'zh' : 'en';

// Testimonials data
$testimonials_zh = array(
    array(
        'name' => '张小明',
        'title' => '跨境电商运营总监',
        'company' => '某知名电商公司',
        'content' => 'TubeScanner帮助我们快速识别了海外市场的优质KOL，转化率提升了300%。这个工具真的改变了我们的营销策略！',
        'rating' => 5,
        'avatar' => '🧑‍💼'
    ),
    array(
        'name' => '李晓芳',
        'title' => '社媒营销专家',
        'company' => '独立营销顾问',
        'content' => '数据分析功能非常强大，界面简洁易用。一键生成的报告为我节省了大量时间，客户满意度也大幅提升。',
        'rating' => 5,
        'avatar' => '👩‍💻'
    ),
    array(
        'name' => '王海涛',
        'title' => '品牌出海负责人',
        'company' => '科技创业公司',
        'content' => '竞品分析功能让我们清楚了解市场动态，制定了更有效的内容策略。强烈推荐给所有出海企业！',
        'rating' => 5,
        'avatar' => '👨‍💼'
    )
);

$testimonials_en = array(
    array(
        'name' => 'John Smith',
        'title' => 'E-commerce Marketing Director',
        'company' => 'Global Commerce Inc.',
        'content' => 'TubeScanner helped us quickly identify quality KOLs in overseas markets, increasing our conversion rate by 300%. This tool truly transformed our marketing strategy!',
        'rating' => 5,
        'avatar' => '🧑‍💼'
    ),
    array(
        'name' => 'Sarah Johnson',
        'title' => 'Social Media Marketing Expert',
        'company' => 'Independent Marketing Consultant',
        'content' => 'The data analysis features are incredibly powerful, with a clean and user-friendly interface. The one-click reports save me tons of time and greatly improve client satisfaction.',
        'rating' => 5,
        'avatar' => '👩‍💻'
    ),
    array(
        'name' => 'Michael Chen',
        'title' => 'Brand Global Expansion Lead',
        'company' => 'Tech Startup Co.',
        'content' => 'The competitor analysis feature gives us clear insights into market dynamics, helping us develop more effective content strategies. Highly recommend to all global businesses!',
        'rating' => 5,
        'avatar' => '👨‍💼'
    )
);

$testimonials = ($lang === 'zh') ? $testimonials_zh : $testimonials_en;
?>

<section id="testimonials" class="py-20 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-4xl sm:text-5xl font-bold text-slate-900 dark:text-gray-200 mb-6">
                <?php 
                if ($lang === 'zh') {
                    echo '用户好评如潮';
                } else {
                    echo 'What Our Users Say';
                }
                ?>
            </h2>
            <p class="text-xl text-slate-600 dark:text-slate-400 max-w-3xl mx-auto">
                <?php 
                if ($lang === 'zh') {
                    echo '来自全球1000+企业用户的真实反馈，见证TubeScanner的专业实力。';
                } else {
                    echo 'Real feedback from 1000+ global enterprise users, witnessing TubeScanner\'s professional capabilities.';
                }
                ?>
            </p>
        </div>

        <!-- Testimonials Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($testimonials as $index => $testimonial) : ?>
                <div class="group">
                    <!-- Testimonial Card -->
                    <div class="bg-white dark:bg-gray-900 rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 transform hover:-translate-y-1 h-full flex flex-col">
                        <!-- Quote Icon -->
                        <div class="flex justify-between items-start mb-6">
                            <svg class="w-8 h-8 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            
                            <!-- Rating Stars -->
                            <div class="flex">
                                <?php for ($i = 0; $i < $testimonial['rating']; $i++) : ?>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                <?php endfor; ?>
                            </div>
                        </div>
                        
                        <!-- Testimonial Content -->
                        <blockquote class="text-slate-600 dark:text-slate-300 leading-relaxed mb-6 flex-grow">
                            "<?php echo esc_html($testimonial['content']); ?>"
                        </blockquote>
                        
                        <!-- Author Info -->
                        <div class="flex items-center">
                            <!-- Avatar -->
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-xl font-bold mr-4">
                                <?php echo $testimonial['avatar']; ?>
                            </div>
                            
                            <!-- Author Details -->
                            <div>
                                <div class="font-semibold text-slate-900 dark:text-gray-200">
                                    <?php echo esc_html($testimonial['name']); ?>
                                </div>
                                <div class="text-sm text-slate-500 dark:text-slate-400">
                                    <?php echo esc_html($testimonial['title']); ?>
                                </div>
                                <div class="text-xs text-blue-600 dark:text-blue-400">
                                    <?php echo esc_html($testimonial['company']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Social Proof Stats -->
        <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="group">
                <div class="text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">1000+</div>
                <div class="text-slate-600 dark:text-slate-400">
                    <?php echo ($lang === 'zh') ? '企业用户' : 'Enterprise Users'; ?>
                </div>
            </div>
            <div class="group">
                <div class="text-4xl font-bold text-green-600 dark:text-green-400 mb-2">4.9</div>
                <div class="text-slate-600 dark:text-slate-400">
                    <?php echo ($lang === 'zh') ? '用户评分' : 'User Rating'; ?>
                </div>
            </div>
            <div class="group">
                <div class="text-4xl font-bold text-purple-600 dark:text-purple-400 mb-2">24/7</div>
                <div class="text-slate-600 dark:text-slate-400">
                    <?php echo ($lang === 'zh') ? '技术支持' : 'Support'; ?>
                </div>
            </div>
            <div class="group">
                <div class="text-4xl font-bold text-orange-600 dark:text-orange-400 mb-2">99%</div>
                <div class="text-slate-600 dark:text-slate-400">
                    <?php echo ($lang === 'zh') ? '推荐率' : 'Recommendation'; ?>
                </div>
            </div>
        </div>
    </div>
</section>