<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'generic_id',
        'laboratory_id'
    ];

    public function generic()
    {
        return $this->belongsTo(Generic::class);
    }

    public function laboratory()
    {
        return $this->belongsTo(Laboratory::class);
    }

    public function depots()
    {
        return $this->belongsToMany(Depot::class)
            ->withPivot(['id', 'stock', 'expiration_date', 'lote_code'])
            ->withTimestamps();
    }

    public function order()
    {
        return $this->belongsToMany(Order::class);
    }

    public function genericRequests()
    {
        return $this->belongsToMany(GenericRequestProduct::class, 'generic_request_product', 'product_id', 'generic_request_id')
            ->withTimestamps();
    }
}
