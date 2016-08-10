<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
	use SoftDeletes;
	
    protected $table = 'master__admin';
	protected $primaryKey = 'id';

	protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at'
    ];
}
