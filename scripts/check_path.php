<?php
/*
 * تشخيص المسارات
 */

echo "=== DIRECTORY STRUCTURE ===\n\n";

// عرض المجلدات والملفات الرئيسية
 $dirs = ['api', 'includes', 'public', 'src', 'app'];
foreach ($dirs as $dir) {
    $path = __DIR__ . '/' . $dir;
    if (is_dir($path)) {
        echo "📁 {$dir}/ EXISTS\n";
        $files = glob($path . '/*.php');
        foreach ($files as $file) {
            echo "   └── " . basename($file) . "\n";
        }
    } else {
        echo "❌ {$dir}/ NOT FOUND\n";
    }
}

echo "\n=== PHP FILES IN ROOT ===\n\n";
 $rootFiles = glob(__DIR__ . '/*.php');
foreach ($rootFiles as $file) {
    echo "📄 " . basename($file) . "\n";
}

echo "\n=== SERVER INFO ===\n\n";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown' . "\n";
echo "Script Filename: " . $_SERVER['SCRIPT_FILENAME'] ?? 'Unknown' . "\n";
echo "Current Dir: " . __DIR__ . "\n";
echo "Base URL: " . (isset($_SERVER['HTTP_HOST']) ? 'http://' . $_SERVER['HTTP_HOST'] : 'Unknown') . "\n";

// حساب URL النسبي
 $docRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] ?? '');
 $currentDir = str_replace('\\', '/', __DIR__);
 $relativePath = str_replace($docRoot, '', $currentDir);
 $baseUrl = 'http://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . $relativePath;

echo "\n=== DETECTED BASE URL ===\n";
echo "👉 {$baseUrl}\n";

// فحص ملفات الطلبات المحتملة
echo "\n=== ORDER-RELATED FILES ===\n\n";
 $allPhpFiles = glob(__DIR__ . '/**/*.php', GLOB_BRACE);
foreach ($allPhpFiles as $file) {
    if (stripos(basename($file), 'order') !== false) {
        $relPath = str_replace(__DIR__, '', $file);
        echo "🛒 Found: {$relPath}\n";
        echo "   Full URL: {$baseUrl}{$relPath}\n\n";
    }
}
?>