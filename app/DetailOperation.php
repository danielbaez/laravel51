<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

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

	public static function insertDetailOperation($data)
	{		
		$insert = new DetailOperation;
		$insert->call_id = $data['call_id'];
		$insert->agent_id = Auth::user()->id;
		$insert->operation_id = $data['operation_id'];
		$insert->comment = $data['comment'];
		$insert->time = $data['time'];

		switch ($data['operation_id']) {
			case 5:
			
			break;
			case 1:
				$insert->product_id = $data['product_id'];
			break;
		}
		return $insert->save();
	}
}
