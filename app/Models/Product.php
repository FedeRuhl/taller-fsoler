<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Generic()
    {
        return $this->belongsTo(Generic::class);
    }

    public function depots()
    {
        return $this->belongsToMany(Depot::class);
    }
}
