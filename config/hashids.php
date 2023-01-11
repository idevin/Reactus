<?php

/*
 * This file is part of Laravel Hashids.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Hashids Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    */

    'connections' => [

        'main' => [
            'salt' => 'your-salt-string',
            'length' => 5,
            'alphabet' => null,
        ],

        'article' => [
            'salt' => 'netgamer-article-68279gyubfsd8f679283goui4bjsd78723puibljkfs87tj',
            'length' => 5,
            'alphabet' => null,
        ],

        'user' => [
            'salt' => 'netgamer-user-alksjxncfiuqweorugasbcv8t239476yquowabdsnpvoiashvyouq',
            'length' => 6,
            'alphabet' => null,
        ],

        'upload' => [
            'salt' => 'netgamer-upload-71298t3yuihasbjdf78612873tuighbasdf9678o1g2y3vhj',
            'length' => 9,
            'alphabet' => null,
        ]

    ],

];
