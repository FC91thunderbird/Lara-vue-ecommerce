<?php 

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends BaseRepository
{
    protected $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    public function getList($request){
        $product = $this->model->query();

        if (!empty($request->search)) {
            $product->where(function($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('colors', 'like', '%' . $request->search . '%')
                ->orWhere('sizes', 'like', '%' . $request->search . '%')
                      ->orWhereHas('category', function($query) use ($request) {
                          $query->where('name', 'like', '%' . $request->search . '%');
                      })
                      ->orWhereHas('subcategory', function($query) use ($request) {
                          $query->where('name', 'like', '%' . $request->search . '%');
                      });
            });
        }

        $product = $product->latest()->paginate(config('constants.paginate'));
        return $product;
    }
}