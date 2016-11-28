<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

use DB;

class DetailOperation extends Model
{
    public $timestamps = false;

    protected $connection = 'mysql';
    
    protected $table = 'DETAIL_OPERATION';

	protected $fillable = ['id'];

	function __construct()
	{
		$c = \Session::get('country');
		$this->connection = 'remote_'.$c;
	}

	/*public static function insertDetailOperation($call_id, $operation_id, $comment, $time)
	{
		$insert = new DetailOperation;
		$insert->call_id = $call_id;
		$insert->agent_id = Auth::user()->id;
		$insert->time = $time;
		$insert->operation_id = $operation_id;
		$insert->comment = $comment;
		return $insert->save();
	}*/

	public static function calling($id_call)
	{
		DB::table('compare_pe.DETAIL_CALLS_OPERATION')->insert(['call_id' => $id_call, 'agent_id' => Auth::user()->id, 'time' => time()]);

		$insertCall = DB::table('compare_pe.DETAIL_CALLS_OPERATION')->select(DB::raw("count(*) as counter"))->where('call_id', $id_call)->get();

		return $insertCall;
	}

	public static function detailCall($id_call)
	{
		$detailCall = DB::table('compare_pe.DETAIL_CALLS_OPERATION')->select(DB::raw("*"))->where('call_id', $id_call)->orderBy('id', 'DESC')->get();

		return $detailCall;
	}

	public static function getDetailCotiz($id)
	{
		$detail = DetailOperation::where('id', $id)->select('quotation')->get();
		$detail = unserialize($detail[0]->quotation);
		return ($detail);
	}

	public static function insertDetailOperation($data)
	{	
		$idt= 0;
		if(is_numeric($data['id']))
		{
			$idt = $data['id'];
		}
		DB::update("UPDATE compare_pe.detail_operation SET state = 0 WHERE call_id = '".$data['call_id']."'");
		//acatualizar todos los call_id = $data['call_id'] con state = 1 y leugo insertar
		$insert = new DetailOperation;
		$insert->call_id = $data['call_id'];
		$insert->agent_id = Auth::user()->id;
		$insert->operation_id = $data['operation_id'];
		$insert->comment = $data['comment'];
		$insert->time = 0;
		$insert->updated = time();
		$insert->product_id = 0;
		$insert->last = $idt;
		$insert->state = 1;

		switch ($data['operation_id']) {
			
			case 1:
				$insert->product_id = $data['product_id'];
			break;
			case 2:
				$insert->motive_id = $data['motive_id'];
			break;
			case 4:
				$insert->product_id = $data['product_id'];
				$insert->time = $data['time'];
				$insert->quotation = $data['quotation'];
			break;
			case 5:
				$insert->time = $data['time'];
			break;
		}
		return $insert->save();
	}

	public static function getAlerts()
	{
		$alerts = DetailOperation::where('time', '>=', time()-300)->where('time', '<=', time()+300)->get();
		return $alerts;
	}
}
