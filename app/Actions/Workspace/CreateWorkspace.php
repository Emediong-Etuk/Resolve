<?php

namespace App\Actions\Workspace;

use App\Models\User;
use App\Models\Workspace;

class CreateWorkspace
{
    public function execute(string $name, string $description, array|null $company_data, string $user_id): Workspace
    {
        $data=[
            "name"=> $name,
            "description"=> $description,
            "company_data"=> $company_data,
            "user_id"=> $user_id,
        ];

        $workspace=Workspace::create($data);

        User::query()->where('id',$user_id)->update([
            'workspace_id'=> $workspace->id
        ]);

        return $workspace;
    }
}
