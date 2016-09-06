<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;

class AccessController extends Controller
{
    public function login()
    {
    	$users = User::all();
    	return view('Auth.login', $users);
    }
}
