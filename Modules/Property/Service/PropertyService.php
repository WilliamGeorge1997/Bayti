<?php

namespace Modules\Property\Service;

use Illuminate\Support\Facades\File;
use Modules\Common\Helpers\UploadHelper;
use Modules\Property\App\Models\Property;
use Modules\Property\App\Jobs\NotifyClientsAboutNewPropertyJob;

class PropertyService
{
    use UploadHelper;

    function findAll($data = [], $relations = [])
    {
        $properties = Property::query()->with($relations)->latest();
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
        $properties = Property::query()->active()->available()->with($relations)->latest();
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
        return $property->fresh();
    }

    public function toggleAvailable($property, $data)
    {
        $property->update(array_merge($data, ['is_available' => !$property->is_available]));
        return $property->fresh();
    }
}