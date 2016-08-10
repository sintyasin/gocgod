<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TxShipDetail extends Model
{
    protected $table = 'transaction__shipping_detail';
    protected $primaryKey = 'tx_shipping_id';
}
