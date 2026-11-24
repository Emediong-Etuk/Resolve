<?php

namespace App\Actions\User\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;


class Login
{
    public function execute(string $email, string $password): array
    {
        //
        $user = User::where("email", $email)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials']
            ]);
        }

        if ($user->hasEnabledTwoFactorAuthentication()) {
            $challenge = Str::random(64);
            $expiresAt = now()->addMinutes(5);

            DB::table('two_factor_login_challenges')->insert([
                'id' => (string) Str::uuid(),
                'user_id' => $user->getKey(),
                'token_hash' => hash('sha256', $challenge),
                'expires_at' => $expiresAt,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return [
                'two_factor_required' => true,
                'challenge' => $challenge,
                'expires_at' => $expiresAt->toISOString()
            ];
        }

        if (!Hash::check($password, $user->password)) {
            throw new \Exception("Invalid credentials");
        }

        $token = $user->createToken('Auth', ['can-access-user']);

        return [
            'two_factor_required' => false,
            'user' => $user,
            'token' => $token->plainTextToken,
        ];
    }
}
