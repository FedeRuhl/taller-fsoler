<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class DepotProduct extends Pivot
{
    protected $fillable = [
        'depot_id',
        'product_id',
        'stock',
        'expiration_date',
        'lote_code'
    ];
}
