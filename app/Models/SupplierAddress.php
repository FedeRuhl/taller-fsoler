<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'zip_code',
        'street',
        'number'
    ];
}
