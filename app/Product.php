<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product__varian';
	protected $primaryKey = 'varian_id';

	//biar ga usah ada created_at and updated_at di kolom
    //public $timestamps = false;
}
