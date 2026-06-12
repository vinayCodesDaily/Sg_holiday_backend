<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripType extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
        'image',
        'status',
        'is_featured'
    ];
    public function packages()
    {
        return $this->belongsToMany(
            Package::class,
            'package_trip_type'
        );
    }
}
