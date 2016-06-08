<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    protected $table = 'master__bank';
	protected $primaryKey = 'bank_id';
}
