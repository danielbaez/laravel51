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

	public static function insertDetailOperation($id_call, $id_operation, $time)
	{
		$insert = new DetailOperation;
		$insert->call_id = $id_call;
		$insert->agent_id = Auth::user()->id;
		$insert->time = $time;
		$insert->operation = $id_operation;
		return $insert->save();
	}
}
