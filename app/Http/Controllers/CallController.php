<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Lead;
use App\Call;
use App\Product;
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
                $products = Product::getProducts();
                return view('panel.calls.index', compact('calls', 'products'));
            }
            else
            {
                return json_encode(array("success"=>false));
            }
        }
        else{
            //dd(Call::all()->first());
            
            $calls = Call::getCalls();
            $products = Product::getProducts();
            return view('panel.calls.index', compact('calls', 'products'));
        }
    }

    public function operation(Request $request)
    {
        if($request->get('idCall'))
        {
            $call_id = $request->get('idCall');
            $operation_id = $request->get('operacion');
            $time = $request->get('fecha');
            $time .= " -0500";
            $time = strtotime($time);
            $comment = $request->get('comentario');

            Call::updateLogCall($call_id, $operation_id, $time);
            
            switch ($operation_id) {
                case 5:
                    $data = array('call_id' => $call_id, 'operation_id' => $operation_id, 'comment' => $comment, 'time' => $time);
                    //DetailOperation::insertDetailOperation($call_id, $operation_id, $comment, $time);
                    DetailOperation::insertDetailOperation($data);
                break;
                case 1:
                    $product_id = $request->get('producto');
                    $data = array('call_id' => $call_id, 'operation_id' => $operation_id, 'product_id' => $product_id ,'comment' => $comment, 'time' => $time);
                    DetailOperation::insertDetailOperation($data);
                break;
                default:
                    # code...
                    break;
            }
            return json_encode(array('success'=> true));            
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
