<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Person extends Model
{
    use HasFactory;

    public function getAgeAttribute() {
        return Carbon::parse($this->birth_date)->age;
    }
}
