<?php

namespace Modules\Property\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShareLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'token',
        'clicks'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}