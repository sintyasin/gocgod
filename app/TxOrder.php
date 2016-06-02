<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TxOrder extends Model
{
    protected $table = 'transaction__order';
    protected $primaryKey = 'order_id';
}
