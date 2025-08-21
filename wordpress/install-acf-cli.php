<?php
/**
 * 使用管理员身份安装ACF插件
 */

define('WP_USE_THEMES', false);
require_once('/var/www/html/wp-load.php');

// 设置当前用户为管理员
wp_set_current_user(1); // ID 1 通常是第一个管理员用户

echo "当前用户：" . wp_get_current_user()->user_login . "\n";
echo "用户权限：" . (current_user_can('install_plugins') ? '✅ 有安装权限' : '❌ 无安装权限') . "\n";

if (!current_user_can('install_plugins')) {
    // 尝试获取管理员用户
    $admin_users = get_users(array('role' => 'administrator', 'number' => 1));
    if (!empty($admin_users)) {
        wp_set_current_user($admin_users[0]->ID);
        echo "切换到管理员用户：" . $admin_users[0]->user_login . "\n";
    } else {
        echo "错误：找不到管理员用户\n";
        exit(1);
    }
}

// 检查插件状态
$plugin_file = 'advanced-custom-fields/acf.php';

if (is_plugin_active($plugin_file)) {
    echo "✅ ACF插件已激活！\n";
    exit(0);
}

// 检查插件是否已下载
$plugin_path = WP_PLUGIN_DIR . '/advanced-custom-fields/acf.php';
if (file_exists($plugin_path)) {
    echo "ACF插件已存在，尝试激活...\n";
    $result = activate_plugin($plugin_file);
    if (is_wp_error($result)) {
        echo "激活失败：" . $result->get_error_message() . "\n";
        exit(1);
    } else {
        echo "✅ ACF插件激活成功！\n";
        exit(0);
    }
}

// 包含WordPress升级相关文件
if (!function_exists('download_url')) {
    require_once(ABSPATH . 'wp-admin/includes/file.php');
}

// 直接下载ACF插件
echo "正在下载ACF插件...\n";
$plugin_zip_url = 'https://downloads.wordpress.org/plugin/advanced-custom-fields.6.2.4.zip';

// 创建临时文件
$temp_file = download_url($plugin_zip_url);

if (is_wp_error($temp_file)) {
    echo "下载失败：" . $temp_file->get_error_message() . "\n";
    exit(1);
}

echo "下载完成，正在解压...\n";

// 解压到插件目录
$plugin_dir = WP_PLUGIN_DIR;
$unzip_result = unzip_file($temp_file, $plugin_dir);

// 删除临时文件
unlink($temp_file);

if (is_wp_error($unzip_result)) {
    echo "解压失败：" . $unzip_result->get_error_message() . "\n";
    exit(1);
}

echo "解压完成，正在激活插件...\n";

// 激活插件
$activate_result = activate_plugin($plugin_file);

if (is_wp_error($activate_result)) {
    echo "激活失败：" . $activate_result->get_error_message() . "\n";
    exit(1);
} else {
    echo "✅ Advanced Custom Fields插件安装并激活成功！\n";
    echo "\n🎉 CardPlanet主题现在具备完整功能！\n";
    echo "访问 http://localhost:8080 查看效果\n";
}
?>