<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Lead;
use App\Call;
use App\DetailOperation;

class CallController extends Controller
{
    public function index(Request $request)
    {
        if($request->get('action') == 'searchCall')
        {
            //dd($request->get('action'));
            $calls = Call::searchCall($request->get('search'));
            if($calls)
            {
                if ($request->ajax()) {
                    return $calls;    
                }

                $calls->setPath('')->appends(['action' => 'searchCall', 'search' => $request->get('search')])->render();

                return view('panel.calls.index', compact('calls'));
            }
            else
            {
                return json_encode(array("success"=>false));
            }
        }
        else{
            //dd(Call::all()->first());
            
            $calls = Call::getCalls();
            return view('panel.calls.index', compact('calls'));
        }
    }

    public function operation(Request $request)
    {
        if($request->get('idCall'))
        {
            $idCall = $request->get('idCall');
            $idOperation = $request->get('operacion');
            switch ($idOperation) {
                case 5:
                    $client = Call::find($idCall);
                    $client->state = 5;
                    $time = $request->get('fecha');
                    $time .= " -0500";
                    //$time = strtotime('10/25/2016 12:12 PM -0500');
                    $time = strtotime($time);
                    $client->update = $time;
                    $client->save();
                    DetailOperation::insertDetailOperation($idCall, $idOperation, $time);
                    return json_encode(array('success'=> true));
                    break;
                
                default:
                    # code...
                    break;
            }
        }
        else
        {
            return json_encode(array("success"=>false, "msg" => 'No existe el id'));
        }
    }

    public function calllAjax(Request $request)
    {
        if($request->get('action') == 'entriesMoreClient')
        {
            $moreData = Call::entriesMoreClient($request->get('email'), $request->get('id'));
            if($moreData)
            {
                return json_encode(array("success"=>true, "result" => $moreData));
            }
            else
            {
                return json_encode(array("success"=>false));
            }
            
        }
        if($request->get('action') == 'calling')
        {
            $calling = Call::calling($request->get('idCall'));
            if($calling)
            {
                return json_encode(array("success"=>true, "result" => $calling[0]));
            }
            else
            {
                return json_encode(array("success"=>false));
            }
            
        }
        if($request->get('action') == 'detailCall')
        {
            $detailCall = Call::detailCall($request->get('idCall'));
            if($detailCall)
            {
                return json_encode(array("success"=>true, "result" => $detailCall));
            }
            else
            {
                return json_encode(array("success"=>false));
            }
            
        }
        if($request->get('action') == 'searchCall')
        {
            $dataSearched = Call::searchCall($request->get('search'));
            if($dataSearched)
            {
                return $dataSearched;
                /*return response()->json([
                    'status' => 'success',
                    'errors' => false,
                    'data' => [
                        'rows' => json_decode($dataSearched->toJson()),
                        'paginationMarkup' => $dataSearched->render()
                    ]
                ], 200);*/
            }
            else
            {
                return json_encode(array("success"=>false));
            }
        }
    }
}
