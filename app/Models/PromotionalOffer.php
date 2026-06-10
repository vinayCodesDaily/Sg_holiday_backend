<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionalOffer extends Model
{
    //
    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'badge',
        'button_text',
        'button_link',
        'start_date',
        'end_date',
        'is_active',
    ];
}
