<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'master__member';
	protected $primaryKey = 'id';	
	public $timestamps = false;
}
