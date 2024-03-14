<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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

        if (isset($input['username'])) {
            $input['username'] = preg_replace('/[^a-zA-Z0-9\s]/', '', $input['username']);
            $input['username'] = trim($input['username']);
        }
    
        $this->replace($input);
    }

    public function rules(): array
    {
        return [
            'name'=>'required|string|unique:users,name',
            'username'=>'required|string|unique:users,username',
            'email'=>'required|email:rfc|unique:users,email',
            'password'=>'required|string|min:6',
            'confirm_password'=>'required|same:password',
        ];
    }
}
