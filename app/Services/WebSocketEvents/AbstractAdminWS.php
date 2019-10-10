<?php

namespace App\Services\WebSocketEvents;


use App\Http\Controllers\RatchetController;
use Ratchet\ConnectionInterface;

abstract class AbstractAdminWS extends AbstractWS
{
    public function isAdmin()
    {
        return $this->connection->user->isAdmin();
    }
}
