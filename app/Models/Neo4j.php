<?php

namespace App\Models;

use Laudis\Neo4j\ClientBuilder;
use Laudis\Neo4j\Contracts\ClientInterface;
use Vinelab\NeoEloquent\Eloquent\Model;

class Neo4j extends Model
{
    public static function client(): ClientInterface
    {
        return ClientBuilder::create()
            ->addBoltConnection('default', self::getNeo4jConnection())->build();
    }

    /**
     * @return string
     */
    public static function getNeo4jConnection(): string
    {
        $neo4j = config('database.connections.neo4j_bolt');

        return 'bolt://' . $neo4j['username'] . ':' .
            $neo4j['password'] . '@' . $neo4j['host'] . ':' . $neo4j['port'];
    }
}