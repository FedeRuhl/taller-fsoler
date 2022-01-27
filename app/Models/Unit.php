<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    public function ubication()
    {
        return $this->belongsTo(UnitUbication::class, 'unit_ubication_id');
    }
}
