<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GenericRequest extends Pivot
{
    public $incrementing = true;

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
