<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//use Session;

use App\Company;

class Call extends Model
{

    protected $connection = 'mysql';
    
    protected $table = 'LOG_CALLS';

	protected $fillable = ['id', 'name'];

	function __construct()
	{
		$country = \Session::get('country');
		$this->connection = 'remote_'.$country;

	}


	public static function getCalls()
	{
		/*$company = Company::getCompany(1);
		print_r($company);*/

		$calls = Call::orderBy('id','DESC')->get();
		/*foreach ($calls as $k => $c) {
			$company = Company::getCompany($c->ci);
			$c->cn = '';
			if(isset($company[0]))
			{
				$c->cn = $company[0]->CO_NAME;
			}
		}	*/

		return $calls;

	}

}
