<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{
    protected $table = 'master__admin';
	protected $primaryKey = 'id';	
	public $timestamps = false;
}
