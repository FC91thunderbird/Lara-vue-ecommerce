<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UserdetailAdd extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    function prepareForValidation(){
        $input = $this->all();
    
        if (isset($input['firstname'])) {
            $input['firstname'] = preg_replace('/[^a-zA-Z0-9\s]/', '', $input['firstname']);
            $input['firstname'] = trim($input['firstname']);
        }

        if (isset($input['lastname'])) {
            $input['lastname'] = preg_replace('/[^a-zA-Z0-9\s]/', '', $input['lastname']);
            $input['lastname'] = trim($input['lastname']);
        }
    
        $this->replace($input);
    }

    public function rules(): array
    {
        return [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'address2' => 'nullable',
            'zip' => 'numeric',
            'phone' => 'numeric',
        ];
    }
}
