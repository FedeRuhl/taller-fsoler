<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id',
        'patient_address_id',
        'unit_id',
        'phone',
        'os_number',
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

    public function address()
    {
        return $this->belongsTo(PatientAddress::class);
    }
}
