<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generic extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function presentations() {
        return $this->belongsToMany(GenericPresentation::class, 'generic_generic_presentation');
    }
}
