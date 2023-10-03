<?php

/*
 * Goonswarm Federation - Black Hand Tools
 *
 * Developed by scopehone <scopeh@gmail.com>
 * In conjuction with Izzy, such a hard customer! 
 *
 */

namespace Vanguard\Http\Controllers\Web;

use Vanguard\Http\Controllers\Controller;
use Vanguard\User;

class ActiveUsersController extends Controller
{
    public function index()
    {
         // Fetch users from database
        $users = User::join('sessions', 'users.id', '=', 'sessions.user_id')
            ->select('users.*')
            ->distinct()
            ->get();

        return view('user.active-users', compact('users'));  
    }
}