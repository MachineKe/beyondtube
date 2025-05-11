<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use common\models\Video;

/** @var yii\web\View $this */
/** @var common\models\Video $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="video-form">
    <div class="row">
        <div class="col-md-8">
            <!-- error summary -->
            <?= $form->errorSummary($model); ?>
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'thumbnail')->fileInput(['class' => 'form-control']) ?>
            <?= $form->field($model, 'tags')->textInput(['maxlength' => true]) ?>

            <div class="form-group mt-3">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <?php if ($model->video_name): ?>
                <div class="mb-2">
<video class="img-fluid" style="max-width:100%;height:auto;" controls poster="<?= $model->getThumbnailLink() ?>">
    <source src="<?= $model->getVideoLink() ?>" type="video/mp4">
    Your browser does not support the video tag.
</video>
                </div>
            <?php endif; ?>
            <div>
                <div class="text-muted">Video Link:</div>
                <a href="<?= $model->getVideoLink() ?>" target="_blank">Open Video</a>
            </div>
            <div>
                <div class="text-muted">Video Name:</div>
                <?= Html::encode($model->video_name) ?>
            </div>
            <div>
                <div class="text-muted">Status:</div>
                <?= $form->field($model, 'status', [
                    'template' => "{input}\n{error}",
                ])->dropDownList([
                    Video::STATUS_UNLISTED => 'Unlisted',
                    Video::STATUS_PUBLISHED => 'Published',
                ]) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
