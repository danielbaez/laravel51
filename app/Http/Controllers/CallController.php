<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Lead;
use App\Call;

class CallController extends Controller
{
    public function index()
    {
    	//dd(Call::all()->first());
    	
    	$calls = Call::getCalls();
    	return view('panel.calls.index', compact('calls'));
    }
}
