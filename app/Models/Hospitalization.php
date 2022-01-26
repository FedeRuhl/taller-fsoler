<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospitalization extends Model
{
    use HasFactory;

    public function Patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function Service()
    {
        return $this->belongsTo(Service::class);
    }
}
