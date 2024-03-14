<?php

namespace App\Http\Resources\subcategory;

use App\Http\Resources\PaginationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubcategoryList extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'data'=> SubcategoryResource::collection($this->resource->items()), // $this->collection || $this->resource->items()
            'pagination' => new PaginationResource($this->resource)
        ];
    }
}
