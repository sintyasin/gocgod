<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgentRating extends Model
{
	use SoftDeletes;

    protected $table = 'master__agent_rating';
    protected $primaryKey = 'rating_id';
	protected $dates = ['deleted_at'];

}
