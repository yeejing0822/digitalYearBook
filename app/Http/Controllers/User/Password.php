<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Password extends Controller
{
    public function __invoke()
    {
        return view('user.password');
    }
}