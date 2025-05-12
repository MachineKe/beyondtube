<?php
namespace frontend\controllers;

use yii\web\Controller;
use common\models\User;
use common\models\Video;
use yii\data\ActiveDataProvider;
use Yii;

class ChannelController extends Controller
{
    public function actionUser($username)
    {
        $user = User::find()->where(['username' => $username])->one();
        if (!$user) {
            throw new \yii\web\NotFoundHttpException('The requested channel does not exist.');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => Video::find()->where(['created_by' => $user->id])->published()->latest(),
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        return $this->render('user', [
            'user' => $user,
            'dataProvider' => $dataProvider,
        ]);
    }
}
