<?php

namespace App\Actions\User\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class ResetPassword
{
    public function execute(string $token, string $password):bool
    {
        $cache=Cache::get('reset-password-token-'.$token);

        if(!$cache){
            return false;
        }

        $user=User::where('email',$cache)->firstOrFail();
        
        $user->update(['password'=>Hash::make($password)]);
        
        Cache::forget('reset-password-token-'.$token);

        return true;

    }
}
