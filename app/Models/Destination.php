<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    //
     protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'status'
    ];

    public function packages()
{
    return $this->hasMany(Package::class);
}
}
