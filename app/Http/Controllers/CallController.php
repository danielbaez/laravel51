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
        if($request->get('idCall'))
        {
            $idCall = $request->get('idCall');
            $idOperation = $request->get('operacion');
            switch ($idOperation) {
                case 5:
                    $id = Call::find($idCall);
                    $id->state = 1;
                    $id->save();
                    return json_encode(array('success'=>$idOperation, 'result'=>$id));
                    break;
                
                default:
                    # code...
                    break;
            }
            //dd($request);
            return json_encode(array("success"=>true));
        }
        else
        {
            return json_encode(array("success"=>false, "msg" => 'No existe el id'));
        }
    }
}
