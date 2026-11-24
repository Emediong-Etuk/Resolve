<?php

namespace App\Actions\User\Auth;

class Logout
{
    public function execute():bool
    {
        request()->user()->tokens()->delete();

        return true;
    }
}
