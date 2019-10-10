<?php

namespace App\Services\WebSocketEvents;

use App\Models\Message;



class onMessage extends AbstractWS
{

    public function handle($data)
    {
        if($this->connection->user->isMuted()) return;
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



}
