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
use Modules\Property\App\Http\Requests\PropertyToggleAvailableRequest;

class PropertyController extends Controller
{
    protected $propertyService;

    public function __construct(PropertyService $propertyService)
    {
        $this->middleware('auth:client')->except(['index', 'show']);
        $this->propertyService = $propertyService;
    }

    public function index(Request $request)
    {
        $data = $request->all();
        $relations = ['client', 'subCategory.category', 'images'];
        $properties = $this->propertyService->active($data, $relations);
        return returnMessage(true, 'تم استرجاع العقارات بنجاح', PropertyResource::collection($properties)->response()->getData(true));
    }

    public function store(PropertyRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = (new PropertyDto($request))->dataFromRequest();
            $data['client_id'] = auth('client')->id();
            $property = $this->propertyService->create($data);
            DB::commit();
            return returnMessage(true, 'تم انشاء العقار بنجاح', $property);
        } catch (\Exception $e) {
            DB::rollBack();
            return returnMessage(false, $e->getMessage(), null, 'server_error');
        }
    }

    public function toggleAvailable(PropertyToggleAvailableRequest $request, Property $property)
    {
        try {
            DB::beginTransaction();
            $property = $this->propertyService->toggleAvailable($property, $request->validated());
            DB::commit();
            return returnMessage(true, 'تم تعديل العقار بنجاح', new PropertyResource($property));
        } catch (\Exception $e) {
            DB::rollBack();
            return returnMessage(false, $e->getMessage(), null, 'server_error');
        }
    }
}
