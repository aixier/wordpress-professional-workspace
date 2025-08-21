<?php
/**
 * WordPress自动安装脚本
 */

$install_url = 'http://localhost:8080/wp-admin/install.php';

// 第一步：语言选择 (使用英文)
$step1_data = [
    'language' => '',
    'step' => '1'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $install_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($step1_data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, '/tmp/cookies.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, '/tmp/cookies.txt');

$response1 = curl_exec($ch);
echo "Step 1 completed - Language selection\n";

// 第二步：安装WordPress
$step2_data = [
    'weblog_title' => 'CardPlanet',
    'user_name' => 'petron',
    'admin_password' => 'Petron12345^',
    'admin_password2' => 'Petron12345^',
    'pw_weak' => '1',  // 确认使用弱密码
    'admin_email' => 'admin@cardplanet.local',
    'Submit' => 'Install WordPress',
    'language' => ''
];

curl_setopt($ch, CURLOPT_URL, $install_url . '?step=2');
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($step2_data));

$response2 = curl_exec($ch);

if (strpos($response2, 'Success!') !== false || strpos($response2, 'WordPress has been installed') !== false) {
    echo "✅ WordPress安装成功！\n";
    echo "网站: http://localhost:8080\n";
    echo "后台: http://localhost:8080/wp-admin\n";
    echo "用户名: petron\n";
    echo "密码: Petron12345^\n";
} else {
    echo "安装状态检查：\n";
    if (strpos($response2, 'already') !== false) {
        echo "ℹ️ WordPress可能已经安装\n";
    } else {
        echo "⚠️ 安装可能有问题，请检查: http://localhost:8080\n";
    }
}

curl_close($ch);

// 验证安装
$verify_ch = curl_init();
curl_setopt($verify_ch, CURLOPT_URL, 'http://localhost:8080');
curl_setopt($verify_ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($verify_ch, CURLOPT_FOLLOWLOCATION, true);

$homepage = curl_exec($verify_ch);
if (strpos($homepage, 'CardPlanet') !== false || strpos($homepage, 'WordPress') !== false) {
    echo "✅ 网站首页可访问\n";
} else {
    echo "⚠️ 网站首页访问异常\n";
}

curl_close($verify_ch);
?>