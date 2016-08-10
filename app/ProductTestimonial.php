<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductTestimonial extends Model
{
    use SoftDeletes;

    protected $table = 'product__testimonial';
    protected $primaryKey = 'testimonial_id';
    protected $dates = ['deleted_at'];
}

