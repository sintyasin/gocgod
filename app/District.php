<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use SoftDeletes;
	
    protected $table = 'master__district';
    protected $primaryKey = 'district_id';
	protected $dates = ['deleted_at'];
}
