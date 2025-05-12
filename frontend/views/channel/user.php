<?php
/**
 * @var $user \common\models\User
 * @var $dataProvider \yii\data\ActiveDataProvider
 */
use yii\helpers\Html;
use yii\widgets\ListView;
?>

<div class="channel-header mb-4">
    <h2><?= Html::encode($user->username) ?>'s Channel</h2>
    <?php if (!empty($user->profile->avatar)): ?>
        <img src="<?= Html::encode($user->profile->avatar) ?>" alt="Avatar" class="img-thumbnail" style="max-width:100px;">
    <?php endif; ?>
    <p><?= Html::encode($user->profile->bio ?? '') ?></p>
</div>

<div class="channel-videos">
    <h4>Videos</h4>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('//video/_video_item', ['model' => $model]);
        },
        'emptyText' => 'No videos found for this channel.',
        'layout' => "{items}\n{pager}",
        'options' => ['class' => 'row'],
        'itemOptions' => ['class' => 'col-md-4 mb-4'],
    ]) ?>
</div>
