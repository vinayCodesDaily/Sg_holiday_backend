<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeAbout extends Model
{
    //
    protected $table = 'home_about';

    protected $fillable = [
        'title',
        'description',
        'image',
        'plan_trip_button_text',
        'plan_trip_button_link',
        'whatsapp_button_text',
        'whatsapp_number',
        'status'
    ];
}
