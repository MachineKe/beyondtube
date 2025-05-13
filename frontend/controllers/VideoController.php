<?php
namespace frontend\controllers;

use common\models\VideoView;
use common\models\VideoLike;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use common\models\Video;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

class VideoController extends Controller
{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['like', 'dislike'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'like' => ['post'],
                    'dislike' => ['post'],
                ],
            ],
        ];
    }

public function actionLike($id)
{
    $video = Video::findOne(['video_id' => $id]);
    if (!$video) {
        throw new \yii\web\NotFoundHttpException('The requested video does not exist.');
    }
    if (Yii::$app->user->isGuest) {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['success' => false, 'error' => 'Login required'];
        }
        return $this->redirect(['site/login']);
    }
    $userId = Yii::$app->user->id;
    $like = \common\models\VideoLike::find()
        ->where(['video_id' => $id, 'user_id' => $userId])
        ->one();

    if ($like && $like->type == 1) {
        // Unlike: remove the like
        $like->delete();
    } else {
        // Like: create or update to type=1
        if (!$like) {
            $like = new \common\models\VideoLike();
            $like->video_id = $id;
            $like->user_id = $userId;
        }
        $like->type = 1;
        $like->created_at = time();
        $like->save(false);
    }

    // Count likes and dislikes
    $likesCount = \common\models\VideoLike::find()->where(['video_id' => $id, 'type' => 1])->count();
    $dislikesCount = \common\models\VideoLike::find()->where(['video_id' => $id, 'type' => 0])->count();

    if (Yii::$app->request->isAjax) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'success' => true,
            'likes' => $likesCount,
            'dislikes' => $dislikesCount,
        ];
    }

    return $this->redirect(['view', 'id' => $id]);
}

public function actionDislike($id)
{
    $video = Video::findOne(['video_id' => $id]);
    if (!$video) {
        throw new \yii\web\NotFoundHttpException('The requested video does not exist.');
    }
    if (Yii::$app->user->isGuest) {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['success' => false, 'error' => 'Login required'];
        }
        return $this->redirect(['site/login']);
    }
    $userId = Yii::$app->user->id;
    $like = \common\models\VideoLike::find()
        ->where(['video_id' => $id, 'user_id' => $userId])
        ->one();

    if ($like && $like->type == 0) {
        // Undislike: remove the dislike
        $like->delete();
    } else {
        // Dislike: create or update to type=0
        if (!$like) {
            $like = new \common\models\VideoLike();
            $like->video_id = $id;
            $like->user_id = $userId;
        }
        $like->type = 0;
        $like->created_at = time();
        $like->save(false);
    }

    // Count likes and dislikes
    $likesCount = \common\models\VideoLike::find()->where(['video_id' => $id, 'type' => 1])->count();
    $dislikesCount = \common\models\VideoLike::find()->where(['video_id' => $id, 'type' => 0])->count();

    if (Yii::$app->request->isAjax) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'success' => true,
            'likes' => $likesCount,
            'dislikes' => $dislikesCount,
        ];
    }

    return $this->redirect(['view', 'id' => $id]);
}
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            "query"=> Video::find()->published()->latest()]);
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }
    public function actionView($id)
    {
        $this->layout = 'auth';
        $video = Video::findOne(['video_id' => $id]);
        if (!$video) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }

        $videoView = new VideoView();
        $videoView->video_id = $video->video_id;
        $videoView->user_id = Yii::$app->user->id;
        $videoView->created_at = time();
        $videoView->save();
        return $this->render('view', [
            'model' => $video
        ]);
    }
public function actionViewLike($id){
        $videoLike = new VideoLike();
        $videoLike->video_id = $id;
        $videoLike->user_id = \Yii::$app->user->id;
        $videoLike->created_at = time();
        $videoLike->type = 1;
        $videoLike->save();
    }

    /**
     * Search videos by keyword.
     */
    public function actionSearch()
    {
        $keyword = Yii::$app->request->get('keyword', '');
        $videos = [];
        if ($keyword !== '') {
            $videos = Video::find()
                ->where(['like', 'title', $keyword])
                ->all();
        }
        return $this->render('search', [
            'keyword' => $keyword,
            'videos' => $videos,
        ]);
    }
}
