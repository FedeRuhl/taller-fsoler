<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalizationHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'hospitalization_id',
        'start_date',
        'end_date'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function hospitalization()
    {
        return $this->belongsTo(Hospitalization::class);
    }
}
