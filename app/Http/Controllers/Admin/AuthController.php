<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $authenticated = auth()->attempt($credentials);
        if (!$authenticated) {
            return $this->response(false, [], 'Invalid credentials', 401); // 'Invalid credentials
        }
        $user = auth()->user();
        $token = $user->createToken('auth_token')->plainTextToken;
        $data = [
            'token' => $token,
            'user' => $user,
        ];
        return $this->response(true, $data, 'Successful login.');
    }

    public function getUserDetails(Request $request)
    {
        try {
            $user = $request->user();
            $data = array(
                'user' => $user,
            );
            return $this->response(true, $data, __('messages.login_successfully'));
        } catch (\Throwable $e) {
            return  $this->response(false, [], $e->getMessage());
        }
    }

    public function register(RegisterRequest $request){
        try {

            $data = $request->validated();

            $data['role_id'] = 3;

            $user = User::create($data);
    
            $token = $user->createToken('auth_token')->plainTextToken;
    
            // $cookie = cookie('token', $token, 60 * 24); // 1 day
            // return response()->json([
            //     'user' => new UserResource($user),
            // ])->withCookie($cookie);

            $data = [
                'token' => $token,
                'user' => $user,
            ];
            return $this->response(true, $data, 'User Created successfully.');
        } catch (\Exception $e) {
            return $this->response(false, [], "Failed to register");
        }
    }


    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return $this->response(true, [], 'Logout Successfull');
    }
}
