<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;


use App\Company;

class UserController extends Controller
{
    public function show()
    {
    	//$users = User::all();
    	$users = User::orderBy('id')->paginate(8);
    	//dd(User::find(1)->company->name);
    	return View('panel.users', compact('users'));
    }
}
