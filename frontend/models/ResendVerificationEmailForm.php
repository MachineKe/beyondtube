<?php

namespace frontend\models;

use Yii;
use common\models\User;
use yii\base\Model;

class ResendVerificationEmailForm extends Model
{
    /**
     * @var string
     */
    public $email;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_INACTIVE],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    /**
     * Sends confirmation email to user
     *
     * @return bool whether the email was sent
     */
    public function sendEmail()
    {
        $user = User::findOne([
            'email' => $this->email,
            'status' => User::STATUS_INACTIVE
        ]);

        if ($user === null) {
            return false;
        }

        $frontendUrl = Yii::$app->params['frontendUrl'] ?? 'http://localhost';
        $verifyLink = rtrim($frontendUrl, '/') . '/site/verify-email?token=' . urlencode($user->verification_token);

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user, 'verifyLink' => $verifyLink]
            )
            ->setFrom([$_ENV['SMTP_FROM_EMAIL'] ?? 'mail@beyondsoftwares.com' => $_ENV['SMTP_FROM_NAME'] ?? (Yii::$app->name . ' robot')])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
