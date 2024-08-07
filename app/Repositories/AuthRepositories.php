<?php

namespace App\Repositories;

use App\Http\Requests\Auth\AuthRequest;
use App\Interfaces\AuthInterfaces;
use App\Models\User;
use App\Traits\HttpResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthRepositories implements AuthInterfaces
{
    protected $userModel;
    use HttpResponseTrait;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }
    

    public function login(AuthRequest $request)
    {
        try {
            if(!Auth::attempt($request->only('email', 'password'))){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ], 401);
            }else{
                $user = $this->userModel->where('email', $request->email)->first();
                $token = $user->createToken('auth_token')->accessToken;
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login success',
                    'token' => $token
                ]);
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}