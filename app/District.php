<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use SoftDeletes;
	
    protected $table = 'master__province';
    protected $primaryKey = 'province_id';
	protected $dates = ['deleted_at'];
}
