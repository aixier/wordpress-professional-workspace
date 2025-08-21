<?php
/**
 * 自动安装Advanced Custom Fields插件的脚本
 */

// 定义WordPress路径
define('WP_USE_THEMES', false);
require_once('/var/www/html/wp-load.php');

// 检查当前用户权限
if (!current_user_can('install_plugins')) {
    wp_die('权限不足：无法安装插件');
}

// 包含必要的文件
require_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/misc.php');
require_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');

echo "开始安装Advanced Custom Fields插件...\n";

// 获取插件信息
$plugin_slug = 'advanced-custom-fields';
$plugin_info = plugins_api('plugin_information', array('slug' => $plugin_slug));

if (is_wp_error($plugin_info)) {
    echo "错误：无法获取插件信息 - " . $plugin_info->get_error_message() . "\n";
    exit(1);
}

echo "找到插件：" . $plugin_info->name . " v" . $plugin_info->version . "\n";

// 检查插件是否已安装
if (is_plugin_active('advanced-custom-fields/acf.php')) {
    echo "ACF插件已激活！\n";
    exit(0);
}

if (file_exists(WP_PLUGIN_DIR . '/advanced-custom-fields/acf.php')) {
    echo "ACF插件已安装，正在激活...\n";
    $result = activate_plugin('advanced-custom-fields/acf.php');
    if (is_wp_error($result)) {
        echo "激活失败：" . $result->get_error_message() . "\n";
    } else {
        echo "✅ ACF插件激活成功！\n";
    }
    exit(0);
}

// 安装插件
echo "正在下载并安装插件...\n";

class Silent_Upgrader_Skin extends WP_Upgrader_Skin {
    public function feedback($string, ...$args) {
        // 静默安装，只在命令行输出
        if (!empty($args)) {
            $string = vsprintf($string, $args);
        }
        echo $string . "\n";
    }
}

$upgrader = new Plugin_Upgrader(new Silent_Upgrader_Skin());
$result = $upgrader->install($plugin_info->download_link);

if (is_wp_error($result)) {
    echo "安装失败：" . $result->get_error_message() . "\n";
    exit(1);
}

if ($result === true) {
    echo "插件安装成功，正在激活...\n";
    
    // 激活插件
    $activate_result = activate_plugin('advanced-custom-fields/acf.php');
    
    if (is_wp_error($activate_result)) {
        echo "激活失败：" . $activate_result->get_error_message() . "\n";
        exit(1);
    } else {
        echo "✅ Advanced Custom Fields插件安装并激活成功！\n";
        
        // 验证安装
        if (is_plugin_active('advanced-custom-fields/acf.php')) {
            echo "✅ 验证成功：ACF插件正在运行\n";
            echo "\n🎉 CardPlanet主题现在具备完整功能！\n";
            echo "访问 http://localhost:8080 查看效果\n";
        }
    }
} else {
    echo "安装过程出现问题\n";
    exit(1);
}
?>