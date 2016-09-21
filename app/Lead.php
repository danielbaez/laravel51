<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $connection = 'mysql2';
    
    protected $table = 'LOG_CAPTURE';

	protected $fillable = ['CAP_COMPANY_ID', 'CAP_NAME'];
}


