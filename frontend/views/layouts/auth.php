<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;

$this->beginContent('@frontend/views/layouts/base.php');
?>


<div class="wrap h-100 d-flex flex-column">
    <?= $this->render('_header') ?>
    <main class="d-flex">
        <div class="content-wrapper p-3 flex-grow-1 mt-5">

            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>
</div>
<?php $this->endContent(); ?>



