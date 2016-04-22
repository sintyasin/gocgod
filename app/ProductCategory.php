<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'product__category';
	protected $primaryKey = 'category_id';

	public function product()
	{
		$this->belongsTo('App\Product', 'category_id', 'category_id');
	}
}
