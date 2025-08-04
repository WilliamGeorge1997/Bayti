<?php

namespace Modules\Client\App\Models;

use Modules\Client\App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Modules\Property\App\Models\Property;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Favourite extends Model
{
    use HasFactory;


    protected $fillable = ['client_id', 'property_id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}