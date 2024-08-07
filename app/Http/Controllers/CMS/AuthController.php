<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Repositories\AuthRepositories;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authRepositories;

    public function __construct(AuthRepositories $authRepositories)
    {
        $this->authRepositories = $authRepositories;
    }

    public function login(AuthRequest $request)
    {
        return $this->authRepositories->login($request);
    }
}
