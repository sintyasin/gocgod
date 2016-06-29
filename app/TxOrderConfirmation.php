<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TxOrderConfirmation extends Model
{
    protected $table = 'transaction__order_confirmation';
    protected $primaryKey = 'confirmation_id';
}
