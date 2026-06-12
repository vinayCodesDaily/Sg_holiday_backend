<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Destination;
use App\Models\TripType;
use App\Models\Activity;
use App\Models\PackageImage;
use App\Models\Itinerary;
use App\Models\PackageInclusion;
use App\Models\PackageExclusion;
use App\Models\PackageFaq;
use App\Models\PackageHighlight;
use App\Models\Enquiry;
use App\Models\User;

class Package extends Model
{
    //
    protected $fillable = [
        'destination_id',
        'created_by',
        'title',
        'slug',
        'short_description',
        'description',
        'transportation',
        'accommodation',
        'best_season',
        'meals',
        'main_attractions',
        'duration_days',
        'duration_nights',
        'max_persons',
        'starting_price',
        'thumbnail',
        'featured',
        'status'
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tripTypes()
    {
        return $this->belongsToMany(
            TripType::class,
            'package_trip_type'
        );
    }

    public function activities()
    {
        return $this->belongsToMany(
            Activity::class,
            'package_activity'
        );
    }

    public function images()
    {
        return $this->hasMany(PackageImage::class);
    }

    public function itineraries()
    {
        return $this->hasMany(Itinerary::class);
    }

    public function inclusions()
    {
        return $this->hasMany(PackageInclusion::class);
    }

    public function exclusions()
    {
        return $this->hasMany(PackageExclusion::class);
    }

    public function highlights()
    {
        return $this->hasMany(PackageHighlight::class);
    }

    public function faqs()
    {
        return $this->hasMany(PackageFaq::class);
    }

    public function enquiries()
    {
        return $this->hasMany(Enquiry::class);
    }
}
