<?php
//**@var $model \common\models\Video */
?>

<div class="card" style="width: 18rem;">
<video class="img-fluid" style="max-width:100%;height:auto;" controls poster="<?= $model->getThumbnailLink() ?>">
    <source src="<?= $model->getVideoLink() ?>" type="video/mp4">
    Your browser does not support the video tag.
</video>
<div class="card-body">
<h5 class="card-title"><?php echo $model->title?></h5>
<p class="card-text"><?php echo $model->createdBy->username ?></p>
<a href="#" class="btn btn-primary">Go somewhere</a>
</div>
</div>
