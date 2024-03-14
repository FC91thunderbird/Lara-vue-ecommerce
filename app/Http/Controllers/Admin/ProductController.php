<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\product\ProductAdd;
use App\Http\Requests\product\ProductUpdate;
use App\Http\Resources\product\ProductList;
use App\Http\Resources\product\ProductResource;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(Request $request){
        $product = $this->productRepository->getList($request);

        if(empty($product)){
            return $this->response(false, [], 'Product not found');
        }

        $data = [
            'products' => new ProductList($product),
        ];

        return $this->response(true, $data, 'Products Fetch');
    }

    public function store(ProductAdd $request){
        $validatedData = $request->validated();

        $product = $this->productRepository->store($validatedData);

        if(empty($product)){
            return $this->response(false, [], 'Failed to create Product');
        }

        $data = [
            'product' => $product,
        ];
        return $this->response(true, $data, 'Successful Added Product');
    }

    public function show(string $id){
        $product = $this->productRepository->getById($id);

        if(empty($product)){
            return $this->response(false, [], 'Product not found');
        }

        $data = [
            'products' => new ProductResource($product),
        ];
        return $this->response(true, $data, 'Product fetch successfully');
    }

    public function update(ProductUpdate $request, string $id){
        $validatedData = $request->validated();

        $product = $this->productRepository->update($id, $validatedData);

        if(empty($product)){
            return $this->response(false, [], 'Failed to update product');
        }

        $data = [
            'product' => $product,
        ];  
        return $this->response(true, $data, 'product update Successfully');
    }

    public function destroy(string $id){
        $product = $this->productRepository->delete($id);

        if(empty($product)){
            return $this->response(false, [], 'Failed to delete product');
        }
        $data = [
            'product'=> $product,
        ];

        return $this->response(true, $data, 'product deleted Successfully');
    }
}
