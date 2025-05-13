<?php
namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\User;
use common\models\Video;
use common\models\Subscriber;
use yii\data\ActiveDataProvider;
use Yii;

class ChannelController extends Controller
{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['subscribe'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    public function actionView($username)
    {
        $user = User::find()->where('LOWER(username) = :username AND status = 10', ['username' => strtolower($username)])->one();
        if (!$user) {
            throw new \yii\web\NotFoundHttpException('The requested channel does not exist.');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => Video::find()->where(['created_by' => $user->id])->published()->latest(),
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        return $this->render('view', [
            'user' => $user,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionSubscribe($username = null)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        try {
            if (!Yii::$app->request->isPost) {
                throw new \yii\web\MethodNotAllowedHttpException('Subscribe action only supports POST requests.');
            }
            $username = Yii::$app->request->post('username', $username);
            $user = User::find()->where('LOWER(username) = :username', ['username' => strtolower($username)])->one();
            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'The requested channel does not exist.',
                ];
            }
            $subscriber = Subscriber::find()
                ->where(['channel_id' => $user->id, 'user_id' => Yii::$app->user->id])
                ->one();

            if ($subscriber) {
                // Unsubscribe
                if (!$subscriber->delete()) {
                    return [
                        'success' => false,
                        'message' => 'Failed to unsubscribe.',
                    ];
                }
                $subscribed = false;
            } else {
                // Subscribe
                $subscriber = new Subscriber();
                $subscriber->channel_id = $user->id;
                $subscriber->user_id = Yii::$app->user->id;
                $subscriber->created_at = time();
                if (!$subscriber->save()) {
                    return [
                        'success' => false,
                        'message' => 'Failed to subscribe: ' . implode(', ', $subscriber->getFirstErrors()),
                    ];
                }
                $subscribed = true;

                // Send email to channel owner
                try {
                    $subscriberUser = Yii::$app->user->identity;
                    Yii::$app->mailer->compose(
                        ['html' => 'subscription-html'],
                        [
                            'user' => $user,
                            'subscriberUser' => $subscriberUser,
                        ]
                    )
                        ->setTo($user->email)
                        ->setSubject('You have a new follower on BeyondTube')
                        ->send();
                } catch (\Throwable $mailEx) {
                    Yii::error('Failed to send subscription email: ' . $mailEx->getMessage() . "\n" . $mailEx->getTraceAsString(), __METHOD__);
                    // Fallback: try PHPMailer with SMTP
                    try {
                        require_once \Yii::getAlias('@vendor/phpmailer/phpmailer/src/PHPMailer.php');
                        require_once \Yii::getAlias('@vendor/phpmailer/phpmailer/src/SMTP.php');
                        require_once \Yii::getAlias('@vendor/phpmailer/phpmailer/src/Exception.php');
                        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
                        $mail->isSMTP();
                        $mail->Host = 'smtp.beyondsoftwares.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'mail@beyondsoftwares.com';
                        $mail->Password = 'MambetNumber1';
                        $mail->SMTPSecure = 'tls';
                        $mail->Port = 587;
                        $mail->setFrom('mail@beyondsoftwares.com', 'BeyondTube');
                        $mail->addAddress($user->email, $user->username);
                        $mail->Subject = 'You have a new follower on BeyondTube';
$mail->isHTML(true);
$subscriberChannelUrl = Yii::$app->urlManager->createAbsoluteUrl(['/channel/view', 'username' => $subscriberUser->username]);
$mail->Body = 'Hello ' . htmlspecialchars($user->username) . ',<br><br>' .
    'You have a new follower on your channel: <a href="' . $subscriberChannelUrl . '">' . htmlspecialchars($subscriberUser->username) . '</a><br><br>' .
    'Visit your channel to see more details.';
$mail->AltBody = "Hello {$user->username},\n\nYou have a new follower on your channel: {$subscriberUser->username} ({$subscriberChannelUrl})\n\nVisit your channel to see more details.";
$mail->send();
                    } catch (\Throwable $phpMailerEx) {
                        Yii::error('PHPMailer SMTP fallback failed: ' . $phpMailerEx->getMessage(), __METHOD__);
                    }
                }
            }

            $count = $user->getSubscriberCount();

            return [
                'success' => true,
                'subscribed' => $subscribed,
                'count' => $count,
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage(),
            ];
        }
    }
}
