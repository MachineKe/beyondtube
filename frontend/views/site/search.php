<?php
use yii\helpers\Html;

/** @var string $q */
/** @var \common\models\Video[] $videos */

$this->title = 'Search Results';
?>

<h2>Search Results for: <?= Html::encode($q) ?></h2>

<?php if ($q === ''): ?>
    <div class="alert alert-info">Please enter a search term.</div>
<?php elseif (empty($videos)): ?>
    <div class="alert alert-warning">No results found.</div>
<?php else: ?>
    <div class="row">
        <?php foreach ($videos as $video): ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= Html::encode($video->title) ?></h5>
                        <?php if (!empty($video->description)): ?>
                            <p class="card-text"><?= Html::encode($video->description) ?></p>
                        <?php endif; ?>
                        <!-- Add more video details/links as needed -->
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
