<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //
    protected $fillable = [
        'company_name',
        'email',
        'phone',
        'address',
        'facebook',
        'instagram',
        'youtube',
        'seo_title',
        'seo_description',
        'logo'
    ];
}
