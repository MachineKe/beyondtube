<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>


<div class="wrap h-100 d-flex flex-column">
<div class="wrap h-100 d-flex flex-column">
    <?= $this->render('_header') ?>
</div>
<?php echo $content; ?>
</div>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
