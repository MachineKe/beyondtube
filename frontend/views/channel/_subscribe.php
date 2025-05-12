<?php
use yii\helpers\Url;
/** @var $channel \common\models\Channel */
?>
<a class="btn btn-danger"
   href="<?= Url::to(['channel/subscribe', 'username' => $channel->username]) ?>"
   data-method="post" data-pjax="1">
    Subscribe <i class="far fa-bell"></i>
</a>
