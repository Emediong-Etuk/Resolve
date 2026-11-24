<?php

namespace App\Actions\Workspace;

use App\Models\Workspace;

class UpdateWorkspace
{
    /**
     * @param array<string, mixed> $attributes
     */
    public function execute(string $id, array $attributes): Workspace
    {
        $workspace = Workspace::findOrFail($id);
        $workspace->update($attributes);

        return $workspace;
    }
}
