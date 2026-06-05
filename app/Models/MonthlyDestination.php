<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyDestination extends Model
{
    //
    protected $fillable = [
        'month',
        'place_name',
        'description',
        'package_id',
        'display_order',
        'status'
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
