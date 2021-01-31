<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Get your Auth Token

    public function getToken(Request $request)
    {
        $request->validate([
            'email'=>'required',
            'password'=>'required',
            'device_name'=>'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            return $user->createToken($request->device_name)->plainTextToken;
        }else {
            throw ValidationException::withMessages([
                'email'=> ['The Provided Credentials are Incorrect']
            ]);
        }

    }
}
