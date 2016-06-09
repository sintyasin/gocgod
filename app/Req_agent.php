<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Req_agent extends Model
{
	use SoftDeletes;

    protected $table = 'master__req_agent';
	protected $primaryKey = 'reqagent_id';
    protected $dates = ['deleted_at'];
}
