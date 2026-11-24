<?php

namespace App\Http\Controllers\User\Auth;

use App\Actions\User\Auth\ForgotPassword;
use App\Actions\User\Auth\GoogleOauthCallback;
use App\Actions\User\Auth\GoogleOauthRedirect;
use App\Actions\User\Auth\Login;
use App\Actions\User\Auth\Logout;
use App\Actions\User\Auth\ResetPassword;
use App\Actions\User\Auth\Signup;
use App\Actions\User\Auth\VerifyEmail;
use App\Actions\User\Auth\VerifyTwoFactorLogin;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SignupRequest;
use App\Http\Requests\TwoFactorChallengeRequest;
use App\Http\Requests\VerifyEmailRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //

    public function signup(Signup $action, SignupRequest $request):JsonResponse
    {
        $action->execute(
            $request->name,
            $request->email,
            $request->password
        );

        return response()->json([
            'message'=>'a verification token has been sent to your email',
        ]);
    }

    public function verifyEmail(VerifyEmailRequest $request, VerifyEmail $action): JsonResponse
    {
        $response = $action->execute($request->token);

        return response()->json($response);
    }

    public function login(Login $action, LoginRequest $request): JsonResponse
    {
        $response = $action->execute($request->email, $request->password);

        return response()->json($response);
    }

    public function logout(Logout $action ): JsonResponse
    {
        $action->execute();

        return response()->json([
            'message'=>'logged out successfully'
        ]);
    }

    public function forgotPassword(ForgotPasswordRequest $request, ForgotPassword $action): JsonResponse
    {
        $action->execute($request->email);

        return response()->json([
            'message'=>'a reset password link has been sent to your email',
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request, ResetPassword $action): JsonResponse
    {
        $resetPassword = $action->execute($request->query('token'), $request->password);

        if (!$resetPassword) {
            return response()->json([
                'message'=>'invalid or expired reset token',
            ], 400);
        }

        return response()->json([
            'message'=>'password reset successfully',
        ]);
    }

    public function twoFactorChallenge(TwoFactorChallengeRequest $request, VerifyTwoFactorLogin $action): JsonResponse
    {
        
        return response()->json(
            $action->execute($request->challenge, $request->code)
        );
    }
}
