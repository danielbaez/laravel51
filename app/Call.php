<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//use Session;

use App\Company;

use DB;

use Illuminate\Support\Facades\Auth;

class Call extends Model
{

    protected $connection = 'mysql';
    
    protected $table = 'LOG_CALLS';

	protected $fillable = ['id', 'name'];

	public static $country;

	function __construct()
	{
		$c = \Session::get('country');
		$this->connection = 'remote_'.$c;
	}

	public static function getCalls()
	{
		$country = \Session::get('country');
		$agente = Auth::user()->name;
		/*$company = Company::getCompany(1);
		print_r($company);*/

		//$calls = Call::where('request', '<>', '')->orderBy('id','DESC')->limit(4)->get();
		if($country == 'pe')
		{
			$table = 'compare_pe.LOG_CALLS';
			$tableCant = 'compare_pe.email_cantidad';
		}
		if($country == 'mx')
		{
			$table = 'compare_mx.LOG_CALLS';
			$tableCant = 'compare_mx.email_cantidad';
		}

		$time = time();

		$result = DB::select("SELECT * FROM users WHERE active = 'N'");
		$user_inactive = array();
		foreach($result as $id => $c){
			$user_inactive[$id] = $c->name;
		}
		
		array_push($user_inactive, $agente);
		$agentes = implode("','",$user_inactive);

		//$calls = DB::select("select * from $db where request <> '' ORDER BY id DESC LIMIT 0,4");

		//$calls = DB::select("SELECT *, IF(usuario = '".$agente."' AND state = 0 AND counter = 0, 'si','no') as nuevo, (SELECT COUNT(*) FROM $table AS alt WHERE alt.e = $table.e) AS  cant FROM $table WHERE id IN(SELECT MAX(id) FROM $table WHERE time <= $time AND state = 0 AND e <> '' AND usuario IN('".$agentes."', '') GROUP BY e) ORDER BY id DESC");

		$a = DB::select("SELECT MAX(id) as max FROM $table WHERE time <= $time AND state = 0 AND e <> '' AND usuario IN('".$agentes."', '') GROUP BY e");
		$c= array();
		foreach ($a as $key => $value) {
			array_push($c, $value->max);
			# code...
		}
		//$c = implode(',', $c);

		//$calls = DB::select("SELECT IF(a.usuario = '".$agente."' AND a.state = 0 AND a.counter = 0, 'si','no') as nuevo, a.*, b.cant as cant FROM $table a inner join $tableCant b on a.e = b.e WHERE a.id IN($c) and a.request <> '' ORDER BY a.id DESC");

		$calls = DB::table($table.' AS a')
                    ->select(DB::raw('a.*, b.cant'))
                    ->join($tableCant.' AS b', 'a.e', '=', 'b.e')
                    ->WhereIn('a.id', $c)
                    ->Where('a.request','<>', '')
                    ->orderBy('a.id', 'DESC')
                    ->paginate(10);

		//dd($calls);

		foreach ($calls as $id => $c)
		{
			if($c->t == 'SEGVEH')
			{
				if(!empty($c->request))
				{
					$c->request = unserialize($c->request);
					if($country == 'pe')
					{
						$rnmCover = '';
						if($c->request['cover'] == 'Total,Parcial')
						{
							//$c->request['cover'] = 'Completa';
							$rnmCover = 'Completa';
						}
						if($c->request['cover'] == 'Total')
						{
							//$c->request['cover'] = 'Perdida Total';
							$rnmCover = 'Perdida Total';
						}
						if($rnmCover != '')
						{
							array_merge($c->request, array('cover'=>$rnmCover));
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
				if(!empty($c->requestMultiple)){
					$c->requestMultiple = unserialize($c->requestMultiple);
					if($country == 'pe'){
						$rnmCoverM = '';
						if($c->requestMultiple['cover'] == 'Total,Parcial')
						{
							//$c->requestMultiple['cover'] = 'Completa';
							$rnmCoverM = 'Completa';
						}
						if($c->requestMultiple['cover'] == 'Total')
						{
							//$c->requestMultiple['cover'] = 'Perdida Total';
							$rnmCoverM = 'Perdida Total';
						}
						if($rnmCoverM != '')
						{
							array_merge($c->requestMultiple, array('cover'=>$rnmCoverM));
						}
					}
				}
				$calls[$id] = $c;
			}
		}

		//dd($calls);

		return $calls;

	}

}
