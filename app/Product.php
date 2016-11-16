<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    public $timestamps = false;

    protected $connection = 'mysql';
    
    protected $table = 'products_sv';

	protected $fillable = ['id'];

	public static function getProducts()
	{
		$country = \Session::get('country');
		return Product::where('country', $country)->orderBy('prod_name', 'asc')->lists('prod_name', 'code');
	}
}
