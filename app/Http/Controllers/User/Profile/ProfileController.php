<?php

namespace App\Http\Controllers\User\Profile;

use App\Actions\User\Profile\ProfileManagement;
use App\Actions\User\Profile\UploadPhoto;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    public function view(Request $request, ProfileManagement $action): JsonResponse
    {
        $viewProfile=$action->execute($request->user()->email);

        return response()->json([
            'profile'=> $viewProfile
        ]);
    }

    public function uploadImage(Request $request, UploadPhoto $action):JsonResponse
    {
        $uploadImage=$action->execute($request);
        
        return response()->json([
            'image'=>$uploadImage
        ]);
    }
}
