<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
	protected $connection = 'remote_pe';
    
    protected $table = 'PE_COMPANIES';

	protected $fillable = ['CO_COMPANY_ID', 'CO_NAME'];

	function __construct()
	{
		$country = \Session::get('country');
		$this->connection = 'remote_'.$country;

	}

	public function user()
    {
        return $this->hasOne('App\User');
    }

    public static function getCompany($id)
    {
    	$dataCompany = Company::where('CO_COMPANY_ID', $id)->get(['CO_NAME']);
    	return $dataCompany;
    }
}
