<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageInclusion extends Model
{
    //
    public function package()
{
    return $this->belongsTo(Package::class);
}
}
