<?php

namespace App\Http\Controllers;

use App\Models\UserDetail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function response($success, $data, $message, $code = 200)
    {
        $response = array(
            'success' => $success,
            'data' => $data,
            'message' => $message
        );
        return response()->json($response, $code);
    }

    public function userDetails($request){
        try {
            $validatedData = $request->validated();

            $userDetails = UserDetail::create($validatedData);

            if(empty($userDetails)){
                return false;
            }
    
            return true;
        } catch (\Exception $e) {
            return $this->response(false, [], "User details created");
        }
    }
}
