<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageImage extends Model
{
    //
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
