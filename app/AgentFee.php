<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentFee extends Model
{
    protected $table = 'master__agent_fee';
    protected $primaryKey  = 'fee';
}
