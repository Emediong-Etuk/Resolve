<?php

namespace App\Actions\User\Auth;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class ForgotPassword
{
    public function execute(string $email):bool
    {
        $token=Str::random(60);

        Cache::put('reset-password-token-'.$token, $email, now()->addMinutes(10));

        $resetPasswordLink=' http://localhost:3000/api/reset-password?token='.$token;

        Notification::route('mail', $email)->notify(new ResetPasswordNotification($resetPasswordLink));

        return true;

    }
}
