<?php

namespace App\Http\Resources\subcategory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubcategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'category_id' => $this->category->pluck('id')->first(), // $this->category->id,
            'category' => $this->category->pluck('name')->first(), //$this->category->name,
            'image' => $this->image,
            'created_at' => $this->created_at
        ];
    }
}
