<?php
use yii\helpers\Url;
/**
 * @var $model \common\models\Video
 */
?>
<div class="row">
    <div class="col-md-8">
        <video class="img-fluid" style="max-width:100%;height:auto;" poster="<?= $model->getThumbnailLink() ?>" controls>
            <source src="<?= $model->getVideoLink() ?>" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="mt-3">
            <h5 class="mb-2"><?php echo $model->title ?></h5>
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="text-muted mr-3">
                    <?php echo $model->getViews()->count() ?> views · <?php echo Yii::$app->formatter->asDate($model->created_at) ?>
                </div>
               <?php echo $this->render('_buttons', ['model' => $model]) ?>
            </div>
<div class="text-muted mb-0">
    <a href="<?= Url::to(['/channel/' . $model->createdBy->username]) ?>" class="text-muted" style="text-decoration: none;">
        <?= $model->createdBy->username ?>
    </a>
</div>
        </div>
    </div>
    <div class="col-md-4">
        <h6>Similar Videos</h6>
        <!-- TODO: List similar videos here -->
    </div>
</div>

<?php
$csrfToken = Yii::$app->request->csrfToken;
$js = <<<JS
$('#like-btn, #dislike-btn').on('click', function(e) {
    e.preventDefault();
    var btn = $(this);
    var url = btn.data('url');
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: {_csrf: '$csrfToken'},
        success: function(data) {
            if (data.success) {
                $('#like-count').text(data.likes);
                $('#dislike-count').text(data.dislikes);
            } else if (data.error) {
                alert(data.error);
            }
        },
        error: function() {
            alert('An error occurred. Please try again.');
        }
    });
});
JS;
$this->registerJs($js);
?>
