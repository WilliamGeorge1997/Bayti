<?php


namespace Modules\Client\Service;

use Modules\Client\App\Models\Favourite;
use Modules\Property\App\Models\Property;

class FavouriteService
{
    function findAll()
    {
        return Favourite::all();
    }

    function findById($id)
    {
        return Favourite::whereId($id)->first();
    }

    function findBy($key, $value, $relation = [], $paginate = 5)
    {
        return Favourite::with($relation)->where($key, $value)->paginate($paginate);
    }

    function findByMultiKeys($key, $value, $key1, $value1)
    {
        return Favourite::where($key, $value)->where($key1, $value1)->first();
    }

    function save($data)
    {
        return Favourite::create($data);
    }

    function delete($id)
    {
        $Favourite = $this->findById($id);
        $Favourite->delete();
    }

    function properties($relation = [], $filters)
    {
        return Property::with($relation)->whereHas('favourites', function ($query) {
            $query->where('client_id', auth('client')->id());
        })
            ->with([
                'cities' => function ($query) use ($filters) {
                    $query->where('city_id', $filters['city_id']);
                }
            ])
            ->whereRelation('cities', 'city_id', $filters['city_id'])
            ->when($filters['order_method'] == 1, function ($q) {
                return $q->where('is_mosque', 1);
            })
            ->when($filters['order_method'] == 2, function ($q) {
                return $q->where('is_home', 1);
            })
            ->paginate($filters['paginate'] ?? 5);
    }
}
