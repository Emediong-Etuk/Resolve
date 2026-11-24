<?php

namespace App\Actions\Workspace;

use App\Models\Workspace;

class ViewWorkspace
{
    public function execute(string $workspaceId)
    {
        return Workspace::query()->where('id', $workspaceId)->firstOrFail();
    }
}
