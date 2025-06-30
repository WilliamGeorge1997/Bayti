<?php

namespace Modules\Property\App\Models;

use Spatie\Activitylog\LogOptions;
use Modules\Client\App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Modules\Category\App\Models\SubCategory;
use Modules\Property\App\Models\PropertyImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'description',
        'client_id',
        'sub_category_id',
        'transaction_type_id',
        'lat',
        'long',
        'country',
        'city',
        'address',
        'price',
        'type',
        'area',
        'floor',
        'directions',
        'age',
        'ownership_type',
        'bedrooms',
        'living_rooms',
        'bathrooms',
        'facades',
        'scale',
        'pools',
        'salons',
        'total_area',
        'fruit_trees',
        'water_wells',
        'video',
        'phone',
        'whatsapp',
        'notes',
        'is_furnished',
        'is_sold',
        'is_installment',
        'is_active',
        'is_available',
        'unavailable_comment',
        'finishing_status',
        'rental_period',
    ];

    //Log Activity
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('Property')
            ->dontLogIfAttributesChangedOnly(['updated_at']);
    }

    //Serialize Dates
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i A');
    }

    //Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', 1);
    }

    //Relations
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

}
