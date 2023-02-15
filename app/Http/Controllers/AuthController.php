<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\RegisterMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function register()
    {
        return view(
            'auth.register'
        );
    } 

    public function handleRegister(Request $request)
    {
       //making validation to the coming $request from register form
       //it has an action to this function
       $request->validate([
        'name'=>'required|string|max:100',
        'email'=>'required|email|max:100',
        'password'=>'required|string|max:50|min:5',
       ]);

       //after validation the coming data 
       //we will put it in the DB by making a query
       $user=User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>Hash::make($request->password),
       ]);
       
       //Login part using login class in larvel that:
       //make the login by the selected row data ($user) , save data in session
       Auth::login($user);

       //sending mail to user
       Mail::to($user->email)->send(new RegisterMail($user->name));

       return redirect( route('books.index') );

    } 

    public function login()
    {
        return view(
            'auth.login'
        );
    }

    public function handleLogin(Request $request)
    {
       //making validation to the coming $request from register form
       //it has an action to this function
       $request->validate([
        'email'=>'required|email|max:100',
        'password'=>'required|string|max:50|min:5',
       ]);

       //we want to check if that data is in the DB or not 
       //return T or F using func attempted in Auth class 
       //don't hash the password the method will hash it for u 
       $is_login=Auth::attempt([
        'email'=>$request->email, 'password'=>$request->password
        ]);
        

        if(! $is_login)
        {
            return back();
        }

        return redirect( route('books.index') );


    } 

    public function logout()
    {
        Auth::logout();

        return back();
    }
}
