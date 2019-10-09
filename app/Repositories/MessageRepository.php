<?php
/**
 * Created by PhpStorm.
 * User: valerii
 * Date: 07.10.19
 * Time: 18:37
 */

namespace App\Repositories;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageRepository
{
    /**
     * @param Request $request
     * @return Message
     */
    public function save(Request $request)
    {
        $message = new Message();
        $message->text = $request->get('message');
        $message->user_id = $request->user()->id;
        $message->save();
        return $message;
    }
}
