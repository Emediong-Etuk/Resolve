<?php

namespace App\Actions\Workspace;

use App\Models\Workspace;

class ViewWorkspaces
{
    public function execute(string $userId)
    {
        return Workspace::query()->where('user_id',$userId)->get();
    }
}
