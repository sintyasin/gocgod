<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'master__admin';
	protected $primaryKey = 'id';	
	public $timestamps = false;
}
