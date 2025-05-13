<?php
// **
// @var $dataProvider \yii\data\activeDataProvider;
// */
?>
<?php echo \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
   'itemView' => '_video_item', 
   'layout' => '<div class="d-flex flex-wrap gap-3">{items}</div>{pager}',
   'itemOptions' => ['tag' => false],
    ])?>
