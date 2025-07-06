<?php

namespace Modules\Country\App\Models;

use Modules\Country\App\Models\City;
use Illuminate\Database\Eloquent\Model;
use Modules\Country\Database\factories\ZoneFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Zone extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['title', 'city_id'];
    //Serialize Dates
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i A');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
