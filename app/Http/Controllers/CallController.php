<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Lead;
use App\Call;

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
                
                /*return response()->json([
                    'status' => 'success',
                    'errors' => false,
                    'data' => [
                        'rows' => json_decode($dataSearched->toJson()),
                        'paginationMarkup' => $dataSearched->render()
                    ]
                ], 200);*/

                //$calls->setPath('?action=searchCall&search='.$request->get('search').'&');

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
