<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
	protected $connection = 'mysql2';
    
    protected $table = 'PE_COMPANIES';

	protected $fillable = ['id', 'name'];

	public function user()
    {
        return $this->hasOne('App\User');
    }
}
