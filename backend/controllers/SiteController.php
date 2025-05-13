<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
[
    'actions' => ['login', 'error'],
    'allow' => true,
],
[
    'allow' => true,
    'roles' => ['@'],
],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $userId = Yii::$app->user->id;

        // All videos by user, newest first
        $videos = \common\models\Video::find()
            ->where(['created_by' => $userId])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();
        // Latest video (for backward compatibility, can be removed if not needed)
        $latestVideo = !empty($videos) ? $videos[0] : null;

        // Total views for all user's videos
        $videoIds = \common\models\Video::find()
            ->select('video_id')
            ->where(['created_by' => $userId])
            ->column();

        $totalViews = 0;
        if ($videoIds) {
            $totalViews = \common\models\VideoView::find()
                ->where(['video_id' => $videoIds])
                ->count();
        }

        // Total subscribers and latest subscribers
        $totalSubscribers = \common\models\Subscriber::find()
            ->where(['channel_id' => $userId])
            ->count();

        $latestSubscribers = \common\models\Subscriber::find()
            ->where(['channel_id' => $userId])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(5)
            ->all();

        return $this->render('index', [
            'videos' => $videos,
            'latestVideo' => $latestVideo,
            'totalViews' => $totalViews,
            'totalSubscribers' => $totalSubscribers,
            'latestSubscribers' => $latestSubscribers,
        ]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        $this->layout = 'auth';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'auth';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
