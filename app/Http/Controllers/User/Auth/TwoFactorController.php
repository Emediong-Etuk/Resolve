<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfirmTwoFactorAuthRequest;
use App\Http\Requests\DisableTwoFactorAuthRequest;
use App\Http\Requests\EnableTwoFactorAuthRequest;
use App\Http\Requests\RegenerateRecoveryCodeRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;

class TwoFactorController extends Controller
{
    //
    public function enable(EnableTwoFactorAuthRequest $request, EnableTwoFactorAuthentication $enable):JsonResponse
    {
       $user=$request->user();

       $this->checkPassword($user, $request->password);

       if($user->hasEnabledTwoFactorAuthentication())
        {
            return response()->json([
                'message'=>__('auth.two_factor_authentication_enabled')
            ], 409);
        }

        $enable($user);

        return response()->json([
            'qr_code_svg'=>$user->twoFactorQrCodeSvg(),
            'recovery_codes'=>$user->recoveryCodes(),
            'message'=> __('auth.two_factor_response_message')
        ]);
    }

    public function confirm(ConfirmTwoFactorAuthRequest $request, ConfirmTwoFactorAuthentication $confirm):JsonResponse
    {
        $confirm($request->user(), $request->code);

        return response()->json([
            'message'=>__('auth.two_factor_confirmation_message')
        ]);
    }

    public function regenerateRecoveryCodes(RegenerateRecoveryCodeRequest $request, GenerateNewRecoveryCodes $generate):JsonResponse
    {
        $user=$request->user();

        $this->checkPassword($user, $request->password);

        if(! $user->hasEnabledTwoFactorAuthentication()){
            return response()->json([
                'message'=>__('auth.two_factor_authentication_prompt'),
            ]);
        }

        $generate($user);

        return response()->json([
            'recovery_codes'=>$user->recoveryCodes()
        ]);
    }

    public function disable(DisableTwoFactorAuthRequest $request, DisableTwoFactorAuthentication $disable):JsonResponse
    {
        $user=$request->user();

        $this->checkPassword($user, $request->password);

        $disable($user);

        return response()->json([
            'message'=>__('auth.two_factor_authentication_disabled')
        ]);
    }

    private function checkPassword(User $user, string $password):void
    {
        if(! Hash::check($password, $user->password)){
            throw ValidationException::withMessages([
                'password'=>[__('auth.password')]
            ]);
        }
    }
}
