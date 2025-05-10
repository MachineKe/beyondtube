<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Video $model */

$this->title = 'Create Video';
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-create">

    <h1><?= Html::encode($this->title) ?></h1>
<div class="d-flex flex-column justify-content-center align-items-center">
 

<div class="upload-icon">
<i class="fa fa-upload" aria-hidden="true"></i>
</div>
<br>
<p class="m-0">Drag and drop a file you want to upload</p>
<p class="text-muted">Your video will be private until you publish it</p>
<?php $form = \yii\bootstrap5\ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]); ?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'video')->fileInput() ?>

<button class="btn btn-primary btn-file" type="submit">
    Upload Video
</button>
<?php \yii\bootstrap5\ActiveForm::end(); ?>
</div>
</div>
