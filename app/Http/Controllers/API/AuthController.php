<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function user(Request $request)
    {
        $token = $request->get('token');

        if(empty($token)){
            return response('Bad request', 400);
        }

        $user = User::where('remember_token', $token)->first();

        if(!$user){
            return response('Not found', 404);
        }

        return response()->json($user);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
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
            return response('You are banned', 403);
        }

        if(Hash::check($request->get('password'), $user->password)){
            return response()->json([
                'token' => $user->remember_token
            ]);
        }

        return response('', 401);
    }
}
