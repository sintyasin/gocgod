<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'faq__question';
	protected $primaryKey = 'question_id';

}
