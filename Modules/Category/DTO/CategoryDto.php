<?php


namespace Modules\Category\DTO;

use Illuminate\Support\Facades\Hash;

class CategoryDto
{
    public $title;
    public $is_active;


    public function __construct($request) {
        if($request->get('title')) $this->title = $request->get('title');
        if($request->get('is_active')) $this->is_active = $request->get('is_active');
    }

    public function dataFromRequest()
    {
        $data =  json_decode(json_encode($this), true);
        if($this->title == null) unset($data['title']);
        if($this->is_active == null) unset($data['is_active']);
        return $data;
    }
}

