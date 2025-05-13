<?php
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Nav;
use yii\bootstrap5\Html;

$menuItems = [
    ['label' => 'Home', 'url' => ['/site/index']],
    ['label' => 'History', 'url' => ['/video/history']],
];

    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-light bg-light fixed-top',
        ],
    ]);

    // Search bar form
    echo Html::beginForm(['/video/search'], 'get', ['class' => 'd-flex ms-3', 'style' => 'width:400px;']);
    echo Html::textInput('keyword', Yii::$app->request->get('keyword'), [
        'class' => 'form-control me-2',
        'placeholder' => 'Search',
        'aria-label' => 'Search',
        'style' => 'font-size:1.25rem;'
    ]);
    echo Html::submitButton('Search', [
        'class' => 'btn btn-outline-success',
        'style' => 'font-size:1.25rem;'
    ]);
    echo Html::endForm();

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto mb-2 mb-md-0'],
        'items' => $menuItems,
    ]);
    if (Yii::$app->user->isGuest) {
        echo Html::tag('div',Html::a('Signup',['/site/signup'],['class' => ['btn btn-link login text-decoration-none']]),['class' => ['d-flex']]);
        echo Html::tag('div',Html::a('Login',['/site/login'],['class' => ['btn btn-link login text-decoration-none']]),['class' => ['d-flex']]);
    } else {
        echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout text-decoration-none']
            )
            . Html::endForm();
    }
    NavBar::end();
    ?>
