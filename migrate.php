<?php
// migrate.php - Run Yii2 migrations via browser or CLI (for cPanel/shared hosting)

define('YII_ENV', 'prod');
define('YII_DEBUG', false);

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/console/config/main.php';

$application = new yii\console\Application($config);

try {
    // Run all new migrations in console/migrations
    $exitCode = $application->runAction('migrate/up', [
        'migrationPath' => '@console/migrations',
        'interactive' => false,
    ]);
    echo "Migration finished with exit code: $exitCode\n";
} catch (Exception $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
}
