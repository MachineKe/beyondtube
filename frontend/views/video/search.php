<?php
use yii\widgets\ListView;
use yii\data\ArrayDataProvider;

/** @var string $keyword */
/** @var \common\models\Video[] $videos */

$dataProvider = new ArrayDataProvider([
    'allModels' => $videos,
    'pagination' => false,
]);
?>

<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_video_item',
    'itemOptions' => ['tag' => false],
    'layout' => '<div class="d-flex flex-wrap">{items}</div>',
    'viewParams' => ['showUsername' => true],
]) ?>
