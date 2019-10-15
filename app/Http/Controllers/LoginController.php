<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;


class LoginController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => ['required', 'alpha_dash', 'min:3',   'max:255'],
            'password' => ['required', 'string', 'min:4'],
        ]);

        $user = User::where('name', $request->get('name'))->first();

        if(!$user){
            $user = User::Create(
                [
                    'name' => $request->get('name'),
                    'password' => Hash::make($request->get('password')),
                    'remember_token' => Hash::make($request->get('name')),
                ]
            );
        }

        if($user->isBanned()){
            return redirect('/login');
        }

        if(Hash::check($request->get('password'), $user->password)){
            Auth::login($user);
            return redirect('/');
        }

        return redirect('/login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        return redirect('/');
    }


}
