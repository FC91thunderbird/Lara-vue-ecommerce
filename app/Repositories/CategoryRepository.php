<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository extends BaseRepository{

    protected $model;

    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    public function getList($request){
        $category = $this->model->query();

        if(!empty($request->search)){
            $category->where(function($query) use ($request){
                $query->where('name', 'like', '%'. $request->search .'%');
            });
        }

        $category = $category->latest()->paginate(config('constants.paginate'));
        return $category;
    }
}