<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    protected $table = 'master__member';
	protected $primaryKey = 'id';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
        'name', 'address', 'date_of_birth', 'phone', 'email', 'password', 'city_id', 'province_id', 'district_id', 'zipcode'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $guarded = [
        'id', 'status_user', 'verification', 'balance', 'bank_account', 'bank_id'
    ];

    public function member_testi()
    {
        return $this->belongsTo('App\ProductTestimonial', 'id', 'id');
    }

    public function city()
    {
        return $this->belongsTo('App\City', 'city_id', 'city_id');
    }
}
