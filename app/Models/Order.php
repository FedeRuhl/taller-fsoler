<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // COMPROBANTE
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'supplier_id',
        'order_type_id',
        'number',
        'date'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function orderType()
    {
        return $this->belongsTo(OrderType::class);
    }

    public function products() {
        return $this->belongsToMany(Product::class)
        ->withPivot(['id', 'product_quantity'])
        ->withTimestamps();
    }
}
