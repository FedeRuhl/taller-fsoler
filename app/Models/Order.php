<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id')
            ->whereRelation('userClass', 'name', '=', 'Personal de sanidad');
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
        return $this->belongsToMany(Product::class);
    }
}
