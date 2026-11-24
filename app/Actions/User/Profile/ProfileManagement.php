<?php

namespace App\Actions\User\Profile;

use App\Models\Team;
use App\Models\Ticket;
use App\Models\User;


class ProfileManagement
{
   public function execute(string $email):array
   {
    $user = User::where("email", $email)->first();

    $role=User::where("id", $user->role_id)->first();

    $tickets=Ticket::where('user_id', $user->id)->get();

    $ticketCount=Ticket::where('user_id', $user->id)->count();

    $team=Team::where('id', $user->team_id)->first();

    $data=[
        'name'=> $user->name,
        'email'=> $user->email,
        'role'=>$role->name,
        'no_of_tickets'=> $ticketCount,
        'tickets'=> $tickets,
        'team'=>$team->name,
    ];

    return $data;
   }
}
