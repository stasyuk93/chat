<?php

namespace App\Http\Controllers;

use Exception;
use React\EventLoop\LoopInterface;
use React\EventLoop\TimerInterface;
use SplObjectStorage;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use App\User;
use App\Services\WebSocketEvents\WSFabric;

class RatchetController extends Controller implements MessageComponentInterface
{
    private $loop;

    private $clients;

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
     * @param ConnectionInterface $conn
     * @throws Exception
     */
    public function onOpen(ConnectionInterface $conn)
    {

        $querystring = $conn->httpRequest->getUri()->getQuery();

        parse_str($querystring,$queryarray);

        $token = $queryarray['token'];

        if (!$token){
            $conn->close();
        }

        $user = User::where(['remember_token' => $token])->first();

        if (!$user || $user->isBanned()){
            $conn->close();
        }

        $conn->user = $user;

        $this->clients->attach($conn);

        WSFabric::make('getOnlineUsers', $this, $conn)->handle(null);

    }

    /**
     * @param ConnectionInterface $conn
     * @throws Exception
     */
    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        WSFabric::make('onClose', $this, $conn)->handle(null);
    }

    /**
     * @param ConnectionInterface $conn
     * @param string $data
     * @throws Exception
     */
    public function onMessage(ConnectionInterface $conn, $data)
    {
        $data = json_decode($data);
        WSFabric::make($data->event, $this, $conn)->handle($data);
    }
    /**
     * Throw error and close connection
     *
     * @param ConnectionInterface $conn
     * @param Exception $e
     */
    public function onError(ConnectionInterface $conn, Exception $e)
    {
        dump($e);
        $conn->close();
    }

    public function getClients()
    {
        return $this->clients;
    }

    /**
     * @return array
     */
    public function getUsers()
    {
        $array = [];
        foreach ($this->clients as $client){
            $array[] = $client->user;
        }
        return $array;
    }

    /**
     * @param $userId
     * @return bool|ConnectionInterface
     */
    public function getClientByUserId($userId)
    {
        foreach ($this->clients as $client){
            if($client->user->id == $userId) {
                return $client;
            }
        }
        return false;
    }
}
