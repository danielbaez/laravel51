<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Lead;
use App\Call;
use App\Product;
use App\DetailOperation;

use Twilio;
use Twilio\Jwt\ClientToken;

class CallController extends Controller
{
    public function index(Request $request)
    {
        $country = \Session::get('country');
        // put your Twilio API credentials here
        $accountSid = env("TWILIO_SID");
        $authToken  = env("TWILIO_TOKEN");
        if($country == 'pe')
        {
            $appSid = 'APcf32e0ee31dd150fbd3d6f080cc322be';
            $sal = 'panelpe';
        }
        if($country == 'mx')
        {
            $appSid = 'AP424f6d080275bcc62854bd45636b471e';
            $sal = 'panelmx';
        }

        $capability = new ClientToken($accountSid, $authToken);
        $capability->allowClientOutgoing($appSid);
        $capability->allowClientIncoming($sal);
        $token = $capability->generateToken();

        if($request->get('action') == 'searchCall')
        {
            //dd($request->get('action'));
            $calls = Call::searchCall($request->get('search'), $request->get('t'));
            if($calls)
            {
                if ($request->ajax()) {
                    return $calls;    
                }

                $calls->setPath('')->appends(['action' => 'searchCall', 'search' => $request->get('search'), 't' => $request->get('t')])->render();
                $products = Product::getProducts();
                return view('panel.calls.index', compact('calls', 'products', 'token'));
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
            return view('panel.calls.index', compact('calls', 'products', 'token'));
        }
    }

    public function repcot(Request $request)
    {
        $country = \Session::get('country');
        // put your Twilio API credentials here
        $accountSid = env("TWILIO_SID");
        $authToken  = env("TWILIO_TOKEN");
        if($country == 'pe')
        {
            $appSid = 'APcf32e0ee31dd150fbd3d6f080cc322be';
            $sal = 'panelpe';
        }
        if($country == 'mx')
        {
            $appSid = 'AP424f6d080275bcc62854bd45636b471e';
            $sal = 'panelmx';
        }

        $capability = new ClientToken($accountSid, $authToken);
        $capability->allowClientOutgoing($appSid);
        $capability->allowClientIncoming($sal);
        $token = $capability->generateToken();
        
        //Twilio::message('+51968820382', 'text example3');
        if($request->get('action') == 'searchCall')
        {
            //dd($request->get('action'));
            $calls = Call::searchCall($request->get('search'));
            if($calls)
            {
                if ($request->ajax()) {
                    return $calls;    
                }

                $calls->setPath('')->appends(['action' => 'searchCall', 'search' => $request->get('search'), 't' => $request->get('t')])->render();
                $products = Product::getProducts();
                return view('panel.calls.index', compact('calls', 'products', 'token'));
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
            $alerts = DetailOperation::getAlerts();
            return view('panel.calls.index', compact('calls', 'products', 'alerts', 'token'));
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
                    $motive_id = $request->get('motivo');
                    $dataLog = array('call_id' => $call_id, 'operation_id' => $operation_id, 'motive_id' => $motive_id, 'time' => $time);
                    if($uri == 'calls')
                    {
                        Call::updateLogCall($dataLog);
                    }
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
                    $gps = $request->get('gps');
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
        if($request->get('action') == 'detailCotiz')
        {
            $dataSearched = DetailOperation::getDetailCotiz($request->get('id'));
            if($dataSearched)
            {
                return $dataSearched;
            }
            else
            {
                return json_encode(array("success"=>false));
            }
        }
    }
}
