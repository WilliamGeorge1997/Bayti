<?php

namespace Modules\Country\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Country\App\Models\City;
use Modules\Country\App\Models\Zone;

class ZoneController extends Controller
{
    public function index(City $city)
    {
        $zones = Zone::where('city_id', $city->id)->get();
        return returnMessage(true, 'تم استرجاع المناطق بنجاح', $zones);
    }
}
