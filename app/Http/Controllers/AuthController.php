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
            return response()->json([
                'success'=> true,
                'token'=> 'Bearer '.$user->createToken($request->device_name)->plainTextToken
            ]);
        }else {
            return response()->json([
                'success'=> false,
                'token'=> 'Credentials are incorrect'
            ]);
        }

    }

    public function register(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required|min:8',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();
        return response()->json([
            'success'=>true,
            'message'=>'Successfully Registered'
        ]);
    }

}
