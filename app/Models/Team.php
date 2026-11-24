<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name','description','logo','user_id','agent_id','ticket_id'])]
class Team extends Model
{
    //
}
