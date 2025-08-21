<?php
$zip_file = '/var/www/html/wp-content/plugins/acf.zip';
$extract_to = '/var/www/html/wp-content/plugins/';

if (!file_exists($zip_file)) {
    echo "错误：ZIP文件不存在\n";
    exit(1);
}

echo "解压 ACF 插件...\n";

$zip = new ZipArchive;
$res = $zip->open($zip_file);

if ($res === TRUE) {
    $zip->extractTo($extract_to);
    $zip->close();
    echo "✅ 解压成功！\n";
    
    // 删除zip文件
    unlink($zip_file);
    echo "✅ 清理完成\n";
    
    // 检查文件是否存在
    if (file_exists($extract_to . 'advanced-custom-fields/acf.php')) {
        echo "✅ ACF插件文件已就绪\n";
        
        // 设置权限
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($extract_to . 'advanced-custom-fields/')
        );
        
        foreach($iterator as $file) {
            if($file->isDir()) {
                chmod($file, 0755);
            } else {
                chmod($file, 0644);
            }
        }
        echo "✅ 权限设置完成\n";
        
    } else {
        echo "❌ 插件文件未找到\n";
        exit(1);
    }
    
} else {
    echo "❌ 解压失败，错误代码：$res\n";
    exit(1);
}
?>