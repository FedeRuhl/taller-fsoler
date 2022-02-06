<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function hospitalization()
    {
        return $this->belongsTo(Hospitalization::class, 'hospitalization_id', 'id');
    }

    public function generics()
    {
        return $this->belongsToMany(Generic::class, 'generic_requests')
            ->withPivot(['id', 'generics_total_quantity', 'generics_consumed_quantity'])
            ->withTimestamps();
    }
}
