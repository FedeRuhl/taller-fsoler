<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit_ubication_id'
    ];

    public function ubication()
    {
        return $this->belongsTo(UnitUbication::class, 'unit_ubication_id');
    }
}
