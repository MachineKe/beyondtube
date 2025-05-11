<?php
// **
// @var $dataProvider \yii\data\activeDataProvider;
// */
?>
<?php echo \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
   'itemView' => '_video_item', 
    ])?>
