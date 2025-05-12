<?php
//**@var $model \common\models\Video */
use yii\helpers\Url;
?>

<div class="card m-3" style="width: 14rem;">
<a href="<?= Url::toRoute(['video/view', 'id' => $model->video_id]) ?>">
<video class="img-fluid" style="max-width:100%;height:auto;" poster="<?= $model->getThumbnailLink() ?>">
    <source src="<?= $model->getVideoLink() ?>" type="video/mp4">
    Your browser does not support the video tag.
</video>
</a>
<div class="card-body p-2">
<h6 class="card-title m-0"><?php echo $model->title?></h6>
<p class="text-muted card-text m-0"><?php echo $model->createdBy->username ?></p>
<p class="text-muted card-text m-0"><?php echo $model->getViews()->count() ?> views . <?php echo Yii::$app->formatter->asRelativeTime($model->created_at) ?></p>
</div>
</div>
