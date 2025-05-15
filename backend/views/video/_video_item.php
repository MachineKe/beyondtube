<?php

use common\models\Video;
use yii\base\Model;
use yii\helpers\StringHelper;
use yii\helpers\Html;
use yii\helpers\Url;
/** @var $model common\models\Video */

?>
<a href="<?= Url::toRoute(['video/update', 'video_id' => $model->video_id]) ?>" style="text-decoration: none; color: inherit;">
<div style="display: flex; align-items: center;">
    <div>
        <img src="<?= $model->getThumbnailLink() ?>" alt="Thumbnail" style="width: 160px; height: 90px; object-fit: cover; margin-right: 20px; border-radius: 4px;">
    </div>
    <div>
        <div style="font-weight: bold; font-size: 1.15em;"><?= Html::encode($model->title) ?></div>
        <div style="color: #555; font-size: 1em;"><?= StringHelper::truncateWords($model->description ?? '', 10) ?></div>
    </div>
</div>
</a>
