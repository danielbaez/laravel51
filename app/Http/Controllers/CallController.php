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

    public function operation(Request $request)
    {
    	$idOperation = $request->get('operacion');
    	switch ($idOperation) {
    		case 1:
    			return json_encode(array('success'=>$idOperation));
    			break;
    		
    		default:
    			# code...
    			break;
    	}
    	//dd($request);
    	return json_encode(array('success'=>true));
    }
}
