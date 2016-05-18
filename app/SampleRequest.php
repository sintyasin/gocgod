<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SampleRequest extends Model
{
    protected $table = 'transaction__sample_request';
    protected $primaryKey = 'request_id';
}
