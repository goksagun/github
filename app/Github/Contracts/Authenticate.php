<?php
/**
 * Created by PhpStorm.
 * User: burak
 * Date: 05.09.2015
 * Time: 12:28
 */

namespace Github\Contracts;


interface Authenticate
{
    public function auth($token);
}