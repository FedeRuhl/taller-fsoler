<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id',
        'unit_id',
        'os_number',
        'status',
        'is_military'
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
