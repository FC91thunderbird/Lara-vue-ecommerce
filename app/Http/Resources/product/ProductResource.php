<?php

namespace App\Http\Resources\product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'category_id' => $this->category->id,
            'category' => $this->category->name,
            'subcategory_id' => $this->subcategory->id,
            'subcategory' => $this->subcategory->name,
            'buy_price' => $this->buy_price,
            'price' => $this->price,
            'colors' => $this->colors,
            'sizes' => $this->sizes,
            'description' => $this->description,

            'image' => $this->image,
            'created_at' => $this->created_at->format('Y/m/d H:i'),
        ];
    }
}
