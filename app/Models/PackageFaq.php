<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageFaq extends Model
{
    //
    protected $fillable = [
    'package_id',
    'question',
    'answer'
];
    public function package()
{
    return $this->belongsTo(Package::class);
}
}
