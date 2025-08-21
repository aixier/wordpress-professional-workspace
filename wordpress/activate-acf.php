<?php
/**
 * 直接通过数据库激活ACF插件（如果已安装）
 */
define('WP_USE_THEMES', false);
require_once('/var/www/html/wp-load.php');

// 检查ACF插件是否存在
$acf_plugin_file = 'advanced-custom-fields/acf.php';
$acf_plugin_path = WP_PLUGIN_DIR . '/' . $acf_plugin_file;

echo "检查ACF插件状态...\n";

// 检查插件文件是否存在
if (!file_exists($acf_plugin_path)) {
    echo "❌ ACF插件文件不存在，需要先安装\n";
    echo "请通过以下方式安装：\n";
    echo "1. 访问：http://localhost:8080/wp-admin/plugin-install.php\n";
    echo "2. 搜索：Advanced Custom Fields\n";
    echo "3. 安装并激活\n\n";
    echo "或者手动提示用户安装...\n";
    exit(1);
}

echo "✅ 找到ACF插件文件\n";

// 检查是否已激活
if (is_plugin_active($acf_plugin_file)) {
    echo "✅ ACF插件已激活！\n";
    echo "🎉 CardPlanet主题完整功能已可用！\n";
    exit(0);
}

echo "正在激活ACF插件...\n";

// 激活插件
$result = activate_plugin($acf_plugin_file);

if (is_wp_error($result)) {
    echo "❌ 激活失败：" . $result->get_error_message() . "\n";
    exit(1);
}

echo "✅ ACF插件激活成功！\n";
echo "🎉 CardPlanet主题现在具备完整功能！\n";

// 验证激活状态
if (is_plugin_active($acf_plugin_file)) {
    echo "✅ 验证：插件正在运行\n";
    echo "\n访问网站查看效果：http://localhost:8080\n";
    echo "后台管理：http://localhost:8080/wp-admin\n";
} else {
    echo "❌ 验证失败：插件未正确激活\n";
}
?>