<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\User;

class MessageController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $token = $request->get('token');

        if(empty($token)){
            return response('', 401);
        }

        $user = User::where('remember_token', $token)->first();

        if(!$user){
            return response('', 401);
        }

        $text = $this->validateMessage($request->get('text'));

        if($text === false){
            return response('',400);
        }

        $message = $user->messages()->create([
            'text' => $text
        ]);

        $message->author = $user->name;

        return response()->json($message);

    }

    /**
     * @param string $text
     * @return bool|string
     */
    public function validateMessage(string $text)
    {
        $text = trim($text);
        $text = strip_tags($text);

        if(empty($text)) {
            return false;
        }

        if(mb_strlen($text) > 200){
            $text = substr($text,0, 200);
        }

        return $text;
    }
}
