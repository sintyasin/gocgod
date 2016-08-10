<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TxShip extends Model
{
    protected $table = 'transaction__shipping';
    protected $primaryKey = 'order_id';
}
