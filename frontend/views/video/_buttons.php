<?php
use yii\helpers\Url;
?>
<div class="ml-auto">
                    <button id="like-btn" class="btn btn-outline-primary btn-sm mr-1" data-url="<?= Url::to(['video/like', 'id' => $model->video_id]) ?>">
                        <i class="fas fa-thumbs-up"></i>
                        <span id="like-count"><?= $model->getLikes()->count() ?></span>
                    </button>
                    <button id="dislike-btn" class="btn btn-outline-secondary btn-sm" data-url="<?= Url::to(['video/dislike', 'id' => $model->video_id]) ?>">
                        <i class="fas fa-thumbs-down"></i>
                        <span id="dislike-count"><?= $model->getDislikes()->count() ?></span>
                    </button>
                </div>