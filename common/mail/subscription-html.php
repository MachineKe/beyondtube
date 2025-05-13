<?php
use yii\helpers\Html;

/** @var \common\models\User $user The channel owner (recipient) */
/** @var \common\models\User $subscriberUser The user who subscribed */

$subscriberChannelUrl = Yii::$app->urlManager->createAbsoluteUrl(['/channel/view', 'username' => $subscriberUser->username]);
?>

<p>Hello <?= Html::encode($user->username) ?>,</p>

<p>
    You have a new follower on your channel:
    <a href="<?= Html::encode($subscriberChannelUrl) ?>">
        <?= Html::encode($subscriberUser->username) ?>
    </a>
</p>

<p>Visit your channel to see more details.</p>
