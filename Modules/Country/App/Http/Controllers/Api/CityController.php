<?php

namespace Modules\Country\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Country\App\Models\City;
use Modules\Country\App\Models\Country;

class CityController extends Controller
{
    public function index(Country $country)
    {
        $cities = City::where('country_id', $country->id)->get();
        return returnMessage(true, 'تم استرجاع المدن بنجاح', $cities);
    }
}
