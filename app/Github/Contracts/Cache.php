<?php

namespace Github\Contracts;


interface Cache
{
    /**
     * @param int $minutes
     * @return mixed
     */
    public function store($minutes = 10);
}