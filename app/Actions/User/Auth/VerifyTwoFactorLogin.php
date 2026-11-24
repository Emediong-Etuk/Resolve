<?php

namespace App\Actions\User\Auth;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\TwoFactorAuthenticationProvider;

class VerifyTwoFactorLogin
{
    public function execute(string $challenge, string $code):array
    {
        $user = DB::transaction(function () use ($challenge, $code): ?User {
            $record = DB::table('two_factor_login_challenges')
            ->where('token_hash', hash('sha256', $challenge))
            ->lockForUpdate()
            ->first();

            if(
                ! $record
                || $record->used_at !==null
                || Carbon::parse($record->expires_at)->isPast()
                || $record->attempts >= 5
            ){
                return null;
            }

            DB::table('two_factor_login_challenges')
            ->where('id',$record->id)
            ->increment('attempts');

            $user=User::query()
            ->whereKey($record->user_id)
            ->lockForUpdate()
            ->first();

            if(! $user || ! $user->hasEnabledTwoFactorAuthentication()){
                return null;
            }

            if(! $this->isValidCode($user, $code)){
                return null;
            }

            DB::table('two_factor_login_challenges')
            ->where('id',$record->id)
            ->update([
                'used_at'=> now(),
                'updated_at'=>now()
            ]);

            return $user;
        });

        if(! $user){
            throw ValidationException::withMessages([
                'code'=> ['The challenge or code is invalid or expired.'],

            ]);
        }

        $token= $user->createToken('Auth', ['can-access-user']);

        return [
            'user'=>$user,
            'token'=>$token->plainTextToken,

        ];
    }

    private function isValidCode(User $user, string $code):bool
    {
        if(preg_match('/^\d{6}$/', $code)===1){
            $secret = Fortify::currentEncrypter()->decrypt($user->two_factor_secret);

            if(app(TwoFactorAuthenticationProvider::class)->verify($secret,$code)){
                return true;
            }
        }

        foreach($user->recoveryCodes() as $recoveryCode){
            if(hash_equals($recoveryCode, $code)){
                $user->replaceRecoveryCode($recoveryCode);

                return true;
            }
        }

        return false;
    }
}
