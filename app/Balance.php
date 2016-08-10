<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $table = 'master__tx_balance';
    protected $primaryKey = 'balance_id';
}
