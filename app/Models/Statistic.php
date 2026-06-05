<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    //
    protected $fillable = [
        'title',
        'value',
        'icon',
        'display_order',
        'status'
    ];
}
