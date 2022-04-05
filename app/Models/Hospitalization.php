<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospitalization extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'is_ambulatory'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function histories()
    {
        return $this->hasMany(HospitalizationHistory::class);
    }

    public function currentHistory()
    {
        return $this->hasMany(HospitalizationHistory::class)
            ->whereNull('end_date');
    }
}
