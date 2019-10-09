<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Exception;
use React\EventLoop\LoopInterface;
use React\EventLoop\TimerInterface;
use SplObjectStorage;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use App\User;

class RatchetController extends Controller implements MessageComponentInterface
{
    private $loop;
    private $clients;
    private $users;
    /**
     * Store all the connected clients in php SplObjectStorage
     *
     * RatchetController constructor.
     */
    public function __construct(LoopInterface $loop)
    {
        $this->loop = $loop;
        $this->clients = new SplObjectStorage;
    }
    /**
     * Store the connected client in SplObjectStorage
     * Notify all clients about total connection
     *
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn)
    {
//        echo "Client connected " . $conn->resourceId . " \n";
        $this->clients->attach($conn);

//        echo "Total clients " . count($this->clients) . " \n";
//
//
//        foreach ($this->clients as $client) {
//            $client->send(json_encode([
//                "type" => "socket",
//                "message" => "Total Connected: " . count($this->clients),
//            ]));
//        }
    }
    /**
     * Remove disconnected client from SplObjectStorage
     * Notify all clients about total connection
     *
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        $this->removeUser($conn);
        foreach ($this->clients as $client) {
            $client->send(json_encode([
                "type" => "socket",
                "users" => array_values($this->users),
            ]));
        }
    }
    /**
     * Receive message from connected client
     * Broadcast message to other clients
     *
     * @param ConnectionInterface $from
     * @param string $data
     */
    public function onMessage(ConnectionInterface $from, $data)
    {
        $resource_id = $from->resourceId;
        $data = json_decode($data);
        $type = $data->type;
        switch ($type) {
            case 'chat':
                // Save to database
                $message = new Message();
                $message->user_id = $data->user_id;
                $message->text = $data->message;
                $message->save();
                // Output
                $from->send(json_encode($data));
                foreach ($this->clients as $client) {
                    if ($from != $client) {
                        $client->send(json_encode($data));
                    }
                }

                echo "Resource id $resource_id sent $data->message \n";
                break;
            case 'connect':
                $this->addUser($from, $data->user_id);
                foreach ($this->clients as $client) {
                    $client->send(json_encode([
                        'type' => 'socket',
                        'users' => array_values($this->users),
                    ]));
                }

                break;

        }
    }
    /**
     * Throw error and close connection
     *
     * @param ConnectionInterface $conn
     * @param Exception $e
     */
    public function onError(ConnectionInterface $conn, Exception $e)
    {
        $conn->close();
    }

    protected function addUser(ConnectionInterface $conn, $user_id)
    {
        $this->users[$conn->resourceId] = User::find($user_id);
    }

    protected function removeUser(ConnectionInterface $conn)
    {
        unset($this->users[$conn->resourceId]);
    }

}
