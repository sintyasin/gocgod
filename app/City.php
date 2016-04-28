<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'master__city';
	protected $primaryKey = 'city_id';

	public function user()
	{
		return $this->hasMany('App\User', 'city_id', 'city_id');
	}
}
