<?php

namespace App\Actions\User\Auth;

use App\Notifications\SendVerificationToken;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class Signup
{
    public function execute(string $name, string $email, string $password): bool
    {
        $data=[
            'name' => $name,
            'email' => $email,
            'password' => $password
        ];

        $token=Str::random(4);
        
        Cache::put('signup_'.$token,[
            'data'=>$data,
        ],now()->addMinutes(5));

        Notification::route('mail', $email)->notify(new SendVerificationToken($token));

        return true;
    }
}
