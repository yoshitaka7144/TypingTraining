<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function update(Request $request, User $user)
    {
        $user->type_count += $request->typeCount;
        $user->save();

        return $user;
    }
}
