<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NameProduct extends Model
{
    protected $table = 'product__varian';
	protected $primaryKey = 'varian_id';

	public function product()
	{
		$this->belongsTo('App\Product', 'category_id', 'category_id');
	}
}
