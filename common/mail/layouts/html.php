<?php

use yii\helpers\Html;

/** @var \yii\web\View $this view component instance */
/** @var \yii\mail\MessageInterface $message the message being composed */
/** @var string $content main view render result */

?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <style>
        body {
            background: #f6f6f6;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .email-container {
            background: #fff;
            max-width: 600px;
            margin: 40px auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            overflow: hidden;
        }
        .email-header {
            background: #0a73bb;
            color: #fff;
            padding: 24px 32px;
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .email-content {
            padding: 32px;
            color: #222;
            font-size: 16px;
            line-height: 1.7;
        }
        .email-footer {
            background: #f0f0f0;
            color: #888;
            text-align: center;
            font-size: 13px;
            padding: 18px 32px;
        }
        a {
            color: #0a73bb;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="email-container">
        <div class="email-header">
            BeyondTube
        </div>
        <div class="email-content">
            <?= $content ?>
        </div>
        <div class="email-footer">
            &copy; <?= date('Y') ?> BeyondTube. All rights reserved.
        </div>
    </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
