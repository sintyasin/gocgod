<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
	use SoftDeletes;

    protected $table = 'product__category';
	protected $primaryKey = 'category_id';
	protected $dates = ['deleted_at'];
	public function product()
	{
		$this->hasMany('App\Product', 'category_id', 'category_id');
	}
}
