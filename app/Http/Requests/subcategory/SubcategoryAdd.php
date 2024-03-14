<?php

namespace App\Http\Requests\subcategory;

use Illuminate\Foundation\Http\FormRequest;

class SubcategoryAdd extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    function prepareForValidation(){
        $input = $this->all();
    
        if (isset($input['name'])) {
            $input['name'] = preg_replace('/[^a-zA-Z0-9\s]/', '', $input['name']);
            $input['name'] = trim($input['name']);
        }
    
        $this->replace($input);
    }
   
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:subcategories,name',
            'category_id' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048'
        ];
    }
}
