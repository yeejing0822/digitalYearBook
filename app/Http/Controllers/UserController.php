<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    //Show subscription feature
    function showSubscription()
    {
        
        $user = User::findOrFail()->getSubscription;
        return view('subscriptions.show')->with('user', $user);
    }

}
