<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    //
    protected $fillable = [
    'package_id',
    'name',
    'email',
    'phone',
    'destination',
    'travel_date',
    'number_of_persons',
    'message',
    'status',
    'remarks'
];

    protected $casts = [
        'travel_date' => 'date',
    ];
    
    
    public function package()
{
    return $this->belongsTo(Package::class);
}
}
