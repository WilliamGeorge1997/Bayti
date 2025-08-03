<?php

namespace Modules\Client\App\Models;

use Spatie\Activitylog\LogOptions;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Modules\Property\App\Models\Property;
use Spatie\Activitylog\Traits\LogsActivity;
use Modules\Notification\App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable implements JWTSubject
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'country_code', 'password', 'image','fcm_token', 'verify_code', 'is_active'];
    protected $hidden = ['password'];

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

    //Get FullImage Path
    public function getImageAttribute($value)
    {
        if ($value != null && $value != '') {
            if (filter_var($value, FILTER_VALIDATE_URL)) {
                return $value;
            } else {
                return asset('uploads/client/' . $value);
            }
        }
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')->orWhere('notifiable_id', null);
    }
    //JWT

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}