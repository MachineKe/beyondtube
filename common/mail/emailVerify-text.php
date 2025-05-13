<?php

/** @var yii\web\View $this */
/** @var common\models\User $user */

?>
Hello <?= $user->username ?>,

Follow the link below to verify your email:

<?= $verifyLink ?>
