<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $table = 'product__testimonial';
    protected $primaryKey = 'testimonial_id';

    protected $fillable = [
        'id', 'varian_id', 'testimonial', 'approval'
    ];
}
