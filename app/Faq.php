<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
	use SoftDeletes;

    protected $table = 'faq__question';
    protected $primaryKey = 'question_id';
    public $incrementing = false;
	protected $dates = ['deleted_at'];
}
