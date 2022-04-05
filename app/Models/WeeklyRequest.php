<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function generics()
    {
        return $this->belongsToMany(Generic::class, 'generic_requests', 'request_id')
            ->withPivot(['id', 'generics_total_quantity', 'generics_consumed_quantity'])
            ->withTimestamps();
    }
}
