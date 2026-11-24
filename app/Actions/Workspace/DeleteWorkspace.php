<?php

namespace App\Actions\Workspace;

use App\Models\Workspace;

class DeleteWorkspace
{
    public function execute(Workspace $workspace, string $userId): bool
    {
        abort_if($workspace->user_id !== $userId, 404);

        return $workspace->delete();
    }
}
