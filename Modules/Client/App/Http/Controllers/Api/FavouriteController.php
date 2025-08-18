<?php

namespace Modules\Client\App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Client\Service\FavouriteService;
use Modules\Property\Service\PropertyService;
use Modules\Client\App\Http\Requests\FavouriteRequest;

class FavouriteController extends Controller
{
    private $favouriteService;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(FavouriteService $favouriteService)
    {
        $this->middleware('auth:client');
        $this->favouriteService = $favouriteService;
    }

    public function toggleFavourite(FavouriteRequest $request)
    {
        $favourite = $this->favouriteService->findByMultiKeys('client_id',$request['client_id'],'property_id',$request['property_id']);

        if ($favourite) {
            $this->favouriteService->delete($favourite->id);
            return returnMessage(true,'Favourite Deleted successfully');
        } else {
            $this->favouriteService->save($request->toArray());
            return returnMessage(true,'Favourite Added successfully');
        }
    }

    public function favourites(Request $request)
    {
        $data = $request->all();
        $data['property_ids'] = $this->favouriteService->findBy('client_id',auth('client')->id())->pluck('property_id');
        $relations = ['subCategory.category', 'images', 'country', 'city'];
        $properties = (new PropertyService())->properties($data, $relations);
        return returnMessage(true,'Favorites', $properties);

    }
}
