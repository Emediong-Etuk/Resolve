<?php

namespace App\Actions\User\Profile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class UploadPhoto
{
    public function execute(Request $request):string
    {
        $path = $request->file('photo')->storePublicly('profiles', 'public');

        if ($path === false) {
            throw new RuntimeException('photo could not be stored');
        }

        $request->user()->update(['photo_path' => $path]);

        $request->user()->save();

        $url = Storage::disk('public')->url($path);

        return $url;
    }
}
