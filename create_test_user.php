<?php
// Usage: php create_test_user.php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/console/config/main.php';

$app = new yii\console\Application($config);

use common\models\User;

$user = new User();
$user->username = 'testmarkkiprotich';
$user->email = 'markkiprotich72@gmail.com';
$user->setPassword('TestPassword123!');
$user->generateAuthKey();
$user->generateEmailVerificationToken();
$user->status = User::STATUS_INACTIVE;
$user->created_at = time();
$user->updated_at = time();

if ($user->save()) {
    echo "Test user created successfully.\n";
    echo "Verification token: " . $user->verification_token . "\n";
} else {
    echo "Failed to create test user:\n";
    print_r($user->getErrors());
}
