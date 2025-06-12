<?php

namespace Modules\Property\App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Modules\Property\DTO\PropertyDto;
use Modules\Property\App\Models\Property;
use Modules\Property\Service\PropertyService;
use Modules\Property\App\resources\PropertyResource;
use Modules\Property\App\Http\Requests\PropertyRequest;

class PropertyAdminController extends Controller
{
    protected $propertyService;

    public function __construct(PropertyService $propertyService)
    {
        $this->middleware('auth:admin');
        $this->propertyService = $propertyService;
    }

    public function index(Request $request)
    {
        $data = $request->all();
        $relations = ['client', 'subCategory.category', 'images'];
        $properties = $this->propertyService->findAll($data, $relations);
        return returnMessage(true, 'Properties Fetched Successfully', PropertyResource::collection($properties)->response()->getData(true));
    }
    public function toggleActivate(Property $property)
    {
        try {
            DB::beginTransaction();
            $property = $this->propertyService->toggleActivate($property);
            DB::commit();
            return returnMessage(true, 'Property updated successfully', new PropertyResource($property));
        } catch (\Exception $e) {
            DB::rollBack();
            return returnMessage(false, $e->getMessage(), null, 'server_error');
        }
    }
}