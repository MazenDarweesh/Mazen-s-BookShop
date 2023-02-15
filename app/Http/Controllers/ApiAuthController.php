<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends Controller
{
    public function handleRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'password' => 'required|string|max:50|min:5',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors);
        }
        

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'access_token' => Str::random(64),
        ]);

        return response()->json($user->access_token);
    }

    public function handleLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:100',
            'password' => 'required|string|max:50|min:5',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors);
        }
        
        $is_user = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        
        if(! $is_user)
        {
            $error = "credentials are not correct";
            return response()->json($error);
        }

        $user = User::where('email', '=', $request->email)->first();
        //else:
        $new_access_token = Str::random(64);

        $user->update([
            'access_token' => $new_access_token
        ]);

        return response()->json($new_access_token);
    }

    public function logout(Request $request)
    {
        $access_token = $request->access_token;

        $user = User::where('access_token', $access_token)->first();

        if($user == null) { // if the given access_token not matching with the one in the DB
            $error = "token not correct";
            return response()->json($error);
        }
        //else:
        $user->update([
            'access_token' => NULL
        ]);

        $success = "logged out successfully";
        return response()->json($success);
    }

}
