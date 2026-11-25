<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'invalid_credentials'=> 'Invalid credentials',
    'two_factor_authentication_prompt'=>'Enable two-factor authentication first',
    'two_factor_authentication_enabled'=>'Two-factor authentication is already enabled',
    'two_factor_response_message'=>'Scan the QR code, then confirm with a code from your authenticator app.',
    'two_factor_confirmation_message'=>'Two-factor authentication is already enabled.',
    'two_factor_authentication_disabled'=>'Two-factor authentication is disabled',

    'workspace_deleted'=>'Workspace has been deleted',
    'user_not_found'=>'This user has not been found',

    'email_verification'=>[
        'subject'=>'Email Verification',
        'message'=>'Your verification code is :token',
    ],

    'welcome_notification'=>[
        'subject'=>'Welcome to Resolve',
        'message'=>'Welcome :name, we are glad to have you on board',
    ],

    'reset_password_notification'=>[
        'subject'=>'Reset Password',
        'message'=>'Your reset password link is :link',
    ],

    'password_reset'=>[
        'subject'=>'Password Reset',
        'message'=>'Your password has been reset successfully',
    ],

    'send_workspace_invite'=>[
        'subject'=>'Workspace Invite',
        'message'=>'Dear :name, you have been invited to :workspace. Click here to accept :url'
    ],

];
