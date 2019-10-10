<?php

namespace App\Services\WebSocketEvents;

use App\Http\Controllers\RatchetController;
use Ratchet\ConnectionInterface;

class WSFabric
{
    /**
     * @param string $event
     * @param RatchetController $ratchet
     * @param ConnectionInterface $connection
     * @return AbstractWS
     * @throws \Exception
     */
    public static function make(string $event, RatchetController $ratchet, ConnectionInterface $connection)
    {
        $namespace = __NAMESPACE__;
        if ($namespace != '') $namespace .= '\\';
        $class = $namespace.$event;
        if(class_exists($class)){
            return new $class($ratchet, $connection);
        } else {
            throw new \Exception("$class not exists");
        }
    }
}
