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

<!-- Progress Bar -->
<div class="progress mb-3" style="width:100%; display:none;" id="upload-progress-container">
  <div id="upload-progress-bar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
</div>
<!-- error summary -->
<?= $form->errorSummary($model); ?>
<button class="btn btn-primary btn-file" type="submit" id="upload-btn">
    Upload Video
</button>
<?php \yii\bootstrap5\ActiveForm::end(); ?>
</div>
</div>

<?php
$uploadUrl = \yii\helpers\Url::to(['video/create']);
$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->csrfToken;
$this->registerJs(<<<JS
$('#{$form->id}').on('submit', function(e) {
    e.preventDefault();
    var form = this;
    var formData = new FormData(form);
    // Add CSRF token manually if not present
    if (!formData.has('$csrfParam')) {
        formData.append('$csrfParam', '$csrfToken');
    }
    var xhr = new XMLHttpRequest();
    xhr.open('POST', form.action);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.upload.addEventListener('progress', function(e) {
        if (e.lengthComputable) {
            var percent = Math.round((e.loaded / e.total) * 100);
            $('#upload-progress-container').show();
            $('#upload-progress-bar').css('width', percent + '%').attr('aria-valuenow', percent).text(percent + '%');
        }
    });
xhr.onload = function() {
    if (xhr.status === 200) {
        try {
            var response = JSON.parse(xhr.responseText);
            if (response.success && response.redirect) {
                window.location.href = response.redirect;
                return;
            }
            $('#upload-progress-bar').removeClass('bg-danger').addClass('bg-success').text('Upload complete');
        } catch (e) {
            $('#upload-progress-bar').removeClass('bg-danger').addClass('bg-success').text('Upload complete');
        }
    } else {
        $('#upload-progress-bar').removeClass('bg-success').addClass('bg-danger').text('Upload failed');
    }
    $('#upload-btn').prop('disabled', false);
};
    xhr.onerror = function() {
        $('#upload-progress-bar').removeClass('bg-success').addClass('bg-danger').text('Upload failed');
        $('#upload-btn').prop('disabled', false);
    };
    $('#upload-btn').prop('disabled', true);
    $('#upload-progress-container').show();
    $('#upload-progress-bar').removeClass('bg-success bg-danger').addClass('progress-bar').css('width', '0%').attr('aria-valuenow', 0).text('0%');
    xhr.send(formData);
});
JS);
?>
