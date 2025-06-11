<?php

namespace Modules\Property\App\Models;

use Modules\Client\App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\App\Models\Category;
use Modules\Property\App\Models\TransactionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Property extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
        'client_id',
        'sub_category_id',
        'transaction_type_id',
        'lat',
        'long',
        'city',
        'address',
        'price',
        'area',
        'floor',
        'directions',
        'age',
        'ownership_type',
        'bedrooms',
        'living_rooms',
        'bathrooms',
        'width_ratio',
        'video',
        'notes',
        'is_furnished',
        'is_installment',
        'is_active',
        'is_available',
    ];

    //Log Activity
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('Client')
            ->dontLogIfAttributesChangedOnly(['updated_at']);
    }

    //Serialize Dates
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i A');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class);
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

}
