<?php
echo "PHP version: " . phpversion() . "<br>";
echo "Include path: " . get_include_path() . "<br>";
echo "Current dir: " . __DIR__ . "<br>";
echo "Vendor dir exists: " . (is_dir(__DIR__ . '/../../vendor/yiisoft/yii2-bootstrap5/src') ? 'yes' : 'no') . "<br>";
echo "NavBar.php exists: " . (is_file(__DIR__ . '/../../vendor/yiisoft/yii2-bootstrap5/src/NavBar.php') ? 'yes' : 'no') . "<br>";
echo "Autoload: ";
require_once __DIR__ . '/../../vendor/autoload.php';
try {
    class_exists('yii\\bootstrap5\\NavBar', true);
    echo "NavBar autoloaded successfully.";
} catch (Throwable $e) {
    echo "Autoload failed: " . $e->getMessage();
}
?>
