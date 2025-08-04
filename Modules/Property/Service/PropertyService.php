<?php

namespace Modules\Property\Service;

use Illuminate\Support\Facades\File;
use Modules\Client\App\Models\Client;
use Modules\Common\Helpers\UploadHelper;
use Modules\Property\App\Models\Property;
use Modules\Notification\Service\NotificationService;
use Modules\Property\App\Jobs\NotifyClientsAboutNewPropertyJob;

class PropertyService
{
    use UploadHelper;

    function findAll($data = [], $relations = [])
    {
        $properties = Property::query()
            ->when($data['client_id'] ?? null, function ($query) use ($data) {
                return $query->where('client_id', $data['client_id']);
            })
            ->when($data['client_phone'] ?? null, function ($query) use ($data) {
                return $query->whereHas('client', function ($query) use ($data) {
                    $query->where('phone', $data['client_phone']);
                });
            })
            ->when($data['name'] ?? null, function ($query) use ($data) {
                return $query->whereHas('client', function ($query) use ($data) {
                    $query->where('first_name', 'like', '%' . $data['name'] . '%')
                        ->orWhere('last_name', 'like', '%' . $data['name'] . '%');
                });
            })
            ->when($data['sub_category_id'] ?? null, function ($query) use ($data) {
                return $query->where('sub_category_id', $data['sub_category_id']);
            })
            ->when($data['country_id'] ?? null, function ($query) use ($data) {
                return $query->where('country_id', $data['country_id']);
            })
            ->when($data['city_id'] ?? null, function ($query) use ($data) {
                return $query->where('city_id', $data['city_id']);
            })
            ->when($data['zone'] ?? null, function ($query) use ($data) {
                return $query->where('zone', $data['zone']);
            })
            ->when($data['type'] ?? null, function ($query) use ($data) {
                return $query->where('type', $data['type']);
            })
            ->when($data['min_price'] ?? null, function ($query) use ($data) {
                return $query->where('price', '>=', $data['min_price']);
            })
            ->when($data['max_price'] ?? null, function ($query) use ($data) {
                return $query->where('price', '<=', $data['max_price']);
            })
            ->when($data['min_area'] ?? null, function ($query) use ($data) {
                return $query->where('area', '>=', $data['min_area']);
            })
            ->when($data['max_area'] ?? null, function ($query) use ($data) {
                return $query->where('area', '<=', $data['max_area']);
            })
            ->when($data['floor'] ?? null, function ($query) use ($data) {
                return $query->where('floor', $data['floor']);
            })
            ->when($data['directions'] ?? null, function ($query) use ($data) {
                return $query->where('directions', $data['directions']);
            })
            ->when($data['age'] ?? null, function ($query) use ($data) {
                return $query->where('age', $data['age']);
            })
            ->when($data['ownership_type'] ?? null, function ($query) use ($data) {
                return $query->where('ownership_type', $data['ownership_type']);
            })
            ->when($data['bedrooms'] ?? null, function ($query) use ($data) {
                return $query->where('bedrooms', $data['bedrooms']);
            })
            ->when($data['living_rooms'] ?? null, function ($query) use ($data) {
                return $query->where('living_rooms', $data['living_rooms']);
            })
            ->when($data['bathrooms'] ?? null, function ($query) use ($data) {
                return $query->where('bathrooms', $data['bathrooms']);
            })
            ->when($data['facades'] ?? null, function ($query) use ($data) {
                return $query->where('facades', $data['facades']);
            })
            ->when($data['scale'] ?? null, function ($query) use ($data) {
                return $query->where('scale', $data['scale']);
            })
            ->when($data['pools'] ?? null, function ($query) use ($data) {
                return $query->where('pools', $data['pools']);
            })
            ->when($data['salons'] ?? null, function ($query) use ($data) {
                return $query->where('salons', $data['salons']);
            })
            ->when($data['min_total_area'] ?? null, function ($query) use ($data) {
                return $query->where('total_area', '>=', $data['min_total_area']);
            })
            ->when($data['max_total_area'] ?? null, function ($query) use ($data) {
                return $query->where('total_area', '<=', $data['max_total_area']);
            })
            ->when($data['fruit_trees'] ?? null, function ($query) use ($data) {
                return $query->where('fruit_trees', $data['fruit_trees']);
            })
            ->when($data['water_wells'] ?? null, function ($query) use ($data) {
                return $query->where('water_wells', $data['water_wells']);
            })
            ->when($data['phone'] ?? null, function ($query) use ($data) {
                return $query->where('phone', $data['phone']);
            })
            ->when($data['whatsapp'] ?? null, function ($query) use ($data) {
                return $query->where('whatsapp', $data['whatsapp']);
            })
            ->when($data['is_sold'] ?? null, function ($query) use ($data) {
                return $query->where('is_sold', $data['is_sold']);
            })
            ->when($data['finishing_status'] ?? null, function ($query) use ($data) {
                return $query->where('finishing_status', $data['finishing_status']);
            })
            ->when($data['rental_period'] ?? null, function ($query) use ($data) {
                return $query->where('rental_period', $data['rental_period']);
            })
            ->when($data['is_furnished'] ?? null, function ($query) use ($data) {
                return $query->where('is_furnished', $data['is_furnished']);
            })
            ->when($data['is_installment'] ?? null, function ($query) use ($data) {
                return $query->where('is_installment', $data['is_installment']);
            })
            ->when($data['is_active'] ?? null, function ($query) use ($data) {
                return $query->where('is_active', $data['is_active']);
            })
            ->when($data['is_available'] ?? null, function ($query) use ($data) {
                return $query->where('is_available', $data['is_available']);
            })
            ->with($relations)->latest();
        return getCaseCollection($properties, $data);
    }

    function findById($id)
    {
        $property = Property::findOrFail($id);
        return $property;
    }

    function findBy($key, $value, $relations = [])
    {
        return Property::where($key, $value)->with($relations)->get();
    }

    function active($data = [], $relations = [])
    {
        $properties = Property::query()
            ->when($data['client_id'] ?? null, function ($query) use ($data) {
                return $query->where('client_id', $data['client_id']);
            })
            ->when($data['client_phone'] ?? null, function ($query) use ($data) {
                return $query->whereHas('client', function ($query) use ($data) {
                    $query->where('phone', $data['client_phone']);
                });
            })
            ->when($data['name'] ?? null, function ($query) use ($data) {
                return $query->whereHas('client', function ($query) use ($data) {
                    $query->where('first_name', 'like', '%' . $data['name'] . '%')
                        ->orWhere('last_name', 'like', '%' . $data['name'] . '%');
                });
            })
            ->when($data['sub_category_id'] ?? null, function ($query) use ($data) {
                return $query->where('sub_category_id', $data['sub_category_id']);
            })
            ->when($data['country_id'] ?? null, function ($query) use ($data) {
                return $query->where('country_id', $data['country_id']);
            })
            ->when($data['city_id'] ?? null, function ($query) use ($data) {
                return $query->where('city_id', $data['city_id']);
            })
            ->when($data['zone'] ?? null, function ($query) use ($data) {
                return $query->where('zone', $data['zone']);
            })
            ->when($data['type'] ?? null, function ($query) use ($data) {
                return $query->where('type', $data['type']);
            })
            ->when($data['price'] ?? null, function ($query) use ($data) {
                return $query->where('price', $data['price']);
            })
            ->when($data['min_price'] ?? null, function ($query) use ($data) {
                return $query->where('price', '>=', $data['min_price']);
            })
            ->when($data['max_price'] ?? null, function ($query) use ($data) {
                return $query->where('price', '<=', $data['max_price']);
            })
            ->when($data['area'] ?? null, function ($query) use ($data) {
                return $query->where('area', $data['area']);
            })
            ->when($data['min_area'] ?? null, function ($query) use ($data) {
                return $query->where('area', '>=', $data['min_area']);
            })
            ->when($data['max_area'] ?? null, function ($query) use ($data) {
                return $query->where('area', '<=', $data['max_area']);
            })
            ->when($data['floor'] ?? null, function ($query) use ($data) {
                return $query->where('floor', $data['floor']);
            })
            ->when($data['directions'] ?? null, function ($query) use ($data) {
                return $query->where('directions', $data['directions']);
            })
            ->when($data['age'] ?? null, function ($query) use ($data) {
                return $query->where('age', $data['age']);
            })
            ->when($data['ownership_type'] ?? null, function ($query) use ($data) {
                return $query->where('ownership_type', $data['ownership_type']);
            })
            ->when($data['bedrooms'] ?? null, function ($query) use ($data) {
                return $query->where('bedrooms', $data['bedrooms']);
            })
            ->when($data['living_rooms'] ?? null, function ($query) use ($data) {
                return $query->where('living_rooms', $data['living_rooms']);
            })
            ->when($data['bathrooms'] ?? null, function ($query) use ($data) {
                return $query->where('bathrooms', $data['bathrooms']);
            })
            ->when($data['facades'] ?? null, function ($query) use ($data) {
                return $query->where('facades', $data['facades']);
            })
            ->when($data['scale'] ?? null, function ($query) use ($data) {
                return $query->where('scale', $data['scale']);
            })
            ->when($data['pools'] ?? null, function ($query) use ($data) {
                return $query->where('pools', $data['pools']);
            })
            ->when($data['salons'] ?? null, function ($query) use ($data) {
                return $query->where('salons', $data['salons']);
            })
            ->when($data['total_area'] ?? null, function ($query) use ($data) {
                return $query->where('total_area', $data['total_area']);
            })
            ->when($data['min_total_area'] ?? null, function ($query) use ($data) {
                return $query->where('total_area', '>=', $data['min_total_area']);
            })
            ->when($data['max_total_area'] ?? null, function ($query) use ($data) {
                return $query->where('total_area', '<=', $data['max_total_area']);
            })
            ->when($data['fruit_trees'] ?? null, function ($query) use ($data) {
                return $query->where('fruit_trees', $data['fruit_trees']);
            })
            ->when($data['water_wells'] ?? null, function ($query) use ($data) {
                return $query->where('water_wells', $data['water_wells']);
            })
            ->when($data['phone'] ?? null, function ($query) use ($data) {
                return $query->where('phone', $data['phone']);
            })
            ->when($data['whatsapp'] ?? null, function ($query) use ($data) {
                return $query->where('whatsapp', $data['whatsapp']);
            })
            ->when($data['is_sold'] ?? null, function ($query) use ($data) {
                return $query->where('is_sold', $data['is_sold']);
            })
            ->when($data['finishing_status'] ?? null, function ($query) use ($data) {
                return $query->where('finishing_status', $data['finishing_status']);
            })
            ->when($data['rental_period'] ?? null, function ($query) use ($data) {
                return $query->where('rental_period', $data['rental_period']);
            })
            ->when($data['is_furnished'] ?? null, function ($query) use ($data) {
                return $query->where('is_furnished', $data['is_furnished']);
            })
            ->when($data['is_installment'] ?? null, function ($query) use ($data) {
                return $query->where('is_installment', $data['is_installment']);
            })
            ->active()->with($relations)->latest();
        return getCaseCollection($properties, $data);
    }
    public function create($data)
    {
        $property = Property::create($data);
        if (request()->hasFile('images')) {
            foreach (request()->file('images') as $image) {
                $property->images()->create([
                    'image' => $this->upload($image, 'property'),
                ]);
            }
        }
        NotifyClientsAboutNewPropertyJob::dispatch($property->id)->onConnection('database');
        return $property;
    }

    function update($property, $data)
    {
        if (request()->hasFile('images')) {
            foreach (request()->file('images') as $image) {
                $property->images()->create([
                    'image' => $this->upload($image, 'property'),
                ]);
            }
        }
        $property->update($data);
        return $property->fresh();
    }

    function delete($property)
    {
        $property->delete();
    }

    public function toggleActivate($property)
    {
        $property->update(['is_active' => !$property->is_active]);
        if ($property->is_active) {
            (new NotificationService)->sendNotification('تم قبول العقار', 'تم قبول العقار بنجاح', $property->client_id, Client::class);
        }
        return $property->fresh();
    }

    public function toggleAvailable($property, $data)
    {
        $property->update(array_merge($data, ['is_available' => !$property->is_available]));
        return $property->fresh();
    }
}