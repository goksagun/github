<?php

namespace Github\Contracts;


interface Authenticate
{
    public function auth($token);
}