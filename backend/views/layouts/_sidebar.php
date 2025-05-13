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
                'label' => '<i class="fa fa-home me-2"></i>Dashboard',
                'url' => ['/site/index'],
                'active' => Yii::$app->controller->id === 'site' && Yii::$app->controller->action->id === 'index',
                'encode' => false
            ],
            [
                'label' => '<i class="fa fa-video me-2"></i>Videos',
                'url' => ['/video/index'],
                'encode' => false
            ]
        ]
    ]);
    ?>
</aside>
