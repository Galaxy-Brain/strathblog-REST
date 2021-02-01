<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    // Login an Existing User
    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            return response()->json([
                'success'=> true,
                'token'=> 'Bearer '.$user->createToken($request->email)->plainTextToken,
                'user'=>$user
            ]);
        }else {
            return response()->json([
                'success'=> false,
                'message'=> 'Your Credentials are Incorrect',
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
        $user = User::find($request->user()->id);
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $photo = $request->file('photo');
        //check if user provided photo
        if(isset($photo)){
            // user time for photo name to prevent name duplication
            $photoname = time().'.'.$photo->getClientOriginalExtension();
            // decode photo string and save to storage/profiles
            $photo->move('storage/profile-photos/', $photoname);
            $user->profile_photo_path = $photoname;
        }

        $user->update();

        return response()->json([
            'success' => true,
            'photo' => $photoname
        ]);

    }

}
