<?php

namespace App\Http\Requests\product;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdate extends FormRequest
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
            'title'=>'string|unique:products,title,' . $this->route('products'),
            'category_id' => 'numeric', 
            'subcategory_id' => 'numeric', 
            'buy_price' => 'numeric', 
            'price' => 'numeric', 
            'description' => 'string', 
            'colors' => 'array', 
            'sizes' => 'array',
            'image' => 'nullable'
        ];
    }
}
