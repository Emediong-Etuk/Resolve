<?php

namespace App\Http\Controllers\Workspace;

use App\Actions\Workspace\CreateWorkspace;
use App\Actions\Workspace\DeleteWorkspace;
use App\Actions\Workspace\UpdateWorkspace;
use App\Actions\Workspace\UploadWorkspaceLogo;
use App\Actions\Workspace\ViewWorkspace;
use App\Actions\Workspace\ViewWorkspaces;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateWorkspaceRequest;
use App\Http\Requests\UpdateWorkspaceRequest;
use App\Http\Requests\UploadWorkspaceLogoRequest;
use App\Models\Workspace;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkspaceController extends Controller
{
    //
    public function create(CreateWorkspaceRequest $request, CreateWorkspace $action): JsonResponse
    {
        $workspace = $action->execute($request->name,$request->description, $request->company_data, $request->user()->id);

        return response()->json([
            'workspace'=> $workspace
        ]);
    }

    public function update(UpdateWorkspaceRequest $request, UpdateWorkspace $action, Workspace $workspace)
    {
        $updateWorkspace = $action->execute($workspace->id, $request->validated());

        return response()->json(
            [
                'workspace'=>$updateWorkspace
            ]
        );
    }

    public function viewAll(Request $request, ViewWorkspaces $action):JsonResponse
    {
        $workspaces= $action->execute($request->user()->id);

        return response()->json([
            'workspaces'=>$workspaces
        ]);
    }

    public function view(Workspace $workspace, ViewWorkspace $action): JsonResponse
    {
        $workspace = $action->execute($workspace->id);

        return response()->json([

        'workspace'=>$workspace
        ]);
    }

    public function delete(Workspace $workspace, DeleteWorkspace $action):JsonResponse
    {
        $action->execute($workspace, request()->user()->id);

        return response()->json([
            'message'=>__('auth.workspace_deleted')
        ]);
    }

    public function uploadLogo(Workspace $workspace, UploadWorkspaceLogo $action): JsonResponse
    {
        $logo=$action->execute($workspace->id);

        return response()->json([
            'workspace_logo'=>$logo
        ]);
    }
}
