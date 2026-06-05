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
    'message',
    'status',
    'remarks'
];
    
    
    public function package()
{
    return $this->belongsTo(Package::class);
}
}
