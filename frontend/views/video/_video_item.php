<?php
//**@var $model \common\models\Video */
/** @var $showUsername bool */
use yii\helpers\Url;

if (!isset($showUsername)) {
    $showUsername = true;
}
?>

<div class="card m-3" style="width: 14rem;">
<a href="<?= Url::toRoute(['video/view', 'id' => $model->video_id]) ?>" style="color: #111; text-decoration: none;">
    <video class="img-fluid" style="max-width:100%;height:auto;" poster="<?= $model->getThumbnailLink() ?>">
        <source src="<?= $model->getVideoLink() ?>" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <h6 class="card-title m-0" style="padding: 8px 0 0 0;"><?= $model->title ?></h6>
</a>
<div class="card-body p-2">
    <?php if ($showUsername): ?>
    <p class="text-muted card-text m-0">
        <a href="<?= Url::to(['/channel/' . $model->createdBy->username]) ?>" class="text-muted" style="text-decoration: none;">
            <?= $model->createdBy->username ?>
        </a>
    </p>
    <?php endif; ?>
    <p class="text-muted card-text m-0"><?= $model->getViews()->count() ?> views . <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?></p>
</div>
</div>
