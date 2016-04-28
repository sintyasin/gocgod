<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'master__member';
	protected $primaryKey = 'id';
	public $incrementing = false;

	public function city()
	{
		return $this->belongsTo('App\City', 'city_id', 'city_id');
	}
}
