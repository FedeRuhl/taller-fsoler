<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitUbication extends Model
{
    use HasFactory;

    protected $fillable = [
        'city',
        'province',
        'zip_code'
    ];
}
