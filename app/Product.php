<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product__varian';
	protected $primaryKey = 'varian_id';

	public function category()
	{
		return $this->hasMany('App\ProductCategory', 'category_id', 'category_id');
	}
}
