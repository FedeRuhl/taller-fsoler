<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        'dni',
        'first_name',
        'last_name',
        'birth_date'
    ];

    public function getAgeAttribute() {
        return Carbon::parse($this->birth_date)->age;
    }

    public function phones() {
        return $this->hasMany(Phone::class);
    }
}
