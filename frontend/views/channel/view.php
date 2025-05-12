<?php
/**
 * @var $user \common\models\User
 * @var $dataProvider \yii\data\ActiveDataProvider
 */
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\Url;
?>

<div class="channel-header mb-4 p-4 bg-light rounded d-flex align-items-center">
    <?php if (!empty($user->profile->avatar)): ?>
        <img src="<?= Html::encode($user->profile->avatar) ?>" alt="Avatar" class="img-thumbnail mr-4" style="max-width:100px;">
    <?php endif; ?>
    <div>
        <h2 class="mb-1"><?= Html::encode($user->username) ?>'s Channel</h2>
        <p class="mb-2 text-muted"><?= Html::encode($user->profile->bio ?? '') ?></p>
        <div class="d-flex align-items-center">
            <button id="subscribe-btn"
                class="btn btn-danger mr-3"
                data-username="<?= Html::encode($user->username) ?>"
                data-subscribed="<?= Yii::$app->user->isGuest ? '0' : ( \common\models\Subscriber::find()->where(['channel_id' => $user->id, 'user_id' => Yii::$app->user->id])->exists() ? '1' : '0') ?>"
            >
                <?= Yii::$app->user->isGuest ? 'Subscribe <i class="far fa-bell"></i>' :
                    (\common\models\Subscriber::find()->where(['channel_id' => $user->id, 'user_id' => Yii::$app->user->id])->exists()
                        ? 'Unsubscribe <i class="fas fa-bell-slash"></i>'
                        : 'Subscribe <i class="far fa-bell"></i>') ?>
            </button>
            <span class="text-muted" id="subscriber-count">
                <?= $user->getSubscriberCount() ?> subscriber<?= $user->getSubscriberCount() == 1 ? '' : 's' ?>
            </span>
        </div>
        <div id="subscribe-message" style="margin-top:8px;"></div>
    </div>
<?php
$subscribeUrl = Url::to(['channel/subscribe', 'username' => $user->username]);
$csrfToken = Yii::$app->request->csrfToken;
$isGuest = Yii::$app->user->isGuest ? '1' : '0';
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var btn = document.getElementById('subscribe-btn');
    var countSpan = document.getElementById('subscriber-count');
    btn.addEventListener('click', function(e) {
        var isGuest = <?= $isGuest ?>;
        var msgDiv = document.getElementById('subscribe-message');
        msgDiv.innerHTML = '';
        if (isGuest) {
            // Redirect guests to login page
            window.location.href = "<?= Url::to(['/site/login']) ?>";
            return;
        }
        e.preventDefault();
        var username = btn.getAttribute('data-username');
        var subscribed = btn.getAttribute('data-subscribed') === '1';
        btn.disabled = true;
        fetch('<?= $subscribeUrl ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-Token': '<?= $csrfToken ?>'
            },
            body: 'username=' + encodeURIComponent(username)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network error: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                btn.setAttribute('data-subscribed', data.subscribed ? '1' : '0');
                btn.innerHTML = data.subscribed
                    ? 'Unsubscribe <i class="fas fa-bell-slash"></i>'
                    : 'Subscribe <i class="far fa-bell"></i>';
                countSpan.innerText = data.count + ' subscriber' + (data.count === 1 ? '' : 's');
                msgDiv.innerHTML = '<span style="color:green;">' + (data.subscribed ? 'Subscribed successfully.' : 'Unsubscribed successfully.') + '</span>';
            } else {
                msgDiv.innerHTML = '<span style="color:red;">' + (data.message || 'Subscription failed.') + '</span>';
            }
        })
        .catch(err => {
            msgDiv.innerHTML = '<span style="color:red;">' + err.message + '</span>';
        })
        .finally(() => {
            btn.disabled = false;
        });
    });
});
</script>
</div>

<div class="channel-videos">
    <h4>Videos</h4>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('//video/_video_item', ['model' => $model]);
        },
        'emptyText' => 'No videos found for this channel.',
        'layout' => "<div class=\"d-flex flex-wrap\">{items}</div>\n{pager}",
        'options' => ['class' => 'row'],
        'itemOptions' => ['class' => 'col-md-4 mb-4'],
    ]) ?>
</div>
