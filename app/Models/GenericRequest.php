<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GenericRequest extends Pivot
{
    protected $table = 'generic_requests';

    public $incrementing = true;

    public function product()
    {
        return $this->hasOne(GenericRequestProduct::class, 'generic_request_id', 'id');
    }
}
