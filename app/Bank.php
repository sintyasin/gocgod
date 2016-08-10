<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
	use SoftDeletes;

    protected $table = 'master__bank';
	protected $primaryKey = 'bank_id';
	protected $dates = ['deleted_at'];
}
