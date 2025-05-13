<?php

namespace console\controllers;

use yii\console\Controller;
use frontend\models\ResendVerificationEmailForm;

class ResendController extends Controller
{
    /**
     * Resend verification email to the given address.
     * Usage: yii resend/verification "user@example.com"
     */
    public function actionVerification($email)
    {
        $form = new ResendVerificationEmailForm();
        $form->email = $email;
        if ($form->sendEmail()) {
            echo "Verification email resent successfully to {$email}.\n";
            return 0;
        } else {
            echo "Failed to resend verification email to {$email}. The user may not exist or is already active.\n";
            return 1;
        }
    }
}
