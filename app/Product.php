<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
	use SoftDeletes;

    protected $table = 'product__varian';
	protected $primaryKey = 'varian_id';
	protected $dates = ['deleted_at'];
	// public $incrementing = false;

	// public function category()
	// {
	// 	return $this->belongsTo('App\ProductCategory', 'category_id', 'category_id');
	// }
}
