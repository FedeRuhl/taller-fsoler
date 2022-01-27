<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    public function address()
    {
        return $this->belongsTo(SupplierAddress::class, 'supplier_address_id', 'id');
    }
}
