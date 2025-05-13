<?php
?>
<aside class="text-white" style="min-height: 100vh; width: 220px; padding-top: 56px; position: relative; z-index: 1; box-shadow: 2px 0 8px rgba(0,0,0,0.08);">
    <?php
    echo \yii\bootstrap5\Nav::widget([
        'options' => [
            'class' => 'flex-column nav-pills shadow'
        ],
        'items' => [
            [
                'label' => '<i class="fa fa-home me-2"></i>Home',
                'url' => ['/video/index'],
                'active' => Yii::$app->controller->id === 'site' && Yii::$app->controller->action->id === 'index',
                'encode' => false
            ],
            [
                'label' => '<i class="fa fa-history me-2"></i>History',
                'url' => ['/video/history'],
                'encode' => false
            ],
            [
                'label' => '<i class="fa fa-cog me-2"></i>Studio',
                'url' => Yii::$app->params['backendUrl'] ?? 'http://studio.beyondtube.test',
                'encode' => false,
                'linkOptions' => ['target' => '_blank']
            ]
        ]
    ]);
    ?>
</aside>
