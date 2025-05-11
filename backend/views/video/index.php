<?php

use common\models\Video;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Videos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Video', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'title',
                "content" => function($model){
                return $this->render('_video_item' , ['model' => $model]);
                },
            ],
            ['attribute' => 'status',
            'content' => function($model){
            return $model->getStatusLabel();
            },
            ],
            'created_at:datetime',
            'updated_at:datetime',
            [
                'class' => ActionColumn::class,
                'template' => '{delete}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'delete') {
                        return ['delete', 'video_id' => $model->video_id];
                    }
                    return [$action, 'video_id' => $model->video_id];
                },
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        return Html::a('Delete', $url, [
                            'data-method' => 'post',
                            'data-confirm' => 'Are you sure you want to delete this video?',
                            'class' => 'text-primary'
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
