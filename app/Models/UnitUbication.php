<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitUbication extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'province_id',
        'zip_code'
    ];
}
