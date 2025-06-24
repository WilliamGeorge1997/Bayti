<?php

namespace Modules\Property\DTO;

class PropertyDto
{
    public $type;
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
    public $facades;
    public $scale;
    public $pools;
    public $salons;
    public $total_area;
    public $fruit_trees;
    public $water_wells;
    public $bedrooms;
    public $living_rooms;
    public $bathrooms;
    public $video;
    public $phone;
    public $whatsapp;
    public $notes;
    public $is_furnished;
    public $is_installment;
    public $finishing_status;
    public $rental_period;
    public function __construct($request)
    {
        if ($request->get('type'))
            $this->type = $request->get('type');
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
        if ($request->get('facades'))
            $this->facades = $request->get('facades');
        if ($request->get('scale'))
            $this->scale = $request->get('scale');
        if ($request->get('pools'))
            $this->pools = $request->get('pools');
        if ($request->get('salons'))
            $this->salons = $request->get('salons');
        if ($request->get('total_area'))
            $this->total_area = $request->get('total_area');
        if ($request->get('fruit_trees'))
            $this->fruit_trees = $request->get('fruit_trees');
        if ($request->get('water_wells'))
            $this->water_wells = $request->get('water_wells');
        if ($request->get('video'))
            $this->video = $request->get('video');
        if ($request->get('phone'))
            $this->phone = $request->get('phone');
        if ($request->get('whatsapp'))
            $this->whatsapp = $request->get('whatsapp');
        if ($request->get('notes'))
            $this->notes = $request->get('notes');
        if ($request->get('is_furnished'))
            $this->is_furnished = $request->get('is_furnished');
        if ($request->get('is_installment'))
            $this->is_installment = $request->get('is_installment');
        if ($request->get('finishing_status'))
            $this->finishing_status = $request->get('finishing_status');
        if ($request->get('rental_period'))
            $this->rental_period = $request->get('rental_period');
    }
    public function dataFromRequest()
    {
        $data = json_decode(json_encode($this), true);
        if ($this->type == null)
            unset($data['type']);
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
        if ($this->facades == null)
            unset($data['facades']);
        if ($this->scale == null)
            unset($data['scale']);
        if ($this->pools == null)
            unset($data['pools']);
        if ($this->salons == null)
            unset($data['salons']);
        if ($this->video == null)
            unset($data['video']);
        if ($this->phone == null)
            unset($data['phone']);
        if ($this->whatsapp == null)
            unset($data['whatsapp']);
        if ($this->notes == null)
            unset($data['notes']);
        if ($this->is_furnished == null)
            unset($data['is_furnished']);
        if ($this->is_installment == null)
            unset($data['is_installment']);
        if ($this->finishing_status == null)
            unset($data['finishing_status']);
        if ($this->rental_period == null)
            unset($data['rental_period']);
        return $data;
    }
}
