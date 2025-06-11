<?php

namespace Modules\Property\App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Modules\Property\DTO\PropertyDto;
use Modules\Property\Service\PropertyService;
use Modules\Property\App\Http\Requests\PropertyRequest;

class PropertyController extends Controller
{
    protected $propertyService;

    public function __construct(PropertyService $propertyService)
    {
        $this->middleware('auth:client')->except(['index', 'show']);
        $this->propertyService = $propertyService;
    }

    public function index()
    {
        $properties = $this->propertyService->findAll();
    }

    public function show($id)
    {
        $property = $this->propertyService->findById($id);
    }

    public function store(PropertyRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = (new PropertyDto($request))->dataFromRequest();
            $data['client_id'] = auth('client')->id();
            $property = $this->propertyService->create($data);
            DB::commit();
            return returnMessage(true, 'Property Created Successfully', $property);
        } catch (\Exception $e) {
            DB::rollBack();
            return returnMessage(false, $e->getMessage(), null, 'server_error');
        }
    }

    public function update(Request $request, $id)
    {
        $property = $this->propertyService->update($id, $request->all());
    }

    public function destroy($id)
    {
        $this->propertyService->delete($id);
    }

    public function toggleAvailable($id)
    {
        $property = $this->propertyService->toggleAvailable($id);
    }
}