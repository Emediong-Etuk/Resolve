<?php

namespace App\Actions\Workspace;

use App\Models\User;
use App\Models\Workspace;
use App\Notifications\SendWorkspaceInvite;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;


class InviteTeamMember
{
    public function execute(string $inviteeEmail, string $workspaceId):string
    {
        $invitee=User::query()->where('email',$inviteeEmail)->first();

        $token=Str::random(10);

        Cache::put('Invitee'.$token, $invitee, now()->addMinutes(10));

        $workspace=Workspace::query()->where('id',$workspaceId)->first();

        if(!$invitee) throw ValidationException::withMessages([
            __('auth.user_not_found')
        ]);

        $url= config('app.url'). "/api/workspace/{$workspaceId}/accept?token={$token}";

        Notification::route('mail',$inviteeEmail)->notify(new SendWorkspaceInvite($invitee->name, $url, $workspace->name));

        return $url;
    }
}
