<?php

namespace App\Actions\Workspace;

use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class UploadWorkspaceLogo
{
    public function execute(string $workspaceId):string
    {
        $path= request()->file('logo')->storePublicly('workspacelogos','public');

        if(!$path) throw new RuntimeException('workspace logo could not be stored');

        Workspace::query()->where('id',$workspaceId)->update([
            'logo'=>$path
        ]);

        $url=Storage::disk('public')->url($path);

        return $url;
    }
}
