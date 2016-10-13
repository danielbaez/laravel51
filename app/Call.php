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

	public static $country;

	function __construct()
	{
		self::$country = \Session::get('country');
		$this->connection = 'remote_'.self::$country;
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

		$country = self::$country;

		foreach ($calls as $k => $c)
		{
			if($c->t == 'SEGVEH' and isset($c->request))
			{
				$c->request = unserialize($c->request);
				if($country == 'pe')
				{
					if($c->request['cover'] == 'Total,Parcial')
					{
						$c->request['cover'] = 'Completa';
					}
					if($c->request['cover'] == 'Total')
					{
						$c->request['cover'] = 'Perdida Total';
					}
					$compare = 'https://comparabien.com.pe/seguros-vehiculares/result?';
					$cobertura = '';
				}
				else
				{
					$compare = 'https://comparabien.com.mx/seguros-auto/result?';
					$cobertura = 'cobertura='.$c->cobertura;
				}
				$values = array('source=call','woopra=false','email='.$c->e, $cobertura);

				$values = array_filter($values);
				
				foreach($c->request as $k => $v)
				{
					$values[] =  "$k=$v";
				}
				$values = implode('&', $values);
				$compare .= $values;
				$c->compare = $compare;
			}

		}

		//dd($calls);

		return $calls;

	}

}
