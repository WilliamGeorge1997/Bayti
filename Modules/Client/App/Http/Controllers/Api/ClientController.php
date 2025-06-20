<?php

namespace Modules\Client\App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Modules\Client\Service\ClientService;
use Modules\Client\App\resources\ClientResource;
use Modules\Client\App\Http\Requests\ClientUpdateProfileRequest;
use Modules\Client\App\Http\Requests\ClientChangePasswordRequest;

class ClientController extends Controller
{
    protected $clientService;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(ClientService $clientService)
    {
        $this->middleware('auth:client');
        $this->clientService = $clientService;
    }

    public function clientProperties(Request $request)
    {
        $data = $request->all();
        $relations = ['properties' => function($query) {
            $query->active()->available();
        }, 'properties.images', 'properties.subCategory.category'];
        $properties = $this->clientService->clientProperties($data, $relations);
        return returnMessage(true, 'Client Properties Fetched Successfully', ClientResource::collection($properties)->response()->getData(true));
    }
    public function changePassword(ClientChangePasswordRequest $request)
    {
        try{
            DB::beginTransaction();
            $this->clientService->changePassword($request->validated());
            DB::commit();
            return returnMessage(true, 'Password Changed Successfully');
        }
        catch(\Exception $e){
            DB::rollBack();
            return returnMessage(false, $e->getMessage(),null ,500);
        }
    }

    public function updateProfile(ClientUpdateProfileRequest $request)
    {
        try{
            DB::beginTransaction();
            $this->clientService->updateProfile($request->validated());
            DB::commit();
            return returnMessage(true, 'Profile Updated Successfully', new ClientResource(auth('client')->user()));
        }catch(\Exception $e){
            DB::rollBack();
            return returnMessage(false, $e->getMessage(),null ,500);
        }
    }
}