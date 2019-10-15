<?php

namespace App\Services\WebSocketEvents;

use App\User;
use Carbon\Carbon;


class onMessage extends AbstractWS
{

    public function handle($data)
    {
        if(!$this->connection->user->isAdmin()){
            if($this->connection->user->isMuted()){
                return;
            }

            if(!$this->checkLimitMessageByTime($this->connection->user)){
                return;
            }
        }

        $message = $this->validateMessage($data->message);

        if($message === false){
            return;
        }

        $this->connection->user->messages()->create([
            'text' => $message
        ]);

        $data = [
            'event' => 'onMessage',
            'message' => $message,
            'user_id' =>  $this->connection->user->id,
            'user_name' =>  $this->connection->user->name
        ];

        foreach ($this->ratchet->getClients() as $client) {
            $client->send(json_encode($data));
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

        if(empty($text)) {
            return false;
        }

        if(mb_strlen($text) > 200){
            $text = substr($text,0, 200);
        }

        return $text;
    }

    /**
     * @param User $user
     * @param int $timer
     * @return bool
     */
    public function checkLimitMessageByTime(User $user, $timer = 15)
    {
        $lastMessage = $user->messages()->orderByDesc('created_at')->first();

        if(!$lastMessage) {
            return true;
        }

        $now = Carbon::now();
        $messageTime = new Carbon($lastMessage->created_at);

        return ($now->diffInSeconds($messageTime) >= $timer);
    }

}
