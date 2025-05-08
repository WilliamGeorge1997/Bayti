<?php

namespace Modules\Category\Service;

use Illuminate\Support\Facades\File;
use Modules\Category\App\Models\Category;
use Modules\Common\Helpers\UploadHelper;

class CategoryService
{
    use UploadHelper;

    function findAll($data = [], $relations = [])
    {
        $categories = Category::query();
        return getCaseCollection($categories, $data);
    }
    function findById($id)
    {
        return Category::find($id);
    }
    function findBy($key, $value)
    {
        return Category::where($key, $value)->get();
    }
    function create($data)
    {
        if (request()->hasFile('image')) {
            $data['image'] = $this->upload(request()->file('image'), 'category');
        }
        $category = Category::create($data);
        return $category;
    }

    function update($id, $data)
    {
        $category = $this->findById($id);
        if (request()->hasFile('image')) {
            if ($category->image) {
                File::delete(public_path('uploads/Category/' . $this->getImageName('category', $category->image)));
            }
            $data['image'] = $this->upload(request()->file('image'), 'category');
        }
        $category->update($data);
        return $category;
    }

    function delete($category)
    {
        if ($category->image) {
            File::delete(public_path('uploads/Category/' . $this->getImageName('category', $category->image)));
        }
        $category->delete();
    }
}