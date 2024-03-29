<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_address_id',
        'CUIT',
        'company_name'
    ];

    public function address()
    {
        return $this->belongsTo(SupplierAddress::class, 'supplier_address_id', 'id');
    }
}
