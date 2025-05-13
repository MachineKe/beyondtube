<?php
/**
 * @var $videos \common\models\Video[]
 */
use yii\helpers\Html;
?>

<div class="container-fluid">
    <h2 class="mt-4 mb-4" style="font-weight: bold;">My History</h2>
    <div class="row">
        <?php
        $hasVideos = false;
        foreach ($videos as $video):
            if (!$video->createdBy) continue;
            $hasVideos = true;
        ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 d-flex align-items-stretch">
                <?= $this->render('_video_item', ['model' => $video, 'showUsername' => true]) ?>
            </div>
        <?php endforeach; ?>
        <?php if (!$hasVideos): ?>
            <div class="col-12 text-muted">No history found.</div>
        <?php endif; ?>
        <?php if (empty($videos)): ?>
            <div class="col-12 text-muted">No history found.</div>
        <?php endif; ?>
    </div>
</div>
