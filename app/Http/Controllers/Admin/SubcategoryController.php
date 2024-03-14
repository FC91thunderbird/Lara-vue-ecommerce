<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\subcategory\SubcategoryAdd;
use App\Http\Requests\subcategory\SubcategoryUpdate;
use App\Http\Resources\subcategory\SubcategoryList;
use App\Http\Resources\subcategory\SubcategoryResource;
use App\Repositories\SubcategoryRepository;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    protected $subcategoryRepository;

    public function __construct(SubcategoryRepository $subcategoryRepository)
    {
        $this->subcategoryRepository = $subcategoryRepository;
    }

    public function index(Request $request){
        $subcategory = $this->subcategoryRepository->getList($request);

        if(empty($subcategory)){
            return $this->response(false, [], 'Subcategory not found');
        }

        $data = [
            'subcategories' => new SubcategoryList($subcategory),
        ];

        return $this->response(true, $data, 'subcategory Fetch');
    }

    public function store(SubcategoryAdd $request){
        $validatedData = $request->validated();

        $subcategory = $this->subcategoryRepository->store($validatedData);

        if(empty($subcategory)){
            return $this->response(false, [], 'Failed to create Subcategory');
        }

        $data = [
            'subcategory' => $subcategory,
        ];
        return $this->response(true, $data, 'Successful Added Subcategory');
    }


    public function fetchSubcategory(string $catId){
        $subcategory = $this->subcategoryRepository->fetchByParentId($catId);

        if(empty($subcategory)){
            return $this->response(false, [], 'subcategory not found');
        }

        $data = [
            'subcategory' => $subcategory,
        ];
        return $this->response(true, $data, 'Category wise fetch successfully');
    }

    public function show(string $id){
        $subcategory = $this->subcategoryRepository->getById($id);

        if(empty($subcategory)){
            return $this->response(false, [], 'subcategory not found');
        }

        $data = [
            'subcategory' => new SubcategoryResource($subcategory),
        ];
        return $this->response(true, $data, 'Subcategory fetch successfully');
    }

    public function update(SubcategoryUpdate $request, string $id){
        $validatedData = $request->validated();

        $subcategory = $this->subcategoryRepository->update($id, $validatedData);

        if(empty($subcategory)){
            return $this->response(false, [], 'Failed to update Subcategory');
        }

        $data = [
            'subcategory' => $subcategory,
        ];  
        return $this->response(true, $data, 'Subcategory update Successfull');
    }

    public function destroy(string $id){
        $subcategory = $this->subcategoryRepository->delete($id);

        if(empty($subcategory)){
            return $this->response(false, [], 'Failed to delete subcategory');
        }
        $data = [
            'subcategory'=> $subcategory,
        ];

        return $this->response(true, $data, 'Subcategory deleted Successfull');
    }
}
