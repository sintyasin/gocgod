<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
	use SoftDeletes;

    protected $table = 'master__city';
	protected $primaryKey = 'city_id';
	protected $dates = ['deleted_at'];

	public function user()
	{
		return $this->hasMany('App\User', 'city_id', 'city_id');
	}
}
