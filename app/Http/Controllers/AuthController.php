<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function logout(Request $request)
    {

        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();

        return redirect()->route('login');
    }
}
