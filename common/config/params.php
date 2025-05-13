<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'mail@beyondsoftwares.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'frontendUrl' => getenv('FRONTEND_URL') ?: 'http://beyondtube.test',
    'backendUrl' => getenv('BACKEND_URL') ?: 'http://studio.beyondtube.test',
];
