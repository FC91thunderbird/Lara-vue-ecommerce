<?php

namespace App\Http\Controllers;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\product\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getCategoryAndProducts(){
        $categories = Category::all();
        $products = Product::all();

        $data = [
            'categories' => CategoryResource::collection($categories),
            'products' => ProductResource::collection($products),
        ];  

        return $this->response(true, $data, 'Category and product fetch');
    }
}
