<?php

/** @var \yii\web\View $this */
/** @var string $content */

use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;
$this->beginContent('@frontend/views/layouts/base.php');
?>


<main class="d-flex">
    <?= $this->render('_sidebar') ?>
    <div class="content-wrapper p-3 flex-grow-1 mt-5">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>
<?php $this->endContent(); ?>
