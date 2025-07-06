<?php

namespace Modules\Country\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Country\App\Models\Country;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        return returnMessage(true, 'تم استرجاع الدول بنجاح', $countries);
    }
}
