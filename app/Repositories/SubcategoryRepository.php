<?php

namespace App\Repositories;

use App\Models\Subcategory;
use Illuminate\Support\Facades\Log;

class SubcategoryRepository extends BaseRepository{

    protected $model;

    public function __construct(Subcategory $subcategory)
    {
        $this->model = $subcategory;
    }

    public function getList($request){
        $subcategory = $this->model->query();

        if(!empty($request->search)){
            $subcategory->where(function($query) use ($request){
                $query->where('name', 'like', '%'. $request->search .'%');
            });
        }

        $subcategory = $subcategory->latest()->paginate(config('constants.paginate'));
        return $subcategory;
    }

    public function fetchByParentId($id, $relations = []){
        try {
            return $this->model->with($relations)->where('category_id', $id)->get();
        } catch (\Exception $e) {
            Log::error($e);
            return false;
        }
    }
}