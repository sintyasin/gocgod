<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SampleRequest extends Model
{
	use SoftDeletes;

    protected $table = 'transaction__sample_request';
    protected $primaryKey = 'request_id';
    protected $dates = ['deleted_at'];
}
