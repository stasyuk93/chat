<?php

namespace App\Services\WebSocketEvents;

use App\Models\Message;
use Carbon\Carbon;


class onMessage extends AbstractWS
{

    public function handle($data)
    {
        if($this->connection->user->isMuted()) return;
        if(!$this->checkLimitMessageByTime($data->user_id)) return;
        $data->message = $this->validateMessage($data->message);
        if($data->message === false) return;

        $message = new Message();
        $message->user_id = $data->user_id;
        $message->text = $data->message;
        $message->save();
        // Output
        $this->connection->send(json_encode($data));
        foreach ($this->ratchet->getClients() as $client) {
            if ($this->connection != $client) {
                $client->send(json_encode($data));
            }
        }
    }

    /**
     * @param $text
     * @return bool|string
     */
    public function validateMessage($text)
    {
        $text = trim($text);
        $text = strip_tags($text);
        if(empty($text)) return false;
        if(mb_strlen($text) > 200){
            $text = substr($text,0, 200);
        }
        return $text;
    }

    /**
     * @param $user_id
     * @param int $timer seconds
     * @return bool
     */
    public function checkLimitMessageByTime($user_id, $timer = 15)
    {
        $lastMessage = Message::orderBy('created_at', 'desc')->first();
        if(!$lastMessage) return true;
        $now = Carbon::now();
        $messageTime = new Carbon($lastMessage->created_at);
        if($now->diffInSeconds($messageTime) >= $timer) return true;
        return false;
    }

}
