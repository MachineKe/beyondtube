<?php
/* @var $this yii\web\View */
/* @var $videos \common\models\Video[] */
/* @var $totalViews int */
/* @var $totalSubscribers int */
/* @var $latestSubscribers \common\models\Subscriber[] */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Dashboard';
?>
<div class="container-fluid mt-4">
    <div class="row g-3 mb-4">
        <!-- Total Views Card -->
        <div class="col-12 col-md-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <div class="h4 mb-2">Total Views</div>
                    <div class="display-5"><?= $totalViews ?></div>
                </div>
            </div>
        </div>
        <!-- Total Subscribers Card -->
        <div class="col-12 col-md-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <div class="h4 mb-2">Total Subscribers</div>
                    <div class="display-5"><?= $totalSubscribers ?></div>
                </div>
            </div>
        </div>
        <!-- Latest Subscribers Card -->
        <div class="col-12 col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="h4 mb-2">Latest Subscribers</div>
                    <div class="text-start ps-1">
                        <?php if (!empty($latestSubscribers)): ?>
                            <?php foreach ($latestSubscribers as $subscriber): ?>
                                <div>
                                    <?php if ($subscriber->user): ?>
                                        <a href="<?= Yii::$app->params['frontendUrl'] . '/channel/' . $subscriber->user->username ?>">
                                            <?= Html::encode($subscriber->user->username) ?>
                                        </a>
                                    <?php else: ?>
                                        unknown
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-muted">No subscribers yet.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3">
        <?php if (!empty($videos)): ?>
            <?php foreach ($videos as $video): ?>
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="card h-100">
                        <img src="<?= $video->getThumbnailLink() ?>" class="card-img-top" alt="Thumbnail" style="height: 180px; object-fit: cover;">
                        <div class="card-body">
                            <div class="fw-bold mb-1"><?= Html::encode($video->title) ?></div>
                            <div>Likes: <?= $video->getLikes()->count() ?></div>
                            <div>Views: <?= $video->getViews()->count() ?></div>
                            <a href="<?= Url::to(['video/update', 'video_id' => $video->video_id]) ?>" class="btn btn-primary mt-2">Edit</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-muted">No videos yet.</div>
        <?php endif; ?>
    </div>
</div>
