<?php

namespace App\Http\Requests\product;

use Illuminate\Foundation\Http\FormRequest;

class ProductAdd extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    function prepareForValidation(){
        $input = $this->all();
    
        if (isset($input['title'])) {
            $input['title'] = preg_replace('/[^a-zA-Z0-9\s]/', '', $input['title']);
            $input['title'] = trim($input['title']);
        }

        if (isset($input['description'])) {
            $input['description'] = preg_replace('/[^a-zA-Z0-9\s]/', '', $input['description']);
            $input['description'] = trim($input['description']);
        }
    
        $this->replace($input);
    }

    public function rules(): array
    {
        return [
            'title'=>'required|string|unique:products,title',
            'category_id' => 'required|numeric', 
            'subcategory_id' => 'required|numeric', 
            'buy_price' => 'required|numeric', 
            'price' => 'required|numeric', 
            'description' => 'required', 
            'colors' => 'array', 
            'sizes' => 'array',
            'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048'
        ];
    }
    
}
