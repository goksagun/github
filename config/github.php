<?php

/*
 * This file is part of Laravel GitHub.
 *
 * (c) Graham Campbell <graham@alt-three.com>
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
    | GitHub Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like. Note that the 3 supported authentication methods are:
    | "application", "password", and "token".
    |
    */

    'connections' => [

        'main' => [
            'token'   => 'c077e60e1f2016550006010c96d1f76f8d1ae4cb',
            'method'  => 'token',
            // 'baseUrl' => 'https://api.github.com/',
            // 'version' => 'v3',
        ],

        'alternative' => [
            'clientId'     => '6a3c70c2d509e26c38ad',
            'clientSecret' => 'f0e2e591286a87d33e7abd8b21a320ddb2aebe72',
            'method'       => 'application',
            // 'baseUrl'      => 'https://api.github.com/',
            // 'version'      => 'v3',
        ],

        'other' => [
            'username' => 'goksagun',
            'password' => '!_@m_fr33',
            'method'   => 'password',
            // 'baseUrl'  => 'https://api.github.com/',
            // 'version'  => 'v3',
        ],

    ],

];
