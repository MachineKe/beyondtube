<?php
//**@var $model \common\models\Video */
/** @var $showUsername bool */
use yii\helpers\Url;

if (!isset($showUsername)) {
    $showUsername = true;
}
?>

<?php
if (!isset($cardWidth)) {
    $cardWidth = '14rem';
}
?>
<a href="<?= Url::toRoute(['video/view', 'id' => $model->video_id]) ?>" style="color: #111; text-decoration: none;">
<div class="card mb-3" style="width: <?= $cardWidth ?>; max-width: 100%;">
    <img src="<?= $model->getThumbnailLink() ?>" alt="Thumbnail" class="img-fluid" style="width: 100%; height: 120px; object-fit: cover; border-radius: 4px; margin-top: 8px;">
    <h6 class="card-title m-0" style="padding: 8px 0 0 0;"><?= $model->title ?></h6>
    <div class="card-body p-2">
        <?php if ($showUsername): ?>
        <p class="text-muted card-text m-0">
            <?php if ($model->createdBy): ?>
                <a href="<?= Url::to(['/channel/' . $model->createdBy->username]) ?>" class="text-muted" style="text-decoration: none;">
                    <?= $model->createdBy->username ?>
                </a>
            <?php else: ?>
                unknown
            <?php endif; ?>
        </p>
        <?php endif; ?>
        <p class="text-muted card-text m-0"><?= $model->getViews()->count() ?> views . <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?></p>
    </div>
</div>
</a>
