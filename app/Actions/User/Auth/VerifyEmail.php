<?php

namespace App\Actions\User\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use App\Notifications\WelcomeNotification;


class VerifyEmail
{
    /**
     * Create a new class instance.
     */
    public function execute(string $token):array
    {
        //
        $data=Cache::get("signup_".$token)['data'];

        $user=User::query()->create($data);

        $user->notify(new WelcomeNotification($user->name));
        
        Cache::forget("signup_".$token);
        
        $apiToken=$user->createToken('Auth',['can-access-user']);


        $response=[
            'user'=>$user,
            'token'=>$apiToken->plainTextToken

        ];

        return $response;

    }
}
