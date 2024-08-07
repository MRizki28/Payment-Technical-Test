<?php

namespace App\Interfaces;

use App\Http\Requests\Auth\AuthRequest;
use Illuminate\Http\Request;

interface AuthInterfaces
{
    public function login(AuthRequest $request);
}
