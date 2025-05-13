<?php
// Usage: php resend_verification.php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/frontend/config/main.php';

$app = new yii\web\Application($config);

$form = new \frontend\models\ResendVerificationEmailForm();
$form->email = 'markhartney72@gmail.com';

if ($form->sendEmail()) {
    echo "Verification email resent successfully.\n";
} else {
    echo "Failed to resend verification email. The user may not exist or is already active.\n";
}
