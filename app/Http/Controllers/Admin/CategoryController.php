<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryAdd;
use App\Http\Requests\Category\CategoryUpdate;
use App\Http\Resources\Category\CategoryList;
use App\Http\Resources\Category\CategoryResource;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request){
        $category = $this->categoryRepository->getList($request);

        if(empty($category)){
            return $this->response(false, [], 'Category not found');
        }

        $data = [
            'categories' => new CategoryList($category),
        ];

        return $this->response(true, $data, 'Category Fetch');
    }

    public function store(CategoryAdd $request){
        $validatedData = $request->validated();

        $category = $this->categoryRepository->store($validatedData);

        if(empty($category)){
            return $this->response(false, [], 'Failed to create Category');
        }

        $data = [
            'category' => $category,
        ];
        return $this->response(true, $data, 'Successful Added Category');
    }

    public function show(string $id){
        $category = $this->categoryRepository->getById($id);

        if(empty($category)){
            return $this->response(false, [], 'Category not found');
        }

        $data = [
            'category' => new CategoryResource($category),
        ];
        return $this->response(true, $data, 'Category fetch successfully');
    }

    public function update(CategoryUpdate $request, string $id){
        $validatedData = $request->validated();

        $category = $this->categoryRepository->update($id, $validatedData);

        if(empty($category)){
            return $this->response(false, [], 'Failed to update category');
        }

        $data = [
            'category' => $category,
        ];  
        return $this->response(true, $data, 'Category update Successfull');
    }

    public function destroy(string $id){
        $category = $this->categoryRepository->delete($id);

        if(empty($category)){
            return $this->response(false, [], 'Failed to delete Category');
        }
        $data = [
            'category'=> $category,
        ];

        return $this->response(true, $data, 'Category deleted Successfull');
    }
}
