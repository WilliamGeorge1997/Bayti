<?php

namespace Modules\Property\DTO;

class PropertyDto
{
    public $title;
    public $description;
    public $sub_category_id;
    public $lat;
    public $long;
    public $city;
    public $address;
    public $price;
    public $area;
    public $floor;
    public $directions;
    public $age;
    public $ownership_type;
    public $bedrooms;
    public $living_rooms;
    public $bathrooms;
    public $width_ratio;
    public $video;
    public $notes;
    public $is_furnished;
    public $is_installment;
    public function __construct($request)
    {
        if ($request->get('title'))
            $this->title = $request->get('title');
        if ($request->get('description'))
            $this->description = $request->get('description');
        if ($request->get('sub_category_id'))
            $this->sub_category_id = $request->get('sub_category_id');
        if ($request->get('lat'))
            $this->lat = $request->get('lat');
        if ($request->get('long'))
            $this->long = $request->get('long');
        if ($request->get('city'))
            $this->city = $request->get('city');
        if ($request->get('address'))
            $this->address = $request->get('address');
        if ($request->get('price'))
            $this->price = $request->get('price');
        if ($request->get('area'))
            $this->area = $request->get('area');
        if ($request->get('floor'))
            $this->floor = $request->get('floor');
        if ($request->get('directions'))
            $this->directions = $request->get('directions');
        if ($request->get('age'))
            $this->age = $request->get('age');
        if ($request->get('ownership_type'))
            $this->ownership_type = $request->get('ownership_type');
        if ($request->get('bedrooms'))
            $this->bedrooms = $request->get('bedrooms');
        if ($request->get('living_rooms'))
            $this->living_rooms = $request->get('living_rooms');
        if ($request->get('bathrooms'))
            $this->bathrooms = $request->get('bathrooms');
        if ($request->get('width_ratio'))
            $this->width_ratio = $request->get('width_ratio');
        if ($request->get('video'))
            $this->video = $request->get('video');
        if ($request->get('notes'))
            $this->notes = $request->get('notes');
        $this->is_furnished = isset($request['is_furnished']) ? 1 : 0;
        $this->is_installment = isset($request['is_installment']) ? 1 : 0;
    }
    public function dataFromRequest()
    {
        $data = json_decode(json_encode($this), true);
        if ($this->title == null)
            unset($data['title']);
        if ($this->description == null)
            unset($data['description']);
        if ($this->sub_category_id == null)
            unset($data['sub_category_id']);
        if ($this->lat == null)
            unset($data['lat']);
        if ($this->long == null)
            unset($data['long']);
        if ($this->city == null)
            unset($data['city']);
        if ($this->address == null)
            unset($data['address']);
        if ($this->price == null)
            unset($data['price']);
        if ($this->area == null)
            unset($data['area']);
        if ($this->floor == null)
            unset($data['floor']);
        if ($this->directions == null)
            unset($data['directions']);
        if ($this->age == null)
            unset($data['age']);
        if ($this->ownership_type == null)
            unset($data['ownership_type']);
        if ($this->bedrooms == null)
            unset($data['bedrooms']);
        if ($this->living_rooms == null)
            unset($data['living_rooms']);
        if ($this->bathrooms == null)
            unset($data['bathrooms']);
        if ($this->width_ratio == null)
            unset($data['width_ratio']);
        if ($this->video == null)
            unset($data['video']);
        if ($this->notes == null)
            unset($data['notes']);
        if ($this->is_furnished == null)
            unset($data['is_furnished']);
        if ($this->is_installment == null)
            unset($data['is_installment']);

        return $data;
    }
}
