<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    protected $connection = 'mysql2';
    
    protected $table = 'LOG_CALLS';

	protected $fillable = ['id', 'name'];

}
