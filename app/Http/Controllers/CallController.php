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

    public function repcot(Request $request)
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
            
            $calls = Call::getRepCot();
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
            $uri = $request->get('uri');
            $idt = false;
            if($uri == 'repcot')
            {
                $idt = $request->get('idt');
            }

            
            switch ($operation_id) {
                case 1:
                    $dataLog = array('call_id' => $call_id, 'operation_id' => $operation_id, 'time' => $time);
                    if($uri == 'calls')
                    {
                        Call::updateLogCall($dataLog);
                    }
                    
                    $product_id = $request->get('producto');
                    $data = array('call_id' => $call_id, 'operation_id' => $operation_id, 'product_id' => $product_id, 'comment' => $comment, 'time' => $time, 'id' => $idt);
                break;
                case 2:
                    $dataLog = array('call_id' => $call_id, 'operation_id' => $operation_id, 'time' => $time);
                    if($uri == 'calls')
                    {
                        Call::updateLogCall($dataLog);
                    }
                    $motive_id = $request->get('motivo');
                    $data = array('call_id' => $call_id, 'operation_id' => $operation_id, 'motive_id' => $motive_id, 'comment' => $comment, 'time' => $time, 'id' => $idt);
                break;
                case 4:
                    $email = $request->get('email');
                    $dataLog = array('call_id' => $call_id, 'operation_id' => $operation_id, 'time' => $time, 'email' => $email);
                    if($uri == 'calls')
                    {
                        Call::updateLogCall($dataLog);
                    }
                    $product_id = $request->get('producto');
                    $gps = $request->get('gps') == 'on' ? 'si' : 'no';
                    $valor = $request->get('valor');
                    $prima = $request->get('prima');
                    $cuota = $request->get('cuota');
                    $nrocuotas = $request->get('nrocuotas');
                    $cot = array('gps' => $gps, 'valor' => $valor, 'prima' => $prima, 'cuota' => $cuota, 'nrocuotas' => $nrocuotas);
                    $coti = serialize($cot);
                    $data = array('call_id' => $call_id, 'operation_id' => $operation_id, 'product_id' => $product_id, 'quotation' => $coti, 'comment' => $comment, 'time' => $time, 'id' => $idt);
                break;
                case 5:
                    $dataLog = array('call_id' => $call_id, 'operation_id' => $operation_id, 'time' => $time);
                    if($uri == 'calls')
                    {
                        Call::updateLogCall($dataLog);
                    }
                    $data = array('call_id' => $call_id, 'operation_id' => $operation_id, 'comment' => $comment, 'time' => $time, 'id' => $idt);
                break;
                
                default:
                    # code...
                    break;
            }
            DetailOperation::insertDetailOperation($data);
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
        if($request->get('action') == 'entriesMoreClientRepCot')
        {
            $moreData = Call::entriesMoreClientRepCot($request->get('email'), $request->get('id'), $request->get('idt'));
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
            if($request->get('t') == 'calls')
            {
                $calling = Call::calling($request->get('idCall'));
            }
            else
            {
                $calling = DetailOperation::calling($request->get('idCall'));
            }
            
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
            if($request->get('t') == 'calls')
            {
                $detailCall = Call::detailCall($request->get('idCall'));
            }
            else
            {
                $detailCall = DetailOperation::detailCall($request->get('idCall'));
            }
            
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
