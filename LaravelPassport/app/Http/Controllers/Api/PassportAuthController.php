<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\loginRequest;
use App\Http\Requests\auth\registerRequest;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PassportAuthController extends Controller
{
    /**
     * Create a user account
     * 
     * @param \App\Http\Requests\auth\registerRequest $registerRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(registerRequest $registerRequest)
    {
        $userValidate = $registerRequest->validated();
        $userValidate['password'] = Hash::make($userValidate['password']);
        $user = User::create($userValidate);
        $token = $user->createToken($userValidate['name'])->accessToken;
        $response = [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => null
        ];
        return response()->json($response, JsonResponse::HTTP_CREATED); // 201
    }
    
    
    /**
     * login 
     * 
     * @param \App\Http\Requests\auth\loginRequest $loginRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(loginRequest $loginRequest){
        $userValidate = $loginRequest->validated();
        if(auth()->attempt($userValidate)){
            $user = auth()->user();
            $token = $user->createToken($user->name)->accessToken;
            $response = [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_at' => null
            ];
            return response()->json($response,JsonResponse::HTTP_OK);//200
        }
        return response()->json([
            'message' => 'Invalid credentials'
        ],JsonResponse::HTTP_UNAUTHORIZED);//401
    }
    /**
     * get ingormation user
     */
    public function userInfo() {

     $user = auth()->user();
    
     
     return response()->json([
        'user' => $user
    ], JsonResponse::HTTP_OK); //200

    }
    /**
     * logout
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ],JsonResponse::HTTP_OK);
    }
}
