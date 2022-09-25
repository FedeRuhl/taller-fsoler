<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GenericRequestProduct extends Pivot
{
    // protected $table = 'generic_request_product';
    protected $fillable = [
        'generic_request_id',
        'product_id',
        'depot_id',
        'products_quantity'
    ];
}
