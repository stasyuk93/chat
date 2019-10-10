<?php

namespace App\Services\WebSocketEvents;

use App\Http\Controllers\RatchetController;
use Ratchet\ConnectionInterface;

abstract class AbstractWS
{
    /**
     * @var RatchetController
     */
    protected $ratchet;

    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * AbstractWS constructor.
     * @param RatchetController $ratchet
     * @param ConnectionInterface $connection
     */
    public function __construct(RatchetController $ratchet, ConnectionInterface $connection)
    {
        $this->ratchet = $ratchet;
        $this->connection = $connection;
    }

    /**
     * @param $data
     * @return void
     */
    abstract public function handle($data);

}
