<?php
/**
 * FAQ Section Template
 *
 * @package TubeScannerTheme
 */

$locale = get_locale();
$lang = (strpos($locale, 'zh') === 0) ? 'zh' : 'en';

// FAQ data
$faqs_zh = array(
    array(
        'question' => '什么是TubeScanner？',
        'answer' => 'TubeScanner是一款专为跨境电商运营者设计的YouTube和TikTok社媒数据分析工具。它能帮助您快速发现优质账号、分析竞品策略、获取市场洞察，从而制定更有效的营销策略。'
    ),
    array(
        'question' => 'TubeScanner支持哪些平台？',
        'answer' => '目前TubeScanner支持YouTube和TikTok两大主流社媒平台的数据分析。我们正在持续开发更多平台支持，包括Instagram、Facebook等，敬请期待。'
    ),
    array(
        'question' => '如何开始使用TubeScanner？',
        'answer' => '非常简单！只需点击"立即使用"按钮，注册账号即可开始免费试用。我们提供详细的使用指南和24/7技术支持，帮助您快速上手。'
    ),
    array(
        'question' => 'TubeScanner的数据准确性如何？',
        'answer' => '我们使用最先进的数据采集和分析技术，确保数据的准确性和时效性。所有数据都经过多重验证，准确率超过95%，并且实时更新。'
    ),
    array(
        'question' => '是否提供技术支持？',
        'answer' => '是的！我们提供24/7专业技术支持。无论您在使用过程中遇到任何问题，都可以通过在线客服、邮件或电话联系我们的技术团队。'
    ),
    array(
        'question' => '数据安全如何保障？',
        'answer' => '我们非常重视用户数据安全。采用企业级加密技术、多重身份验证、定期安全审计等措施，确保您的数据和隐私得到最高级别的保护。'
    )
);

$faqs_en = array(
    array(
        'question' => 'What is TubeScanner?',
        'answer' => 'TubeScanner is a YouTube and TikTok social media data analytics tool designed specifically for cross-border e-commerce operators. It helps you quickly discover quality accounts, analyze competitor strategies, and gain market insights to develop more effective marketing strategies.'
    ),
    array(
        'question' => 'Which platforms does TubeScanner support?',
        'answer' => 'Currently, TubeScanner supports data analysis for YouTube and TikTok, two major social media platforms. We are continuously developing support for more platforms, including Instagram and Facebook. Stay tuned!'
    ),
    array(
        'question' => 'How do I get started with TubeScanner?',
        'answer' => 'It\'s very simple! Just click the "Get Started" button, register an account, and you can begin your free trial. We provide detailed user guides and 24/7 technical support to help you get up to speed quickly.'
    ),
    array(
        'question' => 'How accurate is TubeScanner\'s data?',
        'answer' => 'We use the most advanced data collection and analysis technologies to ensure data accuracy and timeliness. All data undergoes multiple validations with over 95% accuracy rate and real-time updates.'
    ),
    array(
        'question' => 'Do you provide technical support?',
        'answer' => 'Yes! We provide 24/7 professional technical support. Whether you encounter any issues during use, you can contact our technical team through live chat, email, or phone.'
    ),
    array(
        'question' => 'How is data security ensured?',
        'answer' => 'We take user data security very seriously. We employ enterprise-grade encryption, multi-factor authentication, regular security audits, and other measures to ensure your data and privacy receive the highest level of protection.'
    )
);

$faqs = ($lang === 'zh') ? $faqs_zh : $faqs_en;
?>

<section id="faq" class="py-20 bg-white dark:bg-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-4xl sm:text-5xl font-bold text-slate-900 dark:text-gray-200 mb-6">
                <?php 
                if ($lang === 'zh') {
                    echo '常见问题';
                } else {
                    echo 'Frequently Asked Questions';
                }
                ?>
            </h2>
            <p class="text-xl text-slate-600 dark:text-slate-400">
                <?php 
                if ($lang === 'zh') {
                    echo '这里有一些最常见的问题，帮助您更好地了解TubeScanner。';
                } else {
                    echo 'Here are some of the most common questions to help you better understand TubeScanner.';
                }
                ?>
            </p>
        </div>

        <!-- FAQ Accordion -->
        <div class="space-y-4">
            <?php foreach ($faqs as $index => $faq) : ?>
                <div class="group border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden hover:border-blue-300 dark:hover:border-blue-600 transition-colors duration-300">
                    <!-- Question -->
                    <button 
                        class="faq-trigger w-full px-6 py-5 text-left bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors duration-300 flex justify-between items-center focus:outline-none focus:ring-2 focus:ring-blue-500"
                        onclick="toggleFAQ(<?php echo $index; ?>)"
                        aria-expanded="false"
                    >
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-gray-200 pr-8">
                            <?php echo esc_html($faq['question']); ?>
                        </h3>
                        <svg 
                            class="faq-icon w-5 h-5 text-slate-500 dark:text-slate-400 transform transition-transform duration-300"
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <!-- Answer -->
                    <div 
                        id="faq-<?php echo $index; ?>" 
                        class="faq-content max-h-0 overflow-hidden transition-all duration-300 ease-in-out"
                    >
                        <div class="px-6 pb-5 pt-2 bg-gray-50 dark:bg-gray-800/50">
                            <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                                <?php echo esc_html($faq['answer']); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Bottom CTA -->
        <div class="mt-16 text-center">
            <div class="bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-2xl p-8">
                <h3 class="text-2xl font-bold text-slate-900 dark:text-gray-200 mb-4">
                    <?php 
                    if ($lang === 'zh') {
                        echo '还有其他问题？';
                    } else {
                        echo 'Have More Questions?';
                    }
                    ?>
                </h3>
                <p class="text-slate-600 dark:text-slate-400 mb-6">
                    <?php 
                    if ($lang === 'zh') {
                        echo '我们的专业团队随时为您解答，提供一对一的技术支持。';
                    } else {
                        echo 'Our professional team is ready to answer your questions and provide one-on-one technical support.';
                    }
                    ?>
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="mailto:support@tubescanner.com" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <?php echo ($lang === 'zh') ? '发送邮件' : 'Send Email'; ?>
                    </a>
                    <span class="text-slate-500 dark:text-slate-400">
                        <?php echo ($lang === 'zh') ? '或者' : 'or'; ?>
                    </span>
                    <span class="text-slate-600 dark:text-slate-300 font-medium">
                        <?php echo ($lang === 'zh') ? '24/7 在线客服' : '24/7 Live Chat'; ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function toggleFAQ(index) {
    const content = document.getElementById('faq-' + index);
    const button = content.previousElementSibling;
    const icon = button.querySelector('.faq-icon');
    const isExpanded = button.getAttribute('aria-expanded') === 'true';
    
    // Close all other FAQs
    document.querySelectorAll('.faq-content').forEach((item, i) => {
        if (i !== index) {
            item.style.maxHeight = '0px';
            const otherButton = item.previousElementSibling;
            const otherIcon = otherButton.querySelector('.faq-icon');
            otherButton.setAttribute('aria-expanded', 'false');
            otherIcon.style.transform = 'rotate(0deg)';
        }
    });
    
    // Toggle current FAQ
    if (isExpanded) {
        content.style.maxHeight = '0px';
        button.setAttribute('aria-expanded', 'false');
        icon.style.transform = 'rotate(0deg)';
    } else {
        content.style.maxHeight = content.scrollHeight + 'px';
        button.setAttribute('aria-expanded', 'true');
        icon.style.transform = 'rotate(180deg)';
    }
}
</script>