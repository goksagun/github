<?php
/**
 * Created by PhpStorm.
 * User: burak
 * Date: 06.09.2015
 * Time: 00:22
 */

namespace Github\Contracts;


interface Cache
{
    /**
     * @param int $minutes
     * @return mixed
     */
    public function store($minutes = 10);
}