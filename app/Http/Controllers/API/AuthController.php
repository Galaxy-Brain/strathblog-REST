<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

class AuthController extends Controller
{

    // Login an Existing User
    public function login(Request $request)
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

    // Register a new User
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


    public function logout(Request $request){
        try{
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'success' => true,
                'message' => 'Successfully Logged Out'
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => ''.$e
            ]);
        }
    }

    public function saveUserInfo(Request $request){
        $user = User::find(auth()->user()->id);
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $photo = '';
        //check if user provided photo
        if($request->photo!=''){
            // user time for photo name to prevent name duplication
            $photo = time().'.jpg';
            // decode photo string and save to storage/profiles
            file_put_contents('storage/profiles/'.$photo,base64_decode($request->photo));
            $user->photo = $photo;
        }

        $user->update();

        return response()->json([
            'success' => true,
            'photo' => $photo
        ]);

    }

}
